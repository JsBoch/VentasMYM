<?php
    $config = include("config.php");

    $host = $config->host;
    $database = $config->database;
    $username = $config->username;
    $password = $config->pass;
    $port = $config->port;
    
    $mysqli = new mysqli($host,$username,$password,$database,$port);
    
        if ($mysqli->connect_errno) {
            //TODO: ENVIAR EL RESULTADO DEL ERROR A DISCO O BASE DE DATOS.
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            //return $mysqli->connect_errno;
            
            return null;
        } 
        else
        {
            //return $mysqli->connect_errno;              
            return $mysqli;
        }
?>