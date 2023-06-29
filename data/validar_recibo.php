<?php

$recibo = $_POST["recibo"];
require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * Se obtiene el registro principal del registro de pedido como objeto
 */
$jsonRecibo = json_decode($recibo, true);

$reciboID;
$clienteID;
$fechaRegistro;
foreach ($jsonRecibo as $item) {
    $reciboID = $item["id_recibo"]; //$jsonMain->id_cliente;
    $clienteID = $item["id_cliente"]; //$jsonMain->id_departamento;
}
//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaRegistro = date("Ymd");

/**
 * Se ejecuta una consulta en la base de datos para corroborar
 * que el registro de pedido se haya guardado.
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId']; //vendedor
    $usuarioId = $_SESSION['usuarioId']; //usuario que registra
    $Anio = date("Y");

    $stmt = "select count(1) as cantidad " .
        "from vnt_registro_recibo " .
        "where id_recibo = $reciboID " .
        "and id_cliente = $clienteID " .
        "and id_usuario = $usuarioId " .
        "and date(fecha_registro) = '$fechaRegistro';";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'cantidad' => $row['cantidad'],
                );
                $indice++;
            }

            echo json_encode($return_arr);
            $result->close();
        } else {
            $codigoRespuesta = -3; //no hay registros
            $result->close();
        }
    } else {
        $codigoRespuesta = -2; //fallo en la consulta
    }
    $mysqli->close();
} else {
    $codigoRespuesta = -1; //fallo de conexión
}

if ($codigoRespuesta != 1) {
    $mensajeRespuesta = "";
    switch ($codigoRespuesta) {
        case -1:{
                $mensajeRespuesta = "FALLO DE CONEXION";
                break;
            }
        case -2:{
                $mensajeRespuesta = "FALLO DE CONSULTA";
                break;
            }
        case -3:{
                $mensajeRespuesta = "NO HAY REGISTROS";
                break;
            }
    }

    $return_arr = array();
    $Indice = 0;
    $return_arr[$Indice] = array(
        'cantidad' => 0,
    );

    echo json_encode($return_arr);
}
