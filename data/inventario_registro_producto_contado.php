<?php
//session_start();
/**
 * Se almacena en la base de datos
 */
require_once 'connection.php';

$registroMain = $_POST["registro_principal"];

//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaHoraRegistro = date("Y-m-d H:i:s");

$codigoRespuesta = 0;
/**
 * Se obtiene el registro principal del registro de pedido como objeto
 */
$jsonMain = json_decode($registroMain, true);

foreach ($jsonMain as $item) {
    $idProducto = $item["productoId"];
    $codigo = $item["codigoProducto"];
    $nombre = $item["nombreProducto"];
    $existencia_fisica = $item["existenciaFisica"];
    $existencia_sistema = $item["existenciaSistema"];
    $diferencia_conteo = $item["diferencia"];
    $costo_producto = $item["costo"];
    $promedio_ponderado = $item["promedioPonderado"];
    $ultima_compra = $item["ultimaCompra"];
    $observaciones_conteo = $item["observaciones"];
    $idIdentificador = $item["identificadorId"];
    $nombre_identificador = $item["nombreIdentificador"];
    $nombre_ubicacion = $item["nombreUbicacion"];
    $idUbicacion = $item["ubicacionId"];
}

$usuarioNombre = $_SESSION["usuarioNombre"];

if ($mysqli !== null) {
    //inicio de transacciones
    $mysqli->autocommit(false);
    /**
     * Sí el id de solicitud es mayor a cero, entonces se elimina el registro original
     * del pedido.
     */
    $query = "UPDATE adm_inventario_app SET estado = 0 where codigo = '$codigo' " .
        "AND ididentificadorinventario = $idIdentificador " .
        "AND idubicacion = $idUbicacion " .
        " AND estado > 0;";
    $mysqli->query($query);

    try {
        if (!$stmt = $mysqli->prepare(
            "INSERT INTO `db_mymsa`.`adm_inventario_app` ( " .
            "idproducto,codigo,nombre,existencia_sistema,existencia_fisica,diferencia," .
            "costo,promedio_ponderado,ultima_compra,observaciones,identificador,usuario,estado,fecha_registro,ididentificadorinventario,ubicacion,idubicacion) " .
            " VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);")) {

            $codigoRespuesta = -1;

        } else
        if (!$stmt->bind_param("issddddddsssisisi", $idProducto, $codigo, $nombre, $existencia_sistema, $existencia_fisica,
            $diferencia_conteo, $costo_producto, $promedio_ponderado, $ultima_compra, $observaciones_conteo, $nombre_identificador, $usuarioNombre, 1, $fechaHoraRegistro, $idIdentificador, $nombre_ubicacion, $idUbicacion)) {
            //echo "fallo la vinculacion: " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -2;
        } else if (
            !$stmt->execute()) {
            //echo "Fallo la ejecución " . $mysqli->errno . " " . $mysqli->error;
            $codigoRespuesta = -3;
        }
    } catch (Exception $ex) {
        $mysqli->rollback();
        // echo $ex->getMessage();
        $codigoRespuesta = -9; //Se produjo una excepción en la transacción
    }

    if ($stmt) {
        $stmt->close();
    }

    $mysqli->close();
} else {

    $codigoRespuesta = 0; //La conexión es null
}

//respuesta del WS hacia Android
/*$jsonFinal = array("codigo" => $codigoRespuesta,
"id_solicitud"=>$envioID);
echo json_encode($jsonFinal);*/

$return_arr = array();
$indice = 0;
$return_arr[$indice] = array(
    "codigo" => $codigoRespuesta,
    "id_solicitud" => $envioID,
);

//header('Content-Type: application/json');
echo json_encode($return_arr);
