<?php
require_once('modelo/datos.php');

class admin extends datos {
    private $cedula, $nombre, $apellido, $telefono, $correo, $contrasena, $cargo, $id_membresia, $monto, $id_pago, $banco, $cedula_pago, $telefono_pago;

    public function set_cedula($v){ $this->cedula = $v; }
    public function set_nombres($v){ $this->nombre = $v; }
    public function set_apellidos($v){ $this->apellido = $v; }
    public function set_telefono($v){ $this->telefono = $v; }
    public function set_correo($v){ $this->correo = $v; }
    public function set_contrasena($v){ $this->contrasena = $v; }
    public function set_cargo($v){ $this->cargo = $v; }
    public function set_id_membresia($v){ $this->id_membresia = $v; }
    public function set_monto($v){ $this->monto = $v; }
    public function set_id_pago($v){ $this->id_pago = $v; }
  
    public function set_banco($v){ $this->banco = $v; }
    public function set_cedula_pago($v){ $this->cedula_pago = $v; }
    public function set_telefono_pago($v){ $this->telefono_pago = $v; }

    public function consultar() {
        $co = $this->conecta();
        $resultado = $co->query("SELECT cedula, nombre, apellido, telefono FROM cliente");
        $respuesta = '';
        foreach($resultado as $r) {
            $respuesta .= "<tr>
                <td>{$r['cedula']}</td>
                <td>{$r['nombre']}</td>
                <td>{$r['apellido']}</td>
                <td>{$r['telefono']}</td>
                <td class='text-center'>
                    <button class='btn btn-dark btn-sm text-white rounded-0 fw-bold px-3 btn-consultar-cliente' data-cedula='{$r['cedula']}'>CONSULTAR</button>
                </td>
            </tr>";
        }
        return $respuesta;
    }

