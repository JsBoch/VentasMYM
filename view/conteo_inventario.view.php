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
    <link rel="stylesheet" href="../css/conteoInventario.css">
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="icon" href="../imgs/icono.png">
    <title>Conteo de Inventario</title>
</head>
<body onload="ListaIdentificadores()">
    <form class="contenedorPrincipal"  action="" method="post">
                    <!-- Boton para regresar al menu -->
                    <div class="above_all">
                <a href="../index.php">
                    <h3>Volver</h3>
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
            <!-- cliente -->
            <div class="encabezado">
            <h2 class="main_title">Conteo de Inventario</h2>
            </div>
            <div class="sub_contenedor">
            <label for="selectInventario" class="subtitle_input">SELECCIONE EL INVENTARIO A REALIZAR</label>
                <div class="select">
                <select name="selectInventario" id="selectInventario" class="selectors"></select>
                </div>
                <label for="selectUbicacion" class="subtitle_input">UBICACIÓN FÍSICA PARA EL CONTEO</label>
                <div class="select">
                <select name="selectUbicacion" id="selectUbicacion" class="selectors">
                    <option value="0">CENTRAL</option>
                    <option value="1">METATERMINAL</option>
                    <option value="2">BODEGUITAS</option>
                    <option value="3">PETEN</option>
                    <option value="4">XELA</option>
                </select>
                </div>
            </div>
            <div class="sub_contenedor_busqueda">
            <div class="encabezado">
            <h2 class="main_title">Buscar producto</h2>
            </div>
                <label for="txtCodigo" class="subtitle_input">CÓDIGO</label>
                <input id="txtCodigo" type="text" class="info_boxes" onchange="BuscarProductoContado()">
                <label for="txtDescripcion" class="subtitle_input">DESCRIPCIÓN</label>
                <textarea name="txtDescripcion" id="txtDescripcion" class="comentario" cols="30" rows="4"></textarea>
            </div>
            <div class="sub_contenedor_datos">
            <div class="grupo">
                    <div class="uno">
                    <label for="txtExistenciaActual" class="subtitle_input">EXISTENCIA ACTUAL</label>
                    <input type="number" name="txtExistenciaActual" id="txtExistenciaActual" class="info_boxes">
                    </div>
                    <div class="dos">
                    <label for="txtExistenciaFisica" class="subtitle_input">EXISTENCIA FÍSICA</label>
                    <input type="text" name="txtExistenciaFisica" id="txtExistenciaFisica" class="info_boxes" onchange="DiferenciaExistencia()">
                    </div>
                    <div class="tres">
                    <label for="txtDiferencia" class="subtitle_input">DIFERENCIA</label>
                    <input type="text" name="txtDiferencia" id="txtDiferencia" class="info_boxes">
                    </div>

                    <div class="indicaciones">
                        <div class="etiquetas" id="etiquetas">
                            <div class="menos">
                                <h3 class="opciones">MENOS</h3>
                            </div>
                            <div class="mas">
                               <h3 class="opciones">MÁS</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="txtIdProducto" id="txtIdProducto">
                <input type="hidden" name="txtCosto" id="txtCosto">
                <input type="hidden" name="txtPromedioPonderado" id="txtPromedioPonderado">
                <input type="hidden" name="txtUltimaCompra" id="txtUltimaCompra">
                <label for="txtObservaciones" class="subtitle_input">OBSERVACIONES</label>
                <textarea name="txtObservaciones" id="txtObservaciones" class="comentario" cols="30" rows="2"></textarea>
                <button type="button" class="btn_guardar" id="BttnGuardarConteo" onclick="GuardarRegistroConteo()">GUARDAR</button>
            </div>
    </form>
    <script src="../js/jquery-3.7.0.js" type="text/javascript"></script>
    <script src="../js/alertify.min.js" type="text/javascript"></script>
    <script src="../js/inventario_identificadores.js" type="text/javascript"></script>
</body>
</html>