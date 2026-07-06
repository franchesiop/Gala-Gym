<?php
require_once('modelo/datos.php');

class login extends datos {
    private $correo;
    private $contrasena;

    // setters
    public function set_correo($valor){
        $this->correo = $valor;
    }
    
    public function set_contrasena($valor){
        $this->contrasena = $valor;
    }

    // validar al usuario
    public function ingresar() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            // buscamos primero en la tabla empleado
            $stmt = $co->prepare("SELECT * FROM empleado WHERE correo = :correo AND estado = 1");
            $stmt->bindParam(':correo', $this->correo);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                // es un empleado verificamos contrasena
                if (password_verify($this->contrasena, $usuario['contrasena'])) {
                    $r['resultado'] = 'exito';
                    $r['mensaje'] = 'Bienvenido ' . $usuario['nombre'];
                    $r['datos'] = $usuario;
                    $r['tipo_usuario'] = 'empleado'; 
                    return $r;
                } else {
                    return ['resultado' => 'error', 'mensaje' => 'Contraseña incorrecta.'];
                }
            }

            // si no es empleado buscamos en cliente
            $stmt2 = $co->prepare("SELECT * FROM cliente WHERE correo = :correo AND estado = 1");
            $stmt2->bindParam(':correo', $this->correo);
            $stmt2->execute();
            $cliente = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($cliente) {
                // es un cliente verificamos su contrasena
                if (password_verify($this->contrasena, $cliente['contrasena'])) {
                    $r['resultado'] = 'exito';
                    $r['mensaje'] = 'Bienvenido ' . $cliente['nombre'];
                    $r['datos'] = $cliente;
                    $r['tipo_usuario'] = 'cliente'; 
                    return $r;
                } else {
                    return ['resultado' => 'error', 'mensaje' => 'Contraseña incorrecta.'];
                }
            }

            
            // si no esta en ninguna de las dos ta blas
            
            $r['resultado'] = 'error';
            $r['mensaje'] = 'El correo no existe o el usuario está inactivo.';
            
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = 'Error de conexión: ' . $e->getMessage();
        }
        
        return $r;
    }
}
?>