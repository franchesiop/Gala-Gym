<?php
require_once('modelo/datos.php');

class clientes extends datos {
    private $cedulaCliente, $nombreCliente, $apellidoCliente, $tlfCliente, $correoCliente, $contraCliente, $membresiaCliente, $estado;

    // setters
    function set_cedulaCliente($v) { $this->cedulaCliente = $v; }
    function set_nombreCliente($v) { $this->nombreCliente = $v; }
    function set_apellidoCliente($v) { $this->apellidoCliente = $v; }
    function set_tlfCliente($v) { $this->tlfCliente = $v; }
    function set_correoCliente($v) { $this->correoCliente = $v; }
    function set_contraCliente($v) { $this->contraCliente = $v; }
    function set_membresiaCliente($v) { $this->membresiaCliente = $v;}
    function set_estado($valor) {$this->estado = $valor; }

    // getters
    function get_cedulaCliente(){ return $this->cedulaCliente; }
    function get_nombreCliente(){ return $this->nombreCliente; }
    function get_apellidoCliente(){ return $this->apellidoCliente; }
    function get_tlfCliente(){ return $this->tlfCliente; }
    function get_correoCliente(){ return $this->correoCliente;}
    function get_contraCliente(){ return $this->contraCliente;}
    function get_membresiaCliente(){ return $this->membresiaCliente;}
    function get_estado(){ return $this->estado; }

   function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $passwordHasheado = password_hash($this->contraCliente, PASSWORD_DEFAULT);
        $r = array();
        if(!$this->existe($this->cedulaCliente)){
            try{
                $inc = $co->prepare("INSERT INTO cliente(cedula, nombre, apellido, telefono, correo, id_membresia, contrasena)
                VALUES (:cedula, :nombre, :apellido, :telefono, :correo, :id_membresia, :contrasena)");

                $inc->bindParam(':cedula', $this->cedulaCliente);
                $inc->bindParam(':nombre', $this->nombreCliente);
                $inc->bindParam(':apellido', $this->apellidoCliente);
                $inc->bindParam(':telefono', $this->tlfCliente);
                $inc->bindParam(':correo', $this->correoCliente);
                $inc->bindParam(':id_membresia', $this->membresiaCliente);
                $inc->bindParam(':contrasena', $passwordHasheado);
                $inc->execute();

                $r['resultado'] = 'incluir';
                $r['mensaje'] = 'Cliente Registrado';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Ya existe la cedula a registrar';
        }
        return $r;
    }

     function modificar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();

        if($this->existe($this->cedulaCliente)){
            try{
                // Verificamos si se escribió una nueva contraseña
                if (!empty($this->contraCliente)) {
                    $passwordHasheado = password_hash($this->contraCliente, PASSWORD_DEFAULT);
                    $sql = "UPDATE cliente 
                            SET nombre = :nombre, apellido = :apellido, telefono = :telefono, 
                                correo = :correo, id_membresia = :id_membresia, contrasena = :contrasena 
                            WHERE cedula = :cedula";
                    $mod = $co->prepare($sql);
                    $mod->bindParam(':contrasena', $passwordHasheado);
                } else {
                    // Si NO hay contraseña, actualizamos todo menos la clave
                    $sql = "UPDATE cliente 
                            SET nombre = :nombre, apellido = :apellido, telefono = :telefono, 
                                correo = :correo, id_membresia = :id_membresia 
                            WHERE cedula = :cedula";
                    $mod = $co->prepare($sql);
                }

                // Bind comunes a ambos casos
                $mod->bindParam(':cedula', $this->cedulaCliente);
                $mod->bindParam(':nombre', $this->nombreCliente);
                $mod->bindParam(':apellido', $this->apellidoCliente);
                $mod->bindParam(':telefono', $this->tlfCliente);
                $mod->bindParam(':correo', $this->correoCliente);
                $mod->bindParam(':id_membresia', $this->membresiaCliente);
                $mod->execute();
                
                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Cliente Modificado';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'La Cedula No Existe';
        }
        return $r;
    }

     function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->cedulaCliente)){
            try{
                $eli = $co->prepare("UPDATE cliente SET estado = 0 WHERE cedula = :cedulaCliente");

                $eli->bindParam(':cedulaCliente', $this->cedulaCliente);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Cliente Eliminado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'La cedula No Existe';
        }
        return $r;
    }
   function consultar(){
    $co = $this->conecta();
    $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $r = array();
    try{
        $resultado = $co->query("SELECT * FROM cliente WHERE estado = 1");
        if($resultado){
            // Extraemos los datos puros en un arreglo asociativo
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

    function existe($cedula){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM cliente WHERE cedula = :cedula AND estado = 1");
            $resultado->bindParam(':cedula', $cedula);
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

    function listar_membresias(){
    $co = $this->conecta(); 
    $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $datos = [];
    try {
        $resultado = $co->query("SELECT id_membresia, tipo FROM membresia");
        $datos = $resultado->fetchAll(PDO::FETCH_ASSOC); 
    } catch(Exception $e) {
        
        $datos = [];
    }
    return $datos;
}
}
?>