<?php

$fechaInicio = $_POST['fechaInicio'];
$fechaFinal = $_POST['fechaFinal'];

require_once 'connection.php';

//$cliente = $_GET["cliente"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $query = "select " .
        "s.id_solicitud," .
        "s.nosolicitud," .
        "date(s.fecha_registro) as fecha_registro," .
        "c.primer_nombre as cliente," .
        "d.nombre as departamento," .
        "if(s.estado = 1,'INGRESADO',if(s.estado = 2,'DISTRIBUIDO',if(s.estado = 3,'AUTORIZADO',if(s.estado = 4,'DESPACHADO',if(s.estado = 5,'RECHAZADO','PENDIENTE'))))) as estado " .
        "from vnt_solicitud_producto s " .
        "join clientes c on s.id_cliente = c.idcliente " .
        "join adm_departamentopais d on c.iddepartamento = d.iddepartamento " .
        "where s.estado > 0 " .
        "and date(s.fecha_registro) >= ? " .
        "and date(s.fecha_registro) <= ?;";

    /*$result = $mysqli->query($stmt);

    if ($result !== false) {
    if ($result->num_rows > 0) {
    $return_arr = array();
    $indice = 0;
    while ($row = $result->fetch_array()) {
    $return_arr[$indice] = array(
    'idcliente' => $row['idcliente'],
    'codigo' => $row['codigo'],
    'nombre' => $row['nombre'],
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
    }*/
    if (!$stmt = $mysqli->prepare($query)) {
        $codigoRespuesta = -3; //Fallo al preparar la consulta de registro
        echo $mysqli->errno . ' ' . $mysqli->error;
    } else {
        if (!$stmt->bind_param(
            "ss",
            $fechaInicio,
            $fechaFinal)) {
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
                        'id_solicitud' => $row['id_solicitud'],
                        'nosolicitud' => $row['nosolicitud'],
                        'fecha_registro' => $row['fecha_registro'],
                        'cliente' => $row['cliente'],
                        'departamento' => $row['departamento'],
                        'estado' => $row['estado'],
                    );
                    $indice++;
                }

                echo json_encode($return_arr);
                $result->close();
            }
        }

        $mysqli->close();

    }} else {
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
                $mensajeRespuesta = "FALLO AL PREPARAR CONSULTA";
                break;
            }
        case -4:{
                $mensajeRespuesta = "FALLO AL VINCULAR PARAMETROS";
                break;
            }
        case -5:{
                $mensajeRespuesta = "FALLO LA CONSULTA";
                break;
            }
    }

    $return_arr = array();
    $Indice = 0;
    $return_arr[$Indice] = array(
        'id_solicitud' => 0,
        'nosolicitud' => $codigoRespuesta,
        'fecha_registro' => $mensajeRespuesta,
        'cliente' => '',
        'departamento' => '',
        'estado' => '',
    );

    echo json_encode($return_arr);
}
