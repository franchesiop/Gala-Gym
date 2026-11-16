<?php
if (!is_file("modelo/".$pagina.".php")){
    echo "Falta definir la clase ".$pagina;
    exit;
}
require_once("modelo/".$pagina.".php");

if(is_file("vista/".$pagina.".php")){
    $o = new clientes();
    if(!empty($_POST)){
        $accion = $_POST['accion'];

        switch($accion){

            case 'consultar':
                echo json_encode($o->consultar());
                break;

            case 'eliminar':
                $o->set_cedulaCliente($_POST['cedulaCliente']);
                echo json_encode($o->eliminar());
                break;

            case 'incluir':
                // 1. Formateas los datos y los guardas en las variables
                $nombreFormateado = ucfirst(strtolower($_POST['nombreCliente']));
                $apellidoFormateado = ucfirst(strtolower($_POST['apellidoCliente']));

                // 2. Le pasas esas variables formateadas al modelo (AQUÍ ESTABA EL ERROR)
                $o->set_cedulaCliente($_POST['cedulaCliente']);
                $o->set_nombreCliente($nombreFormateado); 
                $o->set_apellidoCliente($apellidoFormateado); 
                
                $o->set_tlfCliente($_POST['tlfCliente']);
                $o->set_correoCliente($_POST['correoCliente']);
                $o->set_contraCliente($_POST['contraCliente']);
                $o->set_membresiaCliente($_POST['membresiaCliente']);
                echo json_encode($o->incluir());
                break;

            case 'modificar':
                // 1. Formateas los datos y los guardas en las variables
                $nombreFormateado = ucfirst(strtolower($_POST['nombreCliente']));
                $apellidoFormateado = ucfirst(strtolower($_POST['apellidoCliente']));
                
                // 2. Le pasas esas variables formateadas al modelo (AQUÍ ESTABA EL ERROR)
                $o->set_cedulaCliente($_POST['cedulaCliente']);
                $o->set_nombreCliente($nombreFormateado); 
                $o->set_apellidoCliente($apellidoFormateado); 
                
                $o->set_tlfCliente($_POST['tlfCliente']);
                $o->set_correoCliente($_POST['correoCliente']);
                $o->set_contraCliente($_POST['contraCliente']);
                $o->set_membresiaCliente($_POST['membresiaCliente']);
                echo json_encode($o->modificar());
                break;

            case 'listar_membresias':
             echo json_encode($o->listar_membresias());
             break;
        }
        exit();
    }
    require_once("vista/".$pagina.".php"); 
} else {
    echo "pagina en construccion";
}
?>