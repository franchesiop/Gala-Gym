<?php

require_once("modelo/admin.php");
$admin = new admin();

function post($key) {
    return isset($_POST[$key]) ? $_POST[$key] : "";
}

// peticiones ajax
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    // asignacion de datos al modelo
    
    if ($accion == 'incluir_membresia' || $accion == 'modificar_membresia') {
        $admin->set_nombres(post('tipo')); 
    } else {
        $admin->set_nombres(post('nombres') ?: post('nombre_emp'));
    }

    // datos comunes que pueden venir de distintos formularios
    $admin->set_cedula(post('cedula') ?: post('cedula_emp'));
    $admin->set_apellidos(post('apellidos') ?: post('apellido_emp'));
    $admin->set_telefono(post('telefono') ?: post('telefono_emp'));
    $admin->set_correo(post('correo') ?: post('correo_emp'));
    $admin->set_contrasena(post('contrasena') ?: post('contrasena_emp'));
    
    $admin->set_id_membresia(post('id_membresia') ?: post('id_membresia_cliente'));
    $admin->set_cargo(post('cargo_emp'));
    $admin->set_monto(post('monto')); 

    $admin->set_banco(post('banco'));
    $admin->set_cedula_pago(post('cedula'));
    $admin->set_telefono_pago(post('telefono'));

    if (isset($_POST['id_pago'])) {
    $admin->set_id_pago(post('id_pago'));
}

    if (method_exists($admin, $accion)) {
        echo $admin->$accion();
    } else {
        echo "Error: Acción '$accion' no definida en el modelo.";
    }
    
    exit; 
}

require_once("vista/admin.php"); 
?>