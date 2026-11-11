<?php
require_once('modelo/datos.php');

class clientes_pagos extends datos {
    private $idPago, $fecha, $monto, $idCliente, $idMembresia, $referencia, $idMetodo, $cantidadPeriodos;

    function set_idPago($v) { $this->idPago = $v; }
    function set_fecha($v) { $this->fecha = $v; }
    function set_monto($v) { $this->monto = $v; }
    function set_idCliente($v) { $this->idCliente = $v; }
    function set_idMembresia($v) { $this->idMembresia = $v; }
    function set_referencia($v) { $this->referencia = $v; }
    function set_idMetodo($v) { $this->idMetodo = $v; }
    function set_cantidadPeriodos($v) { $this->cantidadPeriodos = $v; }

    function consultar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $sql = "SELECT p.id_pago, p.fecha, p.monto, p.referencia, p.estado_pago, p.cantidad_periodos,
                           c.cedula, c.nombre, c.apellido, 
                           m.tipo AS membresia, 
                           mp.banco AS metodo 
                    FROM pago p
                    INNER JOIN cliente c ON p.id_cliente = c.id_cliente
                    INNER JOIN membresia m ON p.id_membresia = m.id_membresia
                    INNER JOIN metodos_pago mp ON p.id_metodo = mp.id_metodo
                    ORDER BY p.id_pago DESC"; 

            $resultado = $co->query($sql);
            if($resultado){
                $respuesta = '';
                foreach($resultado as $fila){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td style='display:none'>" . $fila['id_pago'] . "</td>"; 
                    $respuesta .= "<td>" . $fila['fecha'] . "</td>";
                    $respuesta .= "<td>" . $fila['cedula'] . "</td>";
                    $respuesta .= "<td>" . $fila['nombre'] . " " . $fila['apellido'] . "</td>";
                    $respuesta .= "<td>" . $fila['referencia'] . "</td>";
                    $respuesta .= "<td>$" . $fila['monto'] . "</td>";
                    $respuesta .= "<td>" . $fila['metodo'] . "</td>";
                    
                    $estado = $fila['estado_pago'];
                    if($estado == 0){
                        $respuesta .= "<td><span class='badge bg-warning text-dark'>Pendiente</span></td>";
                        $respuesta .= "<td>";
                        $respuesta .= "<div class='d-flex justify-content-center'>";
                        $respuesta .= "<button type='button' class='btn btn-success text-white w-80 small-width m-1' onclick='aprobar_pago(this)' title='Aprobar'><i class='bi bi-check-circle'></i></button>";
                        $respuesta .= "<button type='button' class='btn btn-danger w-80 small-width m-1' onclick='rechazar_pago(this)' title='Rechazar'><i class='bi bi-x-circle'></i></button>";
                        $respuesta .= "</div></td>";
                    } else if($estado == 1) {
                        $respuesta .= "<td><span class='badge bg-success'>Aprobado</span></td>";
                        $respuesta .= "<td class='text-center'><i class='bi bi-shield-check text-success fs-5'></i></td>"; 
                    } else {
                        $respuesta .= "<td><span class='badge bg-danger'>Rechazado</span></td>";
                        $respuesta .= "<td class='text-center'><i class='bi bi-shield-x text-danger fs-5'></i></td>"; 
                    }
                    
                    $respuesta .= "</tr>";
                }

                if($respuesta == ""){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td colspan='8' class='text-center text-muted py-4'>";
                    $respuesta .= "<span><i class='bi bi-cash-stack fs-1' style='color: #17120b'></i></span>";
                    $respuesta .= "<h5 class='text-dashboard'> No hay pagos registrados </h5>";
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

    function aprobar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $eli = $co->prepare("UPDATE pago SET estado_pago = 1 WHERE id_pago = :idPago");
            $eli->bindParam(':idPago', $this->idPago);
            $eli->execute();

            $r['resultado'] = 'aprobar';
            $r['mensaje'] = 'Pago Aprobado exitosamente';
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function rechazar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $eli = $co->prepare("UPDATE pago SET estado_pago = 2 WHERE id_pago = :idPago");
            $eli->bindParam(':idPago', $this->idPago);
            $eli->execute();

            $r['resultado'] = 'rechazar';
            $r['mensaje'] = 'Pago Rechazado';
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try{
            $fecha_actual = date("Y-m-d");
            
            $inc = $co->prepare("INSERT INTO pago(fecha, monto, id_cliente, id_membresia, referencia, id_metodo, cantidad_periodos, estado_pago)
            VALUES (:fecha, :monto, :idCliente, :idMembresia, :referencia, :idMetodo, :cantidadPeriodos, 1)");

            $inc->bindParam(':fecha', $fecha_actual);
            $inc->bindParam(':monto', $this->monto);
            $inc->bindParam(':idCliente', $this->idCliente);
            $inc->bindParam(':idMembresia', $this->idMembresia);
            $inc->bindParam(':referencia', $this->referencia);
            $inc->bindParam(':idMetodo', $this->idMetodo);
            $inc->bindParam(':cantidadPeriodos', $this->cantidadPeriodos);
            $inc->execute();

            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Pago Manual Registrado y Aprobado';
        } catch(Exception $e){
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function listar_clientes(){
        $co = $this->conecta(); 
        try {
            $resultado = $co->query("SELECT id_cliente, cedula, nombre, apellido, telefono FROM cliente WHERE estado = 1");
            return $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) { return []; }
    }

    function listar_membresias(){
        $co = $this->conecta(); 
        try {
            $resultado = $co->query("SELECT id_membresia, tipo FROM membresia");
            return $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) { return []; }
    }

    function listar_metodos(){
        $co = $this->conecta(); 
        try {
            $resultado = $co->query("SELECT id_metodo, banco FROM metodos_pago WHERE status = 1");
            return $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) { return []; }
    }
}
?>