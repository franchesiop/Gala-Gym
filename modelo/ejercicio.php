<?php
require_once('modelo/datos.php');

class ejercicio extends datos {
    private $id_ejercicio, $nombre_ejercicio, $descripcion_ejercicio, $imagen_ejercicio;

    function set_id_ejercicio($v) { $this->id_ejercicio = $v; }
    function set_nombre_ejercicio($v) { $this->nombre_ejercicio = $v; }
    function set_descripcion_ejercicio($v) { $this->descripcion_ejercicio = $v; }
    function set_imagen_ejercicio($v) { $this->imagen_ejercicio = $v; }
    
    function get_id_ejercicio(){ return $this->id_ejercicio; }
    function get_nombre_ejercicio(){ return $this->nombre_ejercicio; }
    function get_descripcion_ejercicio(){ return $this->descripcion_ejercicio; }
    function get_imagen_ejercicio(){ return $this->imagen_ejercicio; }

    private function subirImagen() {
        if($this->imagen_ejercicio != null && $this->imagen_ejercicio['error'] == 0) {
            $directorio = "img/ejercicios/";
            $extension = pathinfo($this->imagen_ejercicio['name'], PATHINFO_EXTENSION);
            $nombreArchivo = "ejercicio_" . time() . "_" . rand(100,999) . "." . $extension;
            $rutaDestino = $directorio . $nombreArchivo;
            
            if(move_uploaded_file($this->imagen_ejercicio['tmp_name'], $rutaDestino)) {
                return $rutaDestino;
            } else {
                throw new Exception("Error al guardar la imagen en el directorio del servidor.");
            }
        }
        return null;
    }

    function incluir(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        if(!$this->existe_nombre($this->nombre_ejercicio)){
            try{
                $rutaImagen = $this->subirImagen(); 

                $inc = $co->prepare("INSERT INTO ejercicio (nombre, descripcion, imagen) VALUES (:nombre, :descripcion, :imagen)");
                $inc->bindParam(':nombre', $this->nombre_ejercicio);
                $inc->bindParam(':descripcion', $this->descripcion_ejercicio);
                $inc->bindParam(':imagen', $rutaImagen);
                $inc->execute();

                $r['resultado'] = 'incluir';
                $r['mensaje'] = 'Ejercicio Registrado'; 
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'incluir'; 
            $r['mensaje'] = 'Ya existe un ejercicio con ese nombre';
        }
        return $r;
    }

    function modificar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        if($this->existe($this->id_ejercicio)){
            try{
                $rutaImagenNueva = $this->subirImagen();
                
                if($rutaImagenNueva != null) {
                    $buscaFoto = $co->prepare("SELECT imagen FROM ejercicio WHERE id_ejercicio = :id");
                    $buscaFoto->execute([':id' => $this->id_ejercicio]);
                    $fotoVieja = $buscaFoto->fetchColumn();
                    
                    if($fotoVieja && file_exists($fotoVieja) && $fotoVieja != 'img/default.jpg') {
                        unlink($fotoVieja);
                    }

                    $sql = "UPDATE ejercicio SET nombre = :nombre, descripcion = :descripcion, imagen = :imagen WHERE id_ejercicio = :id_ejercicio";
                    $mod = $co->prepare($sql);
                    $mod->bindParam(':imagen', $rutaImagenNueva);
                } else {
                    $sql = "UPDATE ejercicio SET nombre = :nombre, descripcion = :descripcion WHERE id_ejercicio = :id_ejercicio";
                    $mod = $co->prepare($sql);
                }

                $mod->bindParam(':id_ejercicio', $this->id_ejercicio);
                $mod->bindParam(':nombre', $this->nombre_ejercicio);
                $mod->bindParam(':descripcion', $this->descripcion_ejercicio);
                $mod->execute();
                
                $r['resultado'] = 'modificar';
                $r['mensaje'] = 'Ejercicio Modificado';
            } catch(Exception $e){
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'El Ejercicio No Existe';
        }
        return $r;
    }

    function eliminar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        if($this->existe($this->id_ejercicio)){
            try{
                $buscaFoto = $co->prepare("SELECT imagen FROM ejercicio WHERE id_ejercicio = :id");
                $buscaFoto->execute([':id' => $this->id_ejercicio]);
                $fotoVieja = $buscaFoto->fetchColumn();
                
                if($fotoVieja && file_exists($fotoVieja) && $fotoVieja != 'img/default.jpg') {
                    unlink($fotoVieja);
                }

                $eli = $co->prepare("DELETE FROM ejercicio WHERE id_ejercicio = :id_ejercicio");
                $eli->bindParam(':id_ejercicio', $this->id_ejercicio);
                $eli->execute();

                $r['resultado'] = 'eliminar';
                $r['mensaje'] = 'Ejercicio Eliminado';
            } catch(Exception $e) {
                $r['resultado'] = 'error';
                $r['mensaje'] = $e->getMessage();
            }
        } else{
            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'El Ejercicio No Existe';
        }
        return $r;
    }

