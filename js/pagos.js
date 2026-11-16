// Variable global para controlar la instancia de DataTables
var tablaPagos;

function consultar(){
    if ($.fn.DataTable.isDataTable('#tablaPagos')) {
        tablaPagos.ajax.reload(null, false);
        return;
    }

    tablaPagos = $('#tablaPagos').DataTable({
        autoWidth: false,
        order: [],                       // Sin orden inicial por defecto
        lengthChange: false,             // Quita el selector "Mostrar X registros" de la vista predeterminada
        layout: {
            topStart: { div: { html: '<h6 class="fw-bold text-uppercase m-0"><i class="bi bi-credit-card-2-front"></i> Métodos de Pago</h6>' } },
            topEnd: [
                { search: { placeholder: 'Buscar...', text: '' } },
                document.getElementById('btnNuevoPago')
            ]
        },
        ajax: {
            url: "index.php?pagina=pagos",
            type: "POST",
            data: function (d) { d.accion = 'consultar'; },
            dataSrc: "mensaje" // Los datos puros en formato JSON vienen en 'mensaje'
        },
        columns: [
            { data: "id_metodo", visible: false }, // 0: ID oculto
            { data: "banco",     visible: false }, // 1: Banco oculto
            { data: "cedula",    visible: false }, // 2: Cédula / Correo oculto
            { data: "telefono",  visible: false }, // 3: Teléfono / Titular oculto
            { 
                data: "banco",                         // 4: TIPO (Visible)
                render: function (data) {
                    var esZelle = (data.toLowerCase() === 'zelle');
                    return esZelle ? "ZELLE" : "PAGO MÓVIL";
                }
            },
            { 
                data: null,                            // 5: BANCO / NOMBRE (Visible)
                render: function (data, type, row) {
                    var esZelle = (row.banco.toLowerCase() === 'zelle');
                    return esZelle ? row.telefono : row.banco; // Si es zelle muestra titular/teléfono según aplique o detalle
                }
            },
            {
                data: null,                            // 6: OPCIONES (Visible)
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

    // logica para cambiar dinamicamente las etiquetas y campos segun el metodo
    $("#banco").on("change", function(){
        var metodo = $(this).val();
        
        // limpia los campos al cambiar de método
        $("#input_dato_1, #input_dato_2, #input_dato_3").val("");
        $("#sinput_dato_1, #sinput_dato_2, #sinput_dato_3").text("");

        if(metodo === "Pago Móvil"){
            $("#contenedor_dato_1").show(); 
            $("#label_dato_1").text("BANCO");
            $("#label_dato_2").text("CÉDULA");
            $("#label_dato_3").text("TELÉFONO");
          
            $("#input_dato_1").attr("placeholder", "Ej: Banesco, Mercantil...");
            $("#input_dato_2").attr("placeholder", "Ej: 27000000");
            $("#input_dato_3").attr("placeholder", "Ej: 0414-1234567");
            
        } else if (metodo === "Zelle") {
            $("#contenedor_dato_1").hide(); // oculta el campo banco porque zelle no lo necesita
            $("#label_dato_2").text("CORREO ELECTRÓNICO");
            $("#label_dato_3").text("NOMBRE DEL TITULAR");
            
            $("#input_dato_2").attr("placeholder", "ejemplo@correo.com");
            $("#input_dato_3").attr("placeholder", "Ej: Juan Perez");
        }
    });

    // validaciones dinamicas
    $("#input_dato_1").on("keypress",function(e){
        if($("#banco").val() === "Pago Móvil") validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#input_dato_1").on("keyup",function(){
        if($("#banco").val() === "Pago Móvil") validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,50}$/, $(this), $("#sinput_dato_1"),"Banco inválido - entre 3 y 50 caracteres");
    });

    $("#input_dato_2").on("keypress",function(e){
        if($("#banco").val() === "Pago Móvil") {
            validarkeypress(/^[0-9\.]*$/,e);
        } else {
            validarkeypress(/^[a-zA-z0-9._@-]*$/, e);
        }
    });
    $("#input_dato_2").on("keyup",function(){
        if($("#banco").val() === "Pago Móvil") {
            validarkeyup(/^[0-9\.]{7,12}$/,$(this), $("#sinput_dato_2"),"Cédula inválida - entre 7 y 12 caracteres");
        } else {
            validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/,$(this), $("#sinput_dato_2"),"Correo inválido");
        }
    });

    $("#input_dato_3").on("keypress",function(e){
        if($("#banco").val() === "Pago Móvil") {
            validarkeypress(/^[0-9\-+ ]*$/, e);
        } else {
            validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
        }
    });
    $("#input_dato_3").on("keyup",function(){
        if($("#banco").val() === "Pago Móvil") {
            validarkeyup(/^[0-9\-+ ]{11,12}$/,$(this), $("#sinput_dato_3"),"Teléfono inválido - ej: 0414-0000000");
        } else {
            validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#sinput_dato_3"),"Titular inválido - entre 3 y 100 caracteres");
        }
    });

    // botones
    $("#btnGuardar").on("click", function() {
        if(validarEnvio()){
            var datos = new FormData();
            var accion = $(this).text().trim().toLowerCase(); 
            
            datos.append('accion', accion);
            datos.append('id_metodo', $("#id_metodo").val());
            datos.append('banco', $("#banco").val());
            
            if($("#banco").val() === "Pago Móvil") {
                datos.append('nombre_banco', $("#input_dato_1").val());
                datos.append('cedula', $("#input_dato_2").val());
                datos.append('telefono', $("#input_dato_3").val());
            } else if ($("#banco").val() === "Zelle") {
                datos.append('correo_zelle', $("#input_dato_2").val());
                datos.append('titular_zelle', $("#input_dato_3").val());
            }

            enviaAjax(datos);
        }
    });

    $("#btnNuevoPago").on("click", function(){
        limpia();
        $("#btnGuardar").text("INCLUIR"); 
        $("#modalPago").modal("show");
    });
});

