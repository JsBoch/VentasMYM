<?php
//session_start();
/**
 * Se almacena en la base de datos
 */
require_once 'connection.php';

$devolucionId = $_POST["id_devolucion"];
$motivo = $_POST["motivo"];
$noDevolucion = $_POST["nodevolucion"];
$registroMain = $_POST["registro_principal"];
$detalleRegistro = $_POST["detalle_registro"];

$sucursal = $_SESSION['sucursal'];    
    $empleadoId = $_SESSION['empleadoId'];
    $usuarioId = $_SESSION['usuarioId'];
    $usuarioNombre = $_SESSION['usuarioNombre'];

//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaHoraRegistro = date("Y-m-d H:i:s");

$codigoRespuesta = 0;
/**
 * Se obtiene el registro principal de la devolución
 */
$jsonMain = json_decode($registroMain, true);

foreach ($jsonMain as $item) {
    $clienteID = $item["id_cliente"];
    $noFactura = $item["nofactura"]; 
    $ventaId = $item["idventa"];
    $pedidoId = $item["idpedido"];        
    $tipo = "E";
    $serie = "E";
    $rebajoCXC = "N";
    $totalDevolucion = 0;    
    $esMYM = "N";
    $generaNC = "N";
    $estado = 1;
}

if ($mysqli !== null) {
    //inicio de transacciones
    $mysqli->autocommit(false);
    /**
     * Sí el id de solicitud es mayor a cero, entonces se elimina el registro original
     * de la devolucion.
     */
    if ($devolucionId > 0) {

        if($sucursal == 1){
            $query = "update `db_mymsa`.`adm_devolucion_detalle_app` SET estado = 0 WHERE iddevolucion = $devolucionId;";
            $mysqli->query($query);
            $query = "update `db_mymsa`.`adm_devolucion_app` set estado = 0 WHERE iddevolucion = $devolucionId;";
            $mysqli->query($query);
        }else if($sucursal == 2){
            $query = "update `db_mymsapt`.`adm_devolucion_detalle_app` SET estado = 0 WHERE iddevolucion = $devolucionId;";
            $mysqli->query($query);
            $query = "update `db_mymsapt`.`adm_devolucion_app` set estado = 0 WHERE iddevolucion = $devolucionId;";
            $mysqli->query($query);
        }else if($sucursal == 4){
            $query = "update `db_mymsaxela`.`adm_devolucion_detalle_app` SET estado = 0 WHERE iddevolucion = $devolucionId;";
            $mysqli->query($query);
            $query = "update `db_mymsaxela`.`adm_devolucion_app` set estado = 0 WHERE iddevolucion = $devolucionId;";
            $mysqli->query($query);
        }        
    }
    //IDs
    
        if($sucursal == 1){
        $query = "select " .
        "if(max(iddevolucion) is null,1,max(iddevolucion) + 1) as iddevolucion " .        
        "from `db_mymsa`.`adm_devolucion_app`;";
        }else if($sucursal == 2){
            $query = "select " .
        "if(max(iddevolucion) is null,1,max(iddevolucion) + 1) as iddevolucion " .        
        "from `db_mymsapt`.`adm_devolucion_app`;";
        }else if($sucursal == 4){
            $query = "select " .
        "if(max(iddevolucion) is null,1,max(iddevolucion) + 1) as iddevolucion " .        
        "from `db_mymsaxela`.`adm_devolucion_app`;";
        }   

    $resultado = $mysqli->query($query);
    $fila = $resultado->fetch_assoc();

    $devolucionID = intval($fila["iddevolucion"]);


    try {
        if (!$stmt = $mysqli->prepare(
            "INSERT INTO adm_devolucion_app (" .
            "iddevolucion," .
            "fecha_registro," .
            "idcliente," .
            "idvendedor," .
            "nofactura," .
            "idventa," .
            "idpedido," .
            "motivo," .
            "usuario," .
            "genera_nc," .
            "estado," .
            "nodevolucion," .
            "tipo,".
            "serie,".
            "id_sucursal,".
            "rebajo_cxc,".
            "total_devolucion,".
            "es_mym) " .
            " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?);")) {
            //echo "fallo No." . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -1;

        } else
        if (!$stmt->bind_param("isiisiisssiissisds", $devolucionID, $fechaHoraRegistro, $clienteID, $empleadoId, $noFactura,
            $ventaId, $pedidoId, $motivo, $usuarioNombre,$generaNC, $estado,$noDevolucion,$tipo,$serie,$sucursal,$rebajoCXC,$totalDevolucion,$esMYM)) {            
            $codigoRespuesta = -2;
        } else if (
            !$stmt->execute()) {
            //echo "Fallo la ejecución " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -3;
        } else {

            $filasAfectas = $mysqli->affected_rows;

            if ($filasAfectas > 0) {
            /** Se obtiene el correlativo de la tabla detalle de devolución app*/
                if($sucursal == 1){
                    $query = "select " .
                    "if(max(iddetalledevolucion) is null,1,max(iddetalledevolucion) + 1) as iddetalledevolucion " .        
                    "from `db_mymsa`.`adm_detalle_devolucion_app`;";
                    }else if($sucursal == 2){
                        $query = "select " .
                    "if(max(iddetalledevolucion) is null,1,max(iddetalledevolucion) + 1) as iddetalledevolucion " .        
                    "from `db_mymsapt`.`adm_detalle_devolucion_app`;";
                    }else if($sucursal == 4){
                        $query = "select " .
                    "if(max(iddetalledevolucion) is null,1,max(iddetalledevolucion) + 1) as iddetalledevolucion " .        
                    "from `db_mymsaxela`.`adm_detalle_devolucion_app`;";
                    }   
            
                $resultadoDetalle = $mysqli->query($query);
                $filaDetalle = $resultadoDetalle->fetch_assoc();
            
                $devolucionDetalleID = intval($fila["iddetalledevolucion"]);
            //************************************************* */

                $idProducto = 0;                
                $cantidad = 0;
                $cantidadEntregada = 0;
                $cantidadDevuelta = 0;
                $idBodegaDestino = 0;
                $estado = 1;
                $idBodegaOrigen = 0;
                $precioPromedio = 0;
                $estadoProducto = 1;
                $costo = 0;
                $montoGravable = 0;
                $montoImpuesto = 0;
                $subtotal = 0.00;
                $subtotalDevolucion = 0.00;
                $cantidadDevueltaDos = 0.00;
                $idBodegaDestinoDos = 0;


                if (!$stmtd = $mysqli->prepare(
                    "INSERT INTO adm_detalle_devolucion_app (" .
                    "iddetalledevolucion," .
                    "iddevolucion," .
                    "idproducto," .
                    "cantidad_entregada," .
                    "precio_unitario," .
                    "cantidad_devuelta," .
                    "idbodega_destino," .
                    "estado," .
                    "idbodega_origen," .
                    "idsucursal," .
                    "precio_promedio," .
                    "costo," .
                    "monto_gravable," .
                    "monto_impuesto," .
                    "subtotal," .
                    "subtotal_devolucion," .
                    "cantidad_devueltados," .
                    "idbodega_destinodos) " .
                    " VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);")) {
                    $codigoRespuesta = -4; //fallo al preparar la consulta de detalle

                } else if (!$stmtd->bind_param("iiidddiiiidddddddi", $devolucionDetalleID,$devolucionID, $idProducto, $cantidadEntregada, $precio,
                    $cantidadDevuelta, $idBodegaDestino, $estado, $idBodegaOrigen, $sucursal, $precioPromedio, $costo, $montoGravable,$montoImpuesto,$subtotal,$subtotalDevolucion,$cantidadDevueltaDos,$idBodegaDestinoDos)) {
                    $codigoRespuesta = -5; //no se pudieron vincular los parámetros a la consulta detalle
                } else {
                    /**
                     *Se obtiene el detalle de los items como arreglo
                     */
                    $jsonDetalle = json_decode($detalleRegistro, true);

                    $almacenado = true;

                    //foreach ($jsonDetalle as $item) {
                    foreach ($jsonDetalle as $arr) {
                        //$cadenaCompleta = $cadenaCompleta . $arr["nombre"];
                        $idProducto = $arr["idproducto"];
                        $cantidadEntregada = 0;
                        $precio = $arr["precio"];
                        $cantidadDevuelta = $arr["devolucion"];
                        $idBodegaDestino = $arr["idbodega"];
                        $estado = 1;
                        $idBodegaOrigen = 0;
                        $precioPromedio = 0;
                        $costo = 0;
                        $montoGravable = 0;
                        $montoImpuesto = 0;
                        $subtotal = 0;
                        $subtotalDevolucion = 0;
                        $cantidadDevueltaDos = 0;
                        $idBodegaDestinoDos = 0;

                        if (!$stmtd->execute()) {
                            $codigoRespuesta = -6; //fallo al ejecutar la consulta detalle
                            $almacenado = false;
                            break 1;
                        }

                        $devolucionDetalleID++;
                    }
                    //}

                    if ($almacenado) {
                        //se confirma la transacción
                        $mysqli->commit();

                        $codigoRespuesta = 1; //Operación correcta y terminada;
                    } else {
                        $mysqli->rollback();
                    }
                }

            } else {
                $mysqli->rollback();
                if ($filasAfectas == 0) {
                    $codigoRespuesta = -7; //no se hizo el insert principal
                } else if ($filasAfectas == -1) {
                    $codigoRespuesta = -8; //se produjo un error al insertar el registro principal
                }
            }
        }

    } catch (Exception $ex) {
        $mysqli->rollback();
        // echo $ex->getMessage();
        $codigoRespuesta = -9; //Se produjo una excepción en la transacción
    }

    if ($stmtd) {
        $stmtd->close();
    }
    if ($stmt) {
        $stmt->close();
    }

    $mysqli->close();
} else {

    $codigoRespuesta = 0; //La conexión es null
}

$return_arr = array();
$indice = 0;
$return_arr[$indice] = array(
    "codigo" => $codigoRespuesta,
    "id_solicitud" => $envioID    
);


//header('Content-Type: application/json');
echo json_encode($return_arr);

?>