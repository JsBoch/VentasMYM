<?php
session_start();
$reciboId = $_POST["id_recibo"];
$registroMain = $_POST["registro_principal"];
$detalleRegistro = $_POST["detalle_registro"];

//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaHoraRegistro = date("Y-m-d H:i:s");

$codigoRespuesta = 0;
/**
 * Se obtiene el registro principal del registro de recibo como objeto
 */
$jsonMain = json_decode($registroMain, true);
foreach ($jsonMain as $item) {
    $clienteID = $item["id_cliente"]; //$jsonMain->id_cliente;
    $nombreCliente = $item["nombre_cliente"];
    $noRecibo = $item["no_recibo"]; //$jsonMain->id_departamento;
    $cobro = $item["cobro"];
    $semana = $item["semana"];
    $observacionesRegistro = $item["observaciones"]; //$jsonMain->observaciones;
    $usuarioID = $_SESSION["usuarioId"];
}
/**
 * Se almacena en la base de datos
 */
require_once 'connection.php';

if ($mysqli !== null) {
    //inicio de transacciones
    $mysqli->autocommit(false);
    /**
     * Sí el id de recibo es mayor a cero, entonces se elimina el registro original
     * del recibo.
     */
    if ($reciboId > 0) {

        $query = "update vnt_detalle_recibo SET estado = 0 WHERE id_recibo = $reciboId;";
        $mysqli->query($query);
        $query = "update vnt_registro_recibo set estado = 0 WHERE id_recibo = $reciboId;";
        $mysqli->query($query);
    }
    //IDs

    $query = "select " .
        "if(max(id_recibo) is null,1,max(id_recibo) + 1) as id_recibo " .
        "from vnt_registro_recibo;";

    $resultado = $mysqli->query($query);
    $fila = $resultado->fetch_assoc();

    $reciboId = intval($fila["id_recibo"]);
    //detalle recibo id
    $query = "select " .
        "if(max(id_detalle_recibo) is null,1,max(id_detalle_recibo) + 1) as id_detalle " .
        "from vnt_detalle_recibo;";

    $resultado = $mysqli->query($query);
    $fila = $resultado->fetch_assoc();

    $detalleId = intval($fila["id_detalle"]);
    $estado = 1;

    try {
        if (!$stmt = $mysqli->prepare(
            "INSERT INTO vnt_registro_recibo(" .
            "id_recibo," .
            "no_recibo," .
            "fecha_registro," .
            "id_cliente," .
            "nombre_cliente," .
            "cobro," .
            "semana," .
            "observacion," .
            "estado," .
            "id_usuario)" .
            " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);")) {
            //echo "fallo No." . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -1;

        } else
        if (!$stmt->bind_param("ississssii", $reciboId, $noRecibo, $fechaHoraRegistro, $clienteID, $nombreCliente,
            $cobro, $semana, $observacionesRegistro, $estado, $usuarioID)) {
            //echo "fallo la vinculacion: " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -2;
        } else if (
            !$stmt->execute()) {
            //echo "Fallo la ejecución " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -3;
        } else {

            $filasAfectas = $mysqli->affected_rows;

            if ($filasAfectas > 0) {
                $noEnvio = 0;
                $noDeposito = "";
                $cajaRural = "";
                $empresa = "";
                $noCheque = "";
                $tipoPago = "";
                $pago = 0;
                $pagoTotal = 0;
                $observaciones = "";
                $banco = "";
                $ventaID = 0;

                if (!$stmtd = $mysqli->prepare(
                    "INSERT INTO vnt_detalle_recibo (" .
                    "id_detalle_recibo," .
                    "id_recibo," .
                    "id_venta," .
                    "no_envio," .
                    "no_deposito," .
                    "caja_rural," .
                    "empresa," .
                    "no_cheque," .
                    "tipo_pago," .
                    "pago," .
                    "pago_total," .
                    "observaciones," .
                    "estado," .
                    "banco) " .
                    " VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);")) {
                    $codigoRespuesta = -4; //fallo al preparar la consulta de detalle

                } else if (!$stmtd->bind_param("iiiisssssdssis", $detalleId, $reciboId, $ventaID, $noEnvio,
                    $noDeposito, $cajaRural, $empresa, $noCheque, $tipoPago, $pago,$pagoTotal,$observaciones,$estado,$banco)) {
                    $codigoRespuesta = -5; //no se pudieron vincular los parámetros a la consulta detalle
                } else {
                    /**
                     *Se obtiene el detalle de los items como arreglo
                     */
                    $jsonDetalle = json_decode($detalleRegistro, true);

                    $almacenado = true;

                    //foreach ($jsonDetalle as $item) {
                    foreach ($jsonDetalle as $arr) {
                        //$cadenaCompleta = $cadenaCompleta . $arr["nombre"];
                        $noEnvio = $arr["no_envio"];
                        $noDeposito = $arr["no_deposito"];
                        $cajaRural = $arr["caja_rural"];
                        $empresa = $arr["empresa"];
                        $noCheque = $arr["no_cheque"];
                        $tipoPago = $arr["tipo_pago"];
                        $pago = $arr["pago"];
                        $pagoTotal = $arr["pago_total"];
                        $observaciones = $arr["observaciones"];
                        $banco = $arr["banco"];


                        if (!$stmtd->execute()) {
                            $codigoRespuesta = -6; //fallo al ejecutar la consulta detalle
                            $almacenado = false;
                            break 1;
                        }
                        $detalleId++;
                    }
                    //}

                    if ($almacenado) {
                        //se confirma la transacción
                        $mysqli->commit();

                        $codigoRespuesta = 1; //Operación correcta y terminada;
                    } else {
                        $mysqli->rollback();
                    }
                }

            } else {
                $mysqli->rollback();
                if ($filasAfectas == 0) {
                    $codigoRespuesta = -7; //no se hizo el insert principal
                } else if ($filasAfectas == -1) {
                    $codigoRespuesta = -8; //se produjo un error al insertar el registro principal
                }
            }
        }

    } catch (Exception $ex) {
        $mysqli->rollback();
        // echo $ex->getMessage();
        $codigoRespuesta = -9; //Se produjo una excepción en la transacción
    }

   /* if ($stmtd) {
        $stmtd->close();
    }
    if ($stmt) {
        $stmt->close();
    }*/

    $mysqli->close();
} else {

    $codigoRespuesta = 0; //La conexión es null
}

//respuesta del WS hacia Android
$jsonFinal = array("codigo" => $codigoRespuesta);
echo json_encode($jsonFinal);
