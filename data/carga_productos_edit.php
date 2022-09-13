<?php

$solicitudId = $_POST['id_solicitud'];
require_once 'connection.php';

//$cliente = $_GET["cliente"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select ".
    "d.codigo_producto,".
    "d.nombre_producto,".
    "d.cantidad,".
    "d.tipo_precio,".
    "d.precio,".
    "d.subtotal,".
    "d.observaciones ".
    "from vnt_detalle_solicitud_producto d ". 
    "where d.estado = 1 ".
    "and d.id_solicitud = $solicitudId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'codigo_producto' => $row['codigo_producto'],
                    'nombre_producto' => $row['nombre_producto'],
                    'cantidad' => $row['cantidad'],
                    'tipo_precio' => $row['tipo_precio'],
                    'precio' => $row['precio'],
                    'subtotal' => $row['subtotal'],
                    'observaciones' => $row['observaciones'],
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
        'codigo_producto' => 0,
        'nombre_producto' => '',
        'cantidad' => 0,
        'tipo_precio' => '',
        'precio' => 0,
        'subtotal' => 0,
        'observaciones' => ''
    );

    echo json_encode($return_arr);
}
