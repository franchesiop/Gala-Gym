<?php
require_once('modelo/datos.php');

class pagos extends datos {
    private $id_metodo, $banco, $cedula, $telefono;

    //setters
    public function set_id_metodo($v) { $this->id_metodo = $v; }
    public function set_banco($v) { $this->banco = $v; }
    public function set_cedula($v) { $this->cedula = $v; }
    public function set_telefono($v) { $this->telefono = $v; }

    private function existe($id) {
        $co = $this->conecta();
        $stmt = $co->prepare("SELECT id_metodo FROM metodos_pago WHERE id_metodo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ? true : false;
    }

    public function incluir() {
        $co = $this->conecta();
        $r = ['resultado' => 'incluir', 'mensaje' => ''];
        try {
            $sql = "INSERT INTO metodos_pago (banco, cedula, telefono) VALUES (?, ?, ?)";
            $stmt = $co->prepare($sql);
            $stmt->execute([$this->banco, $this->cedula, $this->telefono]);
            $r['mensaje'] = 'Método de pago registrado correctamente';
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    public function modificar() {
        $co = $this->conecta();
        $r = ['resultado' => 'modificar', 'mensaje' => ''];
        if ($this->existe($this->id_metodo)) {
            try {
                $sql = "UPDATE metodos_pago SET banco=?, cedula=?, telefono=? WHERE id_metodo=?";
                $stmt = $co->prepare($sql);
                $stmt->execute([$this->banco, $this->cedula, $this->telefono, $this->id_metodo]);
                $r['mensaje'] = 'Método de pago modificado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else {
            $r['mensaje'] = 'No existe el registro para modificar';
        }
        return $r;
    }

    public function eliminar() {
        $co = $this->conecta();
        $r = ['resultado' => 'eliminar', 'mensaje' => ''];
        if ($this->existe($this->id_metodo)) {
            try {
                $stmt = $co->prepare("DELETE FROM metodos_pago WHERE id_metodo = ?");
                $stmt->execute([$this->id_metodo]);
                $r['mensaje'] = 'Método de pago eliminado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else {
            $r['mensaje'] = 'No existe el registro para eliminar';
        }
        return $r;
    }

        public function obtener_pago_array() {
        $co = $this->conecta();
        $sql = "SELECT * FROM metodos_pago WHERE id_metodo = ?";
        $stmt = $co->prepare($sql);
        $stmt->execute([$this->id_metodo]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
        $resultado['resultado'] = 'obtener_pago';
        return $resultado;
        } else {
        return ['resultado' => 'error', 'mensaje' => 'No encontrado'];
        }
    }
    public function consultar() {
        $co = $this->conecta();
        $r = ['resultado' => 'consultar', 'mensaje' => ''];
        try {
            $resultado = $co->query("SELECT * FROM metodos_pago");
            $respuesta = '';
            foreach($resultado as $r_row) {
                $respuesta .= "<tr>
                    <td>{$r_row['id_metodo']}</td>
                    <td>{$r_row['banco']}</td>
                    <td>{$r_row['cedula']}</td>
                    <td>{$r_row['telefono']}</td>
                    <td class='text-center'>
                        <button type='button' class='btn btn-sm btn-dark btn-consultar-pago fw-bold' data-id='{$r_row['id_metodo']}'>CONSULTAR</button>
                        
                    </td>
                </tr>";
            }
            $r['mensaje'] = $respuesta;
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
}