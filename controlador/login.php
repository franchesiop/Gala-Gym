<?php
session_start();

if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}  

require_once("modelo/".$pagina.".php");  

if(is_file("vista/".$pagina.".php")){
    
    $o = new $pagina(); 
    
    if(!empty($_POST)){
        
        $accion = $_POST['accion'];
        
        if($accion == 'ingresar'){
            $o->set_correo($_POST['correo']);
            $o->set_contrasena($_POST['contrasena']);

            // Llamamos al método ingresar() del modelo (que devuelve un arreglo)
            $respuesta = $o->ingresar();
            
            // Verificamos si el modelo indicó que el login fue un éxito
            if($respuesta['resultado'] == 'exito'){
                
                // Extraemos los datos del usuario del arreglo que envió el modelo
                $usuario = $respuesta['datos'];
                
                // Creamos las variables de sesión
                $_SESSION['id_empleado'] = $usuario['id_empleado'];
                $_SESSION['id_rol']      = $usuario['id_rol'];
                $_SESSION['nombre']      = $usuario['nombre'];
                
                $rol = $_SESSION['id_rol'];
                
                // Asignamos la ruta a la que JS debe redirigir según el rol
                if ($rol == 1) {
                    $respuesta['ruta'] = "?pagina=admin"; 
                } 
                elseif ($rol == 2) {
                    $respuesta['ruta'] = "?pagina=usuario_dashboard"; 
                } 
                elseif ($rol == 4) {
                    $respuesta['ruta'] = "?pagina=recepcion_dashboard"; 
                } 
                elseif ($rol == 5) {
                    $respuesta['ruta'] = "?pagina=entrenador_dashboard"; 
                } 
                else {
                    // Prevenir acceso si tiene un rol no mapeado
                    $respuesta['resultado'] = 'error';
                    $respuesta['mensaje'] = 'Rol desconocido o sin permisos.';
                }
                
                // Removemos los datos sensibles antes de enviar el JSON al frontend (opcional pero recomendado)
                unset($respuesta['datos']); 
            }
            
            // Imprimimos la respuesta en formato JSON para que el AJAX lo procese
            echo json_encode($respuesta);
        }
        exit;
    }
    
    require_once("vista/".$pagina.".php"); 
}
else{
    echo "pagina en construccion";
}
?>