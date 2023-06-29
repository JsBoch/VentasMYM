<?php

$envio = $_POST["no_envio"];
$noRecibo = $_POST['no_recibo'];
require_once 'connection.php';

$codigoRespuesta = 1;

$numeroSucursal = 0;
$from = "";
$join = "";

if (isset($_SESSION['sucursal'])) {
    $numeroSucursal = $_SESSION['sucursal'];
}

//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaRegistro = date("Ymd");

/**
 * Se ejecuta una consulta en la base de datos para corroborar
 * que el registro de pedido se haya guardado.
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {    
    $empleadoId = $_SESSION['empleadoId']; //vendedor
    $usuarioId = $_SESSION['usuarioId']; //usuario que registra
    //$Anio = date("Y");

    /**
     * 0 o 1 MYM Central
     * 2 MYM Petén
     * 3 MYM Xela
     */
    if (intval($numeroSucursal) == 0 || intval($numeroSucursal == 1)) {
        $from = "from `db_mymsa`.`adm_venta` v ";
        $join = "join `db_mymsa`.`saldoxcobrar` s on v.idventa = s.idventa ";
        $joind = "join `db_rmym`.`vnt_detalle_recibo` d on v.nofactura = d.no_envio and v.tipo = 'E' and d.estado > 0 ";
    } else if (intval($numeroSucursal == 2)) {
        $from = "from `db_mymsapt`.`adm_venta` v ";
        $join = "join `db_mymsapt`.`saldoxcobrar` s on v.idventa = s.idventa ";
        $joind = "join `db_rmympt`.`vnt_detalle_recibo` d on v.nofactura = d.no_envio and v.tipo = 'E' and d.estado > 0 ";
    } else if (intval($numeroSucursal == 3)) {

        $from = "from `db_mymsaxela`.`adm_venta` v ";
        $join = "join `db_mymsaxela`.`saldoxcobrar` s on v.idventa = s.idventa ";
        $joind = "join `db_rmymxela`.`vnt_detalle_recibo` d on v.nofactura = d.no_envio and v.tipo = 'E' and d.estado > 0 ";
    }

    /**
     * Se consulta un registro de envío ingresado desde el App
     * que coincida con en número de envío ya procesado en ventas 
     * y el saldo igual a cero que significa que ese envío ya se proceso 
     * y no se puede procesar más, si el saldo es mayor a cero entonces
     * si se podría procesar el envío.  
     */
    $stmt = "SELECT " .
    "count(1) as cantidad " .
    $from .
    $join .
    $joind .
    "WHERE v.nofactura = $envio " .
    "and v.estado > 0 " .
    "and v.tipo = 'E' " .
    "and s.estado > 0 " .
    "and s.saldo = 0;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'cantidad' => $row['cantidad'],
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
        'cantidad' => 0,
    );

    echo json_encode($return_arr);
}
