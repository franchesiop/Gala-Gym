// Variable global para controlar la instancia de DataTables
var tablaEjercicios;

function consultar(){
    if ($.fn.DataTable.isDataTable('#tablaEjercicios')) {
        tablaEjercicios.ajax.reload(null, false);
        return;
    }

    tablaEjercicios = $('#tablaEjercicios').DataTable({
        autoWidth: false,
        order: [],                       // Sin orden inicial por defecto
        lengthChange: false,             // Quita el selector de cantidad de registros por defecto
        layout: {
            topStart: { div: { html: '<h6 class="fw-bold text-uppercase m-0"><i class="bi bi-activity"></i> Ejercicios</h6>' } },
            topEnd: [
                { search: { placeholder: 'Buscar...', text: '' } },
                document.getElementById('btnNuevoEjercicio')
            ]
        },
        ajax: {
            url: "index.php?pagina=ejercicio",
            type: "POST",
            data: function (d) { d.accion = 'consultar'; },
            dataSrc: "mensaje" // Los datos puros en formato JSON vienen en 'mensaje'
        },
        columns: [
            { data: "id_ejercicio", visible: false }, // 0: ID Oculto
            { 
                data: "imagen",                       // 1: Foto (Visible)
                orderable: false,
                className: "text-center",
                render: function (data) {
                    var img = (data && data !== "" && data !== null) ? data : 'img/default.jpg';
                    return `<img src='${img}' alt='ejercicio' style='width:45px; height:45px; object-fit:cover; border-radius:6px;' class='shadow-sm border'>`;
                }
            },
            { data: "nombre" },                       // 2: Nombre (Visible)
            { 
                data: "descripcion",                  // 3: Descripción (Visible)
                render: function (data) {
                    if (!data || data.trim() === "") {
                        return '<span class="text-muted fst-italic">Sin descripción</span>';
                    }
                    return `<div style='max-height: 45px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>${data}</div>`;
                }
            },
            {
                data: null,                           // 4: Opciones (Visible)
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

    $("#formEjercicios").on("submit", function(e){
        e.preventDefault();
    });

    // validacion de imagen (Preview, formato y peso)
    $("#imagen_ejercicio").on("change", function(){
        var archivo = this.files[0];
        if(archivo){
            if(archivo.size > 2097152){ // 2MB
                mostrarMensaje("Imagen Invalida <br/> (La imagen es muy pesada. Máximo 2MB)");
                $(this).val(""); 
                $("#vista_previa").attr("src", "img/default.jpg");
                return;
            }
            
            var tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if(!tiposPermitidos.includes(archivo.type)){
                mostrarMensaje("Formato Invalido <br/> (Solo JPG, PNG o WEBP)");
                $(this).val("");
                $("#vista_previa").attr("src", "img/default.jpg");
                return;
            }
            
            var reader = new FileReader();
            reader.onload = function(e){
                $("#vista_previa").attr("src", e.target.result);
            }
            reader.readAsDataURL(archivo);
        } else {
            $("#vista_previa").attr("src", "img/default.jpg");
        }
    });

    // Validacion nombre
    $("#nombre_ejercicio").on("keypress", function(e){
        validarkeypress(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]$/, e);
    });
    
    $("#nombre_ejercicio").on("keyup", function(){
        validarkeyup(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,100}$/, $(this), $("#snombre_ejercicio"), "Solo se aceptan letras (entre 3 y 100 caracteres)");
    });

    // Botones
    $("#btnGuardar").on("click", function() {
        if($(this).text().toUpperCase() == 'INCLUIR' || $(this).text() == 'incluir'){
            if(validarEnvio()){
                var datos = new FormData($("#formEjercicios")[0]);
                datos.append('accion', 'incluir');
                enviaAjax(datos);
            }
        }
        else if($(this).text().toUpperCase() == 'MODIFICAR' || $(this).text() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData($("#formEjercicios")[0]);
                datos.append('accion', 'modificar');
                enviaAjax(datos);
            }
        }
    });

    $("#btnNuevoEjercicio").on("click", function(){
        limpia();
        $("#btnGuardar").text("INCLUIR"); 
        $("#modalUsuario").modal("show");
    });

});

// Validar antes de enviar
function validarEnvio() {
    if(validarkeyup(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,100}$/, $("#nombre_ejercicio"), $("#snombre_ejercicio"), "Solo letras (Entre 3 y 100 caracteres)") == 0){
        mostrarMensaje("Nombre Inválido <br>" + "(Solo se permiten letras, entre 3 y 100 caracteres)");
        return false;
    }
    return true;
}



// Funcion para validar por keypress
function validarkeypress(er,e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

// Funcion para validar por keyup
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

// Funcion para llenar el formulario usando DataTables
function pone(pos){
    var d = tablaEjercicios.row($(pos).closest('tr')).data();

    $("#id_ejercicio").val(d.id_ejercicio);
    $("#nombre_ejercicio").val(d.nombre);
    $("#descripcion_ejercicio").val(d.descripcion ? d.descripcion : "");
    
    var srcImagen = (d.imagen && d.imagen !== "") ? d.imagen : "img/default.jpg";
    $("#vista_previa").attr("src", srcImagen);

    $("#btnGuardar").text('MODIFICAR');
    $("#modalUsuario").modal("show");
}

function eliminar(pos){
    var d = tablaEjercicios.row($(pos).closest('tr')).data();

    alertaEliminar(function() {
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_ejercicio', d.id_ejercicio);
        enviaAjax(datos);
    });
}

// Funcion Ajax estandarizada
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=ejercicio",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        beforeSend: function () {},
        timeout: 10000,
        success: function (respuesta){
            console.log(respuesta);
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'consultar'){
                    // DataTables gestiona el refresco automático
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Ejercicio Registrado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
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
                        consultar();
                    }
                } 
                else if(lee.resultado == "error"){
                    mostrarMensaje("ERROR: <br/>" + lee.mensaje);
                }
            } catch(e){
                alert("Error en JSON " + e.name);
            }
        },
        error: function(request, status, err){
            if(status == "timeout"){
                mostrarMensaje("Servidor Ocupado, Intente de Nuevo");
            } else {
                mostrarMensaje("ERROR: <br/>" + request + status + err);
            }
        },
        complete: function () {},
    });
}

function limpia(){
    $("#id_ejercicio").val("");
    $("#formEjercicios")[0].reset();
    $("#snombre_ejercicio").text("");
    $("#vista_previa").attr("src", "img/default.jpg");
}