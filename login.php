<?php
session_start();

if (isset($_POST["user_name"]) && isset($_POST["user_password"])) {
    $userName = $_POST["user_name"];
    $userPassword = $_POST["user_password"];

    require_once 'data/connection.php';

    if ($mysqli !== null && $mysqli->connect_errno === 0) {

        $codigoRespuesta;
        $mensajeRespuesta;

        if (!$stmt = $mysqli->prepare("SELECT " .
            "u.idadm_usuario as id," .
            "concat(u.nombres,' ',u.apellidos) as nombre " .
            "FROM adm_usuario u " .
            "WHERE " .
            "u.usuario = ? " .
            "AND aes_decrypt(clave,'$0fTM1M') = ?;")) {
            $codigoRespuesta = -1; //fallo la preparación de la consulta
            $mensajeRespuesta = "FALLO PREPARACION";
        } else if (!$stmt->bind_param("ss", $userName, $userPassword)) {
            $codigoRespuesta = -2; //fallo al víncular valores a la consulta
            $mensajeRespuesta = "FALLO VINCULACION";
        } else if (!$stmt->execute()) {
            $codigoRespuesta = -3; //fallo al ejecutar la consulta
            $mensajeRespuesta = "FALLO AL EJECUTAR";
        } else {
            $result = $stmt->get_result();

            $filas = mysqli_num_rows($result);

            if ($filas > 0) {
                $fila = $result->fetch_assoc();
                $codigoRespuesta = $fila["id"]; //usuario válido
                $mensajeRespuesta = $fila["nombre"];
                $_SESSION['usuarioId'] = $fila['id'];
                $_SESSION['usuarioNombre'] = $fila['nombre'];
                $_SESSION['estado'] = 'conectado';

                header("Location: index.php");
            } else {
                $codigoRespuesta = 0; //usuario no válido
                $mensajeRespuesta = "NO VALIDO";
            }
        }

        if ($stmt) {
            $stmt->close();
        }

        $mysqli->close();

    } else {
        $codigoRespuesta = -4; // error al establecer la conexión
        $mensajeRespuesta = "FALLO DE CONEXIÓN";
    }

    if ($codigoRespuesta <= 0) {
        $_SESSION['usuarioId'] = 0;
                $_SESSION['usuarioNombre'] = '';
                $_SESSION['estado'] = 'desconectado';
        header("Location: acceso.php");
    }
//RESPUESTA
    //$jsonRespuesta = array("id" => $codigoRespuesta, "nombre" => $mensajeRespuesta);
    //echo json_encode($jsonRespuesta);    
    
} else {
    //RESPUESTA
    //$jsonRespuesta = array("id" => 0, "nombre" => "");
    //echo json_encode($jsonRespuesta);
    $_SESSION['usuarioId'] = 0;
                $_SESSION['usuarioNombre'] = '';
                $_SESSION['estado'] = 'desconectado';
    echo $codigoRespuesta . ' ' . $mensajeRespuesta;
    header("Location: acceso.php");
    
}
