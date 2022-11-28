<?php

$solicitudId = $_POST['id_solicitud'];
require_once 'connection.php';

//$cliente = $_GET["cliente"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select ".
    "r.id_recibo,". 
    "r.no_recibo,".
    "d.iddepartamento,".
    "r.id_cliente,".
    "c.primer_nombre as cliente,". 
    "r.semana,".
    "r.observacion ".
    "from vnt_registro_recibo r ".
    "join clientes c on r.id_cliente = c.idcliente ".
    "join adm_departamentopais d on c.iddepartamento = d.iddepartamento ".
    "where r.id_recibo = $solicitudId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'id_recibo' => $row['id_recibo'],
                    'no_recibo' => $row['no_recibo'],
                    'iddepartamento' => $row['iddepartamento'],
                    'id_cliente' => $row['id_cliente'],
                    'cliente' => $row['cliente'],
                    'semana' => $row['semana'],
                    'observacion' => $row['observacion'],           
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
        'id_recibo' => 0,
        "no_recibo" => 0,
        'iddepartamento' => 0,
        'id_cliente' => 0,   
        'cliente' => '',        
        'semana' => '',
        'observacion' => '',
    );

    echo json_encode($return_arr);
}
