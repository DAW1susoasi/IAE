<?php
class Borrar_dinamico extends ControladorPrincipal{
    //private $modelo;
    public function __construct(){
        $this->modelo = $this->setModelo();
        if(isset($_POST["function"])){
            $function = $_POST["function"];
            $this->$function();
        }
    }
    
    public function index(){
    }
    
    public function get(){
        ?>
        <thead class="thead-dark">
            <tr>
                <th class="text-center text-nowrap">Código</th>
                <th class="text-center text-nowrap">Fecha nacimiento</th>
                <th class="text-center text-nowrap">Peso</th>
                <th class="text-center text-nowrap">Tipo</th>
                <th class="text-center text-nowrap">Utilidad</th>
                <th class="text-center text-nowrap">Producción</th>
                <th class="text-center text-nowrap">Descripción</th>       
            </tr>
        </thead>
             <tr>
                <td><input class="text-center" id="id" name='id' type='number' style="width:125px"/></td>
                <td><input class="text-center" id="fecha" name='fecha' type='date' style="width:196px"/></td>
                <td><input class="text-center" id="peso" name='peso' type='number' style="width:121px"/></td>
                <td><input class="text-center" id="tipo" name='tipo' type='text' style="width:146px"/></td>
                <td><input class="text-center" id="utilidad" name='utilidad' type='text' style="width:146px"/></td>
                <td><input class="text-center" id="produccion" name='produccion' type='text' style="width:146px"/></td>
                <td><input class="text-center" id="descripcion" name='descripcion' type='text' style="width:196px"/></td>
                <input class="d-none" type='submit' name='enviar' value='Insertar/Actualizar'/>
              </tr> 
        <?php
    }

    public function submit(){
        //if(isset($_POST["id"], $_POST["fecha"], $_POST["peso"], $_POST["tipo"], $_POST["utilidad"] , $_POST["produccion"], $_POST["descripcion"])){
            $id = trim(htmlentities($_POST["id"]));
            //$fecha = trim(htmlentities($_POST["fecha"]));
            //$peso = trim(htmlentities($_POST["peso"]));
            //$tipo = trim(htmlentities($_POST["tipo"]));
            //$utilidad = trim(htmlentities($_POST["utilidad"]));
            //$produccion = trim(htmlentities($_POST["produccion"]));
            //$descripcion = trim(htmlentities($_POST["descripcion"]));
            //$this->modelo->eliminar($id, $fecha, $peso, $tipo, $utilidad, $produccion, $descripcion);
            $this->modelo->eliminar($id);
        //}
    }    
}
?>