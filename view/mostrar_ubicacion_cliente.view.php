<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/consulta_clientes.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="icon" href="../imgs/logo.png">
    <title>Consulta de clientes</title>

</head>

<body onload="listaDepartamentosConsulta(),listaClientesConsultaRegistro(),Inicializar(),listaRegiones()">
            <!-- Boton para regresar al menu -->
            <div class="above_all">
            <a href="../index.php">
                <h3>Ir al menu</h3>
                <i class='bx bx-log-out'></i>
            </a>
        </div>
    <div class="encabezado">
        <h2 class="main_title">Registro De Clientes</h2>
        </div>    
<div class="container_consulta">
    <label class="subtitle_input" for="depa">DEPARTAMENTO</label>
        <div class="contenedor_datos">
         <select name="depa" class="consulta_boxes" id="depa" onchange="listaClientesConsultaRegistro(),findValue()"></select>
        </div>
        <label class="subtitle_input" for="cliente">NOMBRE DE CLIENTE</label>
        <div class="contenedor_datos">
        <div class="autoC">
        <input type="text" name="cliente" id="cliente" class="consulta_boxes" placeholder="Nombre de cliente" data-id="0">
        <ul id="ulclienteresult" class="autocomplete_listClient"></ul>  
        </div>
    </div>
     <div class="botones">
     <button name="btnCliente" id="btnCliente" class="button" onclick="findValue(),CargarDatosCliente()">Mostrar Información</button>
        <label for="checkAvanzado">Editar</label>
        <input class="check" id="checkAvanzado" type="checkbox" onclick="HabilitarEdicionFichaCliente()">
     </div>
    </div>

    <form action="../data/registro_cliente.php" method="POST" id="customer_registration" class="form_box">
    <!-- formulario -->
        <div class="contenedor">
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
            <label for="municipio" class="subtitle_input">MUNICIPIO</label>
            <select class="selectors" name="SM" id="municipio" form="customer_registration"></select>
            <label for="direccion" class="subtitle_input">DIRECCIÓN</label>
            <input class="info_boxes" placeholder="Ingrese Dirección" name="direccion" id="direccion" type="text">
        </div>
        <div class="sub_container">
            <label for="telefono" class="subtitle_input">TELEFONO</label>
            <input class="info_boxes" placeholder="Ingrese Teléfono" name="telefono" id="telefono" type="number">
            <label for="correo" class="subtitle_input">CORREO</label>
            <input class="info_boxes" placeholder="Ingrese@email.com" name="correo" id="correo" type="email">
            <label for="region" class="subtitle_input">REGIÓN</label>
            <select name="region" id="region" class="selectors"></select>
            <label for="txtCodigoPostal" class="subtitle_input">CÓDIGO POSTAL</label>   
            <input type="text" name="txtCodigoPostal" id="txtCodigoPostal" placeholder="código postal" class="info_boxes">
            <label for="comentario" class="subtitle_input">OBSERVACIÓN</label>
            <textarea class="comentario" cols="10" rows="4"  name="comentario" id="comentario"></textarea>
            <label for="transporte" class="subtitle_input">TRANSPORTE</label>
            <input class="info_boxes" placeholder="Ingrese Transporte" name="transporte" id="transporte" type="text">
            <button id="btnModificar" name="btnModificar" class="send" type="submit">Guardar</button>
        </div>
        </div>   
    </form>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/listas_pedido.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/departamentos.js"></script>
    <script src="../js/clientesln.js"></script>
    <script src="../js/mapa_cliente.js"></script>
</body>

</html>