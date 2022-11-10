<?php
session_start();
$config = include "config.php";

$host = $config->host;
$port = $config->port;
$database = '';
$username = '';
$password = '';

if (isset($_SESSION['sucursal'])) {
    $sucursal = $_SESSION['sucursal'];
    if (intval($sucursal) == 1) {
        $database = $config->database;
        $username = $config->username;
        $password = $config->pass;
    } else if (intval($sucursal) == 2) {
        $database = 'db_rmympt';
        $username = 'usr_speten';
        $password = 'P3t3nMym22*#';
    }
} else {
    $database = $config->database;
    $username = $config->username;
    $password = $config->pass;
}

$mysqli = new mysqli($host, $username, $password, $database, $port);

if ($mysqli->connect_errno) {
    //TODO: ENVIAR EL RESULTADO DEL ERROR A DISCO O BASE DE DATOS.
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    //return $mysqli->connect_errno;

    return null;
} else {
    //return $mysqli->connect_errno;
    // echo "ok connection";
    return $mysqli;
}
