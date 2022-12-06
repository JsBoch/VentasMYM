<?php

$solicitudId = $_POST['id_solicitud'];
require_once 'connection.php';

//$cliente = $_GET["cliente"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select ".
    "d.no_envio,".
    "d.no_deposito,".
    "d.caja_rural,".
    "d.empresa,".
    "d.no_cheque,".
    "d.tipo_pago,".
    "d.pago,".
    "d.pago_total,".
    "d.observaciones,".
    "d.banco,".
    "d.compra_contado ".
    "from vnt_detalle_recibo d ".
    "where d.id_recibo = $solicitudId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'no_envio' => $row['no_envio'],
                    'no_deposito' => $row['no_deposito'],
                    'caja_rural' => $row['caja_rural'],
                    'empresa' => $row['empresa'],
                    'no_cheque' => $row['no_cheque'],
                    'tipo_pago' => $row['tipo_pago'],
                    'pago' => $row['pago'],
                    'pago_total' => $row['pago_total'],
                    'observaciones' => $row['observaciones'],
                    'banco' => $row['banco'],
                    'compra_contado' => $row['compra_contado']
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
        'no_envio' => 0,
        'no_deposito' => '',
        'caja_rural' => '',
        'empresa' => '',
        'no_cheque' => '',
        'tipo_pago' => '',
        'pago' => 0,
        'pago_total' => 0,
        'observaciones' => '',
        'banco' => '',
        'compra_contado' => ''
    );

    echo json_encode($return_arr);
}
