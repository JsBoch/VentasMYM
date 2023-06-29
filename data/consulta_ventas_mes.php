<?php

$mesSelect = $_POST['mes'];
require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * se obtiene el listado de clientes filtrado por departamento y vendedor
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId'];
    $usuarioId = $_SESSION['usuarioId'];
    $Anio = date("Y");
    $from = "";
    $join = "";

    //sucursal 1 es central 2 es petén 3 es xela
    if (intval($sucursal) == 1) {
        $from = "from `db_mymsa`.`adm_venta` v ";
        $join = "join `db_mymsa`.`pedido_producto` p on v.idpedido = p.idpedido ";
    } else if (intval($sucursal) == 2) {
        $from = "from `db_mymsapt`.`adm_venta` v ";
        $join = "join `db_mymsapt`.`pedido_producto` p on v.idpedido = p.idpedido ";
    } else if (intval($sucursal) == 3) {
        $from = "from `db_mymsaxela`.`adm_venta` v ";
        $join = "join `db_mymsaxela`.`pedido_producto` p on v.idpedido = p.idpedido ";
    }

    $stmt = "select v.idventa,v.fecha_registro,v.seriefactura,v.nofactura,v.montooriginal " .
        $from .
        $join .
        "where v.tipo = 'E' " .
        "and v.estado > 0 " .
        "and p.id_empleado = $empleadoId " .
        "and year(v.fecha_registro) = $Anio " .
        "and month(v.fecha_registro) = $mesSelect;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'idventa' => $row['idventa'],
                    'fecha_registro' => $row['fecha_registro'],
                    'seriefactura' => $row['seriefactura'],
                    'nofactura' => $row['nofactura'],
                    'monto' => $row['montooriginal'],
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
        'fecha_registro' => "",
        'seriefactura' => $codigoRespuesta,
        'nofactura' => 0,
        'monto' => 0,
    );

    echo json_encode($return_arr);
}
