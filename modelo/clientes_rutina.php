<?php
require_once('modelo/datos.php');

class clientes_rutina extends datos {
    private $id_rutina, $nombre_rutina, $id_cliente;

    // setters
    function set_id_rutina($v) { $this->id_rutina = $v; }
    function set_nombre_rutina($v) { $this->nombre_rutina = $v; }
    function set_id_cliente($v) { $this->id_cliente = $v; }

    // getters
    function get_id_rutina() { return $this->id_rutina; }
    function get_nombre_rutina() { return $this->nombre_rutina; }
    function get_id_cliente() { return $this->id_cliente; }

    function listar_ejercicios() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $datos = [];
        try {
            $resultado = $co->query("SELECT id_ejercicio, nombre FROM ejercicio");
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC); 
        } catch(Exception $e) {
            $datos = [];
        }
        return $datos;
    }

    function consultar() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try {
            // extrae los datos de racha del cliente primero
            $stmtCliente = $co->prepare("SELECT racha_actual, fecha_ultimo_entrenamiento, CURDATE() as hoy, DATEDIFF(CURDATE(), fecha_ultimo_entrenamiento) as dias_diferencia FROM cliente WHERE id_cliente = :id_cliente");
            $stmtCliente->bindParam(':id_cliente', $this->id_cliente);
            $stmtCliente->execute();
            $datosCliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);
            
            $r['racha_actual'] = $datosCliente['racha_actual'] ? $datosCliente['racha_actual'] : 0;
            $r['fecha_ultimo_entrenamiento'] = $datosCliente['fecha_ultimo_entrenamiento'];
            $r['dias_diferencia'] = $datosCliente['dias_diferencia'] === null ? 99 : (int)$datosCliente['dias_diferencia'];
            
            // extrae las rutinas 
            $sql = "SELECT id_rutina, nombre FROM rutina WHERE id_cliente = :id_cliente";
            $stmt = $co->prepare($sql);
            $stmt->bindParam(':id_cliente', $this->id_cliente);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $respuesta = '';
            if($resultado){
                foreach($resultado as $fila){
                    $respuesta .= '<div class="col-md-6 col-lg-4">';
                    $respuesta .= '<div class="card h-100 border-0 shadow-sm rounded-4 bg-white">';
                    $respuesta .= '<div class="card-body p-4 d-flex flex-column">';
                    $respuesta .= '<h5 class="fw-bold text-uppercase text-dark mb-1">'.$fila['nombre'].'</h5>';
                    $respuesta .= '<p class="text-muted small mb-4">Rutina personalizada</p>';
                    $respuesta .= '<div class="mt-auto d-flex justify-content-between align-items-center gap-2">';
                    $respuesta .= '<button class="btn btn-dark rounded-3 fw-bold small flex-grow-1" onclick="abrirEntrenamiento('.$fila['id_rutina'].', \''.$fila['nombre'].'\')"><i class="bi bi-play-fill me-1"></i> ENTRENAR</button>';
                    $respuesta .= '<button class="btn btn-light border rounded-3 p-2 text-dark" onclick="editarRutina('.$fila['id_rutina'].')" title="Editar"><i class="bi bi-pencil-square"></i></button>';
                    $respuesta .= '<button class="btn btn-light border rounded-3 p-2 text-danger" onclick="modalEliminarRutina('.$fila['id_rutina'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>';
                    $respuesta .= '</div>';
                    $respuesta .= '</div>';
                    $respuesta .= '</div>';
                    $respuesta .= '</div>';
                }
            } else {
                $respuesta .= '<div class="col-12 text-center py-5">';
                $respuesta .= '<i class="bi bi-clipboard2-x fs-1 text-muted mb-3 d-block"></i>';
                $respuesta .= '<h5 class="text-muted fw-bold">No tienes rutinas registradas</h5>';
                $respuesta .= '<p class="text-muted small">Haz clic en "Nueva Rutina" para comenzar.</p>';
                $respuesta .= '</div>';
            }

            $r['resultado'] = 'consultar';
            $r['mensaje'] = $respuesta;
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function incluir($arrEjercicios, $arrSeries, $arrReps) {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            $co->beginTransaction(); 

            $incRutina = $co->prepare("INSERT INTO rutina(nombre, id_cliente) VALUES (:nombre, :id_cliente)");
            $incRutina->bindParam(':nombre', $this->nombre_rutina);
            $incRutina->bindParam(':id_cliente', $this->id_cliente);
            $incRutina->execute();

            $idRutinaGenerado = $co->lastInsertId();

            $incDetalle = $co->prepare("INSERT INTO detalleRutina(id_rutina, id_ejercicio, series, repeticiones) VALUES (:id_rutina, :id_ejercicio, :series, :reps)");
            
            for ($i = 0; $i < count($arrEjercicios); $i++) {
                $incDetalle->bindParam(':id_rutina', $idRutinaGenerado);
                $incDetalle->bindParam(':id_ejercicio', $arrEjercicios[$i]);
                $incDetalle->bindParam(':series', $arrSeries[$i]);
                $incDetalle->bindParam(':reps', $arrReps[$i]);
                $incDetalle->execute();
            }

            $co->commit(); 

            $r['resultado'] = 'incluir';
            $r['mensaje'] = 'Rutina Registrada';
        } catch(Exception $e) {
            $co->rollBack(); 
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function modificar($arrEjercicios, $arrSeries, $arrReps) {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            $co->beginTransaction();

            $modRutina = $co->prepare("UPDATE rutina SET nombre = :nombre WHERE id_rutina = :id_rutina AND id_cliente = :id_cliente");
            $modRutina->bindParam(':nombre', $this->nombre_rutina);
            $modRutina->bindParam(':id_rutina', $this->id_rutina);
            $modRutina->bindParam(':id_cliente', $this->id_cliente); 
            $modRutina->execute();

            $delDetalle = $co->prepare("DELETE FROM detalleRutina WHERE id_rutina = :id_rutina");
            $delDetalle->bindParam(':id_rutina', $this->id_rutina);
            $delDetalle->execute();

            $incDetalle = $co->prepare("INSERT INTO detalleRutina(id_rutina, id_ejercicio, series, repeticiones) VALUES (:id_rutina, :id_ejercicio, :series, :reps)");
            
            for ($i = 0; $i < count($arrEjercicios); $i++) {
                $incDetalle->bindParam(':id_rutina', $this->id_rutina);
                $incDetalle->bindParam(':id_ejercicio', $arrEjercicios[$i]);
                $incDetalle->bindParam(':series', $arrSeries[$i]);
                $incDetalle->bindParam(':reps', $arrReps[$i]);
                $incDetalle->execute();
            }

            $co->commit();

            $r['resultado'] = 'modificar';
            $r['mensaje'] = 'Rutina Modificada';
        } catch(Exception $e) {
            $co->rollBack();
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function eliminar() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        try {
            $eli = $co->prepare("DELETE FROM rutina WHERE id_rutina = :id_rutina AND id_cliente = :id_cliente");
            $eli->bindParam(':id_rutina', $this->id_rutina);
            $eli->bindParam(':id_cliente', $this->id_cliente);
            $eli->execute();

            $r['resultado'] = 'eliminar';
            $r['mensaje'] = 'Rutina Eliminada';
        } catch(Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    function consultar_rutina_id() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $data = [];
        
        try {
            $stmtRutina = $co->prepare("SELECT id_rutina, nombre FROM rutina WHERE id_rutina = :id_rutina AND id_cliente = :id_cliente");
            $stmtRutina->bindParam(':id_rutina', $this->id_rutina);
            $stmtRutina->bindParam(':id_cliente', $this->id_cliente);
            $stmtRutina->execute();
            $rutina = $stmtRutina->fetch(PDO::FETCH_ASSOC);

            if($rutina){
                $data['id_rutina'] = $rutina['id_rutina'];
                $data['nombre'] = $rutina['nombre'];
                $data['ejercicios'] = [];

                $sqlEjercicios = "SELECT d.id_ejercicio, d.series, d.repeticiones as reps, 
                                         e.nombre as nombre_ejercicio, e.descripcion, e.imagen 
                                  FROM detalleRutina d 
                                  INNER JOIN ejercicio e ON d.id_ejercicio = e.id_ejercicio 
                                  WHERE d.id_rutina = :id_rutina";
                
                $stmtDetalle = $co->prepare($sqlEjercicios);
                $stmtDetalle->bindParam(':id_rutina', $this->id_rutina);
                $stmtDetalle->execute();
                
                $data['ejercicios'] = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch(Exception $e) {
        }
        return $data;
    }

    // calculay u actualizar racha
    function calcularRacha() {
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $r = array();
        
        try {
            $co->beginTransaction();
            
            // obtiene el id del cliente dueño de esta rutina
            $stmtRutina = $co->prepare("SELECT id_cliente FROM rutina WHERE id_rutina = :id_rutina");
            $stmtRutina->bindParam(':id_rutina', $this->id_rutina);
            $stmtRutina->execute();
            $rutina = $stmtRutina->fetch(PDO::FETCH_ASSOC);

            if(!$rutina) {
                throw new Exception("Rutina no encontrada.");
            }
            $idCliente = $rutina['id_cliente'];

            // busca la racha y fecha actual del cliente
            $stmt = $co->prepare("SELECT racha_actual, fecha_ultimo_entrenamiento FROM cliente WHERE id_cliente = :id_cliente");
            $stmt->bindParam(':id_cliente', $idCliente);
            $stmt->execute();
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$cliente) {
                throw new Exception("Cliente no encontrado.");
            }

            // evalua la diferencia de dias
            $stmtDiff = $co->query("SELECT CURDATE() as hoy, DATEDIFF(CURDATE(), '".$cliente['fecha_ultimo_entrenamiento']."') as dias_diferencia");
            $fechas = $stmtDiff->fetch(PDO::FETCH_ASSOC);
            
            $dias_diff = $fechas['dias_diferencia'];
            $hoy = $fechas['hoy'];
            $nueva_racha = $cliente['racha_actual'] ? (int)$cliente['racha_actual'] : 0;

            if ($cliente['fecha_ultimo_entrenamiento'] == null || $dias_diff >= 2) {
                // falto 2 dias o mas o es su primer entrenamiento reiniciar a 1
                $nueva_racha = 1;
            } else if ($dias_diff == 1) {
                // entrenó ayer sumar 1 dia a la racha
                $nueva_racha += 1;
            } 
            // si dias_diff == 0 (Ya le dio clic hoy) la racha se queda igual

            // Actualiza el registro del cliente
            $upd = $co->prepare("UPDATE cliente SET racha_actual = :racha, fecha_ultimo_entrenamiento = :hoy WHERE id_cliente = :id_cliente");
            $upd->bindParam(':racha', $nueva_racha);
            $upd->bindParam(':hoy', $hoy);
            $upd->bindParam(':id_cliente', $idCliente);
            $upd->execute();
            
            $co->commit();
            
            $r['estado'] = 'exito';
            $r['racha'] = $nueva_racha;
            
        } catch(Exception $e) {
            $co->rollBack();
            $r['estado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        
        return $r;
    }
}
?>