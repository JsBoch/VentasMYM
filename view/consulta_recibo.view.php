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
    <link rel="stylesheet" href="../css/consultationReceipt.css">
    <link rel="icon" href="../imgs/logo.png">
    <title>Recibo</title>
</head>

<body onload="listaDepartamentosRecibo(),listaBancos()">
<div id="subContainerDates" class="sub_container-dates">
        <!-- Boton para regresar al menu -->
        <div class="above_all">
            <a href="../index.php">
                <h3>Ir al menu</h3>
                <i class='bx bx-log-out'></i>
            </a>
        </div>
        <div class="query_date">
            <div class="start_date">
                <label for="fechaInicio">Fecha Inicio</label>
                <input type="date" name="fechaInicio" id="fechaInicio">
            </div>
            <div class="last_date">
                <label for="fechaFinal">Fecha Final</label>
                <input type="date" name="fechaFinal" id="fechaFinal">
            </div>
            <button type="button" id="bttnConsultar" name="bttnConsultar" onclick="ConsultarRecibos()">Consultar</button>
        </div>
        <div class="orders-product">
            <div class="orders">
                <label for="listaPedidos">Recibos</label>
                <select name="listaPedidos" id="listaPedidos" class="selectors" onchange="ConsultaProductos()"></select>
            </div>
            <div class="products">
                <label for="listaProductos">Envios</label>
                <select name="listaProductos" id="listaProductos" class="selectors"></select>
            </div>
        </div>
        <div class="buttons_forDate">
            <button type="button" id="bttnEditar" name="bttnEditar" onclick="CargaPedidoEdit()">Editar</button>
            <button type="button" id="bttnEliminar" name="bttnEliminar" onclick="EliminarPedidoEdit()">Eliminar</button>
        </div>
    </div>
    <form id="subContainerDates" action="" method="post">
        <div class="customer_frame">
            <!-- cliente -->
            <h2 class="main_title">Datos Generales</h2>
            <div class="sub_container">
                <div class="first_half">
                <label for="numero_recibo" class="subtitle_input">NUMERO DE RECIBO</label>
                <input type='number' name="numero_recibo" class="info_boxes" id="numero_recibo" placeholder="ingrese número de recibo" autocomplete="off">
                    <label for="departamento" class="subtitle_input">DEPARTAMENTO</label>
                    <select name="departamento" class="selectors" id="departamento" onchange="listaClientes()"></select>
                    <!--<select name="cliente" class="selectors" id="cliente"></select>-->

                    <!-- ASIGNAR FORMATO RESPONSIVE a cliente y ulclienteresult-->
                    <label for="cliente" class="subtitle_input">CLIENTE</label>
                    <select name="cliente" class="selectors" id="cliente"></select>
                    <!-- <input type="text" name="cliente" id="cliente" class="info_boxes" placeholder="Nombre de cliente" data-id="0" onblur="obtenerIdCliente()" autocomplete="off"> -->
                    <ul id="ulclienteresult" class="autocomplete_listClient"></ul>
        
                </div>
                <div class="second_half">
                <label for="sltSemana" class="subtitle_input">SEMANA</label>
                    <select name="sltSemana" id="sltSemana" class="selector">
                        <option value="SEMANA 1">SEMANA 1</option>
                        <option value="SEMANA 2">SEMANA 2</option>
                        <option value="SEMANA 3">SEMANA 3</option>
                        <option value="SEMANA 4">SEMANA 4</option>
                    </select>
                    <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                    <textarea name="observaciones" class="comments" id="observaciones" cols="119" rows="5"></textarea>
                </div>
            </div>
        </div>
        <!-- Pedido -->
        <div class="box_products">
            <h2 class="main_title">Detalle de Recibo</h2>
            <div class="second_sub_container">
                <label for="numero_envio" class="subtitle_input">NUMERO DE ENVIO</label>
                <input type='number' name="numero_envio" class="info_boxes" id="numero_envio" placeholder="ingrese número de envio" autocomplete="off">
                <label for="empresa" class="subtitle_input">EMPRESA</label>
                <select name="empresa" class="selector" id="empresa">
                    <option value="mym">MYM</option>
                    <option value="sa">SA</option>
                </select>
                <label for="tipo_pago" class="subtitle_input">TIPO PAGO</label>
                <select name="tipo_pago" class="selector" id="tipo_pago">
                    <option value="efectivo">EFECTIVO</option>
                    <option value="cheque">CHEQUE</option>
                    <option value="deposito">DEPOSITO</option>
                </select>
                <label for="pago" class="subtitle_input">MONTO</label>
                <input type="number" class="info_boxes" name="pago" id="pago" placeholder="Monto" autocomplete="off">
                <!--Agrego un hidden para almacenar el precio mas bajo de la lista-->
                <input type="hidden" name="precioMasBajo" id="precioMasBajo" autocomplete="off">
                <!-- elegir pago  -->
                <label for="forma-de-pago" class="subtitle_input">MONTO FACTURA</label>
                <div class="abono_total" id="forma-de-pago">
                    <input type="radio" id="abono_seleccionado" name="forma_pago" value="abono">
                    <label for="abono_seleccionado" class="abono_texto">Abono</label>
                    <input type="radio" id="total_seleccionado" name="forma_pago" value="total" checked>
                    <label for="total_seleccionado">Total</label>
                </div>

                <label for="banco" class="subtitle_input">BANCO</label>
                <select name="banco" class="selector" id="banco"></select>
                <label for="numero_deposito" class="subtitle_input">NUMERO DEPOSITO</label>
                <input type="text" name="numero_deposito" class="info_boxes" id="numero_deposito" placeholder="Número de deposito" autocomplete="off">
                <label for="numero_cheque" class="subtitle_input">NUMERO CHEQUE</label>
                <input type="text" name="numero_cheque" class="info_boxes" id="numero_cheque" placeholder="Número de cheque" autocomplete="off">

                <div class="checkbox_cajaRural">
                    <div class="text_edit">
                        <h3 class="edit">Caja rural</h3>
                    </div>
                    <div class="checkbox-JASoft">
                        <input type="checkbox" id="checkAvanzado" name="checkAvanzado">
                        <label for="checkAvanzado">TEXTO QUE NO DEBERÍA VERSE</label>
                    </div>
                </div>

                <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                <div class="comentario">
                    <textarea name="observaciones_producto" class="comments" id="observaciones_producto" cols="30" rows="5"></textarea>
                </div>
                <button class="add" onclick="cargarDetalle()" type="button">Agregar</button>
                <button class="see" onclick="seeOrder('subContainerDates')" type="button">Ver recibo</button>
            </div>
        </div>
    </form>

    <div id="main-container">
        <select name="listado" id="listado" class="product_selector"></select>
        <button type="button" id="quitarRegistro" class="button_removeRegistry" name="quitarRegistro" onclick="QuitarItemDeLista()">Quitar recibo</button>
    </div>
    <button class="add_more" onclick="backToOrders('subContainerDates')" type="button" id="shopping_cart">Agregar más</button>
    <a class="link_guardar" href="#subContainerDates">
        <button class="save" type="button" id="send_order" onclick="GuardarRegistro('S')">Guardar</button>
    </a>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/listas_pedido.js"></script>
    <script src="../js/lista_bancos.js"></script>
    <script src="../js/registro_recibo.js"></script>
    <script src="../js/table.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/consulta_recibo.js"></script>
</body>

</html>