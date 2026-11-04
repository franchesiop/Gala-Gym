<?php
if(!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new entrada(); 
    
    if(!empty($_POST)){
        if(isset($_POST['accion']) && $_POST['accion'] == 'entrar'){
            $o->set_correo($_POST['correo']);
            $o->set_contrasena($_POST['contrasena']);
            
            $m = $o->existe();
            
            if($m['resultado'] == 'existe'){
                session_start(); 
                
            
                $_SESSION['rol'] = $m['id_rol'];
                $_SESSION['id_usuario'] = $m['id_usuario']; 
            }
            
           
            echo json_encode($m);
            exit(); 
        }
    }
    require_once("vista/".$pagina.".php"); 
} else {
    echo "Página en construcción";
}
?>