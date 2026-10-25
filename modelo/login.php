<?php
require_once('modelo/datos.php');

class login extends datos {
    private $correo, $contrasena;

    function set_correo($v) { $this->correo = $v; }
    function set_contrasena($v) { $this->contrasena = $v; }

    function ingresar() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();

        try {
            // Buscamos al empleado por su correo y verificamos que esté activo (estado = 1)
            $sql = "SELECT * FROM empleado WHERE correo = :correo AND estado = 1";
            $consulta = $co->prepare($sql);
            $consulta->bindParam(':correo', $this->correo);
            $consulta->execute();

            $fila = $consulta->fetch(PDO::FETCH_ASSOC);

            // Si encontró un registro con ese correo...
            if ($fila) {
                // Verificamos si la contraseña tipeada coincide con el Hash guardado
                if (password_verify($this->contrasena, $fila['contrasena'])) {
                    
                    // ¡Seguridad Primero! Regeneramos el ID de la sesión para evitar hackeos por robo de cookies
                    if(session_status() !== PHP_SESSION_ACTIVE) {
                        session_start();
                    }
                    session_regenerate_id(true);

                    // Levantamos las variables de sesión que usaremos en todo el sistema
                    $_SESSION['id_empleado'] = $fila['id_empleado'];
                    $_SESSION['nombre_empleado'] = $fila['nombre'] . " " . $fila['apellido'];
                    $_SESSION['id_rol'] = $fila['id_rol'];

                    $r['resultado'] = 'exito';
                    $r['mensaje'] = 'Bienvenido';
                } else {
                    // Mismo mensaje genérico para que el atacante no sepa si falló el correo o la clave
                    $r['resultado'] = 'error';
                    $r['mensaje'] = 'Correo o contraseña incorrectos';
                }
            } else {
                $r['resultado'] = 'error';
                $r['mensaje'] = 'Correo o contraseña incorrectos';
            }
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
}
?>