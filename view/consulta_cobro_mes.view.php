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
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="../css/ventas_mes.css">
    <link rel="icon" href="../imgs/logo.png">
    <title>Ventas</title>
</head>

<body >
<div class="contenedorTodo">
    <!-- Boton para regresar al menu -->
        <div class="above_all">
        <a href="../index.php">
            <h3>Ir al menu</h3>
            <i class='bx bx-log-out'></i>
         </a>
        </div>     
        <div class="encabezado">
            <h2 class="main_title">
              Cobro por mes
            </h2>
        </div>   
        <div class="sub_container">
        <label for="sltMesCV" class="subtitle_input">MES</label>
    <select name="sltMesCV" class="selectors" id="sltMesCV">
        <option value="1">ENERO</option>
        <option value="2">FEBRERO</option>
        <option value="3">MARZO</option>
        <option value="4">ABRIL</option>
        <option value="5">MAYO</option>
        <option value="6">JUNIO</option>
        <option value="7">JULIO</option>
        <option value="8">AGOSTO</option>
        <option value="9">SEPTIEMBRE</option>
        <option value="10">OCTUBRE</option>
        <option value="11">NOVIEMBRE</option>
        <option value="12">DICIEMBRE</option>
    </select>
    <!-- ASIGNAR FORMATO RESPONSIVE a cliente y ulclienteresult-->
    <input type="button" value="Consultar" class="btnConsultar" id="btnConsultarEC" onclick="ConsultarCobroTotalMes(),ConsultarCobroMes()">
    </div>  
    <div class="total">
        <div class="resaltado">
        <label for="txtTotalCobro" class="subtitle_parrafo">TOTAL COBRO</label>
    <p id="txtTotalCobro"></p> 
        </div>

    </div>

<div class="contenedorTabla">
<table id="cobroMensual" class="display stripe row-border order-column">
       <thead>
       <tr>
        <th>Recibo</th>
        <th>Envío</th>
        <th>Cobro</th>
        </tr>
       </thead>
       <tbody id="cuerpo">

       </tbody>
    </table>
</div>
</div>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/jquery-3.7.0.js"></script>
    <script src="..//js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.fixedColumns.min.js"></script>
    <script src="../js/cobro_mensual.js"></script>
</body>

</html>