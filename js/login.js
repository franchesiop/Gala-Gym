$(document).ready(function(){

    // Validación correo
    $("#correo").on("keypress", function(e){
        validarkeypress(/^[a-zA-Z0-9._@-]*$/, e);
    });
    $("#correo").on("keyup", function() {
        validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $(this), $("#scorreo"), "Correo inválido");
    });

    // Validación contraseña (evitar caracteres que no correspondan a tu regla)
    $("#contrasena").on("keypress", function(e) {
        validarkeypress(/^[a-zA-Z0-9!@#$%^&*]*$/, e);
    });
    // No ponemos validación estricta de longitud en el keyup para no molestar al usuario mientras escribe su clave actual.

    // Capturar el envío del formulario
    $("form").on("submit", function(e) {
        console.log("Se presionó el botón de submit");
        e.preventDefault(); // Evita que la página se recargue por defecto

        if (validarEnvio()) {
            var datos = new FormData();
            datos.append('accion', 'ingresar');
            datos.append('correo', $("#correo").val());
            datos.append('contrasena', $("#contrasena").val());
            
            enviaAjax(datos);
        }
    });
});

// Validar antes de enviar a AJAX
function validarEnvio() {
    // Validar correo
    if (validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $("#correo"), $("#scorreo"), "Correo Invalido") == 0) {
        mostrarMensaje("Correo Inválido <br/>(Formato incorrecto)");
        return false;
    }
    
    // Validar contraseña vacía
    if ($("#contrasena").val().trim() === "") {
        mostrarMensaje("La contraseña no puede estar vacía");
        return false;
    }
    
    return true;
}

// Función para enviar los datos al controlador
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=login", // Asegúrate de que apunte a tu enrutador principal
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        beforeSend: function () {},
        timeout: 10000,
        success: function (respuesta){
            console.log(respuesta);
            try {
                var lee = JSON.parse(respuesta);
                
                if(lee.resultado == 'exito'){
                    window.location.href = lee.ruta;
                } 
                else if(lee.resultado == "error"){
                    mostrarMensaje(lee.mensaje);
                }
            } catch(e) {
                mostrarMensaje("Error en la respuesta del servidor.");
                console.error("Error en JSON:", e, "Respuesta:", respuesta);
            }
        },
        error: function(request, status, err){
            if(status == "timeout"){
                mostrarMensaje("Servidor Ocupado, Intente de Nuevo");
            } else {
                mostrarMensaje("ERROR: <br/>" + request.status + " " + err);
            }
        },
        complete: function () {},
    });
}

function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

function validarkeypress(er, e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

function validarkeyup(er, etiqueta, etiquetamensaje, mensaje){
    a = er.test(etiqueta.val());
    if(a){
        if(etiquetamensaje.length) etiquetamensaje.text("");
        return 1;
    } else{
        if(etiquetamensaje.length) etiquetamensaje.text(mensaje);
        return 0;
    }
}