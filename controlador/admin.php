<?php
// verifica que exista el modelo
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit; // se detiene si no existe el modelo para evitar un error fatal
}
require_once("modelo/".$pagina.".php"); //carga la clase del modelo
// comprueba q exista la vista
if(is_file("vista/".$pagina.".php")){
    $o = new admin(); // instancia la clase del modelo que hereda la conexion con la BD
    
    // si se envía el formulario
    // Si el usuario envio un formulario por post y definió una accion
    if(!empty($_POST) && isset($_POST['accion'])){
        $accion = $_POST['accion'];

        switch($accion){
            case 'pdf_pagos':
                // encapsula las fechas recibidas desde la vista en los atributos privados del modelo
                $o->set_fecha_inicio($_POST['fecha_inicio']);
                $o->set_fecha_fin($_POST['fecha_fin']);
                // ejecuta el método del modelo encargado de consultar los pagos y generar el PDF
                $o->generarPDF_Pagos();
                exit; 
        }
    }
    
    // si no es un post, calcula los contadores para el dashboard
    $total_clientes = $o->contarClientes();
    $total_empleados = $o->contarEmpleados();
    $stats_pagos = $o->obtenerEstadisticasPagos();

    // carga de la vista inyectando las variables de arriba
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>