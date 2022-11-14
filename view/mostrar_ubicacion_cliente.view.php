<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mainStyles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="icon" href="../imgs/logo.png">
    <title>Consulta de clientes</title>

</head>

<body onload="listaDepartamentosConsulta(),listaClientesConsultaRegistro(),Inicializar(),listaRegiones()">
    <div class="customer_query">
        <!-- Boton para regresar al menu -->
        <div class="above_all">
            <a href="../index.php">
                <h3>Ir al menu</h3>
                <i class='bx bx-log-out'></i>
            </a>
        </div>
        <select name="depa" class="department_selector" id="depa" onchange="listaClientesConsultaRegistro(),findValue()"></select>
        <input type="text" name="cliente" id="cliente" class="customer_name_box onlyUppercase" placeholder="Nombre de cliente" data-id="0">
        <ul id="ulclienteresult" class="autocomplete_listClient"></ul>
        <button name="btnCliente" id="btnCliente" class="show_informationButton" onclick="findValue(),CargarDatosCliente()">Mostrar Información</button>
        <!-- <label class="text_checkbox">Editar Registro</label>
        <input type="checkbox" name="chkEditar" id="chkEditar"  onclick="HabilitarEdicionFichaCliente()"> -->
        <div class="text_edit">
            <h3 class="edit">Editar</h3>
        </div>
        <div class="checkbox-JASoft">
            <input type="checkbox" id="checkAvanzado" onclick="HabilitarEdicionFichaCliente()">
            <label for="checkAvanzado">TEXTO QUE NO DEBERÍA VERSE</label>
        </div>

    </div>
    <!--<div id="floating-panel">
      <b>Mode of Travel: </b>
      <select id="mode" onchange="calcRoute()>
        <option value="DRIVING">Driving</option>
        <option value="WALKING">Walking</option>
        <option value="BICYCLING">Bicycling</option>
        <option value="TRANSIT">Transit</option>
      </select>
    </div>
    <div id="map"></div>-->
    <form action="../data/registro_cliente.php" method="POST" id="customer_registration" class="form_box">
        
        <!-- formulario -->
        <h2 class="main_title">Registro De Clientes</h2>
        <div class="sub_container">
            <label for="txtCodigo" class="subtitle_input">CÓDIGO</label>
            <input type="text" name="txtCodigo" id="txtCodigo" placeholder="codigo" class="info_boxes">
            <label for="nit" class="subtitle_input">NIT</label>       
            <input class="info_boxes" placeholder="Ingrese NIT" name="nit" id="nit" type="text">
            <label for="dpi" class="subtitle_input">DPI</label>
            <input class="info_boxes" placeholder="Ingrese DPI" name="dpi" id="dpi" type="text">
            <label for="nombre" class="subtitle_input">NOMBRE</label>
            <input class="info_boxes" placeholder="Ingrese Nombre" name="nombre" id="nombre" type="text" onblur="EstablecerRazonSocialConsulta()">
            <label for="razonsocial" class="subtitle_input">RAZÓN SOCIAL</label>
            <input class="info_boxes" placeholder="Ingrese Razón Social" name="razonsocial" id="razonsocial" type="text">
            <!-- <div class="label_depa">
        <label for="depa">DEPARTAMENTO</label>
        </div>    -->
            <!--<select class="selectors" name="SD" id="depa" onchange="findValue()"></select>-->
            <!-- <div class="label_muni">
        <label for="municipio">MUNICIPIO</label>
        </div>    -->
        <label for="municipio" class="subtitle_input">MUNICIPIO</label>
            <select class="selectors" name="SM" id="municipio" form="customer_registration">
            </select>
            <label for="direccion" class="subtitle_input">DIRECCIÓN</label>
            <input class="info_boxes" placeholder="Ingrese Dirección" name="direccion" id="direccion" type="text">
            <label for="telefono" class="subtitle_input">TELEFONO</label>
            <input class="info_boxes" placeholder="Ingrese Teléfono" name="telefono" id="telefono" type="number">
            <label for="correo" class="subtitle_input">CORREO</label>
            <input class="info_boxes" placeholder="Ingrese@email.com" name="correo" id="correo" type="email">
            <!--<input class="info_boxes" placeholder="Ingrese Region" name="region" id="region" type="text">-->
            <label for="region" class="subtitle_input">REGIÓN</label>
            <select name="region" id="region" class="selectors"></select>
            <!-- <div class="label_com">
        <label for="comentario">OBSERVACIONES</label>
        </div>    -->   
        <label for="txtCodigoPostal" class="subtitle_input">CÓDIGO POSTAL</label>   
        <input type="text" name="txtCodigoPostal" id="txtCodigoPostal" placeholder="código postal" class="info_boxes">
          <label for="comentario" class="subtitle_input">OBSERVACIÓN</label>
          <textarea class="comments" rows="10" cols="8" name="comentario" id="comentario"></textarea>
          <label for="transporte" class="subtitle_input">TRANSPORTE</label>
          <input style="width: auto;" class="info_boxes" placeholder="Ingrese Transporte" name="transporte" id="transporte" type="text">

            <div class="map">
                <button type="button" name="bttnUbicacion" id="bttnUbicacion" class="button_location" onclick="ObtenerUbicacion()">UBICACIÓN</button>
                <h3 class="titles_location">Latitud</h3>
                <input type="text" name="txtLatitud" id="txtLatitud" placeholder="latitud" class="spaces_location" readonly>
                <h3 class="titles_location">Longitud</h3>
                <input type="text" name="txtLongitud" id="txtLongitud" placeholder="longitud" class="spaces_location" readonly>
                <h3 class="titles_location">Ubicación completa</h3>
                <input type="text" name="ubcacion" id="ubicacion" placeholder="ubicacion" class="spaces_location">
            </div>
            <input type="hidden" value="1" name="empleado">
            <input type="hidden" name="clienteId" id="clienteId">
            <input type="hidden" name="SD" id="SD">
            <button id="bttnModificar" name="bttnModificar" class="send" type="submit">Modificar</button>
            <!-- <a href="#" class="send btn-neon">
        <span id="span1"></span>
        <span id="span2"></span>
        <span id="span3"></span>
        <span id="span4"></span>
        Enviar
     </a> -->
        </div>
    </form>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/listas_pedido.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/departamentos.js"></script>
    <script src="../js/clientesln.js"></script>
    <script src="../js/mapa_cliente.js"></script>
    <!-- <script src="../js/validations.js"></script> -->
</body>

</html>