<?php 
session_start();
    if (!isset($_SESSION['estado']) || $_SESSION['estado'] != "conectado") {
        header("Location: acceso.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mainStyles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="icon" href="../imgs/icono.png">
    <title>Registro de clientes</title>
</head>
<body onload="listaDepartamentos(),limpiarFormulario(),listaRegiones()">
    <form action="../data/registro_cliente.php" method="POST" id="customer_registration" class="form_box" autocomplete="off">
        <!-- Boton para regresar al menu -->
        <div class="above_all">
        <a href="../index.php">
            <h3>Volver</h3>
            <i class='bx bx-log-out'></i>
        </a>
        </div>     
        <!-- formulario -->
        <h2 class="main_title">Registro De Clientes</h2>
        <div class="container">
        <div class="sub_container">
        <label for="nit" class="subtitle_input">NIT</label>
        <input class="info_boxes" placeholder="Ingrese NIT" onblur="findValue()" name="nit" id="nit"  type="text">
        <label for="dpi" class="subtitle_input">DPI</label>
        <input class="info_boxes" placeholder="Ingrese DPI" name="dpi" id="dpi" type="text">
        <label for="nombre" class="subtitle_input">NOMBRE</label>
        <input class="info_boxes" placeholder="Ingrese Nombre" name="nombre" id="nombre" type="text" onblur="EstablecerRazonSocial()">
        <label for="razonsocial" class="subtitle_input">RAZÓN SOCIAL</label>
        <input class="info_boxes" placeholder="Ingrese Razón Social" name="razonsocial" id="razonsocial" type="text">
        <label for="depa" class="subtitle_input">DEPARTAMENTO</label>
        <select class="selectors" name="SD" id="depa" onchange="findValue()"></select>
        <label for="municipio" class="subtitle_input">MUNICIPIO</label>
        <select class="selectors" name="SM" id="municipio" form="customer_registration"></select>
        <label for="direccion" class="subtitle_input">DIRECCIÓN</label>
        <input class="info_boxes" placeholder="Ingrese Dirección" name="direccion" id="direccion" type="text">
</div>
<div class="sub_container">
        <label for="telefono" class="subtitle_input">TELEFONO</label>
        <input class="info_boxes" placeholder="Ingrese Teléfono" name="telefono" id="telefono" type="number">
        <label for="correo" class="subtitle_input">CORREO</label>
        <input class="info_boxes" placeholder="Ingrese@email.com" name="correo" id="correo" type="email">
        <label for="region" class="subtitle_input">REGIÓN</label>
        <select name="region" id="region" class="selectors"></select>
        <label for="comentario" class="subtitle_input">OBSERVACIÓN</label>
        <textarea class="comentario" rows="5" cols="30" name="comentario" id="comentario"></textarea>
        <label for="transporte" class="subtitle_input">TRANSPORTE</label>
        <input class="info_boxes" placeholder="Ingrese Transporte" name="transporte" id="transporte" type="text">
        <input type="hidden" value="1" name="empleado">
        <input type="hidden" name="clienteId" id="clienteId">
        <input type="hidden" name="txtCodigo" id="txtCodigo">
        <button class="send" type="submit">Enviar</button>
        </div>
        </div>
    </form>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/departamentos.js"></script>
    <script src="../js/clientesln.js"></script>
    <script src="../js/alertify.min.js" ></script>

    <!-- <div class="map">
        <button type="button" name="bttnUbicacion" id="bttnUbicacion" class="button_location" onclick="ObtenerUbicacion()">UBICACIÓN</button>
        <h3 class="titles_location">Latitud</h3>
        <input type="text" name="txtLatitud" id="txtLatitud" placeholder="latitud" class="spaces_location">
        <h3 class="titles_location">Longitud</h3>
        <input type="text" name="txtLongitud" id="txtLongitud" placeholder="longitud" class="spaces_location">
        </div> -->
</body>
</html>