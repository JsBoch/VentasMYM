<?php

$clienteId = $_POST['idcliente'];
require_once 'connection.php';

//$cliente = $_GET["cliente"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select " .
        "c.idcliente," .
        "c.codigo," .
        "c.nit," .
        "c.cui as dpi," .
        "c.primer_nombre as nombre," .
        "c.razonsocial," .
        "d.nombre as departamento," .
        "c.id_municipio as municipio," .
        "c.direccion," .
        "c.telefono," .
        "c.email," .
        "c.region," .
        "c.comentario," .
        "c.codigo_postal," .
        "c.transporte," .
        "c.latitud," .
        "c.longitud " .
        "from clientes c " .
        "join adm_departamentopais d on c.iddepartamento = d.iddepartamento " .
       // "join adm_municipio m on c.id_municipio = m.id_municipio " .
        "where c.idcliente = $clienteId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'idcliente' => $row['idcliente'],
                    'codigo' => $row['codigo'],
                    'nit' => $row['nit'],
                    'dpi' => $row['dpi'],
                    'nombre' => $row['nombre'],
                    'razonsocial' => $row['razonsocial'],
                    'departamento' => $row['departamento'],
                    'municipio' => $row['municipio'],
                    'direccion' => $row['direccion'],
                    'telefono' => $row['telefono'],
                    'email' => $row['email'],
                    'region' => $row['region'],
                    'comentario' => $row['comentario'],
                    'codigo_postal' => $row['codigo_postal'],
                    'transporte' => $row['transporte'],
                    'latitud' => $row['latitud'],
                    'longitud' => $row['longitud'],
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
        'idcliente' => 0,
        'codigo' => $codigoRespuesta,
        'nit' => '',
        'dpi' => '',
        'nombre' => $mensajeRespuesta,
        'razonsocial' => '',
        'email' => '',
        'departamento' => '',
        'municipio' => '',
        'region' => '',
        'direccion' => '',
        'telefono' => '',
        'comentario' => '',
        'codigo_postal' => 0,
        'transporte' => '',
        'latitud' => '',
        'longitud' => '',
    );

    echo json_encode($return_arr);
}
