<?php
/**
 * Este archivo contiene el código que obtiene de la base de datos los registros del
 * detalle de un recibo seleccionado
 */
$reciboId = $_POST['reciboId'];

require_once 'connection.php';

$codigoRespuesta = 1;


if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId'];
    $usuarioId = $_SESSION['usuarioId'];
    
    $stmt = "select ".
    "e.no_envio,".
    "e.monto,".
    "e.abono,".
    "e.saldo,".
    "e.pago,".
    "e.tipo_pago,".
    "e.pago_total,".
    "e.no_deposito,".
    "e.no_cheque,".
    "e.banco,".
    "e.observaciones,".
    "e.prefechado,".
    "e.fecha_cobro,".
    "e.cobrado,".
    "e.comentario_cheque,".
    "e.mensaje_seguimiento_cheque,".
    "e.mensaje_deposito,".
    "e.mensaje_cheque,".
    "e.id_detalle_recibo ".
    "from vnt_detalle_recibo e  ".
    "where e.estado = 1 ".
    "and e.id_recibo = $reciboId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'no_envio' => $row['no_envio'],
                    'monto' => $row['monto'],
                    'abono' => $row['abono'],
                    'saldo' => $row['saldo'],
                    'pago' => $row['pago'],
                    'tipo_pago' => $row['tipo_pago'],
                    'pago_total' => $row['pago_total'],
                    'no_deposito' => $row['no_deposito'],
                    'tipo_pago' => $row['tipo_pago'],
                    'pago_total' => $row['pago_total'],
                    'no_deposito' => $row['no_deposito'],
                    'no_cheque' => $row['no_cheque'],
                    'banco' => $row['banco'],
                    'observaciones' => $row['observaciones'],
                    'prefechado' => $row['prefechado'],
                    'fecha_cobro' => $row['fecha_cobro'],
                    'cobrado' => $row['cobrado'],
                    'comentario_cheque' => $row['comentario_cheque'],
                    'mensaje_seguimiento_cheque' => $row['mensaje_seguimiento_cheque'],
                    'mensaje_deposito' => $row['mensaje_deposito'],
                    'mensaje_cheque' => $row['mensaje_cheque'],
                    'id_detalle_recibo' => $row['id_detalle_recibo']
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
        'no_envio' => 0,
                    'monto' => 0,
                    'abono' => 0,
                    'saldo' => 0,
                    'pago' => 0,
                    'tipo_pago' => '',
                    'pago_total' => '',
                    'no_deposito' => 0,
                    'tipo_pago' => '',
                    'pago_total' => 0,                    
                    'no_cheque' => 0,
                    'banco' => '',
                    'observaciones' => '',
                    'prefechado' => '',
                    'fecha_cobro' => '',
                    'cobrado' => '',
                    'comentario_cheque' => '',
                    'mensaje_seguimiento_cheque' => '',
                    'mensaje_deposito' => '',
                    'mensaje_cheque' => '',
                    'id_detalle_recibo' => $codigoRespuesta
    );

    echo json_encode($return_arr);
}
