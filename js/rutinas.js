function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();
    $("#formRutinas").on("submit", function(e){
        e.preventDefault();
        });

    
    
    // Validacion de datos
    // Validacion nombre
    $("#nombreRutina").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#nombreRutina").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#snombre_ejercicio"),"Nombre inválido - entre 3 y 100 caracteres");
    });

    // Botón Guardar / Modificar
    $("#btnGuardar").on("click", function() {
        // Guardar (Incluir)
        if($(this).text().toLowerCase() == 'incluir'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'incluir');
                datos.append('nombreRutina', $("#nombreRutina").val());
                datos.append('idEmpleado', $("#idEmpleado").val());
                enviaAjax(datos);
            }
        }
        // Modificar
        else if($(this).text().toLowerCase() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('idRutina', $("#idRutina").val());
                datos.append('nombreRutina', $("#nombreRutina").val());
                enviaAjax(datos);
            }
        }
    }); // 

    // Botón Nueva Rutina
    $("#btnAsignarRutina").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir"); 
        $("#btnEliminar").hide(); 
        $("#modalUsuario").modal("show");
    });

    // Botón Eliminar del Modal
    $("#btnEliminar").on("click", function(){
        var idRutina = $("#idRutina").val(); 
        if(confirm("¿Seguro que desea eliminar esta rutina?")){
            var datos = new FormData();
            datos.append('accion', 'eliminar');
            datos.append('idRutina', idRutina);
            enviaAjax(datos);
        }
    });

    // Botón Incluir alternativo 
    $("#incluir").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir");
        $("#modalUsuario").modal("show");
    });
}); // Fin del $(document).ready

// Validar antes de enviar
function validarEnvio() {
    if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombreRutina"),$("#snombreRutina"),"Nombre Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
        mostrarMensaje("Asignación inválida <br>" + "(Solo letras entre 3 y 100 caracteres)");
        return false;
    }
    return true;
}

// Función para mostrar el mensaje modal
function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

// Función para validar por keypress
function validarkeypress(er,e){
    var key = e.keyCode || e.which;
    var tecla = String.fromCharCode(key);
    var a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

// Función para validar por keyup
function validarkeyup(er,etiqueta,etiquetamensaje,mensaje){
    var a = er.test(etiqueta.val());
    if(a){
        etiquetamensaje.text("");
        return 1;
    } else{
        etiquetamensaje.text(mensaje);
        return 0;
    }
}

// Función para llenar el formulario al editar
function pone(pos){
    var linea = $(pos).closest('tr');
    
    $("#idRutina").val(linea.find("td:eq(0)").text());
    $("#nombreRutina").val(linea.find("td:eq(1)").text()); 

    $("#btnGuardar").text('modificar');
    $("#btnEliminar").show();
    $("#modalUsuario").modal("show");
}

// Función eliminar directa desde la tabla
function eliminar(pos){
    var linea = $(pos).closest('tr');
    var idRutina = $(linea).find("td:eq(0)").text();

    if(confirm("¿Seguro que desea eliminar esta rutina?")){
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('idRutina', idRutina);
        enviaAjax(datos);
    }
}

// Función AJAX
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=rutinas",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta){
            console.log("Respuesta del servidor:", respuesta); //
            try {
                var lee = JSON.parse(respuesta);
                
                // Si la acción fue consultar, dibuja las filas en la tabla
                if(lee.resultado == 'consultar'){
                    $("#tablaRutinas").html(lee.mensaje);
                } 
                // Si se incluyó con éxito, limpia, cierra el modal y recarga la tabla
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Rutina Asignada'){
                        $("#modalUsuario").modal("hide");
                        consultar(); // <-- Vuelve a llamar a la base de datos para actualizar la vista
                    }
                }
               else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Rutina Modificada'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Rutina Eliminada'){
                        $("#modalUsuario").modal("hide");
                        $("#modal_eliminar").modal("hide");
                        consultar();
                    }
                } 
            } catch(e) {
                alert("Error procesando los datos del servidor (JSON): " + e.message);
            }
        },
        error: function(request, status, err){
            mostrarMensaje("ERROR DE RED o SERVIDOR: <br/>" + err);
        }
    });
}
// Limpiar formulario
function limpia(){
    $("#idRutina").val("");
    $("#nombreRutina").val("");
    $("#snombreRutina").text("");
}

