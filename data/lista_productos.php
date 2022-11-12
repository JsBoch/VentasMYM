<?php
require_once 'connection.php';

//$producto = $_GET["producto"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {

    /**
     * Se agrega un UNION para obtener los productos de ambas empresas. 
     * Se agrega una condicionante IF para saber si la consulta se realiza en la central
     * o en la sucursal de Petén. 
     * [este código se deberá optimizar para cuando se incluyan más sucursales]
     */
    $stmt = "SELECT " .
        "p.codigormym," .
        "p.nombre," .
        "if(pp.venta is null,0,pp.venta) as venta," .
        "if(pp.uno is null,0,pp.uno) as uno," .
        "if(pp.dos is null,0,pp.dos) as dos," .
        "if(pp.tres is null,0,pp.tres) as tres " .
        "FROM adm_producto p " .
        "LEFT JOIN precio_producto pp ON p.idproducto = pp.idproducto " .
        "WHERE p.estado = 1 " .
        "and p.idempresa = 1 " .      
        "UNION ";

    $numeroSucursal = 0;
    if(isset($_SESSION['sucursal']))
    {
        $numeroSucursal = $_SESSION['sucursal'];
    }

    if(intval($numeroSucursal) == 0 || intval($numeroSucursal == 1))
    {
        $stmt += "SELECT " .        
        "p.codigormym," .
        "p.nombre," .
        "if(pp.venta is null,0,pp.venta) as venta," .
        "if(pp.uno is null,0,pp.uno) as uno," .
        "if(pp.dos is null,0,pp.dos) as dos," .
        "if(pp.tres is null,0,pp.tres) as tres " .
        "FROM `db_mymsa`.`adm_producto` p " .
        "LEFT JOIN `db_mymsa`.`precio_producto` pp ON p.idproducto = pp.idproducto " .
        "WHERE p.estado = 1 " .
        "and p.idempresa = 2 " .
        "group by codigormym " .
        "order by nombre;";
    }
    else if(intval($numeroSucursal == 2))
    {
        $stmt += "SELECT " .        
        "p.codigormym," .
        "p.nombre," .
        "if(pp.venta is null,0,pp.venta) as venta," .
        "if(pp.uno is null,0,pp.uno) as uno," .
        "if(pp.dos is null,0,pp.dos) as dos," .
        "if(pp.tres is null,0,pp.tres) as tres " .
        "FROM `db_mymsapt`.`adm_producto` p " .
        "LEFT JOIN `db_mymsapt`.`precio_producto` pp ON p.idproducto = pp.idproducto " .
        "WHERE p.estado = 1 " .
        "and p.idempresa = 2 " .
        "group by codigormym " .
        "order by nombre;";
    }
    $result = $mysqli->query($stmt);

    $indice = 0;
    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'codigo' => $row['codigormym'],
                    'nombre' => $row['nombre'],
                    'venta' => $row['venta'],
                    'uno' => $row['uno'],
                    'dos' => $row['dos'],
                    'tres' => $row['tres'],
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
        'codigo' => $codigoRespuesta,
        'nombre' => $mensajeRespuesta,
        'venta' => 0.00,
        'uno' => 0.00,
        'dos' => 0.00,
        'tres' => 0.00,
    );

    echo json_encode($return_arr);
}