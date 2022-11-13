<?php

$solicitudId = $_POST['id_solicitud'];
require_once 'connection.php';

//$cliente = $_GET["cliente"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select ".
    "s.id_solicitud,".
    "s.nosolicitud,".
    "d.nombre as departamento,".
    "c.primer_nombre as cliente,".
    "s.observaciones," .
    "s.id_departamento," .
    "s.id_cliente," .
    "s.prioridad," .
    "s.transporte ".
    "from vnt_solicitud_producto s ". 
    "join clientes c on s.id_cliente = c.idcliente ". 
    "join adm_departamentopais d on c.iddepartamento = d.iddepartamento ".
    "where s.estado > 0 ".
    "and s.id_solicitud = $solicitudId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'id_solicitud' => $row['id_solicitud'],
                    'nosolicitud' => $row['nosolicitud'],
                    'departamento' => $row['departamento'],
                    'cliente' => $row['cliente'],
                    'observaciones' => $row['observaciones'],
                    'id_departamento' => $row['id_departamento'],
                    'id_cliente' => $row['id_cliente'],
                    'prioridad' => $row['prioridad'],
                    'transporte' => $row['transporte']                
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
        'id_solicitud' => 0,
        "nosolicitud" => 0,
        'departamento' => '',
        'cliente' => '',        
        'observaciones' => '',
        'id_departamento' => 0,
        'id_cliente' => 0,
        'prioridad' => 'NORMAL',
        'transporte' => ''
    );

    echo json_encode($return_arr);
}
