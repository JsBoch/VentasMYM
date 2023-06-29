<?php

$noDeposito = $_POST['no_deposito'];
$banco = $_POST['banco'];

require_once 'connection.php';

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select " .
    "r.no_recibo," .
    "count(d.no_deposito) as cantidad " .
    "from vnt_registro_recibo r " . 
    "join vnt_detalle_recibo d on r.id_recibo = d.id_recibo " .
    "where r.estado > 0 " . 
    "and d.no_deposito = '$noDeposito' " .
    "and d.banco = '$banco';";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'no_recibo' => $row['no_recibo'],
                    'cantidad' => $row['cantidad']
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
        'no_recibo' => 0,
        'cantidad' => -8
    );

    echo json_encode($return_arr);
}
?>