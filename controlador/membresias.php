<?php

if (!is_file("modelo/".$pagina.".php")) {
    echo "Falta definir la clase membresias";
    exit;
}
require_once("modelo/".$pagina.".php");

$o = new membresias();

if (!empty($_POST)) {
    $accion = $_POST['accion'];

    if (isset($_POST['id']))      $o->set_id_membresia($_POST['id']);
    if (isset($_POST['nombre']))  $o->set_tipo($_POST['nombre']);
    if (isset($_POST['costo']))   $o->set_monto($_POST['costo']);

    switch ($accion) {
        case 'consultar':
            echo json_encode($o->consultar());
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
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Acción no permitida']);
            break;
    }
    exit;
}

if (is_file("vista/".$pagina.".php")) {
    require_once("vista/".$pagina.".php");
} else {
    echo "Vista de membresias en construcción";
}
?>