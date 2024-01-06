<?php
$idCliente = trim($_POST["idCliente"]);

require_once 'connection.php';

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {

    $stmt = "";
    if (intval($_SESSION["sucursal"]) == 1) {
        $stmt = "SELECT " .
            "v.idventa,v.nofactura,s.monto,s.abono,s.saldo,0 as pago,s.fecha,s.fecha_vencimiento,datediff(now(),s.fecha_vencimiento) as dias " . 
            "from `db_mymsa`.`adm_venta` v " . 
            "join `db_mymsa`.`saldoxcobrar` s on v.idventa = s.idventa " .
            "where v.estado = 1 and s.estado = 1 and v.id_cliente = $idCliente " .
            "and s.saldo > 0;";
    } else if (intval($_SESSION["sucursal"]) == 2) { //Petén
        $stmt = "SELECT " .
            "v.idventa,v.nofactura,s.monto,s.abono,s.saldo,0 as pago,s.fecha,s.fecha_vencimiento,datediff(now(),s.fecha_vencimiento) as dias " . 
            "from `db_mymsapt`.`adm_venta` v " . 
            "join `db_mymsapt`.`saldoxcobrar` s on v.idventa = s.idventa " .
            "where v.estado = 1 and s.estado = 1 and v.id_cliente = $idCliente " .
            "and s.saldo > 0;";
    }
    else if (intval($_SESSION["sucursal"]) == 3) { //Xela
        $stmt = "SELECT " .
            "v.idventa,v.nofactura,s.monto,s.abono,s.saldo,0 as pago,s.fecha,s.fecha_vencimiento,datediff(now(),s.fecha_vencimiento) as dias " . 
            "from `db_mymsaxela`.`adm_venta` v " . 
            "join `db_mymsaxela`.`saldoxcobrar` s on v.idventa = s.idventa " .
            "where v.estado = 1 and s.estado = 1 and v.id_cliente = $idCliente " .
            "and s.saldo > 0;";
    }

    $result = $mysqli->query($stmt);

    $indice = 0;
    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'idventa' => $row['idventa'],
                    'nofactura' => $row['nofactura'],
                    'monto' => $row['monto'],
                    'abono' => $row['abono'],
                    'saldo' => $row['saldo'],
                    'pago' => $row['pago'],
                    'fecha' => $row['fecha'],
                    'fecha_vencimiento' => $row['fecha_vencimiento'],
                    'dias' => $row['dias'],
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
                $mensajeRespuesta = "NO SE LOCALIZARON REGISTROS";
                break;
            }
    }
    $return_arr = array();
    $indice = 0;
    $return_arr[$indice] = array(
        'idventa' => 0,
                    'nofactura' => $codigoRespuesta,
                    'monto' => 0,
                    'abono' => 0,
                    'saldo' => 0,
                    'pago' => 0,
                    'fecha' => '',
                    'fecha_vencimiento' => '',
                    'dias' => 0,
    );

    echo json_encode($return_arr);
}

?>