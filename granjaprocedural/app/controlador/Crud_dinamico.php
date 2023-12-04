<?php
class Crud_dinamico extends ControladorPrincipal{
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
            <th></th>
            <th class="text-center">Animal</th>
            <th class="text-center">Dieta</th>
            <th class="text-center">Fecha inicio</th>
            <th class="text-center">Resultado</th>
         </tr>
    </thead>
         <tr>
            <td></td>
            <td><select name="animales" id="animales">
            <?php foreach($this->modelo->listarTodos() as $r): ?>
                    <option value="<?php echo $r['cod_animal']; ?>"><?php echo $r['tipo_animal']; ?></option>
            <?php endforeach; ?>
                </select>
            </td>
            <td><select name="dietas" id="dietas">
            <?php foreach($this->modelo->listarDietas() as $r): ?>
                    <option value="<?php echo $r['cod_dieta']; ?>"><?php echo $r['finalidad']; ?></option>
            <?php endforeach; ?>
                </select>
            </td>
            <td><input class="text-center" id="fechaini" name='fechaini' type="date" style="width:170px" required></td>
            <td><input class="text-center" id="resultado" name='resultado' type="text" style="width:200px"></td>
            <input class="d-none" type='submit' name='enviar' value='Insertar/Actualizar'/>
          </tr> 
    <?php
      foreach($this->modelo->listarDietaAnimal() as $r):
    ?>            
          <tr>
              <td class="text-center text-nowrap">
                <button type="button" class="eliminar btn-xs btn-danger">
                    <i class="far fa-trash-alt"></i>
                </button>
                <button type="button" class="editar btn-xs btn-info">
                    <i class="far fa-edit"></i>
                </button>
              </td>
              <td class="oculto"><?php echo $r['cod_animal']; ?></td>
              <td class="text-center"><?php echo $r['tipo_animal']; ?></td>
              <td class="oculto"><?php echo $r['cod_dieta']; ?></td>
              <td class="text-center"><?php echo $r['finalidad']; ?></td>
              <td class="text-center"><?php echo $r['fecha_inicio']; ?></td>
              <td class="text-center"><?php echo $r['od_resultado']; ?></td>
          </tr>       
    <?php  
      endforeach; 
    }

    public function eliminarAnimalDieta(){
        if(!$_POST["animal"] == '' && !$_POST["fechaini"] == ''){
            $fechaini = filter_input(INPUT_POST, 'fechaini', FILTER_SANITIZE_STRING);
            if(strtotime($fechaini) !== false) {
                $fechaini = date('Y-m-d',strtotime($fechaini));
                $animal = $this->test_input($_POST["animal"]);
                if (filter_var($animal, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range"=> 9999]])) {
                    if($this->modelo->existeAnimalDieta($animal, $fechaini)){
                        $this->modelo->eliminarAnimalDieta($animal, $fechaini);
                    }
                }
            }
        }
    }

    private function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function submit(){
        // si los parámetros animales y dietas no están vacíos
        if(!$_POST["animales"] == '' && !$_POST["dietas"] == '' && !$_POST["fechaini"] == ''){
            $fechaini = filter_input(INPUT_POST, 'fechaini', FILTER_SANITIZE_STRING);
            // si la fecha tiene formato fecha
            if(strtotime($fechaini) !== false) {
                $fechaini = date('Y-m-d',strtotime($fechaini));
                $animales = $this->test_input($_POST["animales"]);
                $dietas = $this->test_input($_POST["dietas"]);
                // si el animal y la dieta son un número entero entre 1 y 9999
                if (filter_var($animales, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range"=> 9999]]) !== false && filter_var($dietas, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range"=> 9999]]) !== false) {
                    $resultado = $this->test_input($_POST["resultado"]);
                    // si existe el animal y existe la dieta
                    if($this->modelo->existeAnimal($animales) && $this->modelo->existeDieta($dietas)){
                        // si existe la dieta_animal_fechainicio actualizamos, sino insertamos
                        if($this->modelo->existeAnimalDieta($animales, $fechaini)){
                            $this->modelo->updateAnimalDieta($animales, $dietas, $fechaini, $resultado);
                        }
                        else{
                            $this->modelo->insertarAnimalDieta($animales, $dietas, $fechaini, $resultado);
                        }
                    }
                }
            }
        }
    }    
}
?>