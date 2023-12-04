<?php
class Dietaanimal extends ControladorPrincipal{
    public function __construct(){
        $this->modelo = $this->setModelo();
    }
    
    public function index(){
        define("NOMBRE_SITIO", "Granja");
        $this->setVista("inicio/inicio");
    }

    public function crud(){
        define("NOMBRE_SITIO", "CRUD Dieta animal");
        $this->setVista("crud/crud");
    }
}
?>