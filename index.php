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
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/menuStyles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <link rel="icon" href="imgs/icono.png">
    <title>Menu</title>
</head>

<body>
<!-- <div class="btn">
         <span class="fas fa-bars"></span>
      </div> -->
      <nav class="sidebar">
      <div class="logo">
          <img src="imgs/icono.PNG" alt="">
        </div>
         <ul>
            <li>
               <a href="#" class="feat-btn">Clientes
               <span class="fas fa-caret-down first"></span>
               </a>
               <ul class="feat-show">
                  <li><a href="view/mostrar_ubicacion_cliente.view.php">Consultar</a></li>
                  <li><a href="view/consulta_estadocuenta.view.php">Estado de Cuenta</a></li>
                  <li><a href="view/consulta_ventasmes.view.php">Venta por mes</a></li>
                  <li><a href="view/consulta_cobro_mes.view.php">Cobro por mes</a></li>
               </ul>
            </li>
            <li>
               <a href="#" class="serv-btn">Registro de pedidos
               <span class="fas fa-caret-down second"></span>
               </a>
               <ul class="serv-show">
                  <li><a href="view/registro_pedido.view.php">Registrar</a></li>
                  <li><a href="view/consulta_pedido.view.php">Consultar</a></li>
               </ul>
            </li>
            <li>
               <a href="#" class="third-btn">Registro de recibos
               <span class="fas fa-caret-down third"></span>
               </a>
               <ul class="third-show">
                  <li><a href="view/registro_recibo.view.php">Registrar</a></li>           
                  <li><a href="view/consulta_recibo.view.php">Consultar</a></li>            
               </ul>
            </li>
            <li>
               <a href="#" class="four-btn">Inventario
               <span class="fas fa-caret-down four"></span>
               </a>
               <ul class="four-show">
                  <li><a href="view/conteo_inventario.view.php">Conteo</a></li>               
               </ul>
            </li>
         </ul>
      <div class="return">
        <a href="login.php">
          Cerrar Sesión <i class='bx bx-log-out'></i>
        </a>
      </div>
      </nav>

      <script>
        //  $('.btn').click(function(){
        //    $(this).toggleClass("click");
        //    $('.sidebar').toggleClass("show");
        //  });
           $('.feat-btn').click(function(){
             $('nav ul .feat-show').toggleClass("show");
             $('nav ul .first').toggleClass("rotate");
           });
           $('.serv-btn').click(function(){
             $('nav ul .serv-show').toggleClass("show1");
             $('nav ul .second').toggleClass("rotate");
           });
           $('.third-btn').click(function(){
             $('nav ul .third-show').toggleClass("show2");
             $('nav ul .third').toggleClass("rotate");
           });
           $('.four-btn').click(function(){
             $('nav ul .four-show').toggleClass("show3");
             $('nav ul .four').toggleClass("rotate");
           });
           $('nav ul li').click(function(){
             $(this).addClass("active").siblings().removeClass("active");
           });
      </script>      
</body>

</html>