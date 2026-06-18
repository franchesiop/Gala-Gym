$(document).ready(function(){
    cargarMembresias();
    cargarMetodos(); 

    $("#id_membresia").on("change", function(){
        let monto = $(this).find(':selected').data('monto');
        $("#monto").val(monto);
    });

    $("#btnPagar").on("click", function(e){
        e.preventDefault();
        if($("#id_membresia").val() == null || $("#id_metodo").val() == null || $("#referencia").val() == "") {
            alert("Por favor, completa todos los campos.");
            return;
        }

        var datos = new FormData();
        datos.append('accion', 'registrar_pago');
        datos.append('id_membresia', $("#id_membresia").val());
        datos.append('monto', $("#monto").val());
        datos.append('referencia', $("#referencia").val());
        datos.append('id_metodo', $("#id_metodo").val());

        enviaAjaxPago(datos);
    });
});

function cargarMembresias() {
    var datos = new FormData();
    datos.append('accion', 'consultar_membresias');
    $.ajax({
        url: '?pagina=pago',
        type: 'POST',
        data: datos,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            try {
                let lista = JSON.parse(respuesta);
                let select = $("#id_membresia");
                lista.forEach(function(item){
                    select.append(`<option value='${item.id_membresia}' data-monto='${item.monto}'>${item.tipo} - $${item.monto}</option>`);
                });
            } catch (e) { console.error("Error membresías: ", respuesta); }
        }
    });
}

function cargarMetodos() {
    var datos = new FormData();
    datos.append('accion', 'consultar_metodos');
    $.ajax({
        url: '?pagina=pago',
        type: 'POST',
        data: datos,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            try {
                let lista = JSON.parse(respuesta);
                let select = $("#id_metodo");
                lista.forEach(function(item){
                    select.append(`<option value='${item.id_metodo}'>${item.banco} - ${item.telefono} - ${item.cedula}</option>`);
                });
            } catch (e) { console.error("Error métodos: ", respuesta); }
        }
    });
}

function enviaAjaxPago(datos) {
    $.ajax({
        url: '?pagina=pago',
        type: 'POST',
        data: datos,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            try {
                let lee = JSON.parse(respuesta);
                alert(lee.mensaje);
                if(lee.resultado == 'exito'){
                    $("#formPago")[0].reset();
                    $("#monto").val("");
                }
            } catch (e) { console.error("Error al procesar: ", respuesta); }
        },
        error: function(){ alert("Error de conexión"); }
    }); 
}