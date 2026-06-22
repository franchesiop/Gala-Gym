<?php
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
	exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new ejercicio();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_id_ejercicio($_POST['id_ejercicio']);
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                $o->set_nombre_ejercicio($_POST['nombre_ejercicio']);
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                $o->set_id_ejercicio($_POST['id_ejercicio']);
                $o->set_nombre_ejercicio($_POST['nombre_ejercicio']);
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