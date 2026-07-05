<?php
require_once('modelo/datos.php');

class empleados extends datos {
    private $cedulaEmpleado, $nombreEmpleado, $apellidoEmpleado, $tlfEmpleado, $correoEmpleado, $contraEmpleado, $rolEmpleado, $estado;

    // setters
    function set_cedulaEmpleado($v) { $this->cedulaEmpleado = $v; }
    function set_nombreEmpleado($v) { $this->nombreEmpleado = $v; }
    function set_apellidoEmpleado($v) { $this->apellidoEmpleado = $v; }
    function set_tlfEmpleado($v) { $this->tlfEmpleado = $v; }
    function set_correoEmpleado($v) { $this->correoEmpleado = $v; }
    function set_contraEmpleado($v) { $this->contraEmpleado = $v; }
    function set_rolEmpleado($v) { $this->rolEmpleado = $v;}
    function set_estado($valor) {$this->estado = $valor; }

    // getters
    function get_cedulaEmpleado(){ return $this->cedulaEmpleado; }
    function get_nombreEmpleado(){ return $this->nombreEmpleado; }
    function get_apellidoEmpleado(){ return $this->apellidoEmpleado; }
    function get_tlfEmpleado(){ return $this->tlfEmpleado; }
    function get_correoEmpleado(){ return $this->correoEmpleado;}
    function get_contraEmpleado(){ return $this->contraEmpleado;}
    function get_rolEmpleado(){ return $this->rolEmpleado;}
    function get_estado(){ return $this->estado; }

   function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $passwordHasheado = password_hash($this->contraEmpleado, PASSWORD_DEFAULT);
        $r = array();
        if(!$this->existe($this->cedulaEmpleado)){
            try{
                $inc = $co->prepare("INSERT INTO empleado(cedula, nombre, apellido, telefono, correo, id_rol, contrasena)
                VALUES (:cedula, :nombre, :apellido, :telefono, :correo, :id_rol, :contrasena)");

                $inc->bindParam(':cedula', $this->cedulaEmpleado);
                $inc->bindParam(':nombre', $this->nombreEmpleado);
                $inc->bindParam(':apellido', $this->apellidoEmpleado);
                $inc->bindParam(':telefono', $this->tlfEmpleado);
                $inc->bindParam(':correo', $this->correoEmpleado);
                $inc->bindParam(':id_rol', $this->rolEmpleado);
                $inc->bindParam(':contrasena', $passwordHasheado);
                $inc->execute();

                $r['resultado'] = 'incluir';
                $r['mensaje'] = 'Empleado Registrado';
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

    if($this->existe($this->cedulaEmpleado)){
        try{
            // 1. Verificamos si se escribió una nueva contraseña
            if (!empty($this->contraEmpleado)) {
                // Si hay contraseña, la hasheamos y la incluimos en el update
                $passwordHasheado = password_hash($this->contraEmpleado, PASSWORD_DEFAULT);
                $sql = "UPDATE empleado SET nombre = :nombre, apellido = :apellido, telefono = :telefono, 
                        correo = :correo, id_rol = :id_rol, contrasena = :contrasena WHERE cedula = :cedula";
                $mod = $co->prepare($sql);
                $mod->bindParam(':contrasena', $passwordHasheado);
            } else {
                // Si NO hay contraseña, hacemos update de todo MENOS la contraseña
                $sql = "UPDATE empleado SET nombre = :nombre, apellido = :apellido, telefono = :telefono, 
                        correo = :correo, id_rol = :id_rol WHERE cedula = :cedula";
                $mod = $co->prepare($sql);
            }

            // Bind comunes a ambos casos
            $mod->bindParam(':cedula', $this->cedulaEmpleado);
            $mod->bindParam(':nombre', $this->nombreEmpleado);
            $mod->bindParam(':apellido', $this->apellidoEmpleado);
            $mod->bindParam(':telefono', $this->tlfEmpleado);
            $mod->bindParam(':correo', $this->correoEmpleado);
            $mod->bindParam(':id_rol', $this->rolEmpleado);
            $mod->execute();
            
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'Empleado Modificado';
        } catch(Exception $e){
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
    } else {
        $r['resultado'] = 'modificar';
        $r['mensaje'] = 'La Cedula No Existe';
    }
    return $r;
}

     function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        if($this->existe($this->cedulaEmpleado)){
            try{
                $eli = $co->prepare("UPDATE empleado SET estado = 0 WHERE cedula = :cedulaEmpleado");

                $eli->bindParam(':cedulaEmpleado', $this->cedulaEmpleado);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Empleado Eliminado';
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
            $resultado = $co->query("SELECT e.*, r.nombre AS nombre_rol FROM empleado e LEFT JOIN rol r ON e.id_rol = r.id_rol WHERE e.estado = 1");
            if($resultado){
                $respuesta = '';
                foreach($resultado as $fila){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td>" . $fila['cedula'] . "</td>";
                    $respuesta .= "<td>" . $fila['nombre'] . "</td>";
                    $respuesta .= "<td>" . $fila['apellido'] . "</td>";
                    $respuesta .= "<td>" . $fila['nombre_rol'] . "</td>";
                    $respuesta .= "<td>" . $fila['telefono'] . "</td>";
                    $respuesta .= "<td style='display:none'>" . $fila['correo'] . "</td>";
                    $respuesta .= "<td style='display:none'>" . $fila['id_rol'] . "</td>";
                   // $respuesta .= "<td>" . $fila['contrasena'] . "</td>";
                    $respuesta .= "<td>";
                        $respuesta .= "<div class='d-flex justify-content-center'>";
                        $respuesta .= "<button type='button' class='btn btn-dark text-white w-80 small-width m-1' onclick='pone(this)'><i class='bi bi-pencil-square'></i></button>";
                        $respuesta .= "<button type='button' class='btn btn-danger w-80 small-width m-1' onclick='eliminar(this)'><i class='bi bi-trash'></i></button>";
                    $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }

                if($respuesta == ""){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td colspan = '5' class='text-center text-muted py-4>'";
                    $respuesta .= "<span><i class='bi bi-person-fill fs-1' style='color: #17120b'></i></span>";
                    $respuesta .= "<h5 class= 'text-dashboard'> No hay empleados registrados </h5>";
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

    function existe($cedula){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM empleado WHERE cedula = :cedula AND estado = 1");
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

    function listar_roles(){
        $co = $this->conecta(); 
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $datos = [];
        try {
            // Hacemos el select a tu tabla 'rol' según la imagen de phpMyAdmin
            $resultado = $co->query("SELECT id_rol, nombre FROM rol");
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) {
            $datos = [];
        }
        return $datos;
    }
}
?>