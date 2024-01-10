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
<style>
    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }

</style>
<body onload="listaBancos()">
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
        <h2 class="main_title">Datos Recibos</h2>
        </div>

        <div class="contenedor_controles">
        <label for="datosRecibos" class="subtitle_input">RECIBOS</label>
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
        <button type="button" class="btn_editar" id="btnEditar">Editar</button>
        <label for="datosDetalleRecibos" class="subtitle_input">DETALLE RECIBOS</label>
        <div class="contenedor_tabla">
        <table id="datosDetalleRecibos" class="display stripe row-border order-column">
                   <thead>
                       <tr>
                           <th>No.Envío</th>
                           <th>Monto</th>
                           <th>Abono</th>
                           <th>Saldo</th>
                           <th>Pago</th>
                           <th>Tipo Pago</th>
                           <th>No.Deposito</th>
                           <th>No.Cheque</th>
                           <th>Banco</th>
                           <th>Pre Fechado</th>
                           <th>Fecha Cobro</th>
                           <th>Cobrado</th>
                           <th>Mensaje Seguimiento Cheque</th>
                           <th>Mensaje Deposito</th>
                           <th>Mensaje Cheque</th>
                           <th>Observaciones</th>
                           <th>Comentario Cheque</th>
                           <th>Id Detalle Recibo</th>
                       </tr>
                    </thead>
                  <tbody id="cuerpo">
                   </tbody>
                </table>
        </div>
        <button type="button" class="btn_editar" id="btnEditarDetalle">Editar</button>
        </div>
    </div>
   </form>

   <div id="modalRecibo" class="fondo_recibo">
    <div class="modal">
    <i id="btn_cerrar" class='bx bx-x cerrar_modal'></i>
        <h2 class="titulo_modal">Edición Recibo</h2>
        <div class="centrado">
        <div class="sub_container_recibo">
        <label for="fechaRecibo" class="subtitle_input">FECHA RECIBO</label>
        <input type="date" name="fechaRecibo" id="fechaRecibo" class="info_boxes">
        <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
        <textarea name="observaciones" class="comentario" id="observaciones" cols="34" rows="7"></textarea>

        <button type="button" class="save" onclick="ActualizarDatosRecibo()">Guardar</button>
        </div>
        </div>
    </div>
   </div>

   <div id="modalDetalleRecibo" class="fondo_detalle_recibo">
    <div class="modal">
    <i id="btnCerrarDetalleRecibo" class='bx bx-x cerrar_modal'></i>
        <h2 class="titulo_modal">Detalle Recibo</h2>
        <div class="centrado_detalle">
        <div class="sub_container_detalle_recibo">
        <label for="pago" class="subtitle_input">PAGO</label>
        <input type="number" name="pago" id="pago" class="info_boxes">
        <label for="tipo_pago" class="subtitle_input">TIPO PAGO</label>
                <select name="tipoPago" class="selectors" id="tipoPago">
                    <option value="efectivo">EFECTIVO</option>
                    <option value="cheque">CHEQUE</option>
                    <option value="deposito">DEPOSITO</option>
                    <option value="transferencia">TRANSFERENCIA</option>
                </select>
        <label for="numeroDeposito" class="subtitle_input">NUMERO DEPOSITO</label>
        <input type="number" name="numeroDeposito" id="numeroDeposito" class="info_boxes">
        <label for="numeroCheque" class="subtitle_input">NUMERO CHEQUE</label>
        <input type="number" name="numeroCheque" id="numeroCheque" class="info_boxes">
        <label for="banco" class="subtitle_input">BANCO</label>
                <select name="banco" class="selectors" id="banco"></select>
        </div>
        <div class="sub_container_detalle_recibo">
        <label for="preFechado" class="subtitle_input">PRE FECHADO</label>
        <input type="text" name="preFechado" id="preFechado" class="info_boxes">
        <label for="fechaCobro" class="subtitle_input">FECHA COBRO</label>
        <input type="date" name="fechaCobro" id="fechaCobro" class="info_boxes">
        <label for="mensajeCheque" class="subtitle_input">MENSAJE CHEQUE</label>
        <textarea name="mensajeCheque" class="comentario" id="mensajeCheque" cols="34" rows="7"></textarea>
        <button type="button" class="save" onclick="ActualizarDatosDetalleRecibo()">Guardar</button>
        </div>
        </div>
    </div>
   </div>


    <!--Una versión reciente-->
   <script src="../js/jquery-3.7.0.js"></script>
    <!--Habilita el uso de tablas (grids) con funciones específicas (externo)-->
    <script src="..//js/jquery.dataTables.min.js"></script>
    <!--Complemento del anterior-->
    <script src="../js/dataTables.fixedColumns.min.js"></script>
    <!--Datos para las tablas de este archivo en especifico-->
    <script src="../js/tablaRecibosConsulta.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/lista_bancos.js"></script>
</body>

</html>
