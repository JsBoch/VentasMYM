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
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/consulta_recibo.css">
    <link rel="icon" href="../imgs/icono.png">
    <title>Recibo</title>
</head>

<body>
   <form class="contenedorPrincipal" action="">
            <!-- Boton para regresar al menu -->
            <div class="above_all">
                <a href="../index.php">
                    <h3>Volver</h3>
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
            <!-- Datos consulta -->
       
        <div class="sub_container">

        <div class="encabezado">
        <h2 class="main_title">Fecha</h2>
        </div>
        <div class="contenedor_controles">
        <label for="anio" class="subtitle_input">AÑO</label>
            <input type="number" class="info_boxes" id="anio">
        <label for="sltMes" class="subtitle_input">MES</label>
            <select name="sltMes" id="sltMes" class="selectors">
                <option value="enero">Enero</option>
                <option value="febrero">Febrero</option>
                <option value="marzo">Marzo</option>
                <option value="abril">Abril</option>
                <option value="mayo">Mayo</option>
                <option value="junio">Junio</option>
                <option value="julio">Julio</option>
                <option value="agosto">Agosto</option>
                <option value="septiembre">Septiembre</option>
                <option value="octubre">Octubre</option>
                <option value="noviembre">Noviembre</option>
                <option value="diciembre">Diciembre</option>
            </select>
            <button type="button" class="btn_consulta" onclick="GetRecibosConsulta()">Consultar</button>
        </div>
        </div>
        
            <!-- Datos edición -->
        <div class="second_sub_container">
        <div class="encabezado">
        <h2 class="main_title">Detalle de Recibo</h2>
        </div>

        <div class="contenedor_controles">
        <div class="contenedor_tabla">
        <table id="datosRecibos" class="display stripe row-border order-column">
                   <thead>
                       <tr>
                           <th>Serie</th>
                           <th>No.Recibo</th>
                           <th>Cobro</th>
                           <th>Fecha</th>
                           <th>Observacion</th>
                           <th>Estado</th>   
                           <th>Id</th>                    
                       </tr>
                    </thead>
                  <tbody id="cuerpo">
                   </tbody>
                </table>
        </div>
        
        </div>    
    </div>
   </form>
    <!--Una versión reciente-->
   <script src="../js/jquery-3.7.0.js"></script>
    <!--Habilita el uso de tablas (grids) con funciones específicas (externo)-->
    <script src="..//js/jquery.dataTables.min.js"></script>
    <!--Complemento del anterior-->
    <script src="../js/dataTables.fixedColumns.min.js"></script>
    <!--Datos para las tablas de este archivo en especifico-->
    <script src="../js/tablaRecibosConsulta.js"></script>
    <script src="../js/alertify.min.js"></script>
</body>

</html>