$(document).ready(function(){
    // Cargar datos apenas abre la página
    cargarMembresias();
    cargarMetodos();

    // Eventos para calcular el monto total en vivo
    $("#id_membresia").on("change", calcularMonto);
    $("#cantidad").on("keyup change", calcularMonto);

    // Validación para que solo escriba números en referencia (y máximo 12)
    $("#referencia").on("keypress", function(e){
        validarkeypress(/^[0-9]*$/, e);
    });

    // Validar cantidad (solo números)
    $("#cantidad").on("keypress", function(e){
        validarkeypress(/^[0-9]*$/, e);
    });

    // Botón Enviar
    $("#btnPagar").on("click", function(){
        if(validarEnvio()){
            var datos = new FormData();
            datos.append('accion', 'incluir');
            datos.append('id_membresia', $("#id_membresia").val());
            datos.append('cantidad', $("#cantidad").val());
            datos.append('id_metodo', $("#id_metodo").val());
            datos.append('monto', $("#monto").val());
            datos.append('referencia', $("#referencia").val());
            
            enviaAjax(datos);
        }
    });
});

// Función para multiplicar Precio x Cantidad
function calcularMonto() {
    // Busca el data-monto de la opción seleccionada
    var monto_base = $("#id_membresia option:selected").attr("data-monto");
    var cantidad = $("#cantidad").val();

    if(monto_base && cantidad && cantidad > 0) {
        var total = parseFloat(monto_base) * parseInt(cantidad);
        $("#monto").val(total.toFixed(2)); // Coloca el total con 2 decimales
    } else {
        $("#monto").val("");
    }
}

// Cargar Membresías por AJAX
function cargarMembresias() {
    $.ajax({
        url: "index.php?pagina=pago",
        type: "POST",
        data: { accion: 'listar_membresias' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#id_membresia");
            select.find('option:not(:first)').remove();
            
            $.each(data, function(index, item) {
                // guarda el monto en un atributo data-monto para leerlo luego
                select.append('<option value="' + item.id_membresia + '" data-monto="' + item.monto + '">' + item.tipo + ' ($' + item.monto + ')</option>');
            });
        }
    });
}

// Cargar Bancos por AJAX
function cargarMetodos() {
    $.ajax({
        url: "index.php?pagina=pago",
        type: "POST",
        data: { accion: 'listar_metodos' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#id_metodo");
            select.find('option:not(:first)').remove();
            
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_metodo + '">' + item.banco + '</option>');
            });
        }
    });
}

// Validar todo antes de mandar el AJAX
function validarEnvio() {
    if($("#id_membresia").val() == null || $("#id_membresia").val() == "") {
        mostrarMensaje("Debe seleccionar un plan de membresía.");
        return false;
    }
    else if($("#cantidad").val() == "" || $("#cantidad").val() <= 0) {
        mostrarMensaje("La cantidad a pagar debe ser mayor a 0.");
        return false;
    }
    else if($("#id_metodo").val() == null || $("#id_metodo").val() == "") {
        mostrarMensaje("Debe seleccionar un banco o método de pago.");
        return false;
    }
    // Validar referencia entre 6 y 12 dígitos
    else if($("#referencia").val().length < 6) {
        mostrarMensaje("La referencia es inválida (Mínimo 6 dígitos).");
        return false;
    }
    return true;
}

// Función principal de envío AJAX
function enviaAjax(datos) {
    $.ajax({
        async: true,
        url: "index.php?pagina=pago",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta){
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    // Limpiar el formulario si fue exitoso
                    $("#formPago")[0].reset();
                } 
                else if(lee.resultado == 'error'){
                    mostrarMensaje(lee.mensaje);
                }
            } catch(e){
                mostrarMensaje("Error en servidor, intente de nuevo.");
            }
        },
        error: function(request, status, err){
            mostrarMensaje("ERROR: <br/>" + request + status + err);
        }
    });
}

function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() { $("#mostrarModal").modal("hide"); }, 5000);
}

function validarkeypress(er,e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}