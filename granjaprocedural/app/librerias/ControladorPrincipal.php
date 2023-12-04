<?php
class ControladorPrincipal{
    public $modelo;
    public function setModelo(){
        require_once(RUTA_APP . "/modelo/Modelo2.php");
        return new Modelo2;
    }
    public function setVista($vista){
        //echo $vista;
        require_once(RUTA_APP . "/vista/" . $vista . ".php");
    }
}
?>