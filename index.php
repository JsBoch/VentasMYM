<?php 
session_start();
    if (!isset($_SESSION['estado']) || $_SESSION['estado'] != "conectado") {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU</title>
</head>
<body>
    <h1>MENU</h1>
    <ol>
        <li><a href="view/registro_cliente.view.php">Registro de clientes</a></li>        
        <li><a href="login.php">Salir</a></li>        
    </ol>       
</body>
</html>