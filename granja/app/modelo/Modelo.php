<?php
class Modelo{
    public function conectar(){
      try{       
        $pdo = new PDO(CONEXION["host"], CONEXION["user"], CONEXION["password"]);
	      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET CHARACTER SET UTF8");
	      return($pdo);
      }catch(PDOException $e){    
	      error_log("Error al conectar con la base de datos: " . $e->getMessage());
        exit();
      }
    }

    public function listarDietaAnimal(){
      $con = $this->conectar();
      try{
        $sql = "SELECT a.cod_animal, a.tipo_animal, d.cod_dieta, d.finalidad, da.fecha_inicio, da.od_resultado 
        FROM dieta_animal_fechainicio AS da 
        JOIN animal AS a ON da.cod_animal = a.cod_animal 
        JOIN dieta AS d ON da.cod_dieta = d.cod_dieta
		ORDER BY da.fecha_inicio";
        $stm = $con->prepare($sql);
        $stm->execute();
        $r = $stm->fetchall(PDO::FETCH_OBJ);
        
        $stm->closeCursor();
        return $r;
      }catch(PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function listarTodos(){
      $con = $this->conectar();
      try{
        $sql = "SELECT * FROM animal";
        $stm = $con->prepare($sql);
        $stm->execute();
        $r = $stm->fetchall(PDO::FETCH_OBJ);
        
        $stm->closeCursor();
        return $r;
      }catch(PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function listarDietas(){
      $con = $this->conectar();
      try{
        $sql = "SELECT * FROM dieta";
        $stm = $con->prepare($sql);
        $stm->execute();
        $r = $stm->fetchall(PDO::FETCH_OBJ);
        
        $stm->closeCursor();
        return $r;
      }catch(PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }
    
    public function listarCodigo($codigo){
        $con = $this->conectar();
        try{
          $stm = $con->prepare("SELECT * FROM animal WHERE cod_animal = ?");
          $stm->execute(array($codigo));
          $r = $stm->fetch(PDO::FETCH_OBJ);
          $stm->closeCursor();
          return $r;
        }catch (PDOException $e){
          echo("Error en la consulta: " . $e->getMessage());
        }finally{
          $con = NULL;		
        }
    }

    public function listarTipo($tipo){
      $con = $this->conectar();
      try{
        $stm = $con->prepare("SELECT * FROM animal WHERE tipo_animal LIKE ?");
        $stm->execute(array("%$tipo%"));
        $r = $stm->fetchall(PDO::FETCH_OBJ);
        $stm->closeCursor();
        return $r;
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function listarUtilidad($utilidad){
      $con = $this->conectar();
      try{
        $stm = $con->prepare("SELECT * FROM animal WHERE utilidad_animal LIKE ?");
        $stm->execute(array("%$utilidad%"));
        $r = $stm->fetchall(PDO::FETCH_OBJ);
        $stm->closeCursor();
        return $r;
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function insertar($fecha, $peso, $tipo, $utilidad, $produccion, $descripcion){
      $con = $this->conectar();
      try{
        $sql_cod = "SELECT MAX(cod_animal) as max_codigo FROM animal";
        $stm_cod = $con->prepare($sql_cod);
        $stm_cod->execute();
        $codigo = $stm_cod->fetch(PDO::FETCH_OBJ)->max_codigo + 1;
        $sql = "INSERT INTO animal (cod_animal, f_nacimiento, peso, tipo_animal, utilidad_animal, produccion_animal, od_animal) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stm = $con->prepare($sql);
        $stm->execute(array($codigo, $fecha, $peso, $tipo, $utilidad, $produccion, $descripcion));
        $stm->closeCursor();
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function update($id, $tipo, $peso, $fecha, $utilidad, $produccion, $descripcion){
      $con = $this->conectar();
      try{
        $sql = "UPDATE animal SET tipo_animal = ?,
                                   peso = ?,
                                   f_nacimiento = ?,
                                   utilidad_animal = ?,
                                   produccion_animal = ?,
                                   od_animal = ?
                                   WHERE cod_animal = ?";
         $stm = $con->prepare($sql);
         $stm->execute(array($tipo, $peso, $fecha, $utilidad, $produccion, $descripcion, $id));
         $stm->closeCursor();
       }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
       }finally{
        $con = NULL;		
       }
    }

    public function updateAnimalDieta($animal, $dieta, $fecha, $resultado){
      $con = $this->conectar();
      try{
        $sql = "UPDATE dieta_animal_fechainicio SET cod_dieta = ?,
                                                    od_resultado = ?
                                   WHERE cod_animal = ?
                                   AND fecha_inicio = ?";
         $stm = $con->prepare($sql);
         $stm->execute(array($dieta, $resultado, $animal, $fecha));
         $stm->closeCursor();
       }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
       }finally{
        $con = NULL;		
       }
    }

    public function existeAnimal($id){
      $con = $this->conectar();
      try{
        $sql = "SELECT cod_animal FROM animal where cod_animal = ?";
        $stm = $con->prepare($sql);
        $stm->execute(array($id));
        $r = $stm->rowcount();
        $stm->closeCursor();
        return $r;
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function existeDieta($id){
      $con = $this->conectar();
      try{
        $sql = "SELECT cod_dieta FROM dieta where cod_dieta = ?";
        $stm = $con->prepare($sql);
        $stm->execute(array($id));
        $r = $stm->rowcount();
        $stm->closeCursor();
        return $r;
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function existeAnimalDieta($animal, $fecha){
      $con = $this->conectar();
      try{
        $sql = "SELECT cod_animal, fecha_inicio FROM dieta_animal_fechainicio
          WHERE cod_animal = ? AND fecha_inicio = ?";
        $stm = $con->prepare($sql);
        $stm->execute(array($animal, $fecha));
        $r = $stm->rowcount();
        $stm->closeCursor();
        return $r;
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function eliminarAnimalDieta($animal, $fecha){
      $con = $this->conectar();
      try{
        $stm = $con->prepare("DELETE FROM dieta_animal_fechainicio WHERE cod_animal = ? AND fecha_inicio = ?");
        $stm->execute(array($animal, $fecha));
        $stm->closeCursor();
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function insertarAnimalDieta($animal, $dieta, $fecha, $resultado){
      $con = $this->conectar();
      try{
        $sql = "INSERT INTO dieta_animal_fechainicio (cod_animal, cod_dieta, fecha_inicio, od_resultado) VALUES (?, ?, ?, ?)";
        $stm = $con->prepare($sql);
        $stm->execute(array($animal, $dieta, $fecha, $resultado));
        $stm->closeCursor();
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }

    public function eliminar($id){
      $con = $this->conectar();
      try{
        $stm = $con->prepare("DELETE FROM animal WHERE cod_animal = ?");
        $stm->execute(array($id));
        $stm->closeCursor();
      }catch (PDOException $e){
        echo("Error en la consulta: " . $e->getMessage());
      }finally{
        $con = NULL;		
      }
    }
}
?>