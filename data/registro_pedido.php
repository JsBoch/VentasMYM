<?php
session_start();
$solicitudId = $_POST["id_solicitud"];
$registroMain = $_POST["registro_principal"];
$detalleRegistro = $_POST["detalle_registro"];

//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaHoraRegistro = date("Y-m-d H:i:s");

$codigoRespuesta = 0;
/**
 * Se obtiene el registro principal del registro de pedido como objeto
 */
$jsonMain = json_decode($registroMain, true);
foreach ($jsonMain as $item) {
    $clienteID = $item["id_cliente"]; //$jsonMain->id_cliente;
    $departamentoID = $item["id_departamento"]; //$jsonMain->id_departamento;
    $municipioID = 0; //$jsonMain->id_municipio;
    $empleadoID = $_SESSION["usuarioId"]; //$jsonMain->id_empleado;
    $codigoCliente = ''; //$jsonMain->codigo_cliente;
    $nombreCliente = ''; //$jsonMain->nombre_cliente;
    $observacionesRegistro = $item["observaciones"]; //$jsonMain->observaciones;
    $estadoRegistro = 1;
    $prioridad = $item["prioridad"];
    $noSolicitud = $item["nosolicitud"];
}
/**
 * Se almacena en la base de datos
 */
require_once 'connection.php';

if ($mysqli !== null) {
    //inicio de transacciones
    $mysqli->autocommit(false);
    /**
     * Sí el id de solicitud es mayor a cero, entonces se elimina el registro original
     * del pedido.
     */
    if ($solicitudId > 0) {

        $query = "update vnt_detalle_solicitud_producto SET estado = 0 WHERE id_solicitud = $solicitudId;";
        $mysqli->query($query);
        $query = "update vnt_solicitud_producto set estado = 0 WHERE id_solicitud = $solicitudId;";
        $mysqli->query($query);
    }
    //IDs
    if ($solicitudId > 0) {
        $query = "select " .
        "if(max(id_solicitud) is null,1,max(id_solicitud) + 1) as id_solicitud " .        
        "from vnt_solicitud_producto;";
    }
    else 
    {
        $query = "select " .
        "if(max(id_solicitud) is null,1,max(id_solicitud) + 1) as id_solicitud, " .
        "if(max(nosolicitud) is null,1,max(nosolicitud) + 1) as nosolicitud " .
        "from vnt_solicitud_producto;";
    }

    $resultado = $mysqli->query($query);
    $fila = $resultado->fetch_assoc();

    $envioID = intval($fila["id_solicitud"]);

    if($solicitudId > 0)
    {
        $solicitudID = $noSolicitud;
    }
    else 
    {
        $solicitudID = intval($fila["nosolicitud"]);
    }
    

    try {
        if (!$stmt = $mysqli->prepare(
            "INSERT INTO vnt_solicitud_producto (" .
            "id_solicitud," .
            "nosolicitud," .
            "id_departamento," .
            "id_municipio," .
            "id_empleado," .
            "codigo_cliente," .
            "nombre_cliente," .
            "fecha_registro," .
            "observaciones," .
            "estado," .
            "id_cliente," .
            "prioridad) " .
            " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?);")) {
            //echo "fallo No." . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -1;

        } else
        if (!$stmt->bind_param("iiiiissssiis", $envioID, $solicitudID, $departamentoID, $municipioID, $empleadoID,
            $codigoCliente, $nombreCliente, $fechaHoraRegistro, $observacionesRegistro, $estadoRegistro, $clienteID,$prioridad)) {
            //echo "fallo la vinculacion: " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -2;
        } else if (
            !$stmt->execute()) {
            //echo "Fallo la ejecución " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -3;
        } else {

            $filasAfectas = $mysqli->affected_rows;

            if ($filasAfectas > 0) {
                $codigoProducto = "";
                $nombreProducto = "";
                $cantidad = 0;
                $tipoPrecio = "";
                $precio = 0.00;
                $subtotal = 0.00;
                $observacionesProducto = "";
                $estadoProducto = 1;
                $empresaID = 0;

                if (!$stmtd = $mysqli->prepare(
                    "INSERT INTO vnt_detalle_solicitud_producto (" .
                    "id_solicitud," .
                    "codigo_producto," .
                    "nombre_producto," .
                    "cantidad," .
                    "tipo_precio," .
                    "precio," .
                    "subtotal," .
                    "observaciones," .
                    "estado," .
                    "id_empresa) " .
                    " VALUES (?,?,?,?,?,?,?,?,?,?);")) {
                    $codigoRespuesta = -4; //fallo al preparar la consulta de detalle

                } else if (!$stmtd->bind_param("issisddsii", $envioID, $codigoProducto, $nombreProducto, $cantidad,
                    $tipoPrecio, $precio, $subtotal, $observacionesProducto, $estadoProducto, $empresaID)) {
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
                        $codigoProducto = $arr["codigo_producto"];
                        $nombreProducto = $arr["nombre_producto"];
                        $cantidad = $arr["cantidad"];
                        $tipoPrecio = $arr["tipoprecio"];
                        $precio = $arr["precio"];
                        $subtotal = $arr["subtotal"];
                        $observacionesProducto = $arr["observaciones"];

                        if (!$stmtd->execute()) {
                            $codigoRespuesta = -6; //fallo al ejecutar la consulta detalle
                            $almacenado = false;
                            break 1;
                        }
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

    if ($stmtd) {
        $stmtd->close();
    }
    if ($stmt) {
        $stmt->close();
    }

    $mysqli->close();
} else {

    $codigoRespuesta = 0; //La conexión es null
}

//respuesta del WS hacia Android
$jsonFinal = array("codigo" => $codigoRespuesta);
echo json_encode($jsonFinal);
