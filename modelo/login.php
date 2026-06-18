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
        
        try {
            
            $resultado = $co->prepare("SELECT * FROM cliente WHERE correo = :correo AND contrasena = :pass");
            $resultado->bindValue(':correo', $this->correo);
            $resultado->bindValue(':pass', $this->contrasena);
            $resultado->execute();
            
            $usuario = $resultado->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
            
                return "Bienvenido " . $usuario['nombre'];
            } else {
                return "Correo o contraseña incorrectos.";
            }
        } catch (Exception $e) {
            return "Error de conexión: " . $e->getMessage();
        }
    }
}
?>