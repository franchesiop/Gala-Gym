<?php
  
if (!is_file("modelo/".$pagina.".php")){

	echo "Falta definir la clase ".$pagina;
	exit;
}  
require_once("modelo/".$pagina.".php");  
  if(is_file("vista/".$pagina.".php")){
	    
	  $o = new $pagina(); 
	  
	  if(!empty($_POST)){
		  
		  $accion = $_POST['accion'];
		  
		  if($accion=='consultar'){
			 echo  $o->consultar();  
		  }
		  elseif($accion=='consultatr'){
			 $o->set_cedula($_POST['cedula']); 
			 echo  $o->consultatr();  
		  }
		  elseif($accion=='obtienefecha'){
			 echo $o->obtienefecha();
		  }
		  elseif($accion=='eliminar'){
			 $o->set_cedula($_POST['cedula']);
			 echo  $o->eliminar();
		  }
		  else{		  
			  $o->set_cedula($_POST['cedula']);
			  $o->set_apellidos($_POST['apellidos']);
			  $o->set_nombres($_POST['nombres']);
			  $o->set_fechadenacimiento($_POST['fechadenacimiento']);
			//  if(!empty($_POST['sexo'])){
			  $o->set_sexo($_POST['sexo']);
			//  }
			  $o->set_gradodeinstruccion($_POST['gradodeinstruccion']);
			  if($accion=='incluir'){
				echo  $o->incluir();
			  }
			  elseif($accion=='modificar'){
				echo  $o->modificar();
			  }
		  }
		  exit;
	  }
	  
	  
	  require_once("vista/".$pagina.".php"); 
  }
  else{
	  echo "pagina en construccion";
  }
?>
