<?php
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
	exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new membresias();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_id_membresia($_POST['id_membresia']);
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                $o->set_tipo($_POST['tipo']);
                $o->set_monto($_POST['monto']);
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                $o->set_id_membresia($_POST['id_membresia']);
                $o->set_tipo($_POST['tipo']);
                $o->set_monto($_POST['monto']);
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