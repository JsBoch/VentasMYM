<?php

$departamentoId = $_POST['iddepartamento'];
require_once 'connection.php';

$vendedorId = $_SESSION["empleadoId"];

$codigoRespuesta = 1;

/**
 * se obtiene el listado de clientes filtrado por departamento y vendedor
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "SELECT c.idcliente,c.codigo," .
        "c.primer_nombre as nombre," .
        "c.iddepartamento," .
        "c.id_municipio," .
        "c.direccion " .
        "FROM clientes c " .
        "WHERE c.estado = 1 " .
        "AND c.iddepartamento = $departamentoId ".
        "AND c.id_empleado = $vendedorId " . 
        " ORDER BY c.primer_nombre;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'idcliente' => $row['idcliente'],
                    'codigo' => $row['codigo'],
                    'nombre' => $row['nombre'],
                    'direccion' => $row['direccion'],
                    'iddepartamento' => $row['iddepartamento'],
                    'idmunicipio' => $row['id_municipio']
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
        'nombre' => $mensajeRespuesta,
        'direccion' => "",
        'iddepartamento' => 0,
        'idmunicipio' => 0
    );

    echo json_encode($return_arr);
}