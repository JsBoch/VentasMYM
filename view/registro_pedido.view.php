<?php    
    session_start();
        if (!isset($_SESSION['estado']) || $_SESSION['estado'] != "conectado") {
            header("Location: login.html");
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO DE PEDIDOS</title>
</head>
<body onload="listaDepartamentos(),listaProductos()">
    <form action="" method="post">
        <select name="departamento" id="departamento" onchange="listaClientes()"></select>
        <select name="cliente" id="cliente"></select>
        <input type="text" name="observaciones" id="observaciones">
    </form>
    <form action="" method="post">
        <input type='text' name="codigo" id="codigo" placeholder="ingrese código" onblur="listaPrecios(),getNombreProducto()"></select>        
        <input type="text" name="producto" id="producto" placeholder="ingreso nombre" onblur="getCodigo()">        
        <ul id="results"></ul>
        <ul id="resultsProducto"></ul>
        <input type="number" name="cantidad" id="cantidad">
        <select name="tipo_precio" id="tipo_precio"></select>
        <input type="text" name="precio" id="precio">
        <input type="text" name="subtotal" id="subtotal">
        <input type="text" name="observaciones_producto" id="observaciones_producto">
        <div>            
    </div>
        <input type="button" value="AGREGAR">
    </form>
    <a href="../index.php">VOLVER</a>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/listas_pedido.js"></script>
</body>
</html>