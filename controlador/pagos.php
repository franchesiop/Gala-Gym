<?php
if (!is_file("modelo/".$pagina.".php")) {
    echo "Falta definir la clase pagos";
    exit;
}
require_once("modelo/".$pagina.".php");

$o = new pagos();

if (!empty($_POST)) {
    $accion = $_POST['accion'];

    if (isset($_POST['id_metodo'])) $o->set_id_metodo($_POST['id_metodo']);
    if (isset($_POST['banco'])) $o->set_banco($_POST['banco']);
    if (isset($_POST['cedula'])) $o->set_cedula($_POST['cedula']);
    if (isset($_POST['telefono'])) $o->set_telefono($_POST['telefono']);

    switch ($accion) {
        case 'consultar':
            echo json_encode($o->consultar());
            break;

        case 'obtener_pago':
            echo json_encode($o->obtener_pago_array()); 
            break;

        case 'incluir':
            echo json_encode($o->incluir());
            break;

        case 'modificar':
            echo json_encode($o->modificar());
            break;

        case 'eliminar':
            echo json_encode($o->eliminar());
            break;

        default:
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Acción no válida']);
            break;
    }
    exit; 
}

if (is_file("vista/".$pagina.".php")) {
    require_once("vista/".$pagina.".php");
} else {
    echo "Vista de pagos en construcción";
}
?>