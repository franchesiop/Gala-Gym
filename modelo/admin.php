<?php
require_once('dompdf/vendor/autoload.php'); // importamos la libreria para volver el html a pdf
use Dompdf\Dompdf; 
require_once('modelo/datos.php');

// aqui se hereda la conexion PDO a la bd
class admin extends datos {
    // encapsulamiento
    private $fecha_inicio;
    private $fecha_fin;
     // métodos set_* públicos con los que controlador/admin.php le 
     // transfiere las fechas recibidas del formulario
    function set_fecha_inicio($v) { $this->fecha_inicio = $v; }
    function set_fecha_fin($v) { $this->fecha_fin = $v; }

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

    function obtenerEstadisticasPagos(){
        try {
            $co = $this->conecta();
            // Calcula los totales y cuenta los estados en una sola consulta
            $sql = $co->query("SELECT 
                SUM(CASE WHEN estado_pago = 1 THEN monto ELSE 0 END) as total_ingresos,
                AVG(CASE WHEN estado_pago = 1 THEN monto ELSE 0 END) as promedio_ingresos,
                SUM(CASE WHEN estado_pago = 1 THEN 1 ELSE 0 END) as aprobados,
                SUM(CASE WHEN estado_pago = 0 THEN 1 ELSE 0 END) as pendientes,
                SUM(CASE WHEN estado_pago = 2 THEN 1 ELSE 0 END) as rechazados
                FROM pago");
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
            
            // Validar nulos si la tabla está vacía
            if(!$resultado['total_ingresos']) $resultado['total_ingresos'] = 0;
            if(!$resultado['promedio_ingresos']) $resultado['promedio_ingresos'] = 0;
            if(!$resultado['aprobados']) $resultado['aprobados'] = 0;
            if(!$resultado['pendientes']) $resultado['pendientes'] = 0;
            if(!$resultado['rechazados']) $resultado['rechazados'] = 0;
            
            return $resultado;
        } catch(Exception $e) {
            return array('total_ingresos'=>0, 'promedio_ingresos'=>0, 'aprobados'=>0, 'pendientes'=>0, 'rechazados'=>0);
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
                $html .= "<tr><td colspan='5'>No hay pagos aprobados en este rango de fechas.</td></tr>";
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