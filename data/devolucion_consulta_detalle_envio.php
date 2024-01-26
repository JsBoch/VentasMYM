<?php
/**
 * Este archivo contiene el código que obtiene de la base de datos los registros del
 * detalle de un envío seleccionado
 */
$envioId = $_POST['envioId'];

require_once 'connection.php';

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $sucursal = $_SESSION['sucursal'];
    $empleadoId = $_SESSION['empleadoId'];
    $usuarioId = $_SESSION['usuarioId'];

    if ($sucursal == 1) {
        $stmt = "select p.codigormym,if(i.marca is null,p.nombre,concat(p.nombre,' ',group_concat(i.marca,' ',i.linea,' ',i.anio,' ',i.especificaciones))) as producto," .
            "d.cantidad,d.precio," .
            "0 as devolucion," .
            "'NA' as bodega_destino," .
            "0 as idbodega," .
            "d.id_detalleventa," .
            "p.idproducto " .
            "from `db_mymsa`.`adm_detalle_venta` d " .
            "join `db_mymsa`.`adm_producto` p on d.idproducto = p.idproducto " .
            "left join `db_mymsa`.`adm_informacion_producto` i on p.idproducto = i.id_producto and i.estado = 1 " .
            "where d.idventa = $envioId " .
            "group by codigormym;";
    } else if ($sucursal == 2) {
        $stmt = "select p.codigormym,if(i.marca is null,p.nombre,concat(p.nombre,' ',group_concat(i.marca,' ',i.linea,' ',i.anio,' ',i.especificaciones))) as producto," .
            "d.cantidad,d.precio," .
            "0 as devolucion," .
            "'NA' as bodega_destino," .
            "0 as idbodega," .
            "d.id_detalleventa," .
            "p.idproducto " .
            "from `db_mymsapt`.`adm_detalle_venta` d " .
            "join `db_mymsapt`.`adm_producto` p on d.idproducto = p.idproducto " .
            "left join `db_mymsapt`.`adm_informacion_producto` i on p.idproducto = i.id_producto and i.estado = 1 " .
            "where d.idventa = $envioId " .
            "group by codigormym;";
    } else if ($sucursal == 4) {
        $stmt = "select p.codigormym,if(i.marca is null,p.nombre,concat(p.nombre,' ',group_concat(i.marca,' ',i.linea,' ',i.anio,' ',i.especificaciones))) as producto," .
            "d.cantidad,d.precio," .
            "0 as devolucion," .
            "'NA' as bodega_destino," .
            "0 as idbodega," .
            "d.id_detalleventa," .
            "p.idproducto ".
            "from `db_mymsaxela`.`adm_detalle_venta` d " .
            "join `db_mymsaxela`.`adm_producto` p on d.idproducto = p.idproducto " .
            "left join `db_mymsaxela`.`adm_informacion_producto` i on p.idproducto = i.id_producto and i.estado = 1 " .
            "where d.idventa = $envioId " .
            "group by codigormym;";
    }

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'codigormym' => $row['codigormym'],
                    'producto' => $row['producto'],
                    'cantidad' => $row['cantidad'],
                    'precio' => $row['precio'],
                    'devolucion' => $row['devolucion'],
                    'bodega_destino' => $row['bodega_destino'],
                    'idbodega' => $row['idbodega'],
                    'id_detalleventa' => $row['id_detalleventa'],
                    'idproducto' => $row['idproducto'],                    
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
        'codigormym' => $codigoRespuesta,
                    'producto' => "",
                    'cantidad' => 0,
                    'precio' => 0,
                    'devolucion' => 0,
                    'bodega_destino' => 0,
                    'idbodega' => 0,
                    'id_detalleventa' => 0,
                    'idproducto' => 0
    );

    echo json_encode($return_arr);
}
