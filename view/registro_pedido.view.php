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
    <link rel="stylesheet" href="../css/ordersStyles.css">
    <title>REGISTRO DE PEDIDOS</title>
</head>

<body onload="listaDepartamentos(),listaProductos()">
    <form action="" method="post" id="order_form">
        <div class="customer_frame">
            <!-- Boton para regresar al menu -->
            <div class="above_all">
                <a href="../index.php">
                    <h3>Ir al menu</h3>
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
            <!-- cliente -->
            <h2 class="main_title">Cliente</h2>
            <div class="sub_container">
                <select name="departamento" class="selectors" id="departamento" onchange="listaClientes()"></select>
                <select name="cliente" class="selectors" id="cliente"></select>
                <textarea name="observaciones" class="comments" id="observaciones" cols="119" rows="5"></textarea>
            </div>
        </div>
        <!-- Pedido -->
        <div class="box_products">
            <h2 class="main_title">Registro de Pedidos</h2>
            <div class="second_sub_container">
                <input type='text' name="codigo" class="info_boxes" id="codigo" placeholder="ingrese código" onblur="listaPrecios(),getNombreProducto()"></select>
                <input type="text" name="producto" class="info_boxes" id="producto" placeholder="ingreso nombre" size="100" onblur="getCodigo(),listaPrecios()">

                <ul class="autocomplete_list" id="results">
                </ul>
                <ul id="resultsProducto" class="autocomplete_listPro"></ul>

                <ul class="autocomplete_listCod" id="results"></ul>
                <ul class="autocomplete_list" id="resultsProducto"></ul>
                <input type="number" name="cantidad" class="info_boxes" id="cantidad" placeholder="CANTIDAD">
                <select name="tipo_precio" class="selector" id="tipo_precio" onblur="colocarPrecio()"></select>
                <input type="text" name="precio" class="info_boxes" id="precio" placeholder="PRECIO" onblur="CalculoSubtotal()">
                <input type="text" name="subtotal" class="info_boxes" id="subtotal" placeholder="SUBTOTAL">
                <textarea name="observaciones_producto" class="comments" id="observaciones_producto" cols="30" rows="10"></textarea>
                <button class="add" onclick="cargarDetalle()" type="button">Agregar</button>
                <button class="see" onclick="seeOrder()" type="button">Ver Pedido</button>
            </div>
        </div>
    </form>

    <div id="main-container">
        <select name="listado" id="listado" class="product_selector"></select>
        <button type="button" id="quitarRegistro" class="button_removeRegistry" name="quitarRegistro" onclick="QuitarItemDeLista()">Quitar Registro</button>
    </div>
    <button class="add_more" onclick="backToOrders()" type="button" id="shopping_cart">Agregar Más</button>
    <button class="save" type="button" id="send_order" onclick="GuardarRegistro()">Guardar</button>

    <script src="../js/table.js"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/listas_pedido.js"></script>
    <script src="../js/registro_pedido.js"></script>
    <script src="../js/funciones.js"></script>
</body>

</html>