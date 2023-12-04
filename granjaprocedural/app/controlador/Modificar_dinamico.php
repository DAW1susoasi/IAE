<?php
class Modificar_dinamico extends ControladorPrincipal{
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
                <th class="text-center text-nowrap" style="width:196px">Fecha nacimiento</th>
                <th class="text-center text-nowrap" style="width:121px">Peso</th>
                <th class="text-center text-nowrap" style="width:146px">Tipo</th>
                <th class="text-center text-nowrap" style="width:146px">Utilidad</th>
                <th class="text-center text-nowrap" style="width:146px">Producción</th>
                <th class="text-center text-nowrap" style="width:221px">Descripción</th>       
            </tr>
        </thead>
             <tr>
                <td><input class="text-center" id="id" name='id' type='number' style="width:125px" required/></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <input class="d-none" type='submit' name='enviar' value='Insertar/Actualizar'/>
              </tr> 
    <?php
    }

    public function submit(){

      if(isset($_POST["id"])){
        //print_r($this->modelo->existeAnimal($_POST["id"]));
        if($this->modelo->existeAnimal($_POST["id"]) === 0){
          echo 0;
        }
        else
        {
          $r = $this->modelo->listarCodigo($_POST["id"]);
          
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
           <tbody>
              <tr>
                <td><input class="text-center" id="id" name='id' type='number' style="width:125px" value="<?php echo $r['cod_animal']; ?>" disabled/></td>
                <td><input class="text-center" id="fecha" name='fecha' type='date' style="width:175px" value="<?php echo $r['f_nacimiento']; ?>" required/></td>
                <td><input class="text-center" id="peso" name='peso' type='number' style="width:100px" value="<?php echo $r['peso']; ?>" required/></td>
                <td><input class="text-center" id="tipo" name='tipo' type='text' style="width:125px" value="<?php echo $r['tipo_animal']; ?>" required/></td>
                <td><input class="text-center" id="utilidad" name='utilidad' type='text' style="width:125px" value="<?php echo $r['utilidad_animal']; ?>"/></td>
                <td><input class="text-center" id="produccion" name='produccion' type='text' style="width:125px" value="<?php echo $r['produccion_animal']; ?>"/></td>
                <td><input class="text-center" id="descripcion" name='descripcion' type='text' style="width:200px" value="<?php echo $r['od_animal']; ?>"/></td>
                <input class="d-none" type='submit' name='enviar' value='Insertar/Actualizar'/>
              </tr>   
          </tbody>
        <?php
        }
        //else{
        //  $this->get();
        //}
      } 
    }
    
    public function submit2(){
      if(isset($_POST["id"], $_POST["fecha"], $_POST["peso"], $_POST["tipo"])){
        $id = trim(htmlentities($_POST["id"]));
        $fecha = trim(htmlentities($_POST["fecha"]));
        $peso = trim(htmlentities($_POST["peso"]));
        $tipo = trim(htmlentities($_POST["tipo"]));
        $utilidad = trim(htmlentities($_POST["utilidad"]));
        $produccion = trim(htmlentities($_POST["produccion"]));
        $descripcion = trim(htmlentities($_POST["descripcion"]));
        $this->modelo->update($id, $tipo, $peso, $fecha, $utilidad, $produccion, $descripcion);
      }
    }
}
?>