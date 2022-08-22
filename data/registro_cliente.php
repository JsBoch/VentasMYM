<?php
require_once "connection.php";

//$registroCliente = $_POST['registro_cliente'];

$codigoRespuesta = 1;

//fecha registro
date_default_timezone_set('America/Guatemala');
$fechaRegistro = date("Y-m-d");

//$jsonCliente = json_decode($registroCliente, false);
$clienteID = 0; //se asigna con la consulta a la db
$nit = $_POST['nit'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$email = $_POST['correo'];
$visitas = 0;
$comentario = $_POST['comentario'];
$estado = 1;
$ventas = 0;
$codigo = ""; //se asigna con la consulta de correlativo
$id_sucursal = 1; //se establece la sucursal central para todas las sucursales 1 representa la sucursal
$iddepartamento = $_POST['SD'];
$razonsocial = $_POST['razonsocial'];
$segundo_nombre = "";
$primer_apellido = "";
$segundo_apellido = "";
$monto_credito = 0;
$id_empleado = $_POST['empleado'];
$dias_credito = 0;
$replicado = 0;
$operacion = 1;
$id_municipio = $_POST['SM'];
$region = $_POST['region'];
$idtipocliente = 1;
$transporte = $_POST['transporte'];
$idempresa = 1; //se establece 1 como distribuidora, para todas las sucursales 1 es Distribuidora
$cui = $_POST['dpi'];
$codigo_postal = '';
switch ($iddepartamento) {
    case 1:
        $codigo_postal = '16000';
        break;
    case 2:
        $codigo_postal = '15000';
        break;
    case 3:
        $codigo_postal = '04000';
        break;
    case 4:
        $codigo_postal = '20000';
        break;
    case 5:
        $codigo_postal = '02000';
        break;
    case 6:
        $codigo_postal = '05000';
        break;
    case 7:
        $codigo_postal = '01001';
        break;
    case 8:
        $codigo_postal = '13000';
        break;
    case 9:
        $codigo_postal = '18000';
        break;
    case 10:
        $codigo_postal = '21000';
        break;
    case 11:
        $codigo_postal = '22000';
        break;
    case 12:
        $codigo_postal = '17000';
        break;
    case 13:
        $codigo_postal = '09000';
        break;
    case 14:
        $codigo_postal = '14000';
        break;
    case 15:
        $codigo_postal = '11000';
        break;
    case 16:
        $codigo_postal = '03000';
        break;
    case 17:
        $codigo_postal = '12000';
        break;
    case 18:
        $codigo_postal = '06000';
        break;
    case 19:
        $codigo_postal = '07000';
        break;
    case 20:
        $codigo_postal = '10000';
        break;
    case 21:
        $codigo_postal = '08001';
        break;
    case 22:
        $codigo_postal = '19000';
        break;

    default:
        # code...
        break;
}

if ($mysqli != null && $mysqli->connect_errno === 0) {
    //Se trabaja con transacción
    $mysqli->autocommit(false);
    //obtener id de registro
    $queryCliente = "select if(max(idcliente) is null,1,max(idcliente) +1) as idcliente " .
        "from clientes;";
    $resultado = $mysqli->query($queryCliente);
    if ($resultado !== false) {
        $fila = $resultado->fetch_assoc();
        $clienteID = intval($fila["idcliente"]);
        $resultado->close();
        //obtener correlativo para el código de cliente
        $queryCodigo = "select correlativo + 1 as correlativo " .
            "from cor_correlativo " .
            "where tabla = 'codigocliente';";
        $resultado = $mysqli->query($queryCodigo);
        if ($resultado !== false) {
            $fila = $resultado->fetch_assoc();
            $codigo = $fila['correlativo'];
            $codigoCliente = "GT" . str_pad($fila['correlativo'], 6, "0", STR_PAD_LEFT);
            $resultado->close();

            //SE INICIA EL REGISTRO
            $queryInsert = "INSERT INTO clientes ( " .
                "idcliente,nit,primer_nombre,direccion,telefono,email,visitas,comentario," .
                "fecharegistro,estado,ventas,codigo,id_sucursal,iddepartamento,razonsocial," .
                "segundo_nombre,primer_apellido,segundo_apellido,monto_credito,id_e mpleado,dias_credito," .
                "replicado,operacion,id_municipio,region,idtipocliente,transporte,idempresa,codigo_postal,cui) " .
                " VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            if (!$stmt = $mysqli->prepare($queryInsert)) {
                $codigoRespuesta = -5; //Fallo al preparar la consulta de registro
            } else {
                if (!$stmt->bind_param(
                    "isssssissiisiissssdidiiisisiss",
                    $clienteID,
                    $nit,
                    $nombre,
                    $direccion,
                    $telefono,
                    $email,
                    $visitas,
                    $comentario,
                    $fechaRegistro,
                    $estado,
                    $ventas,
                    $codigoCliente,
                    $id_sucursal,
                    $iddepartamento,
                    $razonsocial,
                    $segundo_nombre,
                    $primer_apellido,
                    $segundo_apellido,
                    $monto_credito,
                    $id_empleado,
                    $dias_credito,
                    $replicado,
                    $operacion,
                    $id_municipio,
                    $region,
                    $idtipocliente,
                    $transporte,
                    $idempresa,
                    $codigo_postal,
                    $cui
                )) {
                    $codigoRespuesta = -6; //fallo al vincular parametros de registro
                    $mysqli->rollback();
                    $stmt->close();
                } else if (!$stmt->execute()) {
                    $codigoRespuesta = -7; //fallo la ejecución de la consulta
                    $mysqli->rollback();
                    $stmt->close();
                } else {
                    $filasAfectas = $mysqli->affected_rows;
                    if ($filasAfectas === 0) {
                        $codigoRespuesta = -7; //no se realizó el insert
                    } else if ($filasAfectas === -1) {
                        $codigoRespuesta = -8; //fallo al realizar el insert
                    } else {
                        $codigoRespuesta = 1; //registro con éxito
                    }
                    $stmt->close();

                    $queryCodigo = "UPDATE cor_correlativo SET correlativo = $codigo WHERE tabla = 'codigocliente';";
                    $resultado = $mysqli->query($queryCodigo);
                    if ($resultado !== false) {
                        $mysqli->commit();
                    } else {
                        $codigoRespuesta = -9; //fallo al actualizar el codigo en cor_correlativo
                        $mysqli->rollback();
                    }
                }
            }
        } else {
            $codigoRespuesta = -4; //fallo en la consulta para codigo cliente
            $mysqli->rollback();
        }
    } else {
        $codigoRespuesta = -3; //fallo en la consulta para idcliente
        $mysqli->rollback();
    }
    $mysqli->close();
} else {
    $codigoRespuesta = -2; //Fallo en conexión
}

$jsonRegistro = array("codigo" => $codigoRespuesta);
echo json_encode($jsonRegistro);
