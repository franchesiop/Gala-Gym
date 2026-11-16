<?php
require_once('modelo/datos.php');

class rutinas extends datos {
    private $id_rutina, $nombre, $id_empleado, $id_cliente;

    // setters
    function set_id_rutina($v) { $this->id_rutina = $v; }
    function set_nombre($v) { $this->nombre = $v; }
    function set_id_empleado($v) { $this->id_empleado = $v; }
    function set_id_cliente($v) { $this->id_cliente = $v; } 
    
    // getters
    function get_id_rutina(){ return $this->id_rutina; }
    function get_nombre(){ return $this->nombre; }
    function get_id_empleado(){ return $this->id_empleado; }
    function get_id_cliente(){ return $this->id_cliente; } 

    function incluir($ejercicios, $series, $repeticiones){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            $co->beginTransaction();

            $inc = $co->prepare("INSERT INTO rutina (nombre, id_empleado, id_cliente) VALUES (:nombre, :id_empleado, :id_cliente)");
            $inc->bindParam(':nombre', $this->nombre);
            $inc->bindParam(':id_empleado', $this->id_empleado);
            $inc->bindParam(':id_cliente', $this->id_cliente);
            $inc->execute();

            $id_rutina_nueva = $co->lastInsertId();

            $inc_detalle = $co->prepare("INSERT INTO detalleRutina (id_rutina, id_ejercicio, series, repeticiones) VALUES (:id_rutina, :id_ejercicio, :series, :repeticiones)");
            
            for ($i = 0; $i < count($ejercicios); $i++) {
                $inc_detalle->bindParam(':id_rutina', $id_rutina_nueva);
                $inc_detalle->bindParam(':id_ejercicio', $ejercicios[$i]);
                $inc_detalle->bindParam(':series', $series[$i]);
                $inc_detalle->bindParam(':repeticiones', $repeticiones[$i]);
                $inc_detalle->execute();
            }

            $co->commit();
            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Rutina Registrada'; 
            
        } catch(Exception $e){
            $co->rollBack();
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function modificar($ejercicios, $series, $repeticiones){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        if($this->existe($this->id_rutina)){
            try{
                $co->beginTransaction();

                $mod = $co->prepare("UPDATE rutina SET nombre = :nombre, id_cliente = :id_cliente WHERE id_rutina = :id_rutina");
                $mod->bindParam(':id_rutina', $this->id_rutina);
                $mod->bindParam(':nombre', $this->nombre);
                $mod->bindParam(':id_cliente', $this->id_cliente);
                $mod->execute();
                
                $eli_detalles = $co->prepare("DELETE FROM detalleRutina WHERE id_rutina = :id_rutina");
                $eli_detalles->bindParam(':id_rutina', $this->id_rutina);
                $eli_detalles->execute();

                $inc_detalle = $co->prepare("INSERT INTO detalleRutina (id_rutina, id_ejercicio, series, repeticiones) VALUES (:id_rutina, :id_ejercicio, :series, :repeticiones)");
                
                for ($i = 0; $i < count($ejercicios); $i++) {
                    $inc_detalle->bindParam(':id_rutina', $this->id_rutina);
                    $inc_detalle->bindParam(':id_ejercicio', $ejercicios[$i]);
                    $inc_detalle->bindParam(':series', $series[$i]);
                    $inc_detalle->bindParam(':repeticiones', $repeticiones[$i]);
                    $inc_detalle->execute();
                }

                $co->commit();
                
                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Rutina Modificada';
            } catch(Exception $e){
                $co->rollBack();
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'La Rutina No Existe';
        }
        return $r;
    }

    function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->id_rutina)){
            try{
                $eli = $co->prepare("DELETE FROM rutina WHERE id_rutina = :id_rutina");
                $eli->bindParam(':id_rutina', $this->id_rutina);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Rutina Eliminada';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'La Rutina No Existe';
        }
        return $r;
    }

    function consultar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $sql = "SELECT r.id_rutina, r.nombre AS rutina, r.id_cliente, 
                           e.nombre AS empleado_nombre, e.apellido AS empleado_apellido,
                           c.cedula, c.nombre AS cliente_nombre, c.apellido AS cliente_apellido
                    FROM rutina r 
                    LEFT JOIN empleado e ON r.id_empleado = e.id_empleado
                    LEFT JOIN cliente c ON r.id_cliente = c.id_cliente";
            
            $resultado = $co->query($sql);
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

    // NUEVA FUNCION: Para traer todos los clientes y llenar la tabla del modal
    function listar_todos_clientes(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $datos = [];
        try {
            $sql = "SELECT id_cliente, cedula, nombre, apellido, telefono FROM cliente WHERE estado = 1 ORDER BY nombre ASC";
            $consulta = $co->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            $datos = [];
        }
        return $datos;
    }

    function listar_ejercicios(){
        $co = $this->conecta(); 
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $datos = [];
        try {
            // Asegúrate de que el campo de la imagen se llame así en tu BD (ej. foto, imagen, url_imagen)
            // Aquí asumo que se llama 'imagen'. Si se llama distinto, cámbialo abajo.
            $resultado = $co->query("SELECT id_ejercicio, nombre, imagen FROM ejercicio ORDER BY nombre ASC");
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) {
            $datos = [];
        }
        return $datos;
    }

    function consultar_detalles(){
        $co = $this->conecta(); 
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $datos = [];
        try {
            $sql = "SELECT d.id_ejercicio, e.nombre, d.series, d.repeticiones 
                    FROM detalleRutina d
                    INNER JOIN ejercicio e ON d.id_ejercicio = e.id_ejercicio 
                    WHERE d.id_rutina = :id_rutina";
            $consulta = $co->prepare($sql);
            $consulta->bindParam(':id_rutina', $this->id_rutina);
            $consulta->execute();
            
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) {
            $datos = [];
        }
        return $datos;
    }

    function existe($id_rutina){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM rutina WHERE id_rutina = :id_rutina");
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