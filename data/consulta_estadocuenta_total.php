<?php

$clienteId = $_POST['idcliente'];
require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * se obtiene el listado de clientes filtrado por departamento y vendedor
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId'];
    $Anio = date("Y");
    $from = "";
    $join = "";

    //sucursal 1 es central 2 es petén
    if (intval($sucursal) == 1) {
        $from = "from `db_mymsa`.`saldoxcobrar` v ";
        //$join = "join `db_mymsa`.`pedido_producto` p on v.idpedido = p.idpedido ";
    } else if (intval($sucursal) == 2) {
        $from = "from `db_mymsapt`.`saldoxcobrar` v ";
        //$join = "join `db_mymsapt`.`pedido_producto` p on v.idpedido = p.idpedido ";
    } else if (intval($sucursal) == 3) {
        $from = "from `db_mymsaxela`.`saldoxcobrar` v ";
        //$join = "join `db_mymsaxela`.`pedido_producto` p on v.idpedido = p.idpedido ";
    }

    $stmt = "select sum(saldo) as saldo " .
    $from .
    "where idcliente = $clienteId " .
    "and estado = 1;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'saldo' => $row['saldo'],
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
        'saldo' => 0,
    );

    echo json_encode($return_arr);
}
