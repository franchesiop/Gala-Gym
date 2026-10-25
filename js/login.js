$(document).ready(function(){

    // Validar correo mientras se escribe
    $("#correo").on("keyup",function() {
        validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $(this), $("#scorreo"), "Formato de correo inválido");
    });

    // Interceptar el envío del formulario
    $("#formLogin").on("submit", function(e){
        e.preventDefault(); // Evita que la página se recargue

        if(validarEnvio()){
            var datos = new FormData();
            datos.append('accion', 'ingresar');
            datos.append('correo', $("#correo").val());
            datos.append('contrasena', $("#contrasena").val());
            
            enviaAjax(datos);
        }
    });
});

// Validar antes de enviar
function validarEnvio() {
    if(validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $("#correo"), $("#scorreo"), "Formato de correo inválido") == 0){
        mostrarMensaje("Por favor, ingresa un correo válido.");
        return false;
    }
    
    if($("#contrasena").val().trim() === "") {
        mostrarMensaje("La contraseña no puede estar vacía.");
        return false;
    }

    return true;
}

function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

function validarkeyup(er, etiqueta, etiquetamensaje, mensaje){
    a = er.test(etiqueta.val());
    if(a){
        etiquetamensaje.text("");
        return 1;
    } else{
        etiquetamensaje.text(mensaje);
        return 0;
    }
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
        beforeSend: function () {
            $("#btnEntrar").prop("disabled", true).text("Verificando...");
        },
        timeout: 10000,
        success: function (respuesta){
            $("#btnEntrar").prop("disabled", false).text("ENTRAR");
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'exito'){
                    // Si el login es correcto, redirigimos al panel de clientes o rutinas
                    window.location.href = "?pagina=admin";
                } 
                else if(lee.resultado == 'error'){
                    mostrarMensaje(lee.mensaje);
                }
            } catch(e){
                alert("Error en JSON: " + e.name);
            }
        },
        error: function(request, status, err){
            $("#btnEntrar").prop("disabled", false).text("ENTRAR");
            if(status == "timeout"){
                mostrarMensaje("Servidor Ocupado, Intente de Nuevo");
            } else {
                mostrarMensaje("ERROR: <br/>" + request + status + err);
            }
        },
        complete: function () {},
    });
}