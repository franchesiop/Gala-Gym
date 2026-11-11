<?php
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new clientes_pagos();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'incluir':
                $o->set_idCliente($_POST['idCliente']);
                $o->set_idMembresia($_POST['idMembresia']);
                $o->set_idMetodo($_POST['idMetodo']);
                $o->set_monto($_POST['monto']);
                $o->set_referencia($_POST['referencia']);
                $o->set_cantidadPeriodos($_POST['cantidadPeriodos']);
                echo json_encode($o->incluir());
                break;

            case 'aprobar':
                $o->set_idPago($_POST['idPago']);
                echo json_encode($o->aprobar());
                break;

            case 'rechazar':
                $o->set_idPago($_POST['idPago']);
                echo json_encode($o->rechazar());
                break;

            case 'listar_clientes':
                echo json_encode($o->listar_clientes());
                break;
            case 'listar_membresias':
                echo json_encode($o->listar_membresias());
                break;
            case 'listar_metodos':
                echo json_encode($o->listar_metodos());
                break;
        }
        exit();
    }
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>