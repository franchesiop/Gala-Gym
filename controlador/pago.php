<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new pago();
    
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){
            case 'listar_membresias':
                echo json_encode($o->listar_membresias());
                break;

            case 'listar_metodos':
                echo json_encode($o->listar_metodos());
                break;

            case 'incluir':
                
                $id_cliente = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 0;
                
                $o->set_idCliente($id_cliente);
                $o->set_idMembresia($_POST['id_membresia']);
                $o->set_cantidadPeriodos($_POST['cantidad']);
                $o->set_idMetodo($_POST['id_metodo']);
                $o->set_monto($_POST['monto']);
                $o->set_referencia($_POST['referencia']);
                
                echo json_encode($o->incluir());
                break;
        }
        exit(); 
    }
    
    require_once("vista/".$pagina.".php"); 
} else {
    echo "Página en construcción";
}
?>