<?php
require_once('modelo/datos.php');

class registro extends datos {
    //atributos privados 
    private $cedula;
    private $nombre;
    private $apellido;
    private $telefono;
    private $correo;
    private $contrasena;

    //setters
    function set_cedula($valor){ $this->cedula = $valor; }
    function set_nombre($valor){ $this->nombre = $valor; }
    function set_apellido($valor){ $this->apellido = $valor; }
    function set_telefono($valor){ $this->telefono = $valor; }
    function set_correo($valor){ $this->correo = $valor; }
    function set_contrasena($valor){ $this->contrasena = $valor; }

    //función incluir 
    function incluir(){
        if(!$this->existe($this->cedula)){
            $co = $this->conecta();
            try {
                $co->query("Insert into CLIENTE(cedula, nombre, apellido, telefono, correo, contrasena)
                    Values('$this->cedula', '$this->nombre', '$this->apellido', 
                    '$this->telefono', '$this->correo', '$this->contrasena')");
                return "Registro incluido";
            } catch(Exception $e) {
                return $e->getMessage();
            }
        } else {
            return "Ya existe la cedula que desea ingresar";
        }
    }

    function modificar(){
        $co = $this->conecta();
        if($this->existe($this->cedula)){
            try {
                $co->query("Update CLIENTE set nombre='$this->nombre', apellido='$this->apellido', 
                    telefono='$this->telefono', correo='$this->correo' where cedula='$this->cedula'");
                return "Registro Modificado";
            } catch(Exception $e) {
                return $e->getMessage();
            }
        } else { return "Cedula no registrada"; }
    }

    function eliminar(){
        $co = $this->conecta();
        if($this->existe($this->cedula)){
            try {
                $co->query("Delete from CLIENTE where cedula = '$this->cedula'");
                return "Registro Eliminado";
            } catch(Exception $e) {
                return $e->getMessage();
            }
        } else { return "Cedula no registrada"; }
    }

    function consultar(){
        $co = $this->conecta();
        try {
            $resultado = $co->query("Select * from CLIENTE");
            if($resultado){
                $respuesta = '';
                foreach($resultado as $r){
                    $respuesta .= "<tr style='cursor:pointer' onclick='coloca(this);'>";
                    $respuesta .= "<td>".$r['cedula']."</td>";
                    $respuesta .= "<td>".$r['nombre']."</td>";
                    $respuesta .= "<td>".$r['apellido']."</td>";
                    $respuesta .= "<td>".$r['correo']."</td>";
                    $respuesta .= "<td>".$r['telefono']."</td>";
                    $respuesta .= "</tr>";
                }
                return $respuesta;
            }
        } catch(Exception $e) { return $e->getMessage(); }
    }

    private function existe($cedula){
        $co = $this->conecta();
        $resultado = $co->query("Select * from CLIENTE where cedula='$cedula'");
        $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
        return $fila ? true : false;
    }

    function consultatr(){
        $co = $this->conecta();
        try {
            $resultado = $co->query("Select * from CLIENTE where cedula='$this->cedula'");
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            if($fila){
                $envia = array('resultado'=>"encontro");
                $envia += $fila;
                return json_encode($envia);
            } else {
                return json_encode(array('resultado'=>"noencontro"));
            }
        } catch(Exception $e){ return json_encode(array('resultado'=>$e->getMessage())); }
    }
}
?>