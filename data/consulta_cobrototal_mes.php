<?php

$mesSelect = $_POST['mes'];
require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * se obtiene el listado de clientes filtrado por departamento y vendedor
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId'];
    $usuarioId = $_SESSION['usuarioId'];
    $Anio = date("Y");
    $from = "";
    $join = "";

    $stmt = "select ".
    "sum(r.cobro) as cobro ".
    "from vnt_registro_recibo r ". 
    "where r.estado > 0 ". 
    "and r.id_usuario = $usuarioId " .
    "and month(fecha_registro) = $mesSelect;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'cobro' => $row['cobro'],
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
        'cobro' => 0,
    );

    echo json_encode($return_arr);
}
