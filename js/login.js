$(document).ready(function(){

    // Validación de correo
    $("#correo").on("keypress", function(e){
        validarkeypress(/^[a-zA-Z0-9._@-]*$/, e);
    });
    $("#correo").on("keyup", function(){
        validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $(this), $("#scorreo"), "Formato inválido");
    });

    // Validación de contraseña
    $("#contrasena").on("keypress", function(e){
        validarkeypress(/^[a-zA-Z0-9!@#$%^&*]*$/, e);
    });
    $("#contrasena").on("keyup", function(){
        validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/, $(this), $("#scontrasena"), "Entre 8 y 20 caracteres");
    });

    // Capturar el submit del formulario
    $("#formLogin").on("submit", function(e){
        e.preventDefault(); // evita que recargue la página
        
        if(validarEnvio()){
            var datos = new FormData();
            datos.append('accion', 'entrar');
            datos.append('correo', $("#correo").val());
            datos.append('contrasena', $("#contrasena").val());
            
            enviaAjax(datos);
        }
    });
});

function validarEnvio() {
    if(validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $("#correo"), $("#scorreo"), "Formato inválido") == 0){
        mostrarMensaje("El correo ingresado no es válido.");    
        return false;                   
    }
    else if(validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/, $("#contrasena"), $("#scontrasena"), "Mínimo 8 caracteres") == 0){
        mostrarMensaje("La contraseña no cumple con el formato.");
        return false;
    }
    return true;
}

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=login", 
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function(respuesta){
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'existe'){
                    // si el login es exitoso, redirige al index para que el front controller asigne la vista
                    window.location.href = "."; 
                } 
                else if(lee.resultado == 'noexiste' || lee.resultado == 'error'){
                    mostrarMensaje(lee.mensaje);
                }
            } catch(e){
                mostrarMensaje("Error en JSON: " + e.name);
            }
        },
        error: function(request, status, err){
            mostrarMensaje("ERROR: " + request + status + err);
        }
    });
}

function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje); 
    $("#mostrarModal").modal("show");
    setTimeout(function() { $("#mostrarModal").modal("hide"); }, 5000);
}

function validarkeypress(er,e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

function validarkeyup(er,etiqueta,etiquetamensaje,mensaje){
    a = er.test(etiqueta.val());
    if(a){
        etiquetamensaje.text("");
        return 1;
    } else{
        etiquetamensaje.text(mensaje);
        return 0;
    }
}