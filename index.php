<?php 
$pagina = "principal"; 

if (!empty($_GET['pagina'])){ 
    $pagina = $_GET['pagina']; 
}

$nivel = ""; // VARIABLE QUE VA A CONTENER EL VALOR DE LA SESSION

// SE LLAMA A LA CLASE VERIFICA
if(is_file("modelo/verifica.php")){
    require_once("modelo/verifica.php");    
    
    // SE INSTANCIA EL OBJETO
    $v = new verifica();
    
    // verifica si la peticion es para cerrar sesión
    if($pagina == 'salida'){
        $v->destruyesesion();
    }
    else{
        // se lee el rol del usuario logueado
        $nivel = $v->leesesion();
    }
}

// BLOQUEAR A LOS QUE NO TIENEN SESIÓN
if($nivel == "" && $pagina != "login" && $pagina != "registro" && $pagina != "principal"){
    $pagina = "login";
}

// REDIRIGIR A LOS QUE YA INICIARON SESIÓN Y ENTRAN A LA RAÍZ O AL LOGIN
if($nivel != "" && ($pagina == "login" || $pagina == "principal")) {
    switch($nivel){
        case 1: // Administrador
        case 4: // Recepcionista
            $pagina = "admin";
            break;
        case 5: // Entrenador
            $pagina = "clientes"; 
            break;
        case 2: // Usuario (Cliente)
            $pagina = "clientes_rutina";
            break;
        default:
            $pagina = "login";
            break;
    }
}

// CANDADO DE SEGURIDAD POR URL (Evita que un rol entre a un módulo que no le toca)
if($nivel != ""){
    // si intenta entrar a 'admin' y no es administrador ni recepcionista
    if($pagina == "admin" && ($nivel != 1 && $nivel != 4)){
        $pagina = ($nivel == 5) ? "clientes" : "clientes_rutina"; 
    }
    
    // si un cliente intenta entrar a modulos de los empleados
    if(($pagina == "clientes" || $pagina == "rutinas" || $pagina == "empleados") && $nivel == 2){
        $pagina = "principal_cliente";
    }
}

// CARGA DEL CONTROLADOR FINAL
if(is_file("controlador/".$pagina.".php")){ 
    require_once("controlador/".$pagina.".php");
}
else{
    echo "PÁGINA EN CONSTRUCCIÓN";
}
?>