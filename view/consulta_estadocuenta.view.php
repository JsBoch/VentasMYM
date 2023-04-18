<?php
session_start();
if (!isset($_SESSION['estado']) || $_SESSION['estado'] != "conectado") {
    header("Location: acceso.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/ordersStyles.css">
    <link rel="icon" href="../imgs/logo.png">
    <title>Estado de cuenta</title>
</head>

<body onload="listaDepartamentosEstadoCuenta()">
    <label for="sltDepartamentoEC" class="subtitle_input">DEPARTAMENTO</label>
    <select name="sltDepartamentoEC" class="selectors" id="sltDepartamentoEC" onchange="listaClientesEC()"></select>
    <!-- ASIGNAR FORMATO RESPONSIVE a cliente y ulclienteresult-->
    <label for="clienteEC" class="subtitle_input">CLIENTE</label>
    <input type="text" name="clienteEC" id="clienteEC" class="info_boxes" placeholder="Nombre de cliente" data-id="0" autocomplete="off">
    <ul id="ulClienteECResult" class="autocomplete_listClient"></ul>
    <label for="direccion_clienteEC" class="subtitle_input">DIRECCION DE CLIENTE</label>
    <input type="text" name="direccion_clienteEC" id="direccion_clienteEC" class="info_boxes" placeholder="Dirección de cliente" autocomplete="off">
    <input type="button" value="Consultar" id="btnConsultarEC" onclick="ConsultarEstadoCuenta()">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/estado_cuenta.js"></script>
</body>

</html>