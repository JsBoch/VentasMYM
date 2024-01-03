<?php

$codigo = $_POST['codigo'];

require_once 'connection.php';

$codigoRespuesta = 1;

/**
 * Se busca el código entre los registros de productos contados para no duplicar
 */
if ($mysqli !== null && $mysqli->connect_errno === 0) {
    $stmt = "select " .
    "p.idproducto," .
    "p.codigormym," .                
    "if (i.linea is null,p.nombre," . 
    "concat(p.nombre, ' ', group_concat(i.marca, ' '," . 
    "i.linea, ' '," . 
    "i.anio, ' '," . 
    "i.especificaciones))) as nombre," . 
    "pp.costo," . 
    "pp.promedio_ponderado," . 
    "pp.ultima_compra," . 
    "if (e.cantidad is null,0,e.cantidad) as existencia " . 
    "from `db_mymsa`.`adm_producto` p " . 
    "join `db_mymsa`.`existencia` e on p.idproducto = e.idproducto and e.estado = 1 and p.idbodega = e.idbodega " . 
    "join `db_mymsa`.`precio_producto` pp on p.idproducto = pp.idproducto " . 
    "left join `db_mymsa`.`adm_informacion_producto` i on p.idproducto = i.id_producto " . 
    "where p.estado = 1 and (p.codigormym = '$codigo' or p.nombre = '$codigo') " . 
    "group by codigormym;";

    $result = $mysqli->query($stmt);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $return_arr = array();
            $indice = 0;
            while ($row = $result->fetch_array()) {
                $return_arr[$indice] = array(
                    'idproducto' => $row['idproducto'],
                    'codigormym' => $row['codigormym'],
                    'nombre' => $row['nombre'],
                    'costo' => $row['costo'],
                    'promedio_ponderado' => $row['promedio_ponderado'],
                    'ultima_compra' => $row['ultima_compra'],
                    'existencia' => $row['existencia']                    
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
        'idproducto' => 0,
        'codigormym' => $codigoRespuesta,
        'nombre' => $mensajeRespuesta,
        'costo' => 0,
        'promedio_ponderado' => 0,
        'ultima_compra' => '',
        'existencia' => 0        
    );

    echo json_encode($return_arr);
}
