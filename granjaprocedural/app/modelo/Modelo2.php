<?php
class Modelo2{
    public function conectar(){
        $mysqli =  mysqli_connect(CONEXION["host"], CONEXION["user"], CONEXION["password"], CONEXION["db"]);
        if(!$mysqli){
          die("Error al conectar con la base de datos: " . mysqli_connect_error());
        }
        mysqli_set_charset($mysqli, "utf8");
	      return($mysqli);
    }

    public function listarDietaAnimal(){
      $con = $this->conectar();
      try {
        $sql = "SELECT a.cod_animal, a.tipo_animal, d.cod_dieta, d.finalidad, da.fecha_inicio, da.od_resultado 
        FROM dieta_animal_fechainicio AS da 
        JOIN animal AS a ON da.cod_animal = a.cod_animal 
        JOIN dieta AS d ON da.cod_dieta = d.cod_dieta
        ORDER BY da.fecha_inicio";
        $result = mysqli_query($con, $sql);
        $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }
    
    public function listarTodos(){
      $con = $this->conectar();
      try {
        $sql = "SELECT * FROM animal";
        $result = mysqli_query($con, $sql);
        $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function listarDietas(){
      $con = $this->conectar();
      try {
        $sql = "SELECT * FROM dieta";
        $result = mysqli_query($con, $sql);
        $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }
    
    public function listarCodigo($codigo){
        $con = $this->conectar();
        try {
          $sql = "SELECT * FROM animal WHERE cod_animal = ?";
          $stm = mysqli_prepare($con, $sql);
          mysqli_stmt_bind_param($stm, "i", $codigo);
          mysqli_stmt_execute($stm);
          $result = mysqli_stmt_get_result($stm);
          $r = mysqli_fetch_object($result);
          mysqli_free_result($result);
          return $r;
        } catch (Exception $e) {
            echo("Error en la consulta: " . $e->getMessage());
        } finally {
            mysqli_close($con);
        }
    }

    public function listarTipo($tipo){
      $con = $this->conectar();
      try {
        $sql = "SELECT * FROM animal WHERE tipo_animal LIKE ?";
        $stm = mysqli_prepare($con, $sql);
        $param = "%$tipo%";
        mysqli_stmt_bind_param($stm, "s", $param);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function listarUtilidad($utilidad){
      $con = $this->conectar();
      try {
        $sql = "SELECT * FROM animal WHERE utilidad_animal LIKE ?";
        $stm = mysqli_prepare($con, $sql);
        $param = "%$utilidad%";
        mysqli_stmt_bind_param($stm, "s", $param);
        mysqli_stmt_execute($stm);
        $result = mysqli_stmt_get_result($stm);
        $r = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function insertar($fecha, $peso, $tipo, $utilidad, $produccion, $descripcion){
      $con = $this->conectar();
      try {
        // Obtener el máximo código de animal
        $sql_cod = "SELECT MAX(cod_animal) as max_codigo FROM animal";
        $result_cod = mysqli_query($con, $sql_cod);
        $row = mysqli_fetch_assoc($result_cod);
        $codigo = $row['max_codigo'] + 1;
        // Preparar y ejecutar la inserción
        $sql = "INSERT INTO animal (cod_animal, f_nacimiento, peso, tipo_animal, utilidad_animal, produccion_animal, od_animal) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "issssss", $codigo, $fecha, $peso, $tipo, $utilidad, $produccion, $descripcion);
        mysqli_stmt_execute($stm);
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function update($id, $tipo, $peso, $fecha, $utilidad, $produccion, $descripcion){
      $con = $this->conectar();
      try {
        $sql = "UPDATE animal SET tipo_animal = ?,
                                   peso = ?,
                                   f_nacimiento = ?,
                                   utilidad_animal = ?,
                                   produccion_animal = ?,
                                   od_animal = ?
                                   WHERE cod_animal = ?";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "ssssssi", $tipo, $peso, $fecha, $utilidad, $produccion, $descripcion, $id);
        mysqli_stmt_execute($stm);
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function updateAnimalDieta($animal, $dieta, $fecha, $resultado){
      $con = $this->conectar();
      try {
        $sql = "UPDATE dieta_animal_fechainicio SET cod_dieta = ?,
                                                    od_resultado = ?
                                   WHERE cod_animal = ?
                                   AND fecha_inicio = ?";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "isis", $dieta, $resultado, $animal, $fecha);
        mysqli_stmt_execute($stm);
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function existeAnimal($id){
      $con = $this->conectar();
      try {
        $sql = "SELECT cod_animal FROM animal WHERE cod_animal = ?";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "i", $id);
        mysqli_stmt_execute($stm);
        mysqli_stmt_store_result($stm);
        $r = mysqli_stmt_num_rows($stm);
        mysqli_stmt_close($stm);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function existeDieta($id){
      $con = $this->conectar();
      try {
        $sql = "SELECT cod_dieta FROM dieta WHERE cod_dieta = ?";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "i", $id);
        mysqli_stmt_execute($stm);
        mysqli_stmt_store_result($stm);
        $r = mysqli_stmt_num_rows($stm);
        mysqli_stmt_close($stm);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function existeAnimalDieta($animal, $fecha){
      $con = $this->conectar();
      try {
        $sql = "SELECT cod_animal, fecha_inicio FROM dieta_animal_fechainicio WHERE cod_animal = ? AND fecha_inicio = ?";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "is", $animal, $fecha);
        mysqli_stmt_execute($stm);
        mysqli_stmt_store_result($stm);
        $r = mysqli_stmt_num_rows($stm);
        mysqli_stmt_close($stm);
        return $r;
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function eliminarAnimalDieta($animal, $fecha){
      $con = $this->conectar();
      try {
        $sql = "DELETE FROM dieta_animal_fechainicio WHERE cod_animal = ? AND fecha_inicio = ?";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "is", $animal, $fecha);
        mysqli_stmt_execute($stm);
        mysqli_stmt_close($stm);
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function insertarAnimalDieta($animal, $dieta, $fecha, $resultado){
      $con = $this->conectar();
      try {
        $sql = "INSERT INTO dieta_animal_fechainicio (cod_animal, cod_dieta, fecha_inicio, od_resultado) VALUES (?, ?, ?, ?)";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "iiss", $animal, $dieta, $fecha, $resultado);
        mysqli_stmt_execute($stm);
        mysqli_stmt_close($stm);
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }

    public function eliminar($id){
      $con = $this->conectar();
      try {
        $sql = "DELETE FROM animal WHERE cod_animal = ?";
        $stm = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stm, "i", $id);
        mysqli_stmt_execute($stm);
        mysqli_stmt_close($stm);
      } catch (Exception $e) {
          echo("Error en la consulta: " . $e->getMessage());
      } finally {
          mysqli_close($con);
      }
    }
}
?>