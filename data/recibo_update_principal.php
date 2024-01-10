<?php
//session_start();
$reciboId = $_POST["id_recibo"];
$registroMain = $_POST["registro_principal"];
require_once 'connection.php';
//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaHoraRegistro = date("Y-m-d H:i:s");

$codigoRespuesta = 0;
/**
 * Se obtiene el registro principal del registro de recibo como objeto
 */
$jsonMain = json_decode($registroMain, true);
foreach ($jsonMain as $item) {
    $fechaRecibo = $item["fecha"];
    $observacionesRegistro = $item["observaciones"]; //$jsonMain->observaciones;
    $usuarioNombre = $_SESSION["usuarioNombre"];
}
/**
 * Se almacena en la base de datos
 */

if ($mysqli !== null) {
    //inicio de transacciones
    $mysqli->autocommit(false);

    try {
        if (!$stmt = $mysqli->prepare(
            "UPDATE vnt_registro_recibo SET " .
            "fecha_recibo = ?," .
            "observacion = ?," .
            "fecha_modificacion = ?," .
            "usuario_modificacion = ? " .
            "WHERE id_recibo = ?;")) {
            $codigoRespuesta = -1;

        } else
        if (!$stmt->bind_param("ssssi", $fechaRecibo, $observacionesRegistro, $fechaHoraRegistro, $usuarioNombre, $reciboId)) {
            //echo "fallo la vinculacion: " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -2;
        } else if (
            !$stmt->execute()) {
            //echo "Fallo la ejecución " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -3;
        } else {
            $mysqli->commit();
            $codigoRespuesta = 1; //Operación correcta y terminada;
        }

    } catch (Exception $ex) {
        $mysqli->rollback();
        // echo $ex->getMessage();
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
    "id_recibo" => $reciboId,
);

//header('Content-Type: application/json');
echo json_encode($return_arr);