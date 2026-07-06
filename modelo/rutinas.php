<?php
require_once('modelo/datos.php');

class rutinas extends datos {
    private $idRutina, $nombreRutina, $idEmpleado;

    // setters
    function set_idRutina($v) { $this->idRutina = $v; }
    function set_nombreRutina($v) { $this->nombreRutina = $v; }
    function set_idEpleado($v) { $this->idEpleado = $v; }

    // getters
    function get_idRutina(){ return $this->idRutina; }
    function get_nombreRutina(){ return $this->nombreRutina; }
    function get_idEpleado(){ return $this->idEpleado; }

   function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if(!$this->existe($this->idRutina)){
            try{
                $inc = $co->prepare("INSERT INTO rutina(id_rutina, nombre, id_empleado)
                VALUES (:id_rutina, :nombre, :id_empleado");

                $inc->bindParam(':id_rutina', $this->idRutina);
                $inc->bindParam(':nombre', $this->nombreRutina);
                $inc->bindParam(':id_empleado', $this->idEpleado);
                $inc->execute();

                $r['resultado'] = 'incluir';
                $r['mensaje'] = 'Rutina Asignada';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Esta rutina ya está asignada';
        }
        return $r;
    }

     function modificar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->idRutina)){
            try{
                $mod = $co->prepare("UPDATE rutina
                    SET id_rutina = :id_rutina, nombre = :nombre, id_empleado = :id_empleado
                    WHERE id_rutina = :id_rutina");

                $mod->bindParam(':id_rutina', $this->idRutina);
                $mod->bindParam(':nombre', $this->nombreRutina);
                $mod->bindParam(':id_empleado', $this->idEpleado);
                $mod->execute();
                
                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Rutina Modificada';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        }
        return $r;
    }

     function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->idRutina)){
            try{
                $eli = $co->prepare("UPDATE rutina SET estado = 0 WHERE id_rutina = :idRutina");

                $eli->bindParam(':idRutina', $this->idRutina);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Rutina Eliminada';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } 
        return $r;
    }
   function consultar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $resultado = $co->query("SELECT * FROM rutina WHERE estado = 1");
            if($resultado){
                $respuesta = '';
                foreach($resultado as $fila){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td style='display:none'>" . $fila['id_rutina'] . "</td>";
                    $respuesta .= "<td>" . $fila['nombre'] . "</td>";
                    $respuesta .= "<td style='display:none'>" . $fila['id_empleado'] . "</td>";
                   // $respuesta .= "<td>" . $fila['contrasena'] . "</td>";
                    $respuesta .= "<td>";
                        $respuesta .= "<div class='d-flex justify-content-center'>";
                        $respuesta .= "<button type='button' class='btn btn-dark text-white w-80 small-width m-1' onclick='pone(this)'><i class='bi bi-pencil-square'></i></button>";
                        $respuesta .= "<button type='button' class='btn btn-danger w-80 small-width m-1' onclick='eliminar(this)'><i class='bi bi-trash'></i></button>";
                    $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }

                if($respuesta == ""){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td colspan = '5' class='text-center text-muted py-4>'";
                    $respuesta .= "<span><i class='bi bi-person-fill fs-1' style='color: #17120b'></i></span>";
                    $respuesta .= "<h5 class= 'text-dashboard'> No hay rutinas asignadas </h5>";
                    $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }

                $r['resultado'] = 'consultar';
                $r['mensaje'] = $respuesta;
            } else {
                $r['resultado'] = 'consultar';
                $r['mensaje'] = '';
            }
        } catch(Exception $e){
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function existe($id_rutina){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM rutina WHERE id_rutina = :id_rutina AND estado = 1");
            $resultado->bindParam(':id_rutina', $id_rutina);
            $resultado->execute();
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            if($fila){
                return true;
            } else{
                return false;
            }
        } catch(Exception $e){
            return false;
        }
    }
 
}
?>