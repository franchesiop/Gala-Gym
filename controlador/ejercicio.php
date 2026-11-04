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
                $o->set_descripcion_ejercicio(isset($_POST['descripcion_ejercicio']) ? $_POST['descripcion_ejercicio'] : '');
                
                // Si viene un archivo y no está vacío, lo mandamos al modelo
                if(isset($_FILES['imagen_ejercicio']) && $_FILES['imagen_ejercicio']['name'] != ''){
                    $o->set_imagen_ejercicio($_FILES['imagen_ejercicio']);
                } else {
                    $o->set_imagen_ejercicio(null);
                }

                echo json_encode($o->incluir());
                break;

            case 'modificar':
                $o->set_id_ejercicio($_POST['id_ejercicio']);
                $o->set_nombre_ejercicio($_POST['nombre_ejercicio']);
                $o->set_descripcion_ejercicio(isset($_POST['descripcion_ejercicio']) ? $_POST['descripcion_ejercicio'] : '');
                
                if(isset($_FILES['imagen_ejercicio']) && $_FILES['imagen_ejercicio']['name'] != ''){
                    $o->set_imagen_ejercicio($_FILES['imagen_ejercicio']);
                } else {
                    $o->set_imagen_ejercicio(null);
                }

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