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
    <title>Registro de pedidos</title>
</head>

<body onload="listaDepartamentos(),listaProductos(),listaClientes(),listaPrioridad()">
    <form id="subContainerDates" action="" method="post">
        <div class="customer_frame">
            <!-- Boton para regresar al menu -->
            <div class="above_all">
                <a href="../index.php">
                    <h3>Ir al menu</h3>
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
            <!-- cliente -->
            <h2 class="main_title">Datos Generales</h2>
            <div class="sub_container">
                <div class="first_half">
                    <label for="departamento" class="subtitle_input">DEPARTAMENTO</label>
                    <select name="departamento" class="selectors" id="departamento" onchange="listaClientes()"></select>
                    <!--<select name="cliente" class="selectors" id="cliente"></select>-->

                    <!-- ASIGNAR FORMATO RESPONSIVE a cliente y ulclienteresult-->
                    <label for="cliente" class="subtitle_input">CLIENTE</label>
                    <input type="text" name="cliente" id="cliente" class="info_boxes" placeholder="Nombre de cliente" data-id="0" onblur="obtenerIdCliente()" autocomplete="off">
                    <ul id="ulclienteresult" class="autocomplete_listClient"></ul>
                    <label for="sltPrioridad" class="subtitle_input">PRIORIDAD</label>
                    <select name="sltPrioridad" id="sltPrioridad" class="selector"></select>
                </div>
                <div class="second_half">
                    <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                    <textarea name="observaciones" class="comments" id="observaciones" cols="119" rows="5"></textarea>
                    <label for="transporte" class="subtitle_input">TRANSPORTE</label>
                    <input type="text" name="transporte" id="transporte" class="info_boxes" placeholder="Ingrese transporte">
                </div>
            </div>
        </div>
        <!-- Pedido -->
        <div class="box_products">
            <h2 class="main_title">Detalle de Productos</h2>
            <div class="second_sub_container">
                <label for="codigo" class="subtitle_input">CODIGO</label>
                <input type='text' name="codigo" class="info_boxes" id="codigo" placeholder="ingrese código" onchange="limpiarNombre()" autocomplete="off">
                <label for="producto" class="subtitle_input">PRODUTO</label>
                <input type="text" name="producto" class="info_boxes" id="producto" placeholder="ingreso nombre" size="100" onchange="limpiarCodigo()" autocomplete="off">

                <ul class="autocomplete_list" id="results"></ul>
                <ul id="resultsProducto" class="autocomplete_listPro"></ul>

                <!--<ul class="autocomplete_listCod" id="results"></ul>
                <ul class="autocomplete_list" id="resultsProducto"></ul>-->
                <label for="existencia" class="subtitle_input">EXISTENCIA</label>
                <input type="text" class="info_boxes" name="existencia" id="existencia" placeholder="EXISTENCIA" readonly autocomplete="off">
                <!--Agrego un hidden para almacenar el precio mas bajo de la lista-->
                <input type="hidden" name="precioMasBajo" id="precioMasBajo" autocomplete="off">
                <label for="cantidad" class="subtitle_input">CANTIDAD</label>
                <input type="number" name="cantidad" class="info_boxes" id="cantidad" placeholder="CANTIDAD" onchange="CalculoSubtotal()" autocomplete="off">
                <label for="tipo_precio" class="subtitle_input">TIPO PRECIO</label>
                <select name="tipo_precio" class="selector" id="tipo_precio" onchange="colocarPrecio(),CalculoSubtotal()"></select>
                <label for="precio" class="subtitle_input">PRECIO</label>
                <input type="text" name="precio" class="info_boxes" id="precio" placeholder="PRECIO" onchange="CalculoSubtotal()" autocomplete="off">
                <label for="subtotal" class="subtitle_input">SUBTOTAL</label>
                <input type="text" name="subtotal" class="info_boxes" id="subtotal" placeholder="SUBTOTAL" autocomplete="off">
                <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                <div class="comentario">
                    <textarea name="observaciones_producto" class="comments" id="observaciones_producto" cols="30" rows="5"></textarea>
                </div>
                <button class="add" onclick="cargarDetalle()" type="button">Agregar al Pedido</button>
                <button class="see" onclick="seeOrder('subContainerDates')" type="button">Ver Pedido</button>
            </div>
        </div>
    </form>

    <div id="main-container">
        <select name="listado" id="listado" class="product_selector"></select>
        <button type="button" id="quitarRegistro" class="button_removeRegistry" name="quitarRegistro" onclick="QuitarItemDeLista()">Quitar Registro</button>
    </div>
    <button class="add_more" onclick="backToOrders('subContainerDates')" type="button" id="shopping_cart">Agregar otro producto</button>
    <a class="link_guardar" href="#subContainerDates">
        <button class="save" type="button" id="send_order" onclick="GuardarRegistro()">Enviar Pedido</button>
    </a>
    <script src="../js/table.js"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/listas_pedido.js"></script>
    <script src="../js/registro_pedido.js"></script>
    <script src="../js/funciones.js"></script>
    <script src="../js/alertify.min.js"></script>
</body>

</html>