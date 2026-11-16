// Variable global para controlar la instancia de DataTables
var tablaEmpleados;

function consultar(){
    if ($.fn.DataTable.isDataTable('#tablaEmpleados')) {
        tablaEmpleados.ajax.reload(null, false);
        return;
    }

    tablaEmpleados = $('#tablaEmpleados').DataTable({
        autoWidth: false,
        order: [],                       // sin orden inicial por defecto
        lengthChange: false,             // quita "Mostrar X registros"
        layout: {
            topStart: { div: { html: '<h6 class="fw-bold text-uppercase m-0"><i class="bi bi-person"></i> Empleados</h6>' } },
            topEnd: [
                { search: { placeholder: 'Buscar...', text: '' } },
                document.getElementById('btnNuevoEmpleado')
            ]
        },
        ajax: {
            url: "index.php?pagina=empleados",
            type: "POST",
            data: function (d) { d.accion = 'consultar'; },
            dataSrc: "mensaje" // Los datos puros vienen en 'mensaje' desde el modelo
        },
        columns: [
            { data: "cedula",       type: "string" },
            { data: "nombre" },
            { data: "apellido" },
            { data: "nombre_rol" },  // Viene del JOIN con la tabla rol
            { data: "telefono",     type: "string" },
            { data: "correo",       visible: false },   // Oculto para usarlo al editar
            { data: "id_rol",       visible: false },   // Oculto para el select de roles
            {
                data: null,
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
    
    // validacion cedula
    $("#cedulaEmpleado").on("keypress",function(e){
        validarkeypress(/^[0-9]*$/,e); 
    });
    $("#cedulaEmpleado").on("keyup",function(){
        validarkeyup(/^[0-9]{7,9}$/,$(this), $("#scedulaEmpleado"),"Cédula inválida - entre 7 y 9 números (sin puntos)");
    });

    // validacion nombre
    $("#nombreEmpleado").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#nombreEmpleado").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $(this),$("#snombreEmpleado"),"Nombre inválido - sin espacios, entre 3 y 25 letras");
    });

    // validacion apellido
    $("#apellidoEmpleado").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#apellidoEmpleado").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $(this),$("#sapellidoEmpleado"),"Apellido inválido - sin espacios, entre 3 y 25 letras");
    });

    // validacion telefono 
    $("#tlfEmpleado").on("keypress",function(e){
        validarkeypress(/^[0-9]*$/, e); 
    });
    $("#tlfEmpleado").on("keyup",function(){
        validarkeyup(/^(0412|0422|0414|0424|0416|0426)[0-9]{7}$/,$(this), $("#stlfEmpleado"),"Teléfono inválido - Ej: 04141234567 (11 números)");
    });

    // validacion correo
    $("#correoEmpleado").on("keypress",function(e){
        validarkeypress(/^[a-zA-z0-9._@-]*$/, e);
    });
    $("#correoEmpleado").on("keyup",function() {
        validarkeyup(/^[a-zA-Z0-9]+([._-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}$/,$(this), $("#scorreoEmpleado"),"Correo inválido - Verifica el formato");
    });

    // validar contrasena
    $("#contraEmpleado").on("keypress",function(e) {
        validarkeypress(/^[a-zA-Z0-9!@#$%^&*]*$/, e);
    });
    $("#contraEmpleado").on("keyup", function(e) {
        validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/,$(this), $("#scontraEmpleado"),"Contrasena invalida - entre 8 y 20 caracteres")
    });

    // botones
    $("#btnGuardar").on("click", function() {
        if($(this).text() == 'incluir'){
            if(validarEnvio()){
              var datos = new FormData();
              datos.append('accion', 'incluir');
              datos.append('cedulaEmpleado', $("#cedulaEmpleado").val());
              datos.append('nombreEmpleado', $("#nombreEmpleado").val());
              datos.append('apellidoEmpleado', $("#apellidoEmpleado").val());
              datos.append('tlfEmpleado', $("#tlfEmpleado").val());
              datos.append('correoEmpleado', $("#correoEmpleado").val());
              datos.append('contraEmpleado', $("#contraEmpleado").val());
              datos.append('rolEmpleado', $("#rolEmpleado").val());
              enviaAjax(datos);
            }
        }
        else if($(this).text() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('cedulaEmpleado', $("#cedulaEmpleado").val());
                datos.append('nombreEmpleado', $("#nombreEmpleado").val());
                datos.append('apellidoEmpleado', $("#apellidoEmpleado").val());
                datos.append('tlfEmpleado', $("#tlfEmpleado").val());
                datos.append('correoEmpleado', $("#correoEmpleado").val());
                datos.append('contraEmpleado', $("#contraEmpleado").val());
                datos.append('rolEmpleado', $("#rolEmpleado").val());
                enviaAjax(datos);
            }
        }
    });

    $("#btnNuevoEmpleado").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir"); 
        $("#btnEliminar").hide();
        cargarRoles(); 
        $("#modalUsuario").modal("show");
    });

});

