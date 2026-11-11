<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new clientes_rutina(); 
    
    if(!empty($_POST)){
        $accion = isset($_POST['accion']) ? $_POST['accion'] : (isset($_POST['accionRutina']) ? $_POST['accionRutina'] : '');

        switch($accion){

            case 'consultar':
                $o->set_id_cliente($_SESSION['id_usuario']);
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_id_rutina($_POST['id_rutina']);
                $o->set_id_cliente($_SESSION['id_usuario']); 
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                $o->set_nombre_rutina($_POST['nombre_rutina']);
                $o->set_id_cliente($_SESSION['id_usuario']); 
                
                $ejercicios = isset($_POST['id_ejercicio']) ? $_POST['id_ejercicio'] : [];
                $series = isset($_POST['series']) ? $_POST['series'] : [];
                $repeticiones = isset($_POST['reps']) ? $_POST['reps'] : [];
                
                echo json_encode($o->incluir($ejercicios, $series, $repeticiones));
                break;

            case 'modificar':
                $o->set_id_rutina($_POST['id_rutina']);
                $o->set_nombre_rutina($_POST['nombre_rutina']);
                $o->set_id_cliente($_SESSION['id_usuario']);
                
                $ejercicios = isset($_POST['id_ejercicio']) ? $_POST['id_ejercicio'] : [];
                $series = isset($_POST['series']) ? $_POST['series'] : [];
                $repeticiones = isset($_POST['reps']) ? $_POST['reps'] : [];
                
                echo json_encode($o->modificar($ejercicios, $series, $repeticiones));
                break;

            case 'listar_ejercicios':
                echo json_encode($o->listar_ejercicios());
                break;
                
            case 'consultar_rutina_id': 
                $o->set_id_rutina($_POST['id_rutina']);
                $o->set_id_cliente($_SESSION['id_usuario']); 
                echo json_encode($o->consultar_rutina_id());
                break;
                
            case 'marcar_hecha':
                $o->set_id_rutina($_POST['id_rutina']);
                echo json_encode($o->calcularRacha());
                break;
        }
        exit();
    }
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>