    function consultar(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try{
            $resultado = $co->query("SELECT * FROM ejercicio ORDER BY id_ejercicio DESC");
            if($resultado){
                $respuesta = '';
                foreach($resultado as $fila){
                    $img = (!empty($fila['imagen']) && file_exists($fila['imagen'])) ? $fila['imagen'] : 'img/default.jpg';
                    $desc = !empty($fila['descripcion']) ? $fila['descripcion'] : 'Sin descripción';
                    $descHTML = !empty($fila['descripcion']) ? $fila['descripcion'] : '<span class="text-muted fst-italic">Sin descripción</span>';

                    $respuesta .= "<tr>";
                    $respuesta .= "<td style='display:none'>" . $fila['id_ejercicio'] . "</td>";
                    $respuesta .= "<td style='width: 80px;'><img src='" . $img . "' alt='ejercicio' style='width:45px; height:45px; object-fit:cover; border-radius:6px;' class='shadow-sm border'></td>";
                    $respuesta .= "<td>" . $fila['nombre'] . "</td>";
                    $respuesta .= "<td><div style='max-height: 45px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>" . $descHTML . "</div></td>";
                    $respuesta .= "<td style='display:none'>" . $desc . "</td>";
                    $respuesta .= "<td class='text-center' style='width: 120px;'>";
                    $respuesta .= "<div class='d-flex justify-content-center'>";
                    $respuesta .= "<button type='button' class='btn btn-dark text-white w-80 small-width m-1' onclick='pone(this)'><i class='bi bi-pencil-square'></i></button>";
                    $respuesta .= "<button type='button' class='btn btn-danger w-80 small-width m-1' onclick='eliminar(this)'><i class='bi bi-trash'></i></button>";
                    $respuesta .= "</div>";
                    $respuesta .= "</td>";
                    $respuesta .= "</tr>";
                }

                if($respuesta == ""){
                    $respuesta .= "<tr>";
                    $respuesta .= "<td colspan='6' class='text-center text-muted py-4'>";
                    $respuesta .= "<span><i class='bi bi-card-list fs-1' style='color: #17120b'></i></span>";
                    $respuesta .= "<h5 class='text-dashboard mt-2'> No hay Ejercicios Registrados </h5>";
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

    function existe($id_ejercicio){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM ejercicio WHERE id_ejercicio = :id_ejercicio");
            $resultado->bindParam(':id_ejercicio', $id_ejercicio);
            $resultado->execute();
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            return ($fila) ? true : false;
        } catch(Exception $e){
            return false;
        }
    }

    function existe_nombre($nombre){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $resultado = $co->prepare("SELECT * FROM ejercicio WHERE nombre = :nombre");
            $resultado->bindParam(':nombre', $nombre);
            $resultado->execute();
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            return ($fila) ? true : false;
        } catch(Exception $e){
            return false;
        }
    }
}
?>