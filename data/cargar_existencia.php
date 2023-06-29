<?php
// session_start();
$codigo = $_POST['codigo'];

require_once 'connection.php';

//$producto = $_GET["producto"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {

    /* $stmt = "select codigormym,sum(existencia) as existencia ".
    "from (".
    "select p.codigormym,if(e.cantidad is null,0,e.cantidad) as existencia ".
    "from adm_producto p ".
    "join existencia e on p.idproducto = e.idproducto and p.idbodega = e.idbodega and e.estado = 1 ".
    "where p.codigormym = '$codigo' ".
    "and p.estado = 1 ".
    "union all ".
    "select p.codigormym,if(e.cantidad is null,0,e.cantidad) as existencia ".
    "from `db_mymsa`.`adm_producto` p ".
    "join `db_mymsa`.`existencia` e on p.idproducto = e.idproducto and p.idbodega = e.idbodega and e.estado = 1 ".
    "where p.codigormym = '$codigo' ".
    "and p.estado = 1) c group by codigormym;";   */
    $stmt = '';
    if (intval($_SESSION['sucursal']) == 1) {
        $stmt = "select if(e.cantidad is null,0,e.cantidad) as existencia " .
            "from `db_mymsa`.`adm_producto` p " .
            "join `db_mymsa`.`existencia` e on p.idproducto = e.idproducto and p.idbodega = e.idbodega and e.estado = 1 " .
            "where p.codigormym = '$codigo' " .
            "and p.estado = 1;";
    } else if (intval($_SESSION['sucursal']) == 2) {
        $stmt = "select if(e.cantidad is null,0,e.cantidad) as existencia " .
            "from `db_mymsapt`.`adm_producto` p " .
            "join `db_mymsapt`.`existencia` e on p.idproducto = e.idproducto and p.idbodega = e.idbodega and e.estado = 1 " .
            "where p.codigormym = '$codigo' " .
            "and p.estado = 1;";
    }else if (intval($_SESSION['sucursal']) == 3) {
        $stmt = "select if(e.cantidad is null,0,e.cantidad) as existencia " .
            "from `db_mymsaxela`.`adm_producto` p " .
            "join `db_mymsaxela`.`existencia` e on p.idproducto = e.idproducto and p.idbodega = e.idbodega and e.estado = 1 " .
            "where p.codigormym = '$codigo' " .
            "and p.estado = 1;";
    }

    $result = $mysqli->query($stmt);

    $indice = 0;
    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'existencia' => $row['existencia'],
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
        'existencia' => $codigoRespuesta,
    );
    echo json_encode($return_arr);

}
