<?php

$reciboId = $_POST['id_recibo'];
require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * se obtiene el listado de clientes filtrado por departamento y vendedor
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {    

    $stmt = "select ".    
    "r.serie_recibo,".
    "r.no_recibo,".
    "r.fecha_recibo,".
    "format(r.cobro,2) as cobro,".
    "r.observacion,".
    "e.no_envio,".
    "format(e.monto,2) as monto,".
    "format(e.abono,2) as abono,".
    "format(e.saldo,2) as saldo,".
    "format(e.pago,2) as pago,".
    "e.tipo_pago,".
    "e.no_cheque,".
    "e.banco,".
    "e.prefechado,".
    "e.fecha_cobro,".
    "e.comentario_cheque ".
    "from vnt_registro_recibo r ".
    "join vnt_detalle_recibo e on r.id_recibo = e.id_recibo and e.estado = 1 ".
    "where e.estado = 1 ".
    "and e.id_recibo = $reciboId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'serie_recibo' => $row['serie_recibo'],
                    'no_recibo' => $row['no_recibo'],
                    'fecha_recibo' => $row['fecha_recibo'],
                    'cobro' => $row['cobro'],
                    'observacion' => $row['observacion'],
                    'no_envio' => $row['no_envio'],
                    'monto' => $row['monto'],
                    'abono' => $row['abono'],
                    'saldo' => $row['saldo'],
                    'pago' => $row['pago'],
                    'tipo_pago' => $row['tipo_pago'],
                    'no_cheque' => $row['no_cheque'],
                    'banco' => $row['banco'],
                    'prefechado' => $row['prefechado'],
                    'fecha_cobro' => $row['fecha_cobro'],
                    'comentario_cheque' => $row['comentario_cheque']
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
        'serie_recibo' => $codigoRespuesta,
                    'no_recibo' => 0,
                    'fecha_recibo' => '',
                    'cobro' => 0,
                    'observacion' => '',
                    'no_envio' => 0,
                    'monto' => 0,
                    'abono' => 0,
                    'saldo' => 0,
                    'pago' => 0,
                    'tipo_pago' => '',
                    'no_cheque' => '',
                    'banco' => '',
                    'prefechado' => '',
                    'fecha_cobro' => '',
                    'comentario_cheque' => ''
    );

    echo json_encode($return_arr);
}