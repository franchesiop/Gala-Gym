<?php
// si el usuario ya está logueado y trata de entrar al login lo pateamos pal panel
session_start();
if(isset($_SESSION['id_empleado']) && empty($_POST)){
    header("Location: ?pagina=admin"); 
    exit();
}

if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new login();
    
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        if($accion == 'ingresar'){
            $o->set_correo($_POST['correo']);
            $o->set_contrasena($_POST['contrasena']);
            
            echo json_encode($o->ingresar());
            exit();
        }
    }
    
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>