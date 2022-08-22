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
    <title>ACCESO</title>
</head>
<body>
    <form action="data/login.php" method="post">
        <label for="user_name">Usuario</label>
        <input type="text" name="user_name" id="user_name">
        <label for="user_password">Clave</label>
        <input type="password" name="user_password" id="user_password">
        <input type="submit" value="ACEPTAR">
    </form>
</body>
</html>