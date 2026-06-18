$(document).ready(function(){
    cargarTablas();

    $("#cedula").on("keypress", function(e){ validarkeypress(/^[0-9-\b]*$/, e); });
    $("#banco").on("keypress", function(e){ validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/, e); });
    $("#telefono").on("keypress", function(e){ validarkeypress(/^[0-9-\b]*$/, e); });

    $("#btnGuardar").on("click", function(e){
        e.preventDefault();
        var accion = $(this).text().toLowerCase();
        
        if(validarenvio()){
            var datos = new FormData();
            datos.append('accion', accion);
            datos.append('id_metodo', $("#id_metodo").val());
            datos.append('banco', $("#banco").val());
            datos.append('cedula', $("#cedula").val());
            datos.append('telefono', $("#telefono").val());
            enviaAjax(datos);
        }
    });
    $("#eliminar").on("click", function(e){
        e.preventDefault();
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_metodo', $("#id_metodo").val());
        enviaAjax(datos);
    });

    $("#btnNuevoPago").on("click", function(){
        limpia();
        $("#btnGuardar").text("Incluir");
        $("#eliminar").hide();
    });
});

$(document).on('click', '.btn-consultar-pago', function(){
    var id = $(this).data('id'); 
    var datos = new FormData();
    datos.append('accion', 'obtener_pago');
    datos.append('id_metodo', id);
    enviaAjax(datos);
});

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: '?pagina=pagos',
        type: 'POST',
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function(respuesta) {
            try {
                let lee = JSON.parse(respuesta);
                
                if(lee.resultado == 'consultar'){
                    $("#cuerpoTablaPagos").html(lee.mensaje);
                } 
                else if(lee.resultado == 'obtener_pago'){
                    $("#id_metodo").val(lee.id_metodo);
                    $("#banco").val(lee.banco);
                    $("#cedula").val(lee.cedula);
                    $("#telefono").val(lee.telefono);
                    $("#btnGuardar").text("Modificar");
                    $("#eliminar").show();
                    $("#modalPago").modal("show");
                }
                else {
                    muestraMensaje(lee.mensaje);
                    $("#modalPago").modal("hide");
                    cargarTablas();
                    limpia();
                }
            } catch (e) {
                console.error("Error al procesar respuesta: ", respuesta);
            }
        },
        error: function(){ muestraMensaje("Error de conexión"); }
    }); 
}

function cargarTablas() {
    var d = new FormData(); 
    d.append('accion', 'consultar');
    enviaAjax(d);
}

function limpia(){
    $("#id_metodo").val("");
    $("#banco").val("");
    $("#cedula").val("");
    $("#telefono").val("");
}

function muestraMensaje(mensaje){
    $("#contenidodemodal").html(mensaje);
    $("#mostrarmodal").modal("show");
    setTimeout(function() { $("#mostrarmodal").modal("hide"); }, 3000);
}

function validarenvio(){
    if(validarkeyup(/^[0-9]{7,8}$/, $("#cedula"), $("#scedula"), "Formato: 9999999") == 0){
        muestraMensaje("La cédula debe coincidir con el formato 9999999");    
        return false;                   
    }
    return true;
}

function validarkeypress(er, e){
    if(!er.test(String.fromCharCode(e.keyCode))) e.preventDefault();
}

function validarkeyup(er, etiqueta, etiquetamensaje, mensaje){
    if(er.test(etiqueta.val())){ etiquetamensaje.text(""); return 1; } 
    else { etiquetamensaje.text(mensaje); return 0; }
}