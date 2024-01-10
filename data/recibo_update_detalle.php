<?php
//session_start();
$reciboDetalleId = $_POST["id_detallerecibo"];
$detalleRegistro = $_POST["detalle_registro"];
require_once 'connection.php';
//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaHoraRegistro = date("Y-m-d H:i:s");
$usuarioNombre = $_SESSION["usuarioNombre"];

$codigoRespuesta = 0;
/**
 * Se almacena en la base de datos
 */
if ($mysqli !== null) {
    //inicio de transacciones
    $mysqli->autocommit(false);

    try {        
        $pago = 0;
        $tipoPago = "";
        $noDeposito = "";        
        $noCheque = "";
        $banco = "";
        $preFechado = "";
        $fechaCobro = "";
        $comentarioCheque = "";        

        if (!$stmtd = $mysqli->prepare(
            "UPDATE vnt_detalle_recibo SET " .
            "pago = ?," .
            "tipo_pago = ?," .
            "no_deposito = ?," .
            "no_cheque = ?," .
            "banco = ?," .
            "prefechado = ?," .
            "fecha_cobro = ?," .
            "fecha_modificacion = ?," .
            "comentario_cheque = ?,".
            "usuario_modificacion = ? where id_detalle_recibo = ?;")) {
            $codigoRespuesta = -4; //fallo al preparar la consulta de detalle

        } else if (!$stmtd->bind_param("dsssssssssi", $pago, $tipoPago, $noDeposito, $noCheque,
            $banco, $preFechado, $fechaCobro, $fechaHoraRegistro,$comentarioCheque,$usuarioNombre,$reciboDetalleId)) {
            $codigoRespuesta = -5; //no se pudieron vincular los parámetros a la consulta detalle
        } else {
            /**
             *Se obtiene el detalle de los items como arreglo
             */                                 
            $jsonDetalle = json_decode($detalleRegistro, true);            
            $almacenado = true;

            //foreach ($jsonDetalle as $item) {                
            foreach ($jsonDetalle as $arr) {                                
                $pago = $arr["pago"];
                $tipoPago = $arr["tipo_pago"];
                $noDeposito = $arr["no_deposito"];
                $noCheque = $arr["no_cheque"];
                $banco = $arr["banco"];
                $preFechado = $arr["prefechado"];
                $fechaCobro = $arr["fecha_cobro"];          
                $comentarioCheque = $arr["comentario_cheque"];      

                if (!$stmtd->execute()) {
                    $codigoRespuesta = -6; //fallo al ejecutar la consulta detalle
                    $almacenado = false;
                    break 1;
                }                
            }
            
            if ($almacenado) {
                //se confirma la transacción
                $mysqli->commit();

                $codigoRespuesta = 1; //Operación correcta y terminada;
            } else {
                $mysqli->rollback();
                $codigoRespuesta = -10;
            }
        }

    } catch (Exception $ex) {
        $mysqli->rollback();        
        $codigoRespuesta = -9; //Se produjo una excepción en la transacción
    }

    $mysqli->close();
} else {

    $codigoRespuesta = 0; //La conexión es null
}

$return_arr = array();
$indice = 0;
$return_arr[$indice] = array(
    "codigo" => $codigoRespuesta,
    "id_detallerecibo" => $reciboDetalleId,
);

//header('Content-Type: application/json');
echo json_encode($return_arr);