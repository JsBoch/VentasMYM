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
    <link rel="stylesheet" href="css/loginStyles.css">
    <title>ACCESO</title>
</head>
<body>
    <form action="login.php" method="post" class="login_form">
        <h2 class="title_login">Iniciar Sesión</h2>
        <input type="text" name="user_name" class="inputs_login" id="user_name" placeholder="Usuario...">
        <input type="password" name="user_password" class="inputs_login" id="user_password" placeholder="Clave...">
        <button type="submit" class="log_in">Ingresar</button>
    </form>
</body>
</html>