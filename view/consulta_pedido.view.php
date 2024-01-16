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
    <link rel="stylesheet" href="../css/consulta_pedido.css">
    <link rel="stylesheet" href="../css/fixedColumns.dataTables.min.css">
    <link rel="icon" href="../imgs/icono.png">
    <title>Consulta de pedidos</title>
</head>
<style>
    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
 
</style>
<body onload="listaDepartamentos(),listaClientes(),listaProductos(),GetDate(),listaPrioridad(),listaTipoPago()">
    <!-- Datos para consulta    -->
    <div id="subContainerDates" class="sub_container_dates">
        <div class="query_date">
            <div class="contenedor_fechas">
                <label for="fechaInicio">Fecha Inicio</label>
                <input type="date" name="fechaInicio" id="fechaInicio" class="fechas">
            </div>
            <div class="contenedor_fechas">
                <label for="fechaFinal">Fecha Final</label>
                <input type="date" name="fechaFinal" id="fechaFinal" class="fechas">
            </div>
            <button type="button" id="bttnConsultar" class="btn_consultar" name="bttnConsultar" onclick="ConsultarPedidos()">Consultar</button>
        </div>
        <div class="orders-product">
            <div class="contenedor_pedido">
                <label for="listaPedidos" class="subtitulo">Pedidos</label>
                <select name="listaPedidos" id="listaPedidos" class="selectors_consulta" onchange="ConsultaProductos()"></select>
            </div>
            <div class="contenedor_producto">
                <!-- tabla -->
                <table id="example1" class="display tabla_pedidos">
                     <thead>
                       <tr>
                           <th>Código</th>
                           <th>Producto</th>
                           <th>Cantidad</th>
                           <th>Precio</th>
                           <th>Subtotal</th>
                           <th>Observaciones</th>
                       </tr>
                     </thead>
                   <tbody id="cuerpo_pd1">
                   </tbody>
                 </table>
                <!-- ----- -->
                <!-- <label for="listaProductos" class="subtitulo">Productos</label>
                <select name="listaProductos" id="listaProductos" class="selectors_consulta"></select> -->
            </div>
        </div>
        <div class="buttons_forDate">
            <button type="button" id="bttnEditar" name="bttnEditar" class="editar" onclick="CargaPedidoEdit()">Editar</button>
            <button type="button" id="bttnEliminar" name="bttnEliminar" class="eliminar" onclick="EliminarPedidoEdit()">Eliminar</button>
        </div>

        <div class="flecha" id="btn">
        <i class='bx bx-chevron-down'></i>
        </div>
    </div>

    <!-- Formulario -->

    <form action="" method="post" class="contenedorPrincipal" id="order_form">
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
            <h2 class="main_title">Cliente</h2>
            </div>
            <div class="sub_container">
                    <label for="departamento" class="subtitle_input">DEPARTAMENTO</label>
                    <select name="departamento" class="selectors" id="departamento"></select>
                    <!-- Autocompletado -->
                    <label for="cliente" class="subtitle_input">CLIENTE</label>
                    <div class="autoC">
                    <input type="text" name="cliente" id="cliente" class="input_autocomplete" placeholder="Nombre de cliente" data-id="0" onblur="obtenerIdCliente()" autocomplete="off">
                    <ul id="ulclienteresult" class="autocomplete_listClient"></ul>
                    </div>

                    <div class="ctdDireccion">
                      <div class="contenedor_direccion">
                      <label for="direccion_cliente" class="subtitle_input">DIRECCION DE CLIENTE</label>
                          <div class="autoC_direccion">
                          <input type="text" name="direccion_cliente" id="direccion_cliente" class="direccion" placeholder="Dirección de cliente" autocomplete="off">
                          </div>
                      </div>
                      <div class="ctdIcon" id="btnVerDireccion">
                      <i class='bx bx-low-vision'></i>
                      </div>
                    </div>
                    
                <label for="sltPrioridad" class="subtitle_input">PRIORIDAD</label>
                <select name="sltPrioridad" id="sltPrioridad"  class="selectors"></select>
                <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                <textarea name="observaciones" class="comentario" id="observaciones" cols="119" rows="4"></textarea>
                <input type="hidden" name="hdnNoSolicitud" id="hdnNoSolicitud">
                <input type="hidden" name="hdndepartamentoid" id="hdndepartamentoid">
                <input type="hidden" name="hdnclienteid" id="hdnclienteid">
                <label for="transporte" class="subtitle_input">TRANSPORTE</label>
                <input type="text" name="transporte" id="transporte" class="info_boxes" placeholder="Ingrese transporte">
                <label for="sltTipoPago" class="subtitle_input">TIPO PAGO</label>
                    <select name="sltTipoPago" id="sltTipoPago" class="selectors"></select>
            </div>
        </div>
        <!-- Pedido -->
        <div class="box_products">
        <div class="encabezado">
            <h2 class="main_title">Registro de Pedidos</h2>
        </div>
            <div class="sub_container_pd">
                <div class="pareja">
                    <div class="primero">
                    <label for="codigo" class="subtitle_input">CODIGO</label>
                <div class="autoC">
                <input type='text' name="codigo" class="input_autocomplete" id="codigo" placeholder="ingrese código" onchange="limpiarNombre()" autocomplete="off">
                <ul class="autocomplete_list" id="results"></ul>
                </div>   </div>
                    <div class="segundo">
                    <label for="existencia" class="subtitle_input">EXISTENCIA</label>
                <input type="text" class="info_boxes" name="existencia" id="existencia" placeholder="EXISTENCIA" readonly autocomplete="off">
                    </div>
                </div>
            
                <div class="ctdProducto">
            <div class="contenedor_producto_dos">
            <label for="producto" class="subtitle_input">PRODUCTO</label>
                <div class="autoC_pd">
                <input type="text" name="producto" class="input_autocomplete" id="producto" placeholder="ingreso nombre" size="100" onchange="limpiarCodigo()" autocomplete="off">
                <ul id="resultsProducto" class="autocomplete_listPro"></ul>
                </div>
            </div>
            <div class="ctdIcon" id="btnVer">
            <i class='bx bx-low-vision'></i>
            </div>
          </div>
                <!--Agrego un hidden para almacenar el precio mas bajo de la lista-->
                <input type="hidden" name="precioMasBajo" id="precioMasBajo" autocomplete="off">     
                <ul class="autocomplete_listCod" id="results"></ul>
                <ul class="autocomplete_list" id="resultsProducto"></ul>
                <label for="cantidad" class="subtitle_input">CANTIDAD</label>
                <input type="number" name="cantidad" class="info_boxes" id="cantidad" placeholder="CANTIDAD" onblur="colocarPrecio(),CalculoSubtotal()">
                <label for="tipo_precio" class="subtitle_input">TIPO PRECIO</label>
                <select name="tipo_precio" class="selectors" id="tipo_precio" onblur="colocarPrecio()"></select>
                <label for="precio" class="subtitle_input">PRECIO</label>
                <input type="text" name="precio" class="info_boxes" id="precio" placeholder="PRECIO" onchange="CalculoSubtotal()" autocomplete="off">
                <input type="hidden" name="precio" class="info_boxes" id="precio" placeholder="PRECIO" onblur="CalculoSubtotal()">
                <div class="grupo">
                    <div class="uno">
                    <label for="descuento" class="subtitle_input">SUBTOTAL</label>
                    <input type="text" name="descuento" class="info_boxes" id="total" placeholder="SUBTOTAL">
                    </div>
                    <div class="dos">
                    <label for="descuento" class="subtitle_input">DESCUENTO</label>
                    <input type="text" name="descuento" class="info_boxes" id="descuento" placeholder="DESCUENTO">
                    </div>
                    <div class="tres">
                    <label for="subtotal" class="subtitle_input">TOTAL</label>
                    <input type="text" name="subtotal" class="info_boxes" id="subtotal" placeholder="TOTAL" autocomplete="off">
                    </div>
                </div>
            </div>
                <div class="sub_container_pd">
                <label for="observaciones_producto" class="subtitle_input">OBSERVACIONES</label>
                <textarea name="observaciones_producto" class="comentario" id="observaciones_producto" cols="30" rows="4"></textarea>
                <button class="add" onclick="cargarDetalleEdit()" type="button">Agregar</button>
                <button class="see" onclick="seeOrder('order_form')" type="button">Ver Pedido</button>
            </div>
        </div>
    </form>

    <div class="fondoMensaje" id="verNombreProducto">
        <div class="contenedor_nombre">
            <p id="parrafoParaNombre"></p>
        </div>
    </div>
    <div class="fondoMensaje" id="verDireccion">
        <div class="contenedor_nombres">
            <p id="parrafoParaDireccion"></p>
        </div>
    </div>

    <div class="fondo" id="modal">
        <div class="modal_pedido">
        <i id="cerrar" class='bx bx-x btn_cerrar'></i>
        <h2 class="titulo_pedido">Pedido</h2>
        <div class="cuadro_botones">
    <button id="button" class="button_removeRegistry" onclick="QuitarItemDeLista()"> <i class='bx bx-trash'></i></button>
    </div>
    <div class="contenedor_select_pedidos">
    <table id="example" class="display">
        <thead>
            <tr>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Producto</th>
            </tr>
        </thead>
        <tbody id="cuerpo">
        </tbody>
    </table>
    </div>
    <div class="ctntFinal">
        <h2 class="total">
             Total:<h2 class="total_cantidad" id="totalGeneral"></h2>
        </h2>
    </div>
    <button class="add_more" onclick="backToOrders('subContainerDates')" type="button" id="shopping_cart">Agregar otro producto</button>
    <a class="link_guardar" href="#subContainerDates">
        <button class="save" type="button" id="send_order" onclick="GuardarRegistro()">Enviar Pedido</button>
    </a>
    </div>
    </div>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/table.js"></script>
    <script src="../js/listas_pedido.js"></script>
    <script src="../js/registro_pedido.js"></script>
    <script src="../js/funciones.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/consulta_pedido.js"></script>
    <script src="../js/jquery-3.7.0.js"></script>
    <script src="..//js/jquery.dataTables.min.js"></script>
    <script src="../js/funcionesTabla.js"></script>
    <script src="../js/dataTables.fixedColumns.min.js"></script>
    <script src="../js/btncerrar.js"></script>
    <script src="../js/fondo.js"></script>
</body>

</html>