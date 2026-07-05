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
            // 1. Buscamos al empleado por su correo y verificamos que esté activo (estado = 1)
            $stmt = $co->prepare("SELECT * FROM empleado WHERE correo = :correo AND estado = 1");
            $stmt->bindParam(':correo', $this->correo);
            $stmt->execute();
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Si el usuario existe en la base de datos
            if ($usuario) {
                // 3. Verificamos la contraseña. 
                // OJO: password_verify requiere que la contraseña en la BD haya sido guardada con password_hash()
                if (password_verify($this->contrasena, $usuario['contrasena'])) {
                    
                    $r['resultado'] = 'exito';
                    $r['mensaje'] = 'Bienvenido ' . $usuario['nombre'];
                    $r['datos'] = $usuario; // Devolvemos todos los datos (incluyendo id_rol) para el controlador
                    
                } else {
                    $r['resultado'] = 'error';
                    $r['mensaje'] = 'Contraseña incorrecta.';
                }
            } else {
                $r['resultado'] = 'error';
                $r['mensaje'] = 'El correo no existe o el usuario está inactivo.';
            }
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = 'Error de conexión: ' . $e->getMessage();
        }
        
        return $r;
    }
}
?>