<?php 
/*session_start();
// definimos la página por defecto si no viene ninguna por utl
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'login';

// si no hay un id de empleado guardado en la sesión, 
// y la persona está intentando entrar a una pagina que no sea el login o el registro
if (!isset($_SESSION['id_empleado']) && $pagina != 'login' && $pagina != 'registro') {
    // lo pateamos de vuelta al login
    header("Location: ?pagina=login");
    exit();
} */
$pagina = "principal"; 

 if (!empty($_GET['pagina'])){ 
   $pagina = $_GET['pagina']; 
 }
 

 if(is_file("controlador/".$pagina.".php")){ 
 
    require_once("controlador/".$pagina.".php");
 }
 else{
    echo "PAGINA EN CONSTRUCCIÓN";
 }
 
?> 