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

            $respuesta = $o->ingresar();
        
            if($respuesta['resultado'] == 'exito'){
                
                $usuario = $respuesta['datos'];
                $tipo_usuario = $respuesta['tipo_usuario']; 
                
                session_regenerate_id(true);

                if ($tipo_usuario == 'empleado') {
                    $_SESSION['id_empleado'] = $usuario['id_empleado'] ?? $usuario['cedula'];
                    $_SESSION['id_rol']      = $usuario['id_rol'];
                    $_SESSION['nombre']      = $usuario['nombre'];
                    
                    $rol = $_SESSION['id_rol'];
                    
                    if ($rol == 1) {
                        $respuesta['ruta'] = "?pagina=admin"; 
                    } elseif ($rol == 4) {
                        $respuesta['ruta'] = "?pagina=recepcion_dashboard"; 
                    } elseif ($rol == 5) {
                        $respuesta['ruta'] = "?pagina=entrenador"; 
                    } else {
                        $respuesta['resultado'] = 'error';
                        $respuesta['mensaje'] = 'Rol de empleado desconocido.';
                    }

                } else if ($tipo_usuario == 'cliente') {
            
                    $_SESSION['id_cliente'] = $usuario['id_cliente'] ?? $usuario['cedula']; 
                    $_SESSION['id_rol']     = 2;
                    $_SESSION['nombre']     = $usuario['nombre'];
                  
                    $respuesta['ruta'] = "?pagina=principal_cliente"; 
                }
                
                // remueve los datos sensibles
                unset($respuesta['datos']); 
                unset($respuesta['tipo_usuario']);
            }
            
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