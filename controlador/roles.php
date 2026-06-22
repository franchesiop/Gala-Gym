<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
	exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new roles();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_idRol($_POST['idRol']);
                
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                
                $o->set_nombreRol($_POST['nombreRol']);
                $o->set_descripcion($_POST['descripcion']);
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                $o->set_idRol($_POST['idRol']);
                $o->set_nombreRol($_POST['nombreRol']);
                $o->set_descripcion($_POST['descripcion']);
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