<?php
class Todos_dinamico extends ControladorPrincipal{
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
                <th class="text-center text-nowrap" style="width:146px">Código</th>
                <th class="text-center text-nowrap" style="width:196px">Fecha nacimiento</th>
                <th class="text-center text-nowrap" style="width:121px">Peso</th>
                <th class="text-center text-nowrap" style="width:125px">Tipo</th>
                <th class="text-center text-nowrap" style="width:146px">Utilidad</th>
                <th class="text-center text-nowrap" style="width:146px">Producción</th>
                <th class="text-center text-nowrap" style="width:221px">Descripción</th>       
            </tr>
        </thead>
            <?php
            foreach($this->modelo->listarTodos() as $r):
            ?>            
            <tr>
                <td class="text-center"><?php echo $r->cod_animal; ?></td>
                <td class="text-center"><?php echo $r->f_nacimiento; ?></td>
                <td class="text-center"><?php echo $r->peso; ?></td>
                <td class="text-center"><?php echo $r->tipo_animal; ?></td>
                <td class="text-center"><?php echo $r->utilidad_animal; ?></td>
                <td class="text-center"><?php echo $r->produccion_animal; ?></td>
                <td class="text-center"><?php echo $r->od_animal; ?></td>
            </tr>       
            <?php  
            endforeach; 
    } 
}
?>