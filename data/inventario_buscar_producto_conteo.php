<?php

$codigo = $_POST['codigo'];
$identificador = $_POST['identificador'];
$idubicacion = $_POST['idubicacion'];

require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * Se busca el código entre los registros de productos contados para no duplicar
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select " .
        "idproducto," .
        "codigo," .
        "nombre," .
        "costo," .
        "promedio_ponderado," .
        "ultima_compra," .
        "existencia_sistema, " .
        "existencia_fisica," .
        "observaciones " .
        "from `db_mymsa`.`adm_inventario_app` " .
        "where (codigo = '$codigo' or nombre = '$codigo') " .
        "and ididentificadorinventario = $identificador " .
        " and idubicacion = $idubicacion;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'idproducto' => $row['idproducto'],
                    'codigo' => $row['codigo'],
                    'nombre' => $row['nombre'],
                    'costo' => $row['costo'],
                    'promedio_ponderado' => $row['promedio_ponderado'],
                    'ultima_compra' => $row['ultima_compra'],
                    'existencia_sistema' => $row['existencia_sistema'],
                    'existencia_fisica' => $row['existencia_fisica'],
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
        'idproducto' => 0,
        'codigo' => $codigoRespuesta,
        'nombre' => $mensajeRespuesta,
        'costo' => 0,
        'promedio_ponderado' => 0,
        'ultima_compra' => '',
        'existencia_sistema' => 0,
        'existencia_fisica' => 0,
        'observaciones' => '',
    );

    echo json_encode($return_arr);
}
