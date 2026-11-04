<?php
// verifica que exista el modelo
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new admin();
    
    // di se envía el formulario
    if(!empty($_POST) && isset($_POST['accion'])){
        $accion = $_POST['accion'];

        switch($accion){
            case 'pdf_clientes':
                $membresia = isset($_POST['filtro_membresia']) ? $_POST['filtro_membresia'] : '';
                $o->set_filtro_membresia($membresia);
                $o->generarPDF_Clientes();
                exit; 

            case 'pdf_pagos':
                $o->set_fecha_inicio($_POST['fecha_inicio']);
                $o->set_fecha_fin($_POST['fecha_fin']);
                $o->generarPDF_Pagos();
                exit; 

            case 'pdf_empleados':
                $rol = isset($_POST['filtro_rol']) ? $_POST['filtro_rol'] : '';
                $o->set_filtro_rol($rol);
                $o->generarPDF_Empleados();
                exit; 
        }
    }
    
    // si no es un post, calcula los contadores para el dashboard
    $total_clientes = $o->contarClientes();
    $total_empleados = $o->contarEmpleados();

    // carga de la vista inyectando las variables de arriba
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>