// funciones
function validarEnvio() {
    var metodo = $("#banco").val();

    if(!metodo) {
        mostrarMensaje("Debe seleccionar un MÉTODO DE PAGO");
        return false;
    }

    if(metodo === "Pago Móvil") {
        if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,50}$/, $("#input_dato_1"),$("#sinput_dato_1"),"")==0){
            mostrarMensaje("Banco Inválido <br/>(Solo letras entre 3 y 50 caracteres)");
            return false;
        }
        if(validarkeyup(/^[0-9\.]{7,12}$/,$("#input_dato_2"), $("#sinput_dato_2"),"")==0){
            mostrarMensaje("Cédula Inválida <br/>(El formato debe ser numérico)");    
            return false;                   
        }
        if(validarkeyup(/^[0-9\-+ ]{11,12}$/,$("#input_dato_3"), $("#sinput_dato_3"),"")==0){
            mostrarMensaje("Teléfono Inválido <br>(Formato sugerido: 0414-0000000)");    
            return false;                   
        }
    } else if (metodo === "Zelle") {
        if(validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $("#input_dato_2"), $("#sinput_dato_2"),"") == 0){
            mostrarMensaje("Correo Zelle Inválido <br/>(Formato incorrecto)");
            return false;
        }
        if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#input_dato_3"),$("#sinput_dato_3"),"")==0){
            mostrarMensaje("Titular Inválido <br>(Solo letras entre 3 y 100 caracteres)");
            return false;
        }
    }

    return true;
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

// funcion para llenar el formulario usando DataTables
function pone(pos){
    var d = tablaPagos.row($(pos).closest('tr')).data();

    $("#id_metodo").val(d.id_metodo);

    if(d.banco.toLowerCase() === "zelle") {
        $("#banco").val("Zelle").trigger("change");
        $("#input_dato_2").val(d.cedula);   // Correo
        $("#input_dato_3").val(d.telefono); // Titular
    } else {
        $("#banco").val("Pago Móvil").trigger("change");
        $("#input_dato_1").val(d.banco);    // Nombre del banco
        $("#input_dato_2").val(d.cedula);   // Cédula
        $("#input_dato_3").val(d.telefono); // Teléfono
    }
    
    $("#btnGuardar").text("MODIFICAR");
    $("#modalPago").modal("show");
}

function eliminar(pos){
    var d = tablaPagos.row($(pos).closest('tr')).data();

    alertaEliminar(function() {
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_metodo', d.id_metodo);
        
        enviaAjax(datos);
    });
}

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=pagos", 
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        beforeSend: function () {},
        timeout: 10000,
        success: function (respuesta){
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'consultar'){
                    // DataTables maneja esto mediante ajax.reload automático en las acciones
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Método Registrado'){
                        $("#modalPago").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Método Modificado'){
                        $("#modalPago").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Método Eliminado'){
                        $("#modalPago").modal("hide");
                        consultar();
                    }
                } 
                else if(lee.resultado == "error"){
                    mostrarMensaje(lee.mensaje);
                }
            } catch(e){
                alert("Error en JSON: " + e.name);
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
    $("#id_metodo").val("");
    $("#banco").val("Pago Móvil").trigger("change");
    $("#input_dato_1").val("");
    $("#input_dato_2").val("");
    $("#input_dato_3").val("");
    $("#sinput_dato_1").text("");
    $("#sinput_dato_2").text("");
    $("#sinput_dato_3").text("");
}