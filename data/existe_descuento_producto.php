<?php 
$codigoProducto = trim($_POST["codigo"]);
$tipoPago = trim($_POST["tipo_pago"]);
require_once 'connection.php';
$codigoRespuesta = 1;
/**
 * Se valida que la conexión se válida y esté abierta
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {

    $stmt = "";
    /**
     * la sucursal se asigna en el login, se valida a que sucursal pertenece el usuario
     * que se está logueando, la sucursal se asigna al usuario en la tabla de usuarios
     * de la central
     */
    if (intval($_SESSION["sucursal"]) == 1) {        
        $stmt = "select count(1) as existe " .
        "from `db_mymsa`.`adm_descuento_ventas` " .
        "where estado = 1 " .
        "and codigormym = '$codigoProducto' and tipo = '$tipoPago';";
    } else if (intval($_SESSION["sucursal"]) == 2) {
        $stmt = "select count(1) as existe " .
        "from `db_mymsapt`.`adm_descuento_ventas` " .
        "where estado = 1 " .
        "and codigormym = '$codigoProducto' and tipo = '$tipoPago';";
    }
    else if (intval($_SESSION["sucursal"]) == 3) {
        $stmt = "select count(1) as existe " .
        "from `db_mymsaxela`.`adm_descuento_ventas` " .
        "where estado = 1 " .
        "and codigormym = '$codigoProducto' and tipo = '$tipoPago';";
    }

    $result = $mysqli->query($stmt);

    $indice = 0;
    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'existe' => $row['existe'],
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
        'existe' => $codigoRespuesta,
    );

    echo json_encode($return_arr);
}
?>