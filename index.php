<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mainStyles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Form</title>
</head>
<body>
    <form action="" id="customer_registration" class="form_box">
        <h2 class="main_title">Registro De Clientes</h2>
        <div class="sub_container">
        <input class="info_boxes" placeholder="Ingrese NIT" onblur="findValue()" type="text">
        <input class="info_boxes" placeholder="Ingrese DPI" type="text">
        <input class="info_boxes" placeholder="Ingrese Nombre" type="text">
        <input class="info_boxes" placeholder="Ingrese Razón Social" type="text">
        <select class="selectors" name="SD" id="depa" onchange="findValue()"></select>
        <select class="selectors" name="SM" id="municipio" form="customer_registration">
        </select>
        <input class="info_boxes" placeholder="Ingrese Dirección" type="text">
        <input class="info_boxes" placeholder="Ingrese Teléfono" type="number">
        <input class="info_boxes" placeholder="Ingrese@email.com" type="email">
        <input class="info_boxes" placeholder="Ingrese Region" type="text">
        <textarea class="comments" rows="10" cols="8">Escribe alguna observación... </textarea>
        <input style="width: auto;" class="info_boxes" placeholder="Ingrese Transporte" type="text">
        <input type="hidden" value="1" name="idEmpleado">
        <!-- <button class="send" type="submit">Enviar</button> -->
        <a href="#" class="send btn-neon">
        <span id="span1"></span>
        <span id="span2"></span>
        <span id="span3"></span>
        <span id="span4"></span>
        Enviar
     </a>
        </div>
    </form>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/departamentos.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</body>
</html>