<?php
require_once('modelo/datos.php');

class membresias extends datos {
    private $id_membresia, $tipo, $monto;

    function set_id_membresia($v) { $this->id_membresia = $v; }
    function set_tipo($v) { $this->tipo = $v; }
    function set_monto($v) { $this->monto = $v; }

    function incluir() {
        $co = $this->conecta();
        try {
            $sql = "INSERT INTO membresia (tipo, monto) VALUES (?,?)";
            $co->prepare($sql)->execute([$this->tipo, $this->monto]);
            return ['resultado' => 'ok', 'mensaje' => 'Plan registrado exitosamente'];
        } catch(Exception $e) {
            return ['resultado' => 'error', 'mensaje' => $e->getMessage()];
        }
    }

    function modificar() {
        $co = $this->conecta();
        try {
            $sql = "UPDATE membresia SET tipo=?, monto=? WHERE id_membresia=?";
            $co->prepare($sql)->execute([$this->tipo, $this->monto, $this->id_membresia]);
            return ['resultado' => 'ok', 'mensaje' => 'Plan actualizado'];
        } catch(Exception $e) {
            return ['resultado' => 'error', 'mensaje' => $e->getMessage()];
        }
    }

    function eliminar() {
        $co = $this->conecta();
        try {
            $sql = "DELETE FROM membresia WHERE id_membresia = ?";
            $co->prepare($sql)->execute([$this->id_membresia]);
            return ['resultado' => 'ok', 'mensaje' => 'Plan eliminado'];
        } catch(Exception $e) {
            return ['resultado' => 'error', 'mensaje' => $e->getMessage()];
        }
    }

    function consultar() {
        $co = $this->conecta();
        $resultado = $co->query("SELECT * FROM membresia");
        $tabla = '';
        foreach($resultado as $f) {
            $tabla .= "<tr>
                <td>{$f['id_membresia']}</td>
                <td>{$f['tipo']}</td>
                <td>{$f['monto']}$</td>
                <td class='text-center'>
                    <button type='button' class='btn btn-sm btn-dark btn-modificar fw-bold'>CONSULTAR</button>
                </td>
            </tr>";
        }
        return ['resultado' => 'consultar', 'mensaje' => $tabla];
    }
}
?>