<?php
require_once 'connection.php';

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {

    $stmt = "select ididentificadorinventario, nombre " . 
    "from `db_mymsa`.`adm_identificador_inventario_app` " .
    "where estado = 1;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            
            /*$return_arr['departamentos'] = array();
            while ($row = $result->fetch_array()) {
                array_push($return_arr['departamentos'], array(
                    'iddepartamento' => $row['iddepartamento'],                    
                    'nombre' => $row['nombre'],
                    'codigo_postal' => $row['codigo_postal']                    
                ));
            }*/

            $return_arr['identificadores'] = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] =  array(
                    'ididentificadorinventario' => $row['ididentificadorinventario'],                    
                    'nombre' => $row['nombre']                               
                );

                $indice++;
            }

            header('Content-Type: application/json');
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
    /*$return_arr['departamentos'] = array();
    array_push($return_arr['departamentos'], array(        
        'iddepartamento' => $codigoRespuesta,
        'nombre' => $mensajeRespuesta,
        'codigo_postal' => '0'        
    ));*/

    $return_arr = array();
    $return_arr = array(        
        'ididentificadorinventario' => $codigoRespuesta,
        'nombre' => $mensajeRespuesta               
    );

    header('Content-Type: application/json');
    echo json_encode($return_arr);
}