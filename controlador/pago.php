<?php

require_once("modelo/".$pagina.".php");
$obj = new Pago();

// 2. Si es una petición AJAX (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    if ($accion == 'consultar_membresias') {
        $resultado = $obj->obtenerMembresias();
        echo json_encode($resultado);
    } 
    elseif ($accion == 'consultar_metodos') {
        $resultado = $obj->obtenerMetodosPago();
        echo json_encode($resultado);
    }
    elseif ($accion == 'registrar_pago') {
        session_start();
        $id_cliente = $_SESSION['id_cliente'] ?? 3;
        $obj->set_id_cliente($id_cliente);
        $obj->set_id_membresia($_POST['id_membresia']);
        $obj->set_monto($_POST['monto']);
        $obj->set_referencia($_POST['referencia']);
        $obj->set_id_metodo($_POST['id_metodo']);
        $respuesta = $obj->registrarPago();
        echo json_encode($respuesta);
    }
} 
else {
    require_once("vista/".$pagina.".php");
}
?>