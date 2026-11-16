// Variable global para controlar la instancia de DataTables
var tablaClientes;

function consultar(){
    if ($.fn.DataTable.isDataTable('#tablaClientes')) {
        tablaClientes.ajax.reload(null, false);
        return;
    }

    tablaClientes = $('#tablaClientes').DataTable({
        autoWidth: false,
        order: [],                       // sin orden inicial (como empleados)
        lengthChange: false,             // quita "Mostrar X registros"
        layout: {
            topStart: { div: { html: '<h6 class="fw-bold text-uppercase m-0"><i class="bi bi-person"></i> Clientes</h6>' } },
            topEnd: [
                { search: { placeholder: 'Buscar...', text: '' } },
                document.getElementById('btnNuevoCliente')
            ]
        },
        ajax: {
            url: "index.php?pagina=clientes",
            type: "POST",
            data: function (d) { d.accion = 'consultar'; },
            dataSrc: "mensaje"
        },
        columns: [
            { data: "cedula",       type: "string" },   // evita alineación derecha
            { data: "nombre" },
            { data: "apellido" },
            { data: "telefono",     type: "string" },
            { data: "correo",       visible: false },   // oculta de verdad
            { data: "id_membresia", visible: false },
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
    
    //validacion de datos
    //validacion cedula
    $("#cedulaCliente").on("keypress",function(e){
        validarkeypress(/^[0-9]*$/,e); 
    });
    $("#cedulaCliente").on("keyup",function(){
        validarkeyup(/^[0-9]{7,9}$/,$(this), $("#scedulaCliente"),"Cédula inválida - entre 7 y 9 números (sin puntos)");
    });

    //validacion nombre
     $("#nombreCliente").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#nombreCliente").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $(this),$("#snombreCliente"),"Nombre inválido - sin espacios, entre 3 y 25 letras");
    });

    //validacion apellido
     $("#apellidoCliente").on("keypress",function(e){
        validarkeypress(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#apellidoCliente").on("keyup",function(){
        validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $(this),$("#sapellidoCliente"),"Apellido inválido - sin espacios, entre 3 y 25 letras");
    });

    //validacion telefono 
     $("#tlfCliente").on("keypress",function(e){
        validarkeypress(/^[0-9]*$/, e); 
    });
    $("#tlfCliente").on("keyup",function(){
        validarkeyup(/^(0412|0422|0414|0424|0416|0426)[0-9]{7}$/,$(this), $("#stlfCliente"),"Teléfono inválido - Ej: 04141234567 (11 números)");
    });

    //validacion correo
    $("#correoCliente").on("keypress",function(e){
        validarkeypress(/^[a-zA-z0-9._@-]*$/, e);
    });
    $("#correoCliente").on("keyup",function() {
        validarkeyup(/^[a-zA-Z0-9]+([._-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}$/,$(this), $("#scorreoCliente"),"Correo inválido - Verifica el formato");
    });

    //validar contrasena
    $("#contraCliente").on("keypress",function(e) {
        validarkeypress(/^[a-zA-Z0-9!@#$%^&*]*$/, e);
    });
    $("#contraCliente").on("keyup", function(e) {
        validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/,$(this), $("#scontraCliente"),"Contrasena invalida - entre 8 y 20 caracteres")
    });

    //botones
    $("#btnGuardar").on("click", function() {
        //guardar
         if($(this).text() == 'incluir'){
            if(validarEnvio()){
              var datos = new FormData();
              datos.append('accion', 'incluir');
              datos.append('cedulaCliente', $("#cedulaCliente").val());
              datos.append('nombreCliente', $("#nombreCliente").val());
              datos.append('apellidoCliente', $("#apellidoCliente").val());
              datos.append('tlfCliente', $("#tlfCliente").val());
              datos.append('correoCliente', $("#correoCliente").val());
              datos.append('contraCliente', $("#contraCliente").val());
              datos.append('membresiaCliente', $("#membresiaCliente").val());
              enviaAjax(datos);
            }
        }
        //modificar
         else if($(this).text() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('cedulaCliente', $("#cedulaCliente").val());
                datos.append('nombreCliente', $("#nombreCliente").val());
                datos.append('apellidoCliente', $("#apellidoCliente").val());
                datos.append('tlfCliente', $("#tlfCliente").val());
                datos.append('correoCliente', $("#correoCliente").val());
                datos.append('contraCliente', $("#contraCliente").val());
                datos.append('membresiaCliente', $("#membresiaCliente").val());
                enviaAjax(datos);
            }
        }
    });

    $("#btnNuevoCliente").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir"); 
        $("#btnEliminar").hide();
        cargarMembresias(); 
        $("#modalUsuario").modal("show");
    });

});

//validar antes de enviar
function validarEnvio() {
    //validar cedula 
    if(validarkeyup(/^[0-9]{7,9}$/,$("#cedulaCliente"), $("#scedulaCliente"),"Cédula inválida - (Entre 7 y 9 números, sin puntos)")==0){
        mostrarMensaje("Cédula Inválida <br/>" + "(Debe tener entre 7 y 9 números, sin puntos ni guiones)");    
        return false;                   
    }
    //validar nombre 
     else if(validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $("#nombreCliente"),$("#snombreCliente"),"Nombre inválido - (Un solo nombre, entre 3 y 25 letras)")==0){
        mostrarMensaje("Nombre Inválido <br>" + "(Debe ser un solo nombre sin espacios, entre 3 y 25 letras)");
        return false;
    }
    //validar apellido 
    else if(validarkeyup(/^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]{3,25}$/, $("#apellidoCliente"),$("#sapellidoCliente"),"Apellido inválido - (Un solo apellido, entre 3 y 25 letras)")==0){
        mostrarMensaje("Apellido Inválido <br>" + "(Debe ser un solo apellido sin espacios, entre 3 y 25 letras)");
        return false;
    }
    //validar telefono 
    else if(validarkeyup(/^(0412|0422|0414|0424|0416|0426)[0-9]{7}$/,$("#tlfCliente"), $("#stlfCliente"),"Teléfono inválido - (Ej: 04141234567)")==0){
        mostrarMensaje("Teléfono Inválido <br>" + "(Debe empezar con prefijo válido y tener 11 números, sin guiones)");    
        return false;                   
    }
    //validar correo 
    else if(validarkeyup(/^[a-zA-Z0-9]+([._-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}$/, $("#correoCliente"), $("#scorreoCliente"),"Correo inválido") == 0){
        mostrarMensaje("Correo Inválido <br/>" + "(Verifica que el formato sea correcto)");
        return false;
    }
    //validar contrasena
    else {
        var contra = $("#contraCliente").val();
        var esModificar = ($("#btnGuardar").text().trim().toLowerCase() == 'modificar');

        if (!(esModificar && contra === "")) {
            if (validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/, $("#contraCliente"), $("#scontraCliente"), "Contraseña inválida") == 0) {
                mostrarMensaje("Contraseña Inválida <br/> (Debe tener entre 8 y 20 caracteres)");
                return false;
            }
        }
    }
    return true;
}


// funcion apra validar por keypress
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

// funcion para llenar el formulario
function pone(pos){
    var d = tablaClientes.row($(pos).closest('tr')).data();

    $("#cedulaCliente").val(d.cedula);
    $("#nombreCliente").val(d.nombre);
    $("#apellidoCliente").val(d.apellido);
    $("#tlfCliente").val(d.telefono);
    $("#correoCliente").val(d.correo);
    cargarMembresias(d.id_membresia);
    $("#contraCliente").val("");
    $("#btnGuardar").text('modificar');
    $("#modalUsuario").modal("show");
}

function eliminar(pos){
    var d = tablaClientes.row($(pos).closest('tr')).data();

    alertaEliminar(function() {
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('cedulaCliente', d.cedula);
        enviaAjax(datos);
    });
}

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=clientes",
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
                
                // Se eliminó la validación 'consultar' porque DataTables lo dibuja automáticamente
                if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Cliente Registrado'){
                        $("#modalUsuario").modal("hide");
                        consultar(); // Esto recargará DataTables automáticamente
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Cliente Modificado'){
                        $("#modalUsuario").modal("hide");
                        consultar(); // Esto recargará DataTables automáticamente
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Cliente Eliminado'){
                        consultar(); // Esto recargará DataTables automáticamente
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

function cargarMembresias(valorSeleccionado = "") {
    $.ajax({
        url: "index.php?pagina=clientes",
        type: "POST",
        data: { accion: 'listar_membresias' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#membresiaCliente");
            select.find('option:not(:first)').remove();
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_membresia + '">' + item.tipo + '</option>');
            });
            if(valorSeleccionado != "") {
                select.val(valorSeleccionado);
            }
        }
    });
}

function limpia(){
    $("#cedulaCliente").val("");
    $("#nombreCliente").val("");
    $("#apellidoCliente").val("");
    $("#tlfCliente").val("");
    $("#correoCliente").val("");
    $("#membresiaCliente").val("");
    $("#contraCliente").val("");
}