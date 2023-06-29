<?php

$clienteId = $_POST['idcliente'];
require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * se obtiene el listado de clientes filtrado por departamento y vendedor
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $from = "";
    $join = "";

    //sucursal 1 es central 2 es petén
    if (intval($sucursal) == 1) {
        $from = "from `db_mymsa`.`adm_venta` v ";
        $join = "join `db_mymsa`.`saldoxcobrar` s on v.idventa = s.idventa ";
    } else if(intval("sucursal") == 2) {
        $from = "from `db_mymsapt`.`adm_venta` v ";
        $join = "join `db_mymsapt`.`saldoxcobrar` s on v.idventa = s.idventa ";
    } else if(intval("sucursal") == 3){
        $from = "from `db_mymsaxela`.`adm_venta` v ";
        $join = "join `db_mymsaxela`.`saldoxcobrar` s on v.idventa = s.idventa ";
    }

    $stmt = "select " .
        "v.idventa," .
        "v.seriefactura," .
        "v.nofactura," .
        "s.monto," .
        "s.abono," .
        "s.saldo," .
        "datediff(now(),s.fecha_vencimiento) as dias_vencimiento " .
        $from .
        $join .
        "where v.estado > 0 " .
        "and v.tipo = 'E' " .
        "and s.saldo > 0 " .
        "and v.id_cliente = $clienteId;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'idventa' => $row['idventa'],
                    'seriefactura' => $row['seriefactura'],
                    'nofactura' => $row['nofactura'],
                    'monto' => $row['monto'],
                    'abono' => $row['abono'],
                    'saldo' => $row['saldo'],
                    'dias_vencimiento' => $row['dias_vencimiento'],
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
        'idventa' => 0,
        'seriefactura' => $codigoRespuesta,
        'nofactura' => 0,
        'monto' => 0,
        'abono' => 0,
        'saldo' => 0,
        'dias_vencimiento' => 0,
    );

    echo json_encode($return_arr);
}
