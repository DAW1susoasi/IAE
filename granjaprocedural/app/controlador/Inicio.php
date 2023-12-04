<?php
class Inicio extends ControladorPrincipal{

    public function __construct(){
        $this->modelo = $this->setModelo();
    }
    
    public function index(){
        define("NOMBRE_SITIO", "Granja");
        $this->setVista("inicio/inicio");
    }
}
?>