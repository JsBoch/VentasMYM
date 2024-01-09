<?php
/**
 * Este archivo contiene el código que obtiene de la base de datos los registros de recibos
 * dentro de un mes y año específicos
 */
$mesSelect = $_POST['mes'];
$anioSelect = $_POST['anio'];
require_once 'connection.php';

$codigoRespuesta = 1;


if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId'];
    $usuarioId = $_SESSION['usuarioId'];
    
    $stmt = "select ".
    "r.id_recibo,".
    "r.serie_recibo,".
    "r.no_recibo,".
    "r.cobro,".
    "r.fecha_recibo,".
    "r.observacion,".
    "if(r.estado = 0,'ANULADO','ACTIVO') as estado ".
    "from vnt_registro_recibo r ". 
    "where month(r.fecha_recibo) = $mesSelect and year(r.fecha_registro) = $anioSelect;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'id_recibo' => $row['id_recibo'],
                    'serie_recibo' => $row['serie_recibo'],
                    'no_recibo' => $row['no_recibo'],
                    'cobro' => $row['cobro'],
                    'fecha_recibo' => $row['fecha_recibo'],
                    'observacion' => $row['observacion'],
                    'estado' => $row['estado']
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
        'id_recibo' => $codigoRespuesta,
                    'serie_recibo' => '',
                    'no_recibo' => '',
                    'cobro' => 0,
                    'fecha_recibo' => '',
                    'observacion' => '',
                    'estado' => 0
    );

    echo json_encode($return_arr);
}
