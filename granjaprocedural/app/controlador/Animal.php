<?php
class Animal extends ControladorPrincipal{
    public function __construct(){
        $this->modelo = $this->setModelo();
    }
    
    public function index(){
        define("NOMBRE_SITIO", "Granja");
        $this->setVista("inicio/inicio");
    }

    public function consultar_todos(){
        define("NOMBRE_SITIO", "Todos los animales");
        $this->setVista("consultar_todos/consultar_todos");
    }

    public function consultar_codigo(){
        define("NOMBRE_SITIO", "Animal por código");
        $this->setVista("consultar_codigo/consultar_codigo");
    }

    public function consultar_tipo(){
        define("NOMBRE_SITIO", "Animal por tipo");
        $this->setVista("consultar_tipo/consultar_tipo");
    }

    public function consultar_utilidad(){
        define("NOMBRE_SITIO", "Animal por utilidad");
        $this->setVista("consultar_utilidad/consultar_utilidad");
    }

    public function insertar(){
        define("NOMBRE_SITIO", "Insertar animal");
        $this->setVista("insertar/insertar");
    }

    public function modificar(){
        define("NOMBRE_SITIO", "Modificar animal");
        $this->setVista("modificar_codigo/modificar_codigo");
    }

    public function borrar(){
        define("NOMBRE_SITIO", "Eliminar animal");
        $this->setVista("borrar/borrar");
    }
}
?>