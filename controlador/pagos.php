<?php
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new metodos_pago();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_id_metodo($_POST['id_metodo']);
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                // logica condicional de si es zelle o pago movil
                if($_POST['banco'] === 'Zelle'){
                    $o->set_banco('Zelle');
                    $o->set_cedula($_POST['correo_zelle']);
                    $o->set_telefono($_POST['titular_zelle']);
                } else {
                    $o->set_banco($_POST['nombre_banco']);
                    $o->set_cedula($_POST['cedula']);
                    $o->set_telefono($_POST['telefono']);
                }
                
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                $o->set_id_metodo($_POST['id_metodo']);
                
                // logica condicional de si es zelle o pago movil
                if($_POST['banco'] === 'Zelle'){
                    $o->set_banco('Zelle');
                    $o->set_cedula($_POST['correo_zelle']);
                    $o->set_telefono($_POST['titular_zelle']);
                } else {
                    $o->set_banco($_POST['nombre_banco']);
                    $o->set_cedula($_POST['cedula']);
                    $o->set_telefono($_POST['telefono']);
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