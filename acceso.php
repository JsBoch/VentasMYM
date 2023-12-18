<?php 
session_start();
    $_SESSION['estado'] = 'desconectado';    
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/loginStyles.css">
    <link rel="icon" href="imgs/icono.png">
    <title>Inicio de Sesión</title>
</head>
<body>
<div class="contenedor">
    <form action="login.php" method="post" class="login_form">
    <div class="logo">
            <img src="imgs/logo.PNG" alt="">
        </div>
        <div class="ctntIcono">
        <input type="text" name="user_name" class="inputs_login" id="user_name" placeholder="Usuario...">
        <span class="icono">
        <i class='bx bxs-user' ></i>
        </span>
        </div>
        <div class="ctntIcono">
        <input type="password" name="user_password" class="inputs_login" id="user_password" placeholder="Clave...">
       <span class="icono">
       <i class='bx bxs-key'></i>  
       </span>
         </div>
        <button type="submit" class="log_in">INGRESAR</button>
    </form>
    </div>
</body>
</html>