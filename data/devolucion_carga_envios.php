<?php
/**
 * Este archivo contiene el código que obtiene de la base de datos los registros de envios
 * para un cliente
 */
$clienteId = $_POST['clienteId'];

require_once 'connection.php';

$codigoRespuesta = 1;


if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId'];
    $usuarioId = $_SESSION['usuarioId'];
    $stmt = "";
    //central
    if($sucursal == 1){ 
        $stmt = "select seriefactura,nofactura,montooriginal,fecha_registro,idventa,id_cliente,idpedido from `db_mymsa`.`adm_venta` where id_cliente = $clienteId and tipo = 'E' and estado = 1 order by fecha_registro desc;";
    }else if($sucursal == 2) //Peten
    {
        $stmt = "select seriefactura,nofactura,montooriginal,fecha_registro,idventa,id_cliente,idpedido from `db_mymsapt`.`adm_venta` where id_cliente = $clienteId and tipo = 'E' and estado = 1 order by fecha_registro desc;";
    }else if($sucursal == 4) //xela
    { 
        $stmt = "select seriefactura,nofactura,montooriginal,fecha_registro,idventa,id_cliente,idpedido from `db_mymsaxela`.`adm_venta` where id_cliente = $clienteId and tipo = 'E' and estado = 1 order by fecha_registro desc;";
      }

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'seriefactura' => $row['seriefactura'],
                    'nofactura' => $row['nofactura'],
                    'montooriginal' => $row['montooriginal'],
                    'fecha_registro' => $row['fecha_registro'],
                    'idventa' => $row['idventa'],
                    'id_cliente' => $row['id_cliente'],
                    'idpedido' => $row['idpedido'],                    
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
        'seriefactura' => $codigoRespuesta,
                    'nofactura' => "",
                    'montooriginal' => "",
                    'fecha_registro' => "",
                    'idventa' => 0,
                    'id_cliente' => 0,
                    'idpedido' => 0
    );

    echo json_encode($return_arr);
}