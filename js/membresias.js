function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();
    $("#formMembresia").on("submit", function(e){
        e.preventDefault();
        });

    
    
    // Validacion de datos
    // Validacion nombre
    $("#nombre_membresia").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    
    $("#nombre_membresia").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#snombre_membresia"),"Nombre inválido - entre 3 y 100 caracteres");
    });

    // Botón Guardar / Modificar
    $("#btnGuardar").on("click", function() {
        // Guardar (Incluir)
        if($(this).text().toLowerCase() == 'incluir'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'incluir');
                datos.append('tipo', $("#nombrePlan").val());
                datos.append('monto', $("#costoPlan").val());
                enviaAjax(datos);
            }
        }
        // Modificar
        else if($(this).text().toLowerCase() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('id_membresia', $("#idMembresia").val());
                datos.append('tipo', $("#nombrePlan").val());
                datos.append('monto', $("#costoPlan").val());
                enviaAjax(datos);
            }
        }
    }); // 

    // Botón Nuevo Ejercicio
    $("#btnNuevoPlan").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir"); 
        $("#modalMembresia").modal("show"); // El ID de tu modal en la vista
    });

    // Botón Eliminar del Modal
   // Reemplaza el botón Eliminar viejo por este:
    $("#btnEliminar").on("click", function(){
        var id_membresia = $("#idMembresia").val(); 
        
        // Pasa el ID al modal de confirmación
        $("#id_eliminar_global").val(id_membresia);
        
        // Oculta el modal de edición y abre el de confirmación
        $("#modalMembresia").modal("hide");
        $("#modal_eliminar").modal("show");
    });

    // Evento del botón "SÍ, ELIMINAR" del modal genérico
    $("#btnConfirmarEliminar").on("click", function(){
        var id_membresia = $("#id_eliminar_global").val(); 
        
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_membresia', id_membresia);
        
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
    if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombrePlan"),$("#snombrePlan"),"Nombre Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
        mostrarMensaje("Nombre de Membresía Invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
        return false;
    }
    if($("#costoPlan").val() == ""){
        mostrarMensaje("El costo no puede estar vacío");
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
    
    $("#idMembresia").val(linea.find("td:eq(0)").text());
    $("#nombrePlan").val(linea.find("td:eq(1)").text()); 
    $("#costoPlan").val(linea.find("td:eq(2)").text()); // Agregamos el costo

    $("#btnGuardar").text('modificar');
    $("#modalMembresia").modal("show");
}

// Función eliminar directa desde la tabla
// Función eliminar directa desde la tabla
function eliminar(pos){
    var linea = $(pos).closest('tr');
    var id_membresia = $(linea).find("td:eq(0)").text();

    // Guardamos el ID en el input oculto del modal genérico
    $("#id_eliminar_global").val(id_membresia);
    
    // Mostramos el modal de Bootstrap
    $("#modal_eliminar").modal("show");
}

// Función AJAX
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=membresias",
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
                    $("#cuerpoTablaMembresias").html(lee.mensaje);
                } 
                // Si se incluyó con éxito, limpia, cierra el modal y recarga la tabla
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Membresía Registrada'){
                        $("#modalMembresia").modal("hide");
                        consultar(); // <-- Vuelve a llamar a la base de datos para actualizar la vista
                    }
                }
               else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Membresía Modificada'){
                        $("#modalMembresia").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Membresía Eliminada'){
                        $("#modalMembresia").modal("hide");
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
    $("#idMembresia").val("");
    $("#nombrePlan").val("");
    $("#costoPlan").val("");
}