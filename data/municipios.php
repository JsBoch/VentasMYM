<?php

$departamentoId = $_POST['departamentoId'];

require_once 'connection.php';

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {

    $stmt = "SELECT m.id_municipio," . 
    "m.id_departamento,".
    "m.nombre " .
    "FROM adm_municipio m " .
    "where m.estado = 1 " . 
    "and m.id_departamento = $departamentoId " .
    " order by m.id_departamento;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'id_municipio' => $row['id_municipio'],
                    'id_departamento' => $row['id_departamento'],
                    'nombre' => $row['nombre']                    
                );
                $indice++;
            }

            echo json_encode($return_arr);
            $result->close();
        } else {
            $codigoRespuesta = -3; // no se localizaron registros
            $result->close();
        }
    } else {
        $codigoRespuesta = -2; //no se realizó la consulta
    }

    $mysqli->close();
} else {
    $codigoRespuesta = -1; //fallo con la conexión
}

if ($codigoRespuesta !== 1) {
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
                $mensajeRespuesta = "NO SE LOCALIZARON REGISTROS";
                break;
            }
    }

    $return_arr = array();
    $indice = 0;
    $return_arr[$indice] = array(
        'id_municipio' => $codigoRespuesta,
        'id_departamento' => 0,
        'nombre' => $mensajeRespuesta        
    );

    echo json_encode($return_arr);
}