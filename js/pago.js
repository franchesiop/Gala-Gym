$(document).ready(function(){
    // Cargar datos apenas abre la página
    cargarMembresias();
    cargarMetodos();

    // Eventos para calcular el monto total en vivo
    $("#id_membresia").on("change", calcularMonto);
    $("#cantidad").on("keyup change", calcularMonto);

    // Evento delegado: Cuando el usuario selecciona una tarjeta de método de pago
    $("#contenedorMetodos").on("change", ".metodo-radio", function() {
        var idSeleccionado = $(this).val();
        var banco = $(this).data("banco");
        
        // Guardar el ID en el input oculto
        $("#id_metodo").val(idSeleccionado);
        
        // Habilitar el input de referencia y enfocarlo
        $("#referencia").prop("disabled", false).val("").focus();

        // Cambiar el placeholder y ayuda según el método
        if(banco && banco.toLowerCase() === 'zelle') {
            $("#referencia").attr("placeholder", "Ingresa el Confirmation Number");
            $("#ayudaReferencia").text("Zelle acepta letras, números y guiones.");
        } else {
            $("#referencia").attr("placeholder", "Ej: 12345678");
            $("#ayudaReferencia").text("Ingresa la referencia numérica bancaria.");
        }
    });

    // Validación inteligente de la referencia según la tarjeta seleccionada
    $("#referencia").on("keypress", function(e){
        // Buscar el radio button que está :checked
        var metodoSeleccionado = $(".metodo-radio:checked");
        var banco = metodoSeleccionado.data("banco");
        
        if(banco && banco.toLowerCase() === 'zelle') {
            // Zelle permite letras, números y guiones
            validarkeypress(/^[a-zA-Z0-9\-]*$/, e);
        } else {
            // Bancos tradicionales solo números
            validarkeypress(/^[0-9]*$/, e);
        }
    });

    // Validar cantidad (solo números)
    $("#cantidad").on("keypress", function(e){
        validarkeypress(/^[0-9]*$/, e);
    });

    // Botón Enviar Principal -> Abre el Modal de Confirmación
    // Botón Enviar Principal -> Abre el Modal de Confirmación
    $("#btnPagar").on("click", function(){
        if(validarEnvio()){
            var nombrePlan = $("#id_membresia option:selected").text();
            var cantidad = $("#cantidad").val();
            var montoTotal = $("#textoMonto").text();
            var referencia = $("#referencia").val();
            
            // Extraer datos de la tarjeta seleccionada
            var metodoSeleccionado = $(".metodo-radio:checked");
            var nombreBanco = metodoSeleccionado.data("banco").toUpperCase(); // Lo ponemos en mayúscula para que resalte
            var cedula = metodoSeleccionado.data("cedula");
            var telefono = metodoSeleccionado.data("telefono");

            // Formatear los datos de destino para el modal integrando el nombre del banco
            var datosDestino = "";
            if(nombreBanco.toLowerCase() === 'zelle') {
                datosDestino = nombreBanco + " | Correo: " + cedula + " | Titular: " + telefono;
            } else {
                datosDestino = nombreBanco + " | Cédula/RIF: " + cedula + " | Tel: " + telefono;
            }

            // Rellenar el modal
            $("#confPlan").text(nombrePlan);
            $("#confCantidad").text(cantidad);
            $("#confMonto").text(montoTotal);
            $("#confReferencia").text(referencia);
            $("#confDatosDestino").text(datosDestino);

            // Mostrar el modal
            $("#modalConfirmarPago").modal("show");
        }
    });

    // Botón Definitivo dentro del Modal de Confirmación
    $("#btnConfirmarEnvio").on("click", function(){
        $("#modalConfirmarPago").modal("hide");

        var datos = new FormData();
        datos.append('accion', 'incluir');
        datos.append('id_membresia', $("#id_membresia").val());
        datos.append('cantidad', $("#cantidad").val());
        datos.append('id_metodo', $("#id_metodo").val());
        datos.append('monto', $("#monto").val());
        datos.append('referencia', $("#referencia").val());
        
        enviaAjax(datos);
    });
});

// Función para multiplicar Precio x Cantidad y mostrarlo
function calcularMonto() {
    var monto_base = $("#id_membresia option:selected").attr("data-monto");
    var cantidad = $("#cantidad").val();

    if(monto_base && cantidad && cantidad > 0) {
        var total = parseFloat(monto_base) * parseInt(cantidad);
        var totalFormateado = "$" + total.toFixed(2);
        
        $("#textoMonto").text(totalFormateado);
        $("#monto").val(total.toFixed(2));
    } else {
        $("#textoMonto").text("$0.00");
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
                select.append('<option value="' + item.id_membresia + '" data-monto="' + item.monto + '">' + item.tipo + ' ($' + item.monto + ')</option>');
            });
        }
    });
}

// Cargar Bancos por AJAX creando tarjetas clickeables
function cargarMetodos() {
    $.ajax({
        url: "index.php?pagina=pago",
        type: "POST",
        data: { accion: 'listar_metodos' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var contenedor = $("#contenedorMetodos");
            contenedor.empty();
            
            $.each(data, function(index, item) {
                var esZelle = item.banco.toLowerCase() === 'zelle';
                var icono = esZelle ? 'bi-currency-exchange' : 'bi-bank';
                var label1 = esZelle ? 'Correo:' : 'C.I/RIF:';
                var label2 = esZelle ? 'Titular:' : 'Tel:';
                
                // Construcción de la tarjeta usando btn-check de Bootstrap
                var tarjetaHTML = `
                <div class="col-md-6">
                    <input type="radio" class="btn-check metodo-radio" name="opcion_metodo" id="metodo_${item.id_metodo}" value="${item.id_metodo}" data-banco="${item.banco}" data-cedula="${item.cedula}" data-telefono="${item.telefono}">
                    <label class="btn btn-outline-dark w-100 rounded-0 text-start p-3 h-100 shadow-sm" for="metodo_${item.id_metodo}">
                        <div class="d-flex align-items-center mb-2 border-bottom border-dark-subtle pb-2">
                            <i class="bi ${icono} fs-4 me-2"></i>
                            <h6 class="fw-bold m-0 text-uppercase">${item.banco}</h6>
                        </div>
                        <div class="small lh-sm">
                            <div class="mb-1"><span class="text-muted">${label1}</span> <span class="fw-bold">${item.cedula}</span></div>
                            <div><span class="text-muted">${label2}</span> <span class="fw-bold">${item.telefono}</span></div>
                        </div>
                    </label>
                </div>`;
                
                contenedor.append(tarjetaHTML);
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
    else if($("#id_metodo").val() == "") {
        mostrarMensaje("Debe seleccionar a qué cuenta realizó la transferencia.");
        return false;
    }
    else if($("#referencia").val().trim() == "" || $("#referencia").val().length < 4) {
        mostrarMensaje("Debe ingresar un número de referencia válido.");
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
                    // Limpiar el formulario
                    $("#formPago")[0].reset();
                    $("#textoMonto").text("$0.00");
                    $("#id_metodo").val("");
                    // Deshabilitar y limpiar referencia
                    $("#referencia").prop("disabled", true).attr("placeholder", "Selecciona un método primero").val("");
                    // Quitar la selección visual de las tarjetas
                    $(".metodo-radio").prop("checked", false);
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