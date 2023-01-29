<?php
    /**
 * Este archivo contine la configuración para la cadena de conexión a la base de datos.
 * Adicionalmente, contiene un parámetro que se puede utilizar para cargar información del 
 * lado del cliente en JavaScritp por medio de convertir un objeto a un archivo JSON.
 * por ejemplo, un archivo php que devuelve la informacion del parametro app_info:
 * <?php
 * $configs = include('config.php');
 * echo json_encode($configs->app_info);
 * ?>
 * 
 */
// return (object) array(
//     'host' => '18.117.25.54',
//     'username' => 'usr_mym',
//     'pass' => 'Mym*20#*81@_)',
//     'database' => 'db_rmym',
//     'port' => '3306',
//     'app_info' => array(
//         'appName'=>"DISTRIBUIDORAMYM",
//         'appURL'=> "http://yourURL/#/"
//     )
// );

return (object) array(
    'host' => '192.168.0.6',
    'username' => 'root',
    'pass' => 'My$qL2039*#@',
    'database' => 'db_rmym',
    'port' => '3306',
    'app_info' => array(
        'appName'=>"DISTRIBUIDORAMYM",
        'appURL'=> "http://yourURL/#/"
    )
);

?>