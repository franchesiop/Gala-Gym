<?php
class verifica {
    function leesesion() {
        // Aseguramos que la sesión inicie solo si no ha iniciado ya
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if(isset($_SESSION['rol'])) {
            $s = $_SESSION['rol'];
        } else {
            $s = "";
        }
        return $s;
    }
    
    function destruyesesion() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: . ");
        exit(); // Se añade exit() para cortar la ejecución después de redirigir
    }
}
?>