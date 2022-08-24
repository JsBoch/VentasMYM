<?php
$producto = $_POST["producto"];

require_once 'connection.php';

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {

    $stmt = "SELECT " .
        "p.codigormym " .        
        "FROM adm_producto p " .        
        "WHERE p.estado = 1 " .
        "AND (p.nombre = '$producto';";         

    $result = $mysqli->query($stmt);

    $indice = 0;
    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'codigo' => $row['codigormym']                  
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
        'codigo' => $codigoRespuesta      
    );

    echo json_encode($return_arr);
}