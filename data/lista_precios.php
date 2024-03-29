<?php
$codigo = $_POST['codigo'];

require_once 'connection.php';

//$producto = $_GET["producto"];

$codigoRespuesta = 1;

if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "";
    if(intval($_SESSION["sucursal"]) == 1)
    {
    $stmt = "SELECT " .        
        "if(pp.venta is null,0,pp.venta) as venta," .
        "if(pp.minorista is null,0,pp.minorista) as minorista," .
        "if(pp.mayorista is null,0,pp.mayorista) as mayorista," .
        "if(pp.especial is null,0,pp.especial) as especial," .
        "if(pp.oferta is null,0,pp.oferta) as oferta," .
        "if(pp.distribuidor is null,0,pp.distribuidor) as distribuidor," .
        "if(pp.uno is null,0,pp.uno) as uno," .
        "if(pp.dos is null,0,pp.dos) as dos," .
        "if(pp.tres is null,0,pp.tres) as tres " .
        "FROM `db_mymsa`.`adm_producto` p " .
        "JOIN `db_mymsa`.`precio_producto` pp ON p.idproducto = pp.idproducto " .    
        "WHERE p.estado = 1 " .
         "AND p.codigormym = '$codigo' or p.nombre = '$codigo';";  
    }else if(intval($_SESSION["sucursal"]) == 2)
    {
        $stmt = "SELECT " .        
        "if(pp.venta is null,0,pp.venta) as venta," .
        "if(pp.minorista is null,0,pp.minorista) as minorista," .
        "if(pp.mayorista is null,0,pp.mayorista) as mayorista," .
        "if(pp.especial is null,0,pp.especial) as especial," .
        "if(pp.oferta is null,0,pp.oferta) as oferta," .
        "if(pp.distribuidor is null,0,pp.distribuidor) as distribuidor," .
        "if(pp.uno is null,0,pp.uno) as uno," .
        "if(pp.dos is null,0,pp.dos) as dos," .
        "if(pp.tres is null,0,pp.tres) as tres " .
        "FROM `db_mymsapt`.`adm_producto` p " .
        "JOIN `db_mymsapt`.`precio_producto` pp ON p.idproducto = pp.idproducto " .    
        "WHERE p.estado = 1 " .
         "AND p.codigormym = '$codigo' or p.nombre = '$codigo';";  
    }   
    else if(intval($_SESSION["sucursal"]) == 3)
    {
        $stmt = "SELECT " .        
        "if(pp.venta is null,0,pp.venta) as venta," .
        "if(pp.minorista is null,0,pp.minorista) as minorista," .
        "if(pp.mayorista is null,0,pp.mayorista) as mayorista," .
        "if(pp.especial is null,0,pp.especial) as especial," .
        "if(pp.oferta is null,0,pp.oferta) as oferta," .
        "if(pp.distribuidor is null,0,pp.distribuidor) as distribuidor, " .
        "if(pp.uno is null,0,pp.uno) as uno," .
        "if(pp.dos is null,0,pp.dos) as dos," .
        "if(pp.tres is null,0,pp.tres) as tres " .
        "FROM `db_mymsaxela`.`adm_producto` p " .
        "JOIN `db_mymsaxela`.`precio_producto` pp ON p.idproducto = pp.idproducto " .    
        "WHERE p.estado = 1 " .
         "AND p.codigormym = '$codigo' or p.nombre = '$codigo';";  
    }  

    $result = $mysqli->query($stmt);

    $indice = 0;
    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(                   
                    'venta' => $row['venta'],
                    'minorista' => $row['minorista'],
                    'mayorista' => $row['mayorista'],
                    'especial' => $row['especial'],
                    'oferta' => $row['oferta'],
                    'distribuidor' => $row['distribuidor'],
                    'uno' => $row['uno'],
                    'dos' => $row['dos'],
                    'tres' => $row['tres']
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
        'venta' => 0.00,
        'minorista' => 0.00,
        'mayorista' => 0.00,
        'especial' => 0.00,        
        'oferta' => 0.00,
        'distribuidor' => 0.00,
        'uno' => 0.00,
        'dos' => 0.00,
        'tres' => 0.00
    );

    echo json_encode($return_arr);
}