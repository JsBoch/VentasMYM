<?php
session_start();
if (!isset($_SESSION['estado']) || $_SESSION['estado'] != "conectado") {
    header("Location: acceso.php");
}
?>
<!DOCTYPE html>
<html lang="es">

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
    <link rel="stylesheet" href="../css/devolucion.css">
    <link rel="icon" href="../imgs/icono.png">
    <title>Registro de devolución</title>
</head>
<style>
    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }

</style>
<body onload="listaDepartamentos(),listaClientes()">
    <form id="subContainerDates" class="contenedorPrincipal"  action="" method="post">
        <div class="customer_frame">
            <!-- Boton para regresar al menu -->
            <div class="above_all">
                <a href="../index.php">
                    <h3>Volver</h3>
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
            <div class="encabezado">
            <h2 class="main_title">Datos Generales</h2>
            </div>
            <div class="sub_container">
                    <label for="departamento" class="subtitle_input">DEPARTAMENTO</label>
                    <select name="departamento" class="selectors" id="departamento" onchange="listaClientes()"></select>
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
                    <!-- No.Devolución: se utiliza para que el usuario registre el número de devolución física que
                    puedo haber trabajado, si hizo directamente el registro en la aplicación este campo queda vacío-->
                    <label for="inputNoDevolucion" class="subtitle_input">No.DEVOLUCIÓN FISICA</label>                    
                    <input type="text" name="inputNoDevolucion" class="selectors" id="inputNoDevolucion">
                    <label for="inputMotivo" class="subtitle_input">MOTIVO</label>                    
                    <input type="text" name="inputMotivo" class="selectors" id="inputMotivo">
            </div>
        </div>
    </div>
    
    <div class="second_container">
                    <div class="encabezado">
            <h2 class="main_title">Detalle de devoluciones</h2>
            </div>
            <div class="contenedor_tablas">
  <!-- Tabla que muestra los envíos asociados al cliente seleccioando -->
  <label for="tablaEnviosCliente" class="subtitle_input">Envíos asociados</label>
                <div class="contenedor_tabla">
                <table id="tablaEnviosCliente" class="display stripe row-border order-column">
                   <thead>
                       <tr>
                           <th>Tipo</th>
                           <th>No.Envío</th>
                           <th>Monto</th>
                           <th>Fecha</th>                                                      
                       </tr>
                    </thead>
                  <tbody id="cuerpo">
                   </tbody>
                </table>
                </div>


                <!-- Se carga el detalle del envío seleccionado -->
                <label for="tablaDetalleEnvio" class="subtitle_input">Detalle del envío</label>
                <div class="contenedor_tabla">
                <table id="tablaDetalleEnvio" class="display stripe row-border order-column">
                   <thead>
                       <tr>
                           <th>Codigo</th>
                           <th>Producto</th>
                           <th>Cantidad</th>
                           <th>Precio</th>
                           <th>Devolucion</th>
                           <th>Bodega destino</th>
                           <th>Id Bodega</th>
                           <th>Id Detalleventa</th>                           
                       </tr>
                    </thead>
                  <tbody id="cuerpo">
                   </tbody>
                </table>
                </div>
                <button type="button" class="btn_editar" id="btnEditarDetalle">Editar</button>
                <!-- *************************** -->
                </div>
            </div>
              
    </div>
    </form>    
    <div class="fondoMensaje" id="verDireccion">
        <div class="contenedor_nombres">
            <p id="parrafoParaDireccion"></p>
        </div>
    </div>

    <div id="modalDetalleEnvio" class="fondo_detalle_recibo">
    <div class="modal">
    <i id="btnCerrarDetalleEnvio" class='bx bx-x cerrar_modal'></i>
        <h2 class="titulo_modal">Detalle Envío</h2>
        <div class="centrado_detalle">
        <div class="sub_container_recibo">
        <label for="cantidadDevuelta" class="subtitle_input">CANTIDAD DEVUELTA</label>
        <input type="number" name="cantidadDevuelta" id="cantidadDevuelta" class="info_boxes">
        <label for="bodegaDestino" class="subtitle_input">BODEGA DESTINO</label>
        <input type="text" name="bodegaDestino" id="bodegaDestino" class="info_boxes">
        <button type="button" class="save" onclick="asignarDevolucion()">Guardar</button>
    </div>
    </div>

    <script src="../js/verDireccion.js"></script>
    <script src="../js/jquery-3.7.0.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="..//js/jquery.dataTables.min.js"></script>    
    <script src="../js/dataTables.fixedColumns.min.js"></script>
    <script src="../js/funcionesTabla.js"></script>
    <script src="../js/funciones.js"></script>
    <script src="../js/devolucion_carga_envios.js"></script>
    <script src="../js/listas_pedido.js"></script>
</body>

</html>