    public function obtener_cliente() {
        $co = $this->conecta();
        $stmt = $co->prepare("SELECT * FROM cliente WHERE cedula = ?");
        $stmt->execute([$this->cedula]);
        return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function incluir() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("INSERT INTO cliente (cedula, nombre, apellido, telefono, correo, contrasena, id_membresia) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$this->cedula, $this->nombre, $this->apellido, $this->telefono, $this->correo, $this->contrasena, $this->id_membresia]);
            return "Socio registrado con éxito";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    public function modificar() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("UPDATE cliente SET nombre=?, apellido=?, telefono=?, correo=?, contrasena=?, id_membresia=? WHERE cedula=?");
            $stmt->execute([$this->nombre, $this->apellido, $this->telefono, $this->correo, $this->contrasena, $this->id_membresia, $this->cedula]);
            return "Datos del socio actualizados";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    public function eliminar() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("DELETE FROM cliente WHERE cedula = ?");
            $stmt->execute([$this->cedula]);
            return "Socio eliminado correctamente";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    // empleados

    public function consultar_emp() {
        $co = $this->conecta();
        $resultado = $co->query("SELECT cedula, nombre, apellido, cargo, telefono FROM empleado");
        $respuesta = '';
        foreach($resultado as $r) {
            $respuesta .= "<tr>
                <td>{$r['cedula']}</td>
                <td>{$r['nombre']}</td>
                <td>{$r['apellido']}</td>
                <td>{$r['cargo']}</td>
                <td>{$r['telefono']}</td>
                <td class='text-center'>
                    <button class='btn btn-dark btn-sm text-white rounded-0 fw-bold px-3 btn-consultar-empleado' data-cedula='{$r['cedula']}'>CONSULTAR</button>
                </td>
            </tr>";
        }
        return $respuesta;
    }

    public function obtener_empleado() {
        $co = $this->conecta();
        $stmt = $co->prepare("SELECT * FROM empleado WHERE cedula = ?");
        $stmt->execute([$this->cedula]);
        return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function incluir_emp() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("INSERT INTO empleado (cedula, nombre, apellido, cargo, telefono, correo, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$this->cedula, $this->nombre, $this->apellido, $this->cargo, $this->telefono, $this->correo, $this->contrasena]);
            return "Empleado registrado con éxito";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    public function modificar_emp() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("UPDATE empleado SET nombre=?, apellido=?, cargo=?, telefono=?, correo=?, contrasena=? WHERE cedula=?");
            $stmt->execute([$this->nombre, $this->apellido, $this->cargo, $this->telefono, $this->correo, $this->contrasena, $this->cedula]);
            return "Datos del empleado actualizados";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    public function eliminar_emp() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("DELETE FROM empleado WHERE cedula = ?");
            $stmt->execute([$this->cedula]);
            return "Empleado eliminado correctamente";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    public function consultar_membresias() {
        $co = $this->conecta();
        $resultado = $co->query("SELECT id_membresia, tipo, monto FROM membresia");
        $respuesta = '';
        foreach($resultado as $r) {
            $respuesta .= "<tr>
                
                <td>{$r['id_membresia']}</td>
                <td>{$r['tipo']}</td>
                <td>{$r['monto']}$</td>
                <td class='text-center'>
                    <button class='btn btn-dark btn-sm text-white rounded-0 fw-bold px-3 btn-consultar-membresia' data-id='{$r['id_membresia']}'>CONSULTAR</button>
                </td>
            </tr>";
        }
        return $respuesta;
    }


    public function incluir_membresia() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("INSERT INTO membresia (tipo, monto) VALUES (?, ?)");
            $stmt->execute([$this->nombre, $this->monto]); 
            return "Membresía registrada con éxito";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    public function modificar_membresia() {
        $co = $this->conecta();
        try {
            $stmt = $co->prepare("UPDATE membresia SET tipo=?, monto=? WHERE id_membresia=?");
            $stmt->execute([$this->nombre, $this->monto, $this->id_membresia]);
            return "Membresía actualizada con éxito";
        } catch(Exception $e) { return "Error: " . $e->getMessage(); }
    }

    public function obtener_membresia() {
    $co = $this->conecta();
    $stmt = $co->prepare("SELECT * FROM membresia WHERE id_membresia = ?");
    $stmt->execute([$this->id_membresia]);
    return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

    public function eliminar_membresia() {
    $co = $this->conecta();
    try {
        $stmt = $co->prepare("DELETE FROM membresia WHERE id_membresia = ?");
        $stmt->execute([$this->id_membresia]);
        return "Membresía eliminada correctamente";
    } catch(Exception $e) { return "Error: " . $e->getMessage(); }
}

public function incluir_pago() {
    $co = $this->conecta();
    try {
        $stmt = $co->prepare("INSERT INTO metodos_pago (banco, cedula, telefono) VALUES (?, ?, ?)");
        $stmt->execute([post('banco'), post('cedula'), post('telefono')]);
        return "Método de pago registrado con éxito";
    } catch(Exception $e) { return "Error: " . $e->getMessage(); }
}

public function modificar_pago() {
    $co = $this->conecta();
    try {
        $stmt = $co->prepare("UPDATE metodos_pago SET banco=?, cedula=?, telefono=? WHERE id_metodo=?");
        $stmt->execute([$this->banco, $this->cedula_pago, $this->telefono_pago, $this->id_pago]);
        return "Método de pago actualizado";
    } catch(Exception $e) { return "Error: " . $e->getMessage(); }
}

public function obtener_pago() {
    $co = $this->conecta();
    $stmt = $co->prepare("SELECT * FROM metodos_pago WHERE id_metodo = ?");
    $stmt->execute([$this->id_pago]); 
    return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

public function consultar_pagos() {
    $co = $this->conecta();
    $resultado = $co->query("SELECT * FROM metodos_pago");
    $respuesta = '';
    foreach($resultado as $r) {
        $respuesta .= "<tr>
            <td>{$r['id_metodo']}</td>
            <td>{$r['banco']}</td>
            <td>{$r['cedula']}</td>
            <td>{$r['telefono']}</td>
            <td class='text-center'>
                <button class='btn btn-dark btn-sm rounded-0 fw-bold px-3 btn-consultar-pago' data-id='{$r['id_metodo']}'>CONSULTAR</button>
            </td>
        </tr>";
    }
    return $respuesta;
}

    public function eliminar_pago() {
    $co = $this->conecta();
    try {
        $stmt = $co->prepare("DELETE FROM metodos_pago WHERE id_metodo = ?");
        $stmt->execute([$this->id_pago]);
        return "Método de pago eliminado correctamente";
    } catch(Exception $e) { return "Error: " . $e->getMessage(); }
}
    
}
?>