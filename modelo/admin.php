<?php
require_once('dompdf/vendor/autoload.php'); 
use Dompdf\Dompdf; 
require_once('modelo/datos.php');

class admin extends datos {
    
    private $filtro_membresia;
    private $fecha_inicio;
    private $fecha_fin;
    private $filtro_rol;
    
    function set_filtro_membresia($v) { $this->filtro_membresia = $v; }
    function set_fecha_inicio($v) { $this->fecha_inicio = $v; }
    function set_fecha_fin($v) { $this->fecha_fin = $v; }
    function set_filtro_rol($v) { $this->filtro_rol = $v; }

    function contarClientes(){
        try {
            $co = $this->conecta();
            $sql = $co->query("SELECT COUNT(*) as total FROM cliente WHERE estado = 1");
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch(Exception $e) {
            return 0;
        }
    }

    function contarEmpleados(){
        try {
            $co = $this->conecta();
            $sql = $co->query("SELECT COUNT(*) as total FROM empleado WHERE estado = 1");
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch(Exception $e) {
            return 0;
        }
    }

    private function getEstilosPDF() {
        return '<style>
                    body { font-family: "Helvetica", "Arial", sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
                    .header { text-align: left; border-bottom: 2px solid #222; padding-bottom: 10px; margin-bottom: 20px; }
                    .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; color: #111; }
                    .header p { margin: 5px 0 0 0; color: #555; font-size: 12px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th { background-color: #f4f4f4; color: #333; font-weight: bold; border: 1px solid #ccc; text-align: left; padding: 8px; font-size: 12px; }
                    td { border: 1px solid #ccc; padding: 8px; color: #444; font-size: 12px; }
                    .total-row td { font-weight: bold; background-color: #f9f9f9; text-align: right; }
                    .footer { text-align: left; font-size: 10px; color: #999; position: fixed; bottom: -20px; width: 100%; border-top: 1px solid #eee; padding-top: 5px; }
                </style>';
    }

    function generarPDF_Clientes(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try{
            $sql = "SELECT c.cedula, c.nombre, c.apellido, c.telefono, m.tipo 
                    FROM cliente c 
                    LEFT JOIN membresia m ON c.id_membresia = m.id_membresia 
                    WHERE c.estado = 1";
            
            if(!empty($this->filtro_membresia)){
                $sql .= " AND c.id_membresia = :id_mem";
                $resultado = $co->prepare($sql);
                $resultado->bindParam(':id_mem', $this->filtro_membresia);
            } else {
                $resultado = $co->prepare($sql);
            }
            
            $resultado->execute();
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            $fecha = date("d/m/Y H:i");

            $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">'.$this->getEstilosPDF().'</head><body>';
            $html .= '<div class="header">
                        <h2>Reporte de Clientes Activos</h2>
                        <p>Gala Gym - Generado el: '.$fecha.'</p>
                      </div>';
            $html .= "<table><thead><tr>
                        <th>Cédula</th>
                        <th>Nombre y Apellido</th>
                        <th>Teléfono</th>
                        <th>Membresía</th>
                      </tr></thead><tbody>";
                      
            if($fila){
                foreach($fila as $f){
                    $html .= "<tr>";
                    $html .= "<td>".$f['cedula']."</td>";
                    $html .= "<td>".$f['nombre']." ".$f['apellido']."</td>";
                    $html .= "<td>".$f['telefono']."</td>";
                    $html .= "<td>".($f['tipo'] ? $f['tipo'] : 'Sin Membresía')."</td>";
                    $html .= "</tr>";
                }
            } else {
                $html .= "<tr><td colspan='4'>No hay clientes registrados o activos.</td></tr>";
            }
            
            $html .= "</tbody></table><div class='footer'>Documento generado por el Sistema Gala Gym</div></body></html>";
            
        } catch(Exception $e){
            $html = "Error: " . $e->getMessage();
        }
 
        $pdf = new DOMPDF();
        $pdf->set_paper("A4", "portrait");
        $pdf->load_html($html); 
        $pdf->render();
        $pdf->stream('Clientes_GalaGym.pdf', array("Attachment" => false));
    }


    function generarPDF_Empleados(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try{
            $sql = "SELECT e.cedula, e.nombre, e.apellido, e.telefono, r.nombre as rol 
                    FROM empleado e 
                    LEFT JOIN rol r ON e.id_rol = r.id_rol 
                    WHERE e.estado = 1";
            
            if(!empty($this->filtro_rol)){
                $sql .= " AND e.id_rol = :id_rol";
                $resultado = $co->prepare($sql);
                $resultado->bindParam(':id_rol', $this->filtro_rol);
            } else {
                $resultado = $co->prepare($sql);
            }
            
            $resultado->execute();
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            $fecha = date("d/m/Y H:i");
            
            $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">'.$this->getEstilosPDF().'</head><body>';
            $html .= '<div class="header">
                        <h2>Reporte de Personal (Staff)</h2>
                        <p>Gala Gym - Generado el: '.$fecha.'</p>
                      </div>';
            $html .= "<table><thead><tr>
                        <th>Cédula</th>
                        <th>Nombre y Apellido</th>
                        <th>Teléfono</th>
                        <th>Rol / Cargo</th>
                      </tr></thead><tbody>";
                      
            if($fila){
                foreach($fila as $f){
                    $html .= "<tr>";
                    $html .= "<td>".$f['cedula']."</td>";
                    $html .= "<td>".$f['nombre']." ".$f['apellido']."</td>";
                    $html .= "<td>".$f['telefono']."</td>";
                    $html .= "<td>".($f['rol'] ? $f['rol'] : 'Sin Rol')."</td>";
                    $html .= "</tr>";
                }
            } else {
                $html .= "<tr><td colspan='4'>No hay personal registrado o activo en este filtro.</td></tr>";
            }
            
            $html .= "</tbody></table><div class='footer'>Documento generado por el Sistema Gala Gym</div></body></html>";
            
        } catch(Exception $e){
            $html = "Error: " . $e->getMessage();
        }
 
        $pdf = new DOMPDF();
        $pdf->set_paper("A4", "portrait");
        $pdf->load_html($html); 
        $pdf->render();
        $pdf->stream('Staff_GalaGym.pdf', array("Attachment" => false));
    }


    function generarPDF_Pagos(){
        $co = $this->conecta();
        $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try{
            $sql = "SELECT p.fecha, p.monto, p.referencia, c.nombre, c.apellido, m.banco 
        FROM pago p 
        INNER JOIN cliente c ON p.id_cliente = c.id_cliente 
        INNER JOIN metodos_pago m ON p.id_metodo = m.id_metodo 
        WHERE p.fecha BETWEEN :f_inicio AND :f_fin 
        AND p.estado_pago = 1 
        ORDER BY p.fecha DESC";
                    
            $resultado = $co->prepare($sql);
            $resultado->bindParam(':f_inicio', $this->fecha_inicio);
            $resultado->bindParam(':f_fin', $this->fecha_fin);
            $resultado->execute();
            
            $fila = $resultado->fetchAll(PDO::FETCH_BOTH);
            $total_ingresos = 0;
            $fecha_gen = date("d/m/Y H:i");

            $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">'.$this->getEstilosPDF().'</head><body>';
            $html .= '<div class="header">
                        <h2>Reporte de Pagos e Ingresos</h2>
                        <p>Gala Gym - Rango: '.$this->fecha_inicio.' al '.$this->fecha_fin.' | Generado el: '.$fecha_gen.'</p>
                      </div>';
            $html .= "<table><thead><tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Banco</th>
                        <th>Referencia</th>
                        <th>Monto ($)</th>
                      </tr></thead><tbody>";
                      
            if($fila){
                foreach($fila as $f){
                    $html .= "<tr>";
                    $html .= "<td>".$f['fecha']."</td>";
                    $html .= "<td>".$f['nombre']." ".$f['apellido']."</td>";
                    $html .= "<td>".$f['banco']."</td>";
                    $html .= "<td>".$f['referencia']."</td>";
                    $html .= "<td>$".number_format($f['monto'], 2)."</td>";
                    $html .= "</tr>";
                    $total_ingresos += $f['monto'];
                }
                $html .= "<tr class='total-row'>
                            <td colspan='4'>TOTAL INGRESADO:</td>
                            <td>$".number_format($total_ingresos, 2)."</td>
                          </tr>";
            } else {
                $html .= "<tr><td colspan='5'>No hay pagos en este rango de fechas.</td></tr>";
            }
            
            $html .= "</tbody></table><div class='footer'>Documento generado por el Sistema Gala Gym</div></body></html>";
            
        } catch(Exception $e){
            $html = "Error: " . $e->getMessage();
        }
 
        $pdf = new DOMPDF();
        $pdf->set_paper("A4", "portrait");
        $pdf->load_html($html); 
        $pdf->render();
        $pdf->stream('Pagos_GalaGym.pdf', array("Attachment" => false));
    }
}
?>