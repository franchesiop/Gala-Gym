<?php
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new empleados();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_cedulaEmpleado($_POST['cedulaEmpleado']);
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                // 1. Formateamos Nombre y Apellido: 1ra letra mayúscula, resto minúscula
                $nombreFormateado = ucfirst(strtolower($_POST['nombreEmpleado']));
                $apellidoFormateado = ucfirst(strtolower($_POST['apellidoEmpleado']));

                // 2. Le pasamos las variables formateadas al modelo
                $o->set_cedulaEmpleado($_POST['cedulaEmpleado']);
                $o->set_nombreEmpleado($nombreFormateado);
                $o->set_apellidoEmpleado($apellidoFormateado);
                
                $o->set_tlfEmpleado($_POST['tlfEmpleado']);
                $o->set_correoEmpleado($_POST['correoEmpleado']);
                $o->set_contraEmpleado($_POST['contraEmpleado']);
                $o->set_rolEmpleado($_POST['rolEmpleado']);
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                // 1. Formateamos Nombre y Apellido: 1ra letra mayúscula, resto minúscula
                $nombreFormateado = ucfirst(strtolower($_POST['nombreEmpleado']));
                $apellidoFormateado = ucfirst(strtolower($_POST['apellidoEmpleado']));

                // 2. Le pasamos las variables formateadas al modelo
                $o->set_cedulaEmpleado($_POST['cedulaEmpleado']);
                $o->set_nombreEmpleado($nombreFormateado);
                $o->set_apellidoEmpleado($apellidoFormateado);
                
                $o->set_tlfEmpleado($_POST['tlfEmpleado']);
                $o->set_correoEmpleado($_POST['correoEmpleado']);
                $o->set_contraEmpleado($_POST['contraEmpleado']);
                $o->set_rolEmpleado($_POST['rolEmpleado']);
                echo json_encode($o->modificar());
                break;

            case 'listar_roles':
             echo json_encode($o->listar_roles());
             break;
        }
        exit();
    }
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>