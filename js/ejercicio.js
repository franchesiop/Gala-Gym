function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();
    $("#formEjercicios").on("submit", function(e){
        e.preventDefault();
        });

    
    
    // Validacion de datos
    // Validacion nombre
    $("#nombre_ejercicio").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#nombre_ejercicio").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#snombre_ejercicio"),"Nombre inválido - entre 3 y 100 caracteres");
    });

    // Botón Guardar / Modificar
    $("#btnGuardar").on("click", function() {
        // Guardar (Incluir)
        if($(this).text().toLowerCase() == 'incluir'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'incluir');
                datos.append('nombre_ejercicio', $("#nombre_ejercicio").val());
                enviaAjax(datos);
            }
        }
        // Modificar
        else if($(this).text().toLowerCase() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('id_ejercicio', $("#id_ejercicio").val());
                datos.append('nombre_ejercicio', $("#nombre_ejercicio").val());
                enviaAjax(datos);
            }
        }
    }); // 

    // Botón Nuevo Ejercicio
    $("#btnNuevoEjercicio").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir"); 
        $("#btnEliminar").hide(); 
        $("#modalUsuario").modal("show");
    });

    // Botón Eliminar del Modal
   // Reemplaza el Botón Eliminar del Modal de edición por este:
    $("#btnEliminar").on("click", function(){
        var id_ejercicio = $("#id_ejercicio").val(); 
        
        // Pasa el ID al modal de confirmación
        $("#id_eliminar_global").val(id_ejercicio);
        
        // Oculta el modal de edición y abre el de confirmación
        $("#modalUsuario").modal("hide");
        $("#modal_eliminar").modal("show");
    });

    // Añade el evento del botón "SÍ, ELIMINAR" del nuevo modal
    $("#btnConfirmarEliminar").on("click", function(){
        var id_ejercicio = $("#id_eliminar_global").val(); 
        
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_ejercicio', id_ejercicio);
        
        enviaAjax(datos);
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
    if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombre_ejercicio"),$("#snombre_ejercicio"),"Nombre Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
        mostrarMensaje("Nombre de Ejercicio Invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
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
    
    $("#id_ejercicio").val(linea.find("td:eq(0)").text());
    $("#nombre_ejercicio").val(linea.find("td:eq(1)").text()); 

    $("#btnGuardar").text('modificar');
    $("#btnEliminar").show();
    $("#modalUsuario").modal("show");
}

// Función eliminar directa desde la tabla
// Función eliminar directa desde la tabla
function eliminar(pos){
    var linea = $(pos).closest('tr');
    var id_ejercicio = $(linea).find("td:eq(0)").text();

    // Guardamos el ID en el input oculto del nuevo modal
    $("#id_eliminar_global").val(id_ejercicio);
    
    // Mostramos el modal de Bootstrap
    $("#modal_eliminar").modal("show");
}

// Función AJAX
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=ejercicio",
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
                    $("#tablaEjercicios").html(lee.mensaje);
                } 
                // Si se incluyó con éxito, limpia, cierra el modal y recarga la tabla
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Ejercicio Registrado'){
                        $("#modalUsuario").modal("hide");
                        consultar(); // <-- Vuelve a llamar a la base de datos para actualizar la vista
                    }
                }
               else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Ejercicio Modificado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Ejercicio Eliminado'){
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
    $("#id_ejercicio").val("");
    $("#nombre_ejercicio").val("");
    $("#snombre_ejercicio").text("");
}