<?php
// mapear la url
class Core{
    protected $controlador = "Inicio";
    protected $metodo = "index";
    protected $parametros;
    public function __construct(){
        if(isset($_GET["url"])){
            //echo $_GET["url"]; // public/.htaccess
            $url = rtrim($_GET["url"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            //print_r($url);
            // ****************************************** CONTROLADOR ************************************
            if(file_exists(RUTA_APP . "/controlador/" . ucwords(strtolower($url[0])) . ".php")){
                $this->controlador = ucwords(strtolower($url[0]));
            }
            unset($url[0]);
        }
        require_once(RUTA_APP . "/controlador/" . $this->controlador . ".php");
        //echo RUTA_APP . "/controlador/" . $this->controlador; 
        $this->controlador = new $this->controlador; // instancio el controlador
        // ************************************************ METODO ****************************************
        if(isset($url[1])){
            //print_r($url);
            if(method_exists($this->controlador, $url[1])){
                $this->metodo = $url[1];
            }
            unset($url[1]);
        }
        // ******************************************** PARAMETROS ****************************************
        $this->parametros = isset($url) ? array_values($url) : []; // lo que quede de la url
        //print_r($this->parametros);
        call_user_func_array(array($this->controlador, $this->metodo), array($this->parametros));
    }
}
?>