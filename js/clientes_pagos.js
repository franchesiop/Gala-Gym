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
        lengthChange: false,             // Quita el selector "Mostrar X registros" por defecto (dejando el layout limpio)
        layout: {
            topStart: { div: { html: '<h6 class="fw-bold text-uppercase m-0"><i class="bi bi-cash-coin"></i> Gestión de Pagos</h6>' } },
            topEnd: [
                { search: { placeholder: 'Buscar...', text: '' } },
                document.getElementById('btnNuevoPago')
            ]
        },
        ajax: {
            url: "index.php?pagina=clientes_pagos",
            type: "POST",
            data: function (d) { d.accion = 'consultar'; },
            dataSrc: "mensaje" // Los datos puros vienen en el arreglo asociativo 'mensaje'
        },
        columns: [
            { data: "id_pago",      visible: false }, // Columna oculta para referencias internas
            { data: "cedula",       visible: false }, // Columna oculta para búsquedas por cédula
            { data: "fecha",        type: "string" },
            { 
                data: null,
                render: function (data, type, row) {
                    return row.nombre + " " + row.apellido;
                }
            },
            { data: "referencia",   type: "string" },
            { 
                data: "monto",
                render: function (data) {
                    return "$" + data;
                }
            },
            { 
                data: "estado_pago",
                className: "text-center",
                render: function (data) {
                    if (data == 0) {
                        return "<span class='badge bg-warning text-dark'>Pendiente</span>";
                    } else if (data == 1) {
                        return "<span class='badge bg-success'>Aprobado</span>";
                    } else {
                        return "<span class='badge bg-danger'>Rechazado</span>";
                    }
                }
            },
            {
                data: null,
                orderable: false,
                className: "text-center",
                render: function (data, type, row) {
                    // Preparamos los atributos data-* para la función ver_detalles
                    var datosModal = `data-fecha='${row.fecha}' data-cliente='${row.nombre} ${row.apellido}' data-cedula='${row.cedula}' data-referencia='${row.referencia}' data-monto='${row.monto}' data-metodo='${row.metodo}' data-mcedula='${row.metodo_cedula}' data-mtelefono='${row.metodo_telefono}'`;
                    
                    var btnDetalles = `<button type='button' class='btn btn-dark btn-sm rounded-0 fw-bold m-1' onclick='ver_detalles(this)' title='Ver Detalles' ${datosModal}><i class='bi bi-receipt me-1'></i> DETALLES</button>`;

                    if (row.estado_pago == 0) {
                        return `<div class='d-flex justify-content-center'>
                                    ${btnDetalles}
                                    <button type='button' class='btn btn-success text-white small-width m-1' onclick='aprobar_pago(this)' title='Aprobar'><i class='bi bi-check-circle'></i></button>
                                    <button type='button' class='btn btn-danger small-width m-1' onclick='rechazar_pago(this)' title='Rechazar'><i class='bi bi-x-circle'></i></button>
                                </div>`;
                    } else {
                        return `<div class='d-flex justify-content-center'>
                                    ${btnDetalles}
                                </div>`;
                    }
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

    // VALIDACIONES DE DATOS (Teclado)
    $("#referencia").on("keypress", function(e){ validarkeypress(/^[0-9]*$/, e); });
    $("#referencia").on("keyup", function(){
        validarkeyup(/^[0-9]{4,20}$/, $(this), $("#sreferencia"), "Referencia inválida (solo números)");
    });

    $("#monto").on("keypress", function(e){ validarkeypress(/^[0-9\.]*$/, e); });
    $("#monto").on("keyup", function(){
        validarkeyup(/^[0-9]+(\.[0-9]{1,2})?$/, $(this), $("#smonto"), "Monto inválido (Ej: 30.00)");
    });

    $("#cantidadPeriodos").on("keypress", function(e){ validarkeypress(/^[0-9]*$/, e); });
    $("#cantidadPeriodos").on("keyup", function(){
        validarkeyup(/^[1-9][0-9]*$/, $(this), $("#scantidadPeriodos"), "Mínimo 1 período");
    });

    // LÓGICA DEL MODAL DE CLIENTES
    $("#listarClienteBtn").on("click", function(){
        $.ajax({
            url: 'index.php?pagina=clientes_pagos',
            type: 'POST',
            data: { accion: 'listar_clientes' }, 
            success: function(respuesta){
                try {
                    var data = JSON.parse(respuesta);
                    var html = "";
                    if (data.length > 0) {
                        $.each(data, function(index, cliente) {
                             html += `<tr style="cursor:pointer" onclick="colocacliente(this);">
                                         <td style="display:none">${cliente.id_cliente}</td>
                                         <td>${cliente.cedula}</td>
                                         <td>${cliente.nombre} ${cliente.apellido}</td>
                                         <td>${cliente.telefono || 'N/A'}</td>
                                     </tr>`;
                        });
                    } else {
                        html = `<tr><td colspan="4" class="text-center text-muted py-3">No hay clientes registrados</td></tr>`;
                    }
                    $("#listaClientesModal").html(html);
                    $("#modal_clientes").modal("show");
                } catch(e) {
                    console.error("Error al cargar clientes:", e);
                }
            }
        });
    });

    $("#filtrarClientesModal").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        $("#listaClientesModal tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

    // BOTONES Y EVENTOS
    $("#btnGuardar").on("click", function() {
        if(validarEnvio()){
            var datos = new FormData();
            datos.append('accion', 'incluir');
            datos.append('idCliente', $("#idCliente").val());
            datos.append('idMembresia', $("#idMembresia").val());
            datos.append('cantidadPeriodos', $("#cantidadPeriodos").val());
            datos.append('idMetodo', $("#idMetodo").val());
            datos.append('referencia', $("#referencia").val());
            datos.append('monto', $("#monto").val());
            
            enviaAjax(datos);
        }
    });

    $("#btnNuevoPago").on("click", function(){
        limpia();
        cargarMembresias();
        cargarMetodos();
        $("#modalPago").modal("show");
    });

});

// FUNCIONES DE SELECCIÓN Y ACCIÓN 
function colocacliente(tr) {
    var id = $(tr).find("td:eq(0)").text();
    var cedula = $(tr).find("td:eq(1)").text();
    var nombre = $(tr).find("td:eq(2)").text();

    $("#idCliente").val(id); 
    $("#clienteInfo").val(cedula + " - " + nombre); 
    $("#modal_clientes").modal("hide"); 
    $("#sCliente").text(""); 
}

function aprobar_pago(pos) {
    var d = tablaPagos.row($(pos).closest('tr')).data();

    alertaAprobarPago(function() {
        var datos = new FormData();
        datos.append('accion', 'aprobar');
        datos.append('idPago', d.id_pago);
        enviaAjax(datos);
    });
}

function rechazar_pago(pos) {
    var d = tablaPagos.row($(pos).closest('tr')).data();

    alertaRechazarPago(function() {
        var datos = new FormData();
        datos.append('accion', 'rechazar');
        datos.append('idPago', d.id_pago);
        enviaAjax(datos);
    });
}

// Nueva función para ver los detalles estilo factura
function ver_detalles(btn) {
    var fecha = $(btn).data('fecha');
    var cliente = $(btn).data('cliente');
    var cedula = $(btn).data('cedula');
    var referencia = $(btn).data('referencia');
    var monto = $(btn).data('monto');
    
    var metodo = $(btn).data('metodo');
    var mcedula = $(btn).data('mcedula');
    var mtelefono = $(btn).data('mtelefono');

    var textoMetodo = metodo.toLowerCase();

    if (textoMetodo === 'zelle') {
        $("#iconoMetodo").removeClass("bi-bank").addClass("bi-currency-exchange");
        $("#lblMetodo1").html('Correo: <span class="fw-bold text-dark">' + mcedula + '</span>');
        $("#lblMetodo2").html('Titular: <span class="fw-bold text-dark">' + mtelefono + '</span>');
    } else {
        if (textoMetodo.indexOf('banco') === -1) {
            metodo = "Banco " + metodo;
        }
        $("#iconoMetodo").removeClass("bi-currency-exchange").addClass("bi-bank");
        $("#lblMetodo1").html('Cédula/RIF: <span class="fw-bold text-dark">' + mcedula + '</span>');
        $("#lblMetodo2").html('Teléfono: <span class="fw-bold text-dark">' + mtelefono + '</span>');
    }

    $("#detMetodo").text(metodo);
    $("#detFecha").text(fecha);
    $("#detCedula").text(cedula);
    $("#detCliente").text(cliente);
    $("#detReferencia").text(referencia);
    $("#detMonto").text("$" + monto);

    $("#modalDetallePago").modal("show");
}

// VALIDACIÓN ANTES DE ENVIAR
function validarEnvio() {
    if($("#idCliente").val() == "" || $("#clienteInfo").val().trim() == ""){
        mostrarMensaje("Debe seleccionar un Cliente");
        return false;
    }
    else if($("#idMembresia").val() == null){
        mostrarMensaje("Debe seleccionar una Membresía");
        return false;
    }
    else if($("#idMetodo").val() == null){
        mostrarMensaje("Debe seleccionar un Método de Pago");
        return false;
    }
    else if(validarkeyup(/^[0-9]+(\.[0-9]{1,2})?$/, $("#monto"), $("#smonto"), "Monto inválido") == 0){
        mostrarMensaje("Monto Inválido <br/> (Solo números y dos decimales)");    
        return false;                   
    }
    else if(validarkeyup(/^[0-9]{4,20}$/, $("#referencia"), $("#sreferencia"), "Referencia inválida") == 0){
        mostrarMensaje("Referencia Inválida <br/> (Solo números)");    
        return false;                   
    }
    else if(validarkeyup(/^[1-9][0-9]*$/, $("#cantidadPeriodos"), $("#scantidadPeriodos"), "Mínimo 1") == 0){
        mostrarMensaje("Cantidad de períodos inválida");    
        return false;                   
    }
    return true;
}


function validarkeypress(er, e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

function validarkeyup(er, etiqueta, etiquetamensaje, mensaje){
    a = er.test(etiqueta.val());
    if(a){
        etiquetamensaje.text("");
        return 1;
    } else{
        etiquetamensaje.text(mensaje);
        return 0;
    }
}

// AJAX PRINCIPAL
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=clientes_pagos", 
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        timeout: 10000,
        success: function (respuesta){
            console.log(respuesta);
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'consultar'){
                    // Ya no se inyecta HTML manual; DataTables maneja el renderizado con .ajax.reload()
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    $("#modalPago").modal("hide");
                    consultar();
                }
                else if(lee.resultado == 'aprobar' || lee.resultado == 'rechazar'){
                    mostrarMensaje(lee.mensaje);
                    consultar(); 
                }
                else if(lee.resultado == "error"){
                    mostrarMensaje("Error: " + lee.mensaje);
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
        }
    });
}

// FUNCIONES PARA LLENAR LOS SELECTS
function cargarMembresias() {
    $.ajax({
        url: "index.php?pagina=clientes_pagos",
        type: "POST",
        data: { accion: 'listar_membresias' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#idMembresia");
            select.find('option:not(:first)').remove();
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_membresia + '">' + item.tipo + '</option>');
            });
        }
    });
}

function cargarMetodos() {
    $.ajax({
        url: "index.php?pagina=clientes_pagos",
        type: "POST",
        data: { accion: 'listar_metodos' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#idMetodo");
            select.find('option:not(:first)').remove();
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_metodo + '">' + item.banco + '</option>');
            });
        }
    });
}

function limpia(){
    $("#idCliente").val("");
    $("#clienteInfo").val("");
    
    $("#idMembresia").val("");
    $("#idMetodo").val("");
    $("#monto").val("");
    $("#referencia").val("");
    $("#cantidadPeriodos").val("1");
    
    $("#sCliente").text("");
    $("#sidMembresia").text("");
    $("#sidMetodo").text("");
    $("#smonto").text("");
    $("#sreferencia").text("");
    $("#scantidadPeriodos").text("");
}