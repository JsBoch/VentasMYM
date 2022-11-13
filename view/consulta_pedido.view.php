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
    <title>Consulta de pedidos</title>
</head>

<body onload="listaDepartamentosConsultaPedido(),listaProductos(),GetDate(),listaPrioridad()">
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
            <button type="button" id="bttnConsultar" name="bttnConsultar" onclick="ConsultarPedidos()">Consultar</button>
        </div>
        <div class="orders-product">
            <div class="orders">
                <label for="listaPedidos">Pedidos</label>
                <select name="listaPedidos" id="listaPedidos" class="selectors" onchange="ConsultaProductos()"></select>
            </div>
            <div class="products">
                <label for="listaProductos">Productos</label>
                <select name="listaProductos" id="listaProductos" class="selectors"></select>
            </div>
        </div>
        <div class="buttons_forDate">
            <button type="button" id="bttnEditar" name="bttnEditar" onclick="CargaPedidoEdit()">Editar</button>
            <button type="button" id="bttnEliminar" name="bttnEliminar" onclick="EliminarPedidoEdit()">Eliminar</button>
        </div>
    </div>
    <form action="" method="post" id="order_form">
        <div class="customer_frame">

            <!-- cliente -->
            <h2 class="main_title">Cliente</h2>
            <div class="sub_container">
            <div class="first_half">
                <label for="departamento" class="subtitle_input">DEPARTAMENTO</label>
                <select name="departamento" class="selectors" id="departamento"></select>
                <label for="cliente" class="subtitle_input">CLIENTE</label>
                <select name="cliente" class="selectors" id="cliente"></select>
                <label for="sltPrioridad" class="subtitle_input">PRIORIDAD</label>
                <select name="sltPrioridad" id="sltPrioridad"  class="selector"></select>
                </div>
                <div class="second_half">
                <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                <textarea name="observaciones" class="comments" id="observaciones" cols="119" rows="5"></textarea>
                <input type="hidden" name="hdnNoSolicitud" id="hdnNoSolicitud">
                <input type="hidden" name="hdndepartamentoid" id="hdndepartamentoid">
                <input type="hidden" name="hdnclienteid" id="hdnclienteid">
                <label for="transporte" class="subtitle_input">TRANSPORTE</label>
                <input type="text" name="transporte" id="transporte" class="info_boxes" placeholder="Ingrese transporte">
                </div>
            </div>
        </div>
        <!-- Pedido -->
        <div class="box_products">
            <h2 class="main_title">Registro de Pedidos</h2>
            <div class="second_sub_container">
                <label for="codigo" class="subtitle_input">CODIGO</label>
                <input type='text' name="codigo" class="info_boxes" id="codigo" placeholder="ingrese código" onchange="limpiarNombre()"></select>
                <label for="producto" class="subtitle_input">PRODUTO</label>
                <input type="text" name="producto" class="info_boxes" id="producto" placeholder="ingreso nombre" size="100" onchange="limpiarCodigo()">

                <ul class="autocomplete_list" id="results">
                </ul>
                <ul id="resultsProducto" class="autocomplete_listPro"></ul>

                <label for="existencia" class="subtitle_input">EXISTENCIA</label>
                <input type="text" class="info_boxes" name="existencia" id="existencia" placeholder="EXISTENCIA" readonly autocomplete="off">
                <!--Agrego un hidden para almacenar el precio mas bajo de la lista-->
                <input type="hidden" name="precioMasBajo" id="precioMasBajo" autocomplete="off">
                
                <ul class="autocomplete_listCod" id="results"></ul>
                <ul class="autocomplete_list" id="resultsProducto"></ul>
                <label for="cantidad" class="subtitle_input">CANTIDAD</label>
                <input type="number" name="cantidad" class="info_boxes" id="cantidad" placeholder="CANTIDAD" onblur="colocarPrecio(),CalculoSubtotal()">
                <label for="tipo_precio" class="subtitle_input">TIPO PRECIO</label>
                <select name="tipo_precio" class="selector" id="tipo_precio" onblur="colocarPrecio()"></select>
                <label for="precio" class="subtitle_input">PRECIO</label>
                <input type="text" name="precio" class="info_boxes" id="precio" placeholder="PRECIO" onchange="CalculoSubtotal()" autocomplete="off">
                <input type="hidden" name="precio" class="info_boxes" id="precio" placeholder="PRECIO" onblur="CalculoSubtotal()">
                <label for="subtotal" class="subtitle_input">SUBTOTAL</label>
                <input type="text" name="subtotal" class="info_boxes" id="subtotal" placeholder="SUBTOTAL">
                <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                <div class="comentario"> 
                <textarea name="observaciones_producto" class="comments" id="observaciones_producto" cols="30" rows="10"></textarea>
                </div>
                <button class="add" onclick="cargarDetalleEdit()" type="button">Agregar</button>
                <button class="see" onclick="seeOrder('order_form')" type="button">Ver Pedido</button>
            </div>
        </div>
    </form>

    <div id="main-container">
        <select name="listado" id="listado" class="product_selector"></select>
        <button type="button" id="quitarRegistro" name="quitarRegistro" class="button_removeRegistry" onclick="QuitarItemDeListaEdit()">Quitar Registro</button>
    </div>

    <button class="add_more" onclick="backToOrders('order_form')" type="button" id="shopping_cart">Agregar Más</button>
    <a class="link_guardar" href="#subContainerDates">
    <button class="save" type="button" id="send_order" onclick="GuardarNuevoRegistro()">Guardar</button>
    </a>

    <script src="../js/table.js"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/listas_pedido.js"></script>
    <script src="../js/registro_pedido.js"></script>
    <script src="../js/funciones.js"></script>
    <script src="../js/consulta_pedido.js"></script>
    <script src="../js/alertify.min.js"></script>
</body>

</html>