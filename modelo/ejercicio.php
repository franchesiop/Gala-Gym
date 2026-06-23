<?php
require_once('modelo/datos.php');

class ejercicio extends datos {
    private $id_ejercicio, $nombre_ejercicio;

    // setters
    function set_id_ejercicio($v) { $this->id_ejercicio = $v; }
    function set_nombre_ejercicio($v) { $this->nombre_ejercicio = $v; }
    
    // getters
    function get_id_ejercicio(){ return $this->id_ejercicio; }
    function get_nombre_ejercicio(){ return $this->nombre_ejercicio; }

    function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            // Se usa $this->nombre_ejercicio de manera consistente
            $busqueda = $co->prepare("SELECT * FROM ejercicio WHERE nombre = :nombre");
            $busqueda->bindParam(':nombre', $this->nombre_ejercicio);
            $busqueda->execute();
            
            if($busqueda->fetch()){
                $r['resultado'] = 'error';
                $r['mensaje'] = 'Ya este ejercicio está registrado';
            } else {
                $inc = $co->prepare("INSERT INTO ejercicio (nombre) VALUES (:nombre)");
                $inc->bindParam(':nombre', $this->nombre_ejercicio);
                $inc->execute();

                $r['resultado'] = 'incluir';
                $r['mensaje'] = 'Ejercicio Registrado'; 
            }
        } catch(Exception $e){
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function modificar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->id_ejercicio)){
            try{
                $mod = $co->prepare("UPDATE ejercicio
                    SET nombre = :nombre
                    WHERE id_ejercicio = :id_ejercicio");

                $mod->bindParam(':id_ejercicio', $this->id_ejercicio);
                $mod->bindParam(':nombre', $this->nombre_ejercicio);
                $mod->execute();
                
                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Ejercicio Modificado';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'El Ejercicio No Existe';
        }
        return $r;
    }

    function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->id_ejercicio)){
            try{
                $eli = $co->prepare("DELETE FROM ejercicio WHERE id_ejercicio = :id_ejercicio");

                $eli->bindParam(':id_ejercicio', $this->id_ejercicio);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Ejercicio Eliminado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'El Ejercicio No Existe';
        }
        return $r;
    }

    function consultar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $resultado = $co->query("SELECT * FROM ejercicio");
            if($resultado){
                $respuesta = '';
                foreach($resultado as $fila){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td>" . $fila['id_ejercicio'] . "</td>";
                    $respuesta .= "<td>" . $fila['nombre'] . "</td>";
                   
                    $respuesta .= "<td>";
                    $respuesta .= "<div class='d-flex justify-content-center'>";
        
                    $respuesta .= "<button type='button' class='btn btn-dark text-white w-80 small-width m-1' onclick='pone(this)'><i class='bi bi-pencil-square'></i> CONSULTAR</button>";
                    $respuesta .= "</div>";
                    $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }

                if($respuesta == ""){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td colspan='3' class='text-center text-muted'>";
                    $respuesta .= "<span><i class='bi bi-card-list fs-1' style='color: #17120b'></i></span>";
                    $respuesta .= "<h5 class='text-dashboard'> No hay Ejercicios Registrados </h5>";
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

    function existe($id_ejercicio){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM ejercicio WHERE id_ejercicio = :id_ejercicio");
            $resultado->bindParam(':id_ejercicio', $id_ejercicio);
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