<?php
require_once('modelo/datos.php');

class entrada extends datos {
    private $correo; 
    private $contrasena;
    
    function set_correo($valor) { $this->correo = $valor; }
    function set_contrasena($valor) { $this->contrasena = $valor; }
    
    function get_correo() { return $this->correo; }
    function get_contrasena() { return $this->contrasena; }
    
    function existe() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            // busca primero en la tabla empleado
            $p = $co->prepare("SELECT id_empleado as id_usuario, contrasena, id_rol FROM empleado WHERE correo = :correo AND estado = 1");
            $p->bindParam(':correo', $this->correo);
            $p->execute();
            $fila = $p->fetch(PDO::FETCH_ASSOC);
            
            if ($fila) {
                // compara la contraseña en texto plano con el hash de la base de datos
                if (password_verify($this->contrasena, $fila['contrasena'])) {
                    $r['resultado'] = 'existe';
                    $r['id_rol'] = $fila['id_rol'];
                    $r['id_usuario'] = $fila['id_usuario'];
                    return $r;
                } else {
                    $r['resultado'] = 'noexiste';
                    $r['mensaje'] = "Contraseña incorrecta";
                    return $r;
                }
            }
            
            // si no es empleado busca en la tabla cliente
            $p2 = $co->prepare("SELECT id_cliente as id_usuario, contrasena, id_rol FROM cliente WHERE correo = :correo AND estado = 1");
            $p2->bindParam(':correo', $this->correo);
            $p2->execute();
            $fila2 = $p2->fetch(PDO::FETCH_ASSOC);
            
            if ($fila2) {
                if (password_verify($this->contrasena, $fila2['contrasena'])) {
                    $r['resultado'] = 'existe';
                    $r['id_rol'] = $fila2['id_rol'];
                    $r['id_usuario'] = $fila2['id_usuario'];
                    return $r;
                } else {
                    $r['resultado'] = 'noexiste';
                    $r['mensaje'] = "Contraseña incorrecta";
                    return $r;
                }
            }
            
            // si no está en ninguna tabla o está inactivo
            $r['resultado'] = 'noexiste';
            $r['mensaje'] = "El correo no está registrado o el usuario está inactivo";
            
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
}
?>