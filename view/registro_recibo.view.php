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
    <link rel="stylesheet" href="../css/receiptStyles.css">
    <link rel="stylesheet" href="../css/fixedColumns.dataTables.min.css">
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
<body onload="listaDepartamentos(),listaBancos(),GetNumeroRecibo()">
    <form id="subContainerDates" class="contenedorPrincipal" action="" method="post">
        <div class="customer_frame">
            <!-- Boton para regresar al menu -->
            <div class="above_all">
                <a href="../index.php">
                    <h3>Volver</h3>
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
            <!-- cliente -->
            <div class="encabezado">
            <h2 class="main_title">Datos Generales</h2>
            </div>
        <div class="sub_container">
            <label for="fechaInicio" class="subtitle_input">FECHA RECIBO</label>
            <input type="date" name="fecha" id="fecha" class="info_boxes">
            <label for="serie_recibo" class="subtitle_input">SERIE RECIBO</label>
            <input type="text" class="info_boxes" id="serie_recibo" style="text-transform: uppercase;">
            <label for="numero_recibo" class="subtitle_input">NUMERO DE RECIBO</label>
            <input type='number' name="numero_recibo" class="info_boxes" id="numero_recibo" placeholder="ingrese número de recibo" autocomplete="off" onblur="ExisteRecibo()">
            <label for="checkAnulado" class="subtitle_input">ANULADO</label>
            <input type="checkbox" id="checkAnulado" name="checkAvanzado" class="chekbox">
            <!--*******************************************-->
            <label for="departamento" class="subtitle_input">DEPARTAMENTO</label>
            <select name="departamento" class="selectors" id="departamento" onchange="listaClientes()"></select>
            <!-- ASIGNAR FORMATO RESPONSIVE a cliente y ulclienteresult-->
            <label for="cliente" class="subtitle_input">CLIENTE</label>
            <div class="autoC">
            <input type="text" name="cliente" id="cliente" class="input_autocomplete" placeholder="Nombre de cliente" data-id="0" onblur="obtenerIdCliente()" autocomplete="off">
            <ul id="ulclienteresult" class="autocomplete_list"></ul>
            </div>

            <label for="sltSemana" class="subtitle_input">SEMANA</label>
            <select name="sltSemana" id="sltSemana" class="selectors">
                <option value="SEMANA 1">SEMANA 1</option>
                <option value="SEMANA 2">SEMANA 2</option>
                <option value="SEMANA 3">SEMANA 3</option>
                <option value="SEMANA 4">SEMANA 4</option>
                <option value="SEMANA 5">SEMANA 5</option>
            </select>
            <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
            <textarea name="observaciones" class="comentario" id="observaciones" cols="34" rows="7"></textarea>
            </div>
            </div>
        </div>
        <!-- Envios -->
        <div class="box_products">
            <div class="encabezado">
            <h2 class="main_title">Detalle de Recibo</h2>
            </div>
            <div class="second_sub_container">
                <label for="numero_envio" class="subtitle_input">NUMERO DE ENVIO</label>
                <!-- tabla -->
                <div class="contenedor_tabla">
                <table id="example" class="display stripe row-border order-column">
                   <thead>
                       <tr>
                           <th>No.Envío</th>
                           <th>Saldo</th>
                           <th>Pago</th>
                           <th>Monto</th>
                           <th>Abono</th>
                           <th>Fecha</th>
                           <th>Fecha vencimiento</th>
                           <th>Dias</th>       
                           <th>Id</th>                    
                       </tr>
                    </thead>
                  <tbody id="cuerpo">
                   </tbody>
                </table>
                </div>
                <div class="saldo_total">
                    <h2>Saldo total:&nbsp;</h2><h2 id="saldoTotal"></h2>
                </div>
                <!-- ---------- -->
                <label for="tipo_pago" class="subtitle_input">TIPO PAGO</label>
                <select name="tipo_pago" class="selectors" id="tipo_pago">
                    <option value="efectivo">EFECTIVO</option>
                    <option value="cheque">CHEQUE</option>
                    <option value="deposito">DEPOSITO</option>
                    <option value="transferencia">TRANSFERENCIA</option>
                </select>
                <label for="pago" class="subtitle_input">MONTO</label>
                <div class="input_con_boton">
                <input type="number" class="info_boxes_pareja" name="pago" id="pago" placeholder="Monto" autocomplete="off">
                <button class="boton_pareja" onclick="desgloceMonto()" type="button">Desglosar</button>
                </div>
                <!--Agrego un hidden para almacenar el precio mas bajo de la lista-->
                <input type="hidden" name="precioMasBajo" id="precioMasBajo" autocomplete="off">
                <!-- elegir pago  -->
                <!--<label for="forma-de-pago" class="subtitle_input">MONTO FACTURA</label>
                <div class="abono_total" id="forma-de-pago">
                <input type="radio" id="abono_seleccionado" name="forma_pago" value="abono">
                <label for="abono_seleccionado" class="abono_texto">Abono</label>
                <input type="radio" id="total_seleccionado" name="forma_pago" value="total" checked>
                <label for="total_seleccionado">Total</label>
                </div>-->
                <label for="banco" class="subtitle_input">BANCO</label>
                <select name="banco" class="selectors" id="banco"></select>
                <label for="numero_deposito" class="subtitle_input">NUMERO DEPOSITO</label>
                <input type="text" name="numero_deposito" class="info_boxes" id="numero_deposito" placeholder="Número de deposito" autocomplete="off" onblur="ExisteNoDeposito()">
                </div>
                <div class="second_sub_container">
                <label for="numero_cheque" class="subtitle_input">NUMERO CHEQUE</label>
                <input type="text" name="numero_cheque" class="info_boxes" id="numero_cheque" placeholder="Número de cheque" autocomplete="off">
                <label for="chkPrefechado" class="subtitle_input">CHEQUE PRE-FECHADO</label>
                <input type="checkbox" id="chkPrefechado" name="chkPrefechado" class="chekbox">
                <label for="fechaCobroCheque"  class="subtitle_input">FECHA COBRO</label>
                <input type="date" name="fechaCobroCheque" id="fechaCobroCheque"  class="info_boxes">
                <label for="comentarioCheque" class="subtitle_input">OBSERVACIONES CHEQUE</label>
                <textarea name="comentarioCheque" class="comentario" id="comentarioCheque" cols="30" rows="5"></textarea>
                <label for="checkAvanzado" class="subtitle_input">CAJA RURAL</label>
                <input type="checkbox" id="checkAvanzado" name="checkAvanzado" class="chekbox">
                <!--<label for="checkAvanzadoDos" class="subtitle_input">COMPRA CONTADO</label>
                <input type="checkbox" id="checkAvanzadoDos" name="checkAvanzado">-->
                <!-- <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                <textarea name="observaciones_producto" class="comentario" id="observaciones_producto" cols="30" rows="5"></textarea> -->
                <!-- <button class="see" id="btnImprimir" type="button">IMPRIMIR</button> -->
                <button class="add" onclick="GuardarRegistro('N')" type="button">GUARDAR</button>
                <!-- <button class="see" onclick="seeOrder('subContainerDates')" type="button">Ver recibo</button> -->
                </div>
            </div>
    </form>
    <div id="modalPago" class="fondo_pagos">
    <div class="modal_pagos">
    <i id="modal_x" class='bx bx-x'></i>
    <h2 class="titulo_pedido">Pago</h2>
    <div class="cuadros">
    <label for="saldoModal" class="subtitle_input">SALDO</label>
        <input type="text" name="saldoModal" class="info_boxes_modal" id="saldoModal" autocomplete="off" readonly>
    </div>
    <div class="cuadros">
    <label for="pagoModal" class="subtitle_input">PAGO</label>
        <input type="text" name="pagoModal" class="info_boxes_modal" id="pagoModal" autocomplete="off">
    </div>
    <button class="btn_confirmar" type="button" onclick="asignarPago()">Confirmar</button>
  </div>
    </div>

    
    <div class="fondo" id="modal">
        <div class="modal_pedido">
        <h2 class="titulo_pedido">Pedido</h2>
    <div class="contenedor_select_pedidos">
        <select name="listado" id="listado" class="selector"></select>
        <button type="button" id="quitarRegistro" class="button_removeRegistry" name="quitarRegistro" onclick="QuitarItemDeLista()">Quitar recibo</button>
    </div>
    <button class="add_more" onclick="backToOrders('subContainerDates')" type="button" id="shopping_cart">Agregar más</button>
    <a class="link_guardar" href="#subContainerDates">
        <button class="save" type="button" id="send_order" onclick="GuardarRegistro('N')">Guardar</button>
    </a>
    </div>
    </div>
    <!--Habilita funciones como autocompletar y alertify, entre otras-->
    <script src="../js/jquery-3.6.0.min.js"></script>
    <!--Habilita la carga de códigos y nombres de clientes-->
    <script src="../js/listas_pedido.js"></script>
    <!--Habilita el listado de bancos-->
    <script src="../js/lista_bancos.js"></script>
    <!--Habilita las funciones para realizar las operaciones con los recibos-->
    <script src="../js/registro_recibo.js"></script>
    <!--Funciones para modales-->
    <script src="../js/table.js"></script>
    <!--Mensajes al usuario-->
    <script src="../js/alertify.min.js"></script>
    <!--Expone las funciones para cargar la serie y número de recibo por vendedor-->
    <script src="../js/recibo_numeracion.js"></script>
    <!--Una versión reciente-->
    <script src="../js/jquery-3.7.0.js"></script>
    <!--Habilita el uso de tablas (grids) con funciones específicas (externo)-->
    <script src="..//js/jquery.dataTables.min.js"></script>
    <!--Complemento del anterior-->
    <script src="../js/dataTables.fixedColumns.min.js"></script>
    <!--Expone la tabla a nivel global para interacciones (no está en uso)-->
    <script src="../js/tablaRecibos.js"></script>
    <!--Funciones para obtener saldo, desglosar montos, asignar pagos-->
    <script src="../js/recibo_cobro_envio.js"></script>
    <!-- Conector para impresión -->
    <!-- <script src="../js/conectorImpresora.js"></script> -->
    <!-- Enviar los datos a imprimir -->
    <!-- <script src="../js/impresion.js"></script> -->
</body>

</html>