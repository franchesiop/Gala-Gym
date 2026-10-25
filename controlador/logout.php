<?php
// Aseguramos que la sesión esté iniciada para poder destruirla
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpiamos todas las variables registradas ($_SESSION)
session_unset();

// Destruimos la sesión en el servidor
session_destroy();

// Redirigimos inmediatamente al login
header("Location: ?pagina=principal");
exit();
?>