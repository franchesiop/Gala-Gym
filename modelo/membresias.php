<?php
require_once('modelo/datos.php');

class membresias extends datos {
    private $id_membresia, $tipo, $monto;

    // setters
    function set_id_membresia($v) { $this->id_membresia = $v; }
    function set_tipo($v) { $this->tipo = $v; }
    function set_monto($v) { $this->monto = $v; }
    
    // getters
    function get_id_membresia(){ return $this->id_membresia; }
    function get_tipo(){ return $this->tipo; }
    function get_monto(){ return $this->monto; }

    function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            // se usa $this->nombre_ejercicio de manera consistente
            $busqueda = $co->prepare("SELECT * FROM membresia WHERE tipo = :tipo");
            $busqueda->bindParam(':tipo', $this->tipo);
            $busqueda->execute();
            
            if($busqueda->fetch()){
                $r['resultado'] = 'error';
                $r['mensaje'] = 'Ya esta membresia está registrado';
            } else {
                $inc = $co->prepare("INSERT INTO membresia (tipo, monto) VALUES (:tipo, :monto)");
                $inc->bindParam(':tipo', $this->tipo);
                $inc->bindParam(':monto', $this->monto);
                $inc->execute();

                $r['resultado'] = 'incluir';
                $r['mensaje'] = 'Membresía Registrada'; 
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
        if($this->existe($this->id_membresia)){
            try{
                $mod = $co->prepare("UPDATE membresia
                    SET tipo = :tipo, monto = :monto
                    WHERE id_membresia = :id_membresia");

                $mod->bindParam(':id_membresia', $this->id_membresia);
                $mod->bindParam(':tipo', $this->tipo);
                $mod->bindParam(':monto', $this->monto);
                $mod->execute();
                
                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Membresía Modificada';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'La Membresía No Existe';
        }
        return $r;
    }

    function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->id_membresia)){
            try{
                $eli = $co->prepare("DELETE FROM membresia WHERE id_membresia = :id_membresia");

                $eli->bindParam(':id_membresia', $this->id_membresia);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Membresía Eliminada';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'La Membresía No Existe';
        }
        return $r;
    }

    function consultar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $resultado = $co->query("SELECT * FROM membresia");
            if($resultado){
                // Extraemos todos los registros puros en un array asociativo
                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                
                $r['resultado'] = 'consultar';
                $r['mensaje'] = $datos; 
            } else {
                $r['resultado'] = 'consultar';
                $r['mensaje'] = [];
            }
        } catch(Exception $e){
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function existe($id_membresia){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM membresia WHERE id_membresia = :id_membresia");
            $resultado->bindParam(':id_membresia', $id_membresia);
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