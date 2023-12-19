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
    <link rel="icon" href="../imgs/icono.png">
    <title>Conteo de Inventario</title>
</head>
<body>
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
                <select name="selectInventario" id="selectInventario" class="selectors">
                    <option value="">1</option>
                    <option value="">1</option>
                    <option value="">1</option>
                </select>
                </div>
                <label for="selectUbicacion" class="subtitle_input">UBICACIÓN FÍSICA PARA EL CONTEO</label>
                <div class="select">
                <select name="selectUbicacion" id="selectUbicacion" class="selectors">
                    <option value="">1</option>
                    <option value="">1</option>
                    <option value="">1</option>
                </select>
                </div>
            </div>
            <div class="sub_contenedor_busqueda">
            <div class="encabezado">
            <h2 class="main_title">Buscar producto</h2>
            </div>
                <label for="txtCodigo" class="subtitle_input">CÓDIGO</label>
                <input id="txtCodigo" type="text" class="info_boxes">
                <label for="txtDescripcion" class="subtitle_input">DESCRIPCIÓN</label>
                <textarea name="txtDescripcion" id="txtDescripcion" class="comentario" cols="30" rows="4"></textarea>
            </div>
            <div class="sub_contenedor_datos">
            <div class="grupo">
                    <div class="uno">
                    <label for="descuento" class="subtitle_input">EXISTENCIA ACUTAL</label>
                    <input type="number" name="existencia" id="txtExistenciaActual" class="info_boxes">
                    </div>
                    <div class="dos">
                    <label for="descuento" class="subtitle_input">EXISTENCIA FÍSICA</label>
                    <input type="text" name="descuento" id="txtExistenciaFisica" class="info_boxes">
                    </div>
                    <div class="tres">
                    <label for="subtotal" class="subtitle_input">DIFERENCIA</label>
                    <input type="text" name="subtotal" id="txtDiferencia" class="info_boxes">
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
                <label for="txtObservaciones" class="subtitle_input">OBSERVACIONES</label>
                <textarea name="txtObservaciones" id="txtObservaciones" class="comentario" cols="30" rows="2"></textarea>
                <button class="btn_guardar" id="BttnGuardarConteo">GUARDAR</button>
            </div>
    </form>
</body>

</html>