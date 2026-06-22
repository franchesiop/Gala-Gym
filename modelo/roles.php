<?php
require_once('modelo/datos.php');

class roles extends datos {
    private $nombreRol, $descripcion, $idRol;

    // setters
    function set_nombreRol($v) { $this->nombreRol = $v;}
    function set_descripcion($v) { $this->descripcion = $v;}
    function set_idRol($v) { $this->idRol = $v;}

    // getters
    function get_nombreRol(){ return $this->nombreRol; }
    function get_descripcion(){ return $this->descripcion; }
    function get_idRol(){ return $this->idRol; }

    function incluir(){
    $co = $this->conecta();
    $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $r = array();
    if(!$this->existe($this->nombreRol)){
        try{
            $inc = $co->prepare("INSERT INTO rol(nombre, descripcion)
            VALUES (:nombre, :descripcion)");

            $inc->bindParam(':nombre', $this->nombreRol);
            $inc->bindParam(':descripcion', $this->descripcion);
            $inc->execute();

            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Rol registrado';
            
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();

        }
    } else {
        $r['resultado'] = 'incluir';
        $r['mensaje'] = 'Ya existe el registro';
    }
    return $r;
    }

    function modificar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->idRol)) {
            try {
                $mod = $co->prepare("UPDATE rol
                SET nombre = :nombre, descripcion = :descripcion
                WHERE id_rol = :id");

                $mod->bindParam(':nombre', $this->nombreRol);
                $mod->bindParam(':descripcion', $this->descripcion);
                $mod->bindParam(':id', $this->idRol);
                $mod->execute();

                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Rol modificado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else {
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'El registro no existe';
        }
        return $r;
    }

    function eliminar() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->idRol)) {
            try {
                $eli = $co->prepare("DELETE FROM rol WHERE id_rol = :id_rol");
                
                $eli->bindParam(':id_rol', $this->idRol);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Rol eliminado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else {
            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'el rol no existe';
        }
        return $r;
    }

    function consultar() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try {
            $resultado = $co->query("SELECT * FROM rol");
            if($resultado) {
                $respuesta = '';
                foreach($resultado as $fila) {
                    $respuesta .= "<tr>";
                    $respuesta .= "<td style='display:none'>" . $fila['id_rol'] . "</td>";
                    $respuesta .= "<td>" . $fila['nombre'] . "</td>";
                    $respuesta .= "<td>" . $fila['descripcion'] . "</td>";
                    $respuesta .= "<td style='display:none'>" . $fila['id_rol'] . "</td>";
                    
                    $respuesta .= "<td>";
                        $respuesta .= "<div class='d-flex justify-content-center'>";
                        $respuesta .= "<button type='button' class='btn btn-dark text-white w-80 small-width m-1' onclick='pone(this)'><i class='bi bi-pencil-square'></i>CONSULTAR</button>";
                       $respuesta .= "<button type='button' class='btn btn-danger text-white w-80 small-width m-1 d-none' onclick='eliminar(this)'><i class='bi bi-trash-fill'></i> Eliminar</button>";
                    $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }
                if($respuesta == ""){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td colspan = '5' class='text-center text-muted py-4>'";
                    $respuesta .= "<span><i class='bi bi-person-fill fs-1' style='color: #17120b'></i></span>";
                    $respuesta .= "<h5 class= 'text-dashboard'> No hay roles registrados </h5>";
                    $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }
                $r['resultado'] = 'consultar';
                $r['mensaje'] = $respuesta;
            } else {
                $r['resultado'] = 'consultar';
                $r['mensaje'] = '';
            }
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
    function existe($id_rol) {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $resultado = $co->prepare("SELECT * FROM rol WHERE id_rol = :id_rol");
            $resultado->bindParam(':id_rol', $id_rol);
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