// validar antes de enviar
function validarEnvio() {
    if(validarkeyup(/^[0-9]{7,9}$/,$("#cedulaEmpleado"), $("#scedulaEmpleado"),"Cédula inválida - (Entre 7 y 9 números, sin puntos)")==0){
        mostrarMensaje("Cédula Inválida <br/>" + "(Debe tener entre 7 y 9 números, sin puntos ni guiones)");    
        return false;                   
    }
    else if(validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $("#nombreEmpleado"),$("#snombreEmpleado"),"Nombre inválido - (Un solo nombre, entre 3 y 25 letras)")==0){
        mostrarMensaje("Nombre Inválido <br>" + "(Debe ser un solo nombre sin espacios, entre 3 y 25 letras)");
        return false;
    }
    else if(validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $("#apellidoEmpleado"),$("#sapellidoEmpleado"),"Apellido inválido - (Un solo apellido, entre 3 y 25 letras)")==0){
        mostrarMensaje("Apellido Inválido <br>" + "(Debe ser un solo apellido sin espacios, entre 3 y 25 letras)");
        return false;
    }
    else if(validarkeyup(/^(0412|0422|0414|0424|0416|0426)[0-9]{7}$/,$("#tlfEmpleado"), $("#stlfEmpleado"),"Teléfono inválido - (Ej: 04141234567)")==0){
        mostrarMensaje("Teléfono Inválido <br>" + "(Debe empezar con prefijo válido y tener 11 números, sin guiones)");    
        return false;                   
    }
    else if(validarkeyup(/^[a-zA-Z0-9]+([._-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}$/, $("#correoEmpleado"), $("#scorreoEmpleado"),"Correo inválido") == 0){
        mostrarMensaje("Correo Inválido <br/>" + "(Verifica que el formato sea correcto)");
        return false;
    }
    else {
        var contra = $("#contraEmpleado").val();
        var esModificar = ($("#btnGuardar").text().trim().toLowerCase() == 'modificar');

        if (!(esModificar && contra === "")) {
            if (validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/, $("#contraEmpleado"), $("#scontraEmpleado"), "Contraseña inválida") == 0) {
                mostrarMensaje("Contraseña Inválida <br/> (Debe tener entre 8 y 20 caracteres)");
                return false;
            }
        }
    }
    return true;
}



// funcion para validar por keypress
function validarkeypress(er,e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

// funcion para validar por keyup
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

// funcion para llenar el formulario usando los datos nativos de DataTables
function pone(pos){
    var d = tablaEmpleados.row($(pos).closest('tr')).data();

    $("#cedulaEmpleado").val(d.cedula);
    $("#nombreEmpleado").val(d.nombre);   
    $("#apellidoEmpleado").val(d.apellido); 
    $("#tlfEmpleado").val(d.telefono);      
    $("#correoEmpleado").val(d.correo); 
    cargarRoles(d.id_rol); 
    
    $("#contraEmpleado").val(""); 
    $("#btnGuardar").text('modificar');
    $("#btnEliminar").show();
    $("#modalUsuario").modal("show");
}

function eliminar(pos){
    var d = tablaEmpleados.row($(pos).closest('tr')).data();

    alertaEliminar(function() {
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('cedulaEmpleado', d.cedula);
        enviaAjax(datos);
    });
}

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=empleados",
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
                
                if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Empleado Registrado'){
                        $("#modalUsuario").modal("hide");
                        consultar(); // Recarga DataTables automáticamente
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Empleado Modificado'){
                        $("#modalUsuario").modal("hide");
                        consultar(); // Recarga DataTables automáticamente
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Empleado Eliminado'){
                        consultar(); // Recarga DataTables automáticamente
                    }
                } 
                else if(lee.resultado == "error"){
                    mostrarMensaje(lee.mensaje);
                }
            } catch(e){
                alert("Error en JSON" + e.name);
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

function cargarRoles(valorSeleccionado = "") {
    $.ajax({
        url: "index.php?pagina=empleados",
        type: "POST",
        data: { accion: 'listar_roles' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#rolEmpleado");
            select.find('option:not(:first)').remove();
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_rol + '">' + item.nombre + '</option>');
            });
            if(valorSeleccionado != "") {
                select.val(valorSeleccionado);
            }
        }
    });
}

function limpia(){
    $("#cedulaEmpleado").val("");
    $("#nombreEmpleado").val("");
    $("#apellidoEmpleado").val("");
    $("#tlfEmpleado").val("");
    $("#correoEmpleado").val("");
    $("#rolEmpleado").val("");
    $("#contraEmpleado").val("");
}