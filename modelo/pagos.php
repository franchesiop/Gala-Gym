<?php
require_once('modelo/datos.php');

class metodos_pago extends datos {
    private $id_metodo, $banco, $cedula, $telefono;

    // setters
    function set_id_metodo($v) { $this->id_metodo = $v; }
    function set_banco($v) { $this->banco = $v; }
    function set_cedula($v) { $this->cedula = $v; }
    function set_telefono($v) { $this->telefono = $v; }

    // getters
    function get_id_metodo(){ return $this->id_metodo; }
    function get_banco(){ return $this->banco; }
    function get_cedula(){ return $this->cedula; }
    function get_telefono(){ return $this->telefono; }

    function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try{
            $inc = $co->prepare("INSERT INTO metodos_pago(banco, cedula, telefono) VALUES (:banco, :cedula, :telefono)");
            $inc->bindParam(':banco', $this->banco);
            $inc->bindParam(':cedula', $this->cedula);
            $inc->bindParam(':telefono', $this->telefono);
            $inc->execute();

            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Método Registrado';
        } catch(Exception $e){
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        
        return $r;
    }

    function modificar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        if($this->existe($this->id_metodo)){
            try{
                $mod = $co->prepare("UPDATE metodos_pago SET banco = :banco, cedula = :cedula, telefono = :telefono WHERE id_metodo = :id_metodo");

                $mod->bindParam(':banco', $this->banco);
                $mod->bindParam(':cedula', $this->cedula);
                $mod->bindParam(':telefono', $this->telefono);
                $mod->bindParam(':id_metodo', $this->id_metodo);
                $mod->execute();
                
                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Método Modificado';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'El Método de Pago No Existe';
        }
        return $r;
    }

    function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        if($this->existe($this->id_metodo)){
            try{
                // elminado logico
                $eli = $co->prepare("UPDATE metodos_pago SET status = 0 WHERE id_metodo = :id_metodo");
                $eli->bindParam(':id_metodo', $this->id_metodo);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Método Eliminado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'El Método de Pago No Existe';
        }
        return $r;
    }
    
    function consultar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try{
            $resultado = $co->query("SELECT * FROM metodos_pago WHERE status = 1");
            
            if($resultado){
                $respuesta = '';
                foreach($resultado as $fila){
                    $esZelle = (strtolower($fila['banco']) === 'zelle');
                    $etiquetaMetodo = $esZelle ? "ZELLE" : "PAGO MÓVIL";
                    $detalle = $esZelle ? $fila['telefono'] : $fila['banco']; 

                    $respuesta .= "<tr>";
                        $respuesta .= "<td style='display:none'>" . $fila['id_metodo'] . "</td>";
                       
                        $respuesta .= "<td style='display:none'>" . $fila['banco'] . "</td>";
                        $respuesta .= "<td style='display:none'>" . $fila['cedula'] . "</td>";
                        $respuesta .= "<td style='display:none'>" . $fila['telefono'] . "</td>";
                        
                        $respuesta .= "<td>" . $etiquetaMetodo . "</span></td>";
                        $respuesta .= "<td>" . $detalle . "</td>";
                        
                        $respuesta .= "<td>";
                            $respuesta .= "<div class='d-flex justify-content-center'>";
                            $respuesta .= "<button type='button' class='btn btn-dark text-white w-80 small-width m-1' onclick='pone(this)'><i class='bi bi-pencil-square'></i></button>";
                            $respuesta .= "<button type='button' class='btn btn-danger w-80 small-width m-1' onclick='eliminar(this)'><i class='bi bi-trash'></i></button>";
                            $respuesta .= "</div>";
                        $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }

                if($respuesta == ""){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td colspan = '4' class='text-center text-muted py-4'>";
                    $respuesta .= "<span><i class='bi bi-wallet2 fs-1' style='color: #17120b'></i></span>";
                    $respuesta .= "<h5 class= 'text-dashboard'> No hay métodos de pago registrados </h5>";
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

    function existe($id_metodo){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try{
            $resultado = $co->prepare("SELECT * FROM metodos_pago WHERE id_metodo = :id_metodo");
            $resultado->bindParam(':id_metodo', $id_metodo);
            $resultado->execute();
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            
            return ($fila) ? true : false;
        } catch(Exception $e){
            return false;
        }
    }
}
?>