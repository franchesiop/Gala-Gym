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
                $o->set_cedulaEmpleado($_POST['cedulaEmpleado']);
                $o->set_nombreEmpleado($_POST['nombreEmpleado']);
                $o->set_apellidoEmpleado($_POST['apellidoEmpleado']);
                $o->set_tlfEmpleado($_POST['tlfEmpleado']);
                $o->set_correoEmpleado($_POST['correoEmpleado']);
                $o->set_contraEmpleado($_POST['contraEmpleado']);
                $o->set_rolEmpleado($_POST['rolEmpleado']);
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                $o->set_cedulaEmpleado($_POST['cedulaEmpleado']);
                $o->set_nombreEmpleado($_POST['nombreEmpleado']);
                $o->set_apellidoEmpleado($_POST['apellidoEmpleado']);
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