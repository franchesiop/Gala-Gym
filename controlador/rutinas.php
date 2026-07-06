<?php
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
	exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new rutinas();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_idRutina($_POST['idRutina']);
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                $o->set_idRutina($_POST['idRutina']);
                $o->set_nombreRutina($_POST['nombreRutina']);
                $o->set_idEmpleado($_POST['idEmpleado']);
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                $o->set_idRutina($_POST['idRutina']);
                $o->set_nombreRutina($_POST['nombreRutina']);
                $o->set_idEmpleado($_POST['idEmpleado']);
                echo json_encode($o->modificar());
                break;

        }
        exit();
    }
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>