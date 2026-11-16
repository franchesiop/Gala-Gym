<?php
require_once('modelo/datos.php');

class pago extends datos {
    private $id_cliente, $id_membresia, $cantidad_periodos, $id_metodo, $monto, $referencia;

    // Setters
    function set_idCliente($v) { $this->id_cliente = $v; }
    function set_idMembresia($v) { $this->id_membresia = $v; }
    function set_cantidadPeriodos($v) { $this->cantidad_periodos = $v; }
    function set_idMetodo($v) { $this->id_metodo = $v; }
    function set_monto($v) { $this->monto = $v; }
    function set_referencia($v) { $this->referencia = $v; }

    function listar_membresias(){
        $co = $this->conecta(); 
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $datos = [];
        try {
            $resultado = $co->query("SELECT id_membresia, tipo, monto FROM membresia");
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) {
            $datos = [];
        }
        return $datos;
    }

    function listar_metodos(){
        $co = $this->conecta(); 
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $datos = [];
        try {
            // Traemos banco, cedula y telefono para mostrarlos dinámicamente en el resumen
            $resultado = $co->query("SELECT id_metodo, banco, cedula, telefono FROM metodos_pago WHERE status = 1");
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) {
            $datos = [];
        }
        return $datos;
    }

    function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try{
            $fechaActual = date('Y-m-d');
            
            $inc = $co->prepare("INSERT INTO pago(fecha, monto, id_cliente, id_membresia, referencia, id_metodo, cantidad_periodos)
                                 VALUES (:fecha, :monto, :id_cliente, :id_membresia, :referencia, :id_metodo, :cantidad)");
            
            $inc->bindParam(':fecha', $fechaActual);
            $inc->bindParam(':monto', $this->monto);
            $inc->bindParam(':id_cliente', $this->id_cliente);
            $inc->bindParam(':id_membresia', $this->id_membresia);
            $inc->bindParam(':referencia', $this->referencia);
            $inc->bindParam(':id_metodo', $this->id_metodo);
            $inc->bindParam(':cantidad', $this->cantidad_periodos);
            
            $inc->execute();

            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Pago Registrado Exitosamente';
        } catch(Exception $e){
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
}
?>