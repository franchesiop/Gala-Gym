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
    $o = new rutinas();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_id_rutina($_POST['id_rutina']);
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                $o->set_nombre($_POST['nombreRutina']);
                $o->set_id_empleado($_SESSION['id_usuario']); 
                $o->set_id_cliente($_POST['idCliente']); 
                
                $ejercicios = isset($_POST['ejercicios']) ? $_POST['ejercicios'] : [];
                $series = isset($_POST['series']) ? $_POST['series'] : [];
                $repeticiones = isset($_POST['repeticiones']) ? $_POST['repeticiones'] : [];
                
                echo json_encode($o->incluir($ejercicios, $series, $repeticiones));
                break;

            case 'modificar':
                $o->set_id_rutina($_POST['idRutina']);
                $o->set_nombre($_POST['nombreRutina']);
                $o->set_id_empleado($_SESSION['id_usuario']); 
                $o->set_id_cliente($_POST['idCliente']); 
                
                $ejercicios = isset($_POST['ejercicios']) ? $_POST['ejercicios'] : [];
                $series = isset($_POST['series']) ? $_POST['series'] : [];
                $repeticiones = isset($_POST['repeticiones']) ? $_POST['repeticiones'] : [];
                
                echo json_encode($o->modificar($ejercicios, $series, $repeticiones));
                break;

            case 'consultar_detalles':
                $o->set_id_rutina($_POST['id_rutina']);
                echo json_encode($o->consultar_detalles());
                break;
                
            case 'listar_clientes': 
                echo json_encode($o->listar_todos_clientes()); 
                break;

            case 'listar_ejercicios':
                echo json_encode($o->listar_ejercicios());
                break;
        }
        exit();
    }
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>