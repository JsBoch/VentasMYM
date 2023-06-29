<?php
$codigo = $_POST["codigo"];

require_once 'connection.php';

$codigoRespuesta = 1;
$stmt = "";
if ($mysqli !== null && $mysqli->connect_errno === 0) {    
    
    if (intval($_SESSION['sucursal']) == 1) {
        $stmt = "SELECT " .
            "p.nombre " .
            "FROM `db_mymsa`.`adm_producto` p " .
            "WHERE p.estado = 1 " .
            "AND p.codigormym = '$codigo' ";
            "GROUP BY nombre;";
    } else if (intval($_SESSION['sucursal']) == 2) {
        $stmt = "SELECT " .
            "p.nombre " .
            "FROM `db_mymsapt`.`adm_producto` p " .
            "WHERE p.estado = 1 " .
            "AND p.codigormym = '$codigo' " .
            "GROUP BY nombre;";
    }
    else if (intval($_SESSION['sucursal']) == 3) {
        $stmt = "SELECT " .
            "p.nombre " .
            "FROM `db_mymsaxela`.`adm_producto` p " .
            "WHERE p.estado = 1 " .
            "AND p.codigormym = '$codigo' " .
            "GROUP BY nombre;";
    }

    $result = $mysqli->query($stmt);

    $indice = 0;
    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'nombre' => $row['nombre'],
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
                $mensajeRespuesta = "NO SE LOCALIZARON REGISTROS ";
                break;
            }
    }
    $return_arr = array();
    $indice = 0;
    $return_arr[$indice] = array(
        'nombre' => $mensajeRespuesta
    );

    echo json_encode($return_arr);
}
