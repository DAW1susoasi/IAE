<?php
// ruta de la aplicación
define("RUTA_APP", dirname(__FILE__));
// ruta url
define("RUTA_URL", "http://localhost/granja");
//define("RUTA_URL", "https://cobro.herokuapp.com");

// conexion bbdd

define("CONEXION", array(
    "host" => "mysql:host=localhost;dbname=dietaganadera",
    "user" => "root",
    "password" => ""
));

/*
define("CONEXION", array(
    "host" => "mysql:host=remotemysql.com;dbname=rdh1krbW1e",
    "user" => "rdh1krbW1e",
    "password" => "mdKXv9ZrfP"
));
*/
// autocarga de archivos
spl_autoload_register(function($nombreClase){
    require_once("librerias/" . $nombreClase . ".php");
});
/*
require_once("librerias/ControladorPrincipal.php");
require_once("librerias/Core.php");
*/
?>