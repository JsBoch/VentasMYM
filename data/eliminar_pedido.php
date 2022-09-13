<?php
$solicitudId = $_POST["id_solicitud"];

require_once 'connection.php';

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {

    $query = "update vnt_detalle_solicitud_producto SET estado = 0 WHERE id_solicitud = $solicitudId;";
    $result = $mysqli->query($query);
    if($result)
    {
        $query = "update vnt_solicitud_producto set estado = 0 WHERE id_solicitud = $solicitudId;";
        $result = $mysqli->query($query);         
                
        if ($result) {
            $filasAfectas = $mysqli->affected_rows;
            if($filasAfectas >= 0)
            {
            /*if ($result->num_rows > 0) {
                $return_arr = array();
                while ($row = $result->fetch_array()) {
                    $return_arr[0] = array(
                        'codigo' => 1                  
                    );                    
                }*/

                $jsonFinal = array("codigo" => $codigoRespuesta);
                echo json_encode($jsonFinal);
                $result->close();
            } 
            else {
                $codigoRespuesta = -4; // no se localizaron registros
                $result->close();
            }
        } else {
            $codigoRespuesta = -3; //fallo pdate a pedido
        }
    
        $mysqli->close();
    } else {
        $codigoRespuesta = -2; //fallo update a detalle
    }
    }
    else {
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
                $mensajeRespuesta = "FALLO DE CONSULTA";
                break;
            }
        case -4:{
                $mensajeRespuesta = "NO SE LOCALIZARON REGISTROS";
                break;
            }
    }
    $return_arr = array();
    $indice = 0;
    $return_arr[$indice] = array(
        'codigo' => $codigoRespuesta      
    );

    echo json_encode($return_arr);
}