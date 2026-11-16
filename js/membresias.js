// Variable global para controlar la instancia de DataTables
var tablaMembresias;

function consultar(){
    if ($.fn.DataTable.isDataTable('#tablaMembresias')) {
        tablaMembresias.ajax.reload(null, false);
        return;
    }

    tablaMembresias = $('#tablaMembresias').DataTable({
        autoWidth: false,
        order: [],                       // Sin orden inicial por defecto
        lengthChange: false,             // Quita el selector de cantidad de registros por defecto
        layout: {
            topStart: { div: { html: '<h6 class="fw-bold text-uppercase m-0"><i class="bi bi-cash-stack"></i> Membresías</h6>' } },
            topEnd: [
                { search: { placeholder: 'Buscar...', text: '' } },
                document.getElementById('btnNuevoPlan')
            ]
        },
        ajax: {
            url: "index.php?pagina=membresias",
            type: "POST",
            data: function (d) { d.accion = 'consultar'; },
            dataSrc: "mensaje" // Los datos puros en formato JSON vienen en 'mensaje'
        },
        columns: [
            { data: "id_membresia", visible: false }, // 0: ID Oculto
            { data: "tipo" },                          // 1: Tipo de Plan (Visible)
            { 
                data: "monto",                         // 2: Costo (Visible)
                render: function (data) {
                    return "$" + data;                 // Opcional: le agrega el signo de dólar estético
                }
            },
            {
                data: null,                            // 3: Opciones (Visible)
                orderable: false,
                className: "text-center",
                render: function () {
                    return `<div class='d-flex justify-content-center'>
                                <button type='button' class='btn btn-dark text-white small-width m-1' onclick='pone(this)'><i class='bi bi-pencil-square'></i></button>
                                <button type='button' class='btn btn-danger small-width m-1' onclick='eliminar(this)'><i class='bi bi-trash'></i></button>
                            </div>`;
                }
            }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        }
    });
}

$(document).ready(function(){

    consultar();
    
    $("#formMembresia").on("submit", function(e){
        e.preventDefault();
    });
    
    // Validacion de datos
    // Validacion nombre
    $("#nombrePlan").on("keypress", function(e){
        validarkeypress(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]$/, e);
    });
    
    $("#nombrePlan").on("keyup", function(){
        validarkeyup(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,100}$/, $(this), $("#snombrePlan"), "Solo letras (entre 3 y 100 caracteres)");
    });

    $("#costoPlan").on("keypress", function(e){
        validarkeypress(/^[0-9]$/, e);
    });
    
    $("#costoPlan").on("keyup", function(){
        validarkeyup(/^[0-9]+$/, $(this), $("#scostoPlan"), "Solo se aceptan números");
    });

    // Botón Guardar / Modificar
    $("#btnGuardar").on("click", function() {
        if($(this).text().toLowerCase() == 'incluir'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'incluir');
                datos.append('tipo', $("#nombrePlan").val());
                datos.append('monto', $("#costoPlan").val());
                enviaAjax(datos);
            }
        }
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
    });

    // Botón Nuevo Plan
    $("#btnNuevoPlan").on("click", function(){
        limpia();
        $("#btnGuardar").text("INCLUIR"); 
        $("#modalMembresia").modal("show"); 
    });

    // Botón Eliminar del Modal
    $("#btnEliminar").on("click", function(){
        var id_membresia = $("#idMembresia").val(); 
        $("#modalMembresia").modal("hide");

        alertaEliminar(function() {
            var datos = new FormData();
            datos.append('accion', 'eliminar');
            datos.append('id_membresia', id_membresia);
            enviaAjax(datos);
        });
    });

    // Botón Incluir alternativo 
    $("#incluir").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir");
        $("#modalUsuario").modal("show");
    });
});

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

// Función para llenar el formulario al editar usando DataTables
function pone(pos){
    var d = tablaMembresias.row($(pos).closest('tr')).data();
    
    $("#idMembresia").val(d.id_membresia);
    $("#nombrePlan").val(d.tipo); 
    $("#costoPlan").val(d.monto);

    $("#btnGuardar").text('MODIFICAR');
    $("#modalMembresia").modal("show");
}

// Función eliminar directa desde la tabla usando DataTables
function eliminar(pos){
    var d = tablaMembresias.row($(pos).closest('tr')).data();

    alertaEliminar(function() {
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_membresia', d.id_membresia);
        enviaAjax(datos);
    });
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
            console.log("Respuesta del servidor:", respuesta); 
            try {
                var lee = JSON.parse(respuesta);
                
                if(lee.resultado == 'consultar'){
                    // DataTables se encarga de recargar y actualizar automáticamente mediante ajax.reload()
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Membresía Registrada'){
                        $("#modalMembresia").modal("hide");
                        consultar(); 
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