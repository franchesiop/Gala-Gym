<?php
require_once('modelo/datos.php');

class Pago extends datos {
    private $id_pago, $id_cliente, $id_membresia, $monto, $fecha, $referencia, $id_metodo;
    
    public function set_id_cliente($v) { $this->id_cliente = $v; }
    public function set_id_membresia($v) { $this->id_membresia = $v; }
    public function set_monto($v) { $this->monto = $v; }
    public function set_referencia($v) { $this->referencia = $v; }
    public function set_id_metodo($v) { $this->id_metodo = $v; }

    public function obtenerMembresias() {
        $co = $this->conecta();
        try {
            $resultado = $co->query("SELECT id_membresia, tipo, monto FROM membresia");
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            return [];
        }
    }

    public function obtenerMetodosPago() {
    $co = $this->conecta();
    try {
        $resultado = $co->query("SELECT id_metodo, banco, telefono, cedula FROM metodos_pago");
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

    public function registrarPago() {
        $co = $this->conecta();
        $r = ['resultado' => 'error', 'mensaje' => ''];
        
        try {
            $fecha_actual = date('Y-m-d');
            $sql = "INSERT INTO pago (fecha, monto, id_cliente, id_membresia, referencia, id_metodo) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $co->prepare($sql);
            $stmt->execute([
                $fecha_actual, 
                $this->monto, 
                $this->id_cliente, 
                $this->id_membresia, 
                $this->referencia,
                $this->id_metodo 
            ]);
            
            $r['resultado'] = 'exito';
            $r['mensaje'] = 'Pago registrado exitosamente';
        } catch(Exception $e) {
            $r['mensaje'] = 'Error al registrar el pago: ' . $e->getMessage();
        }
        return $r;
    }
}
?>