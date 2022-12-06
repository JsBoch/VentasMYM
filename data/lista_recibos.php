<?php

$fechaInicio = $_POST['fechaInicio'];
$fechaFinal = $_POST['fechaFinal'];

require_once 'connection.php';

//$cliente = $_GET["cliente"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $query = "select " .
        "r.id_recibo," .
        "r.no_recibo," .
        "r.nombre_cliente," .
        "r.cobro " .
        "from vnt_registro_recibo r " .
        "where r.estado = 1 " .
        "and date(r.fecha_registro) >= ? " .
        "and date(r.fecha_registro) <= ?;";

    if (!$stmt = $mysqli->prepare($query)) {
        $codigoRespuesta = -3; //Fallo al preparar la consulta de registro
        echo $mysqli->errno . ' ' . $mysqli->error;
    } else {
        if (!$stmt->bind_param(
            "ss",
            $fechaInicio,
            $fechaFinal
        )) {
            $codigoRespuesta = -4; //fallo al vincular parametros de registro
            $stmt->close();
        } else if (!$stmt->execute()) {
            $codigoRespuesta = -5; //fallo la ejecución de la consulta
            $stmt->close();
        } else {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $return_arr = array();
                $indice = 0;
                while ($row = $result->fetch_assoc()) {
                    $return_arr[$indice] = array(
                        'id_recibo' => $row['id_recibo'],
                        'no_recibo' => $row['no_recibo'],
                        'nombre_cliente' => $row['nombre_cliente'],
                        'cobro' => $row['cobro'],
                    );
                    $indice++;
                }

                echo json_encode($return_arr);
                $result->close();
            }
        }

        $mysqli->close();
    }
} else {
    $codigoRespuesta = -1; //fallo de conexión
}

if ($codigoRespuesta != 1) {
    $mensajeRespuesta = "";
    switch ($codigoRespuesta) {
        case -1: {
                $mensajeRespuesta = "FALLO DE CONEXION";
                break;
            }
        case -2: {
                $mensajeRespuesta = "FALLO DE CONSULTA";
                break;
            }
        case -3: {
                $mensajeRespuesta = "FALLO AL PREPARAR CONSULTA";
                break;
            }
        case -4: {
                $mensajeRespuesta = "FALLO AL VINCULAR PARAMETROS";
                break;
            }
        case -5: {
                $mensajeRespuesta = "FALLO LA CONSULTA";
                break;
            }
    }

    $return_arr = array();
    $Indice = 0;
    $return_arr[$Indice] = array(
        'id_recibo' => 0,
        'no_recibo' => $codigoRespuesta,
        'nombre_cliente' => $mensajeRespuesta,
        'cobro' => 0,
    );

    echo json_encode($return_arr);
}
