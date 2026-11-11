var paginaActual = 1;
var filasPorPagina = 10;

function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();

    // ==========================================
    // VALIDACIONES DE DATOS (Teclado)
    // ==========================================

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

    // ==========================================
    // LÓGICA DEL MODAL DE CLIENTES
    // ==========================================
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

    // Buscador en tiempo real dentro del modal
    $("#filtrarClientesModal").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        $("#listaClientesModal tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

    // ==========================================
    // BOTONES Y EVENTOS
    // ==========================================

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

    // Buscador general de la tabla
    $("#buscar_pago").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        var filasFiltradas = 0;
        
        $("#cuerpoTablaPagos tr").filter(function() {
            var fecha = $(this).find("td:eq(1)").text().toLowerCase();
            var cedula = $(this).find("td:eq(2)").text().toLowerCase();
            var nombre = $(this).find("td:eq(3)").text().toLowerCase();
            var referencia = $(this).find("td:eq(4)").text().toLowerCase();

            var coincide = cedula.indexOf(valor) > -1 || nombre.indexOf(valor) > -1 || referencia.indexOf(valor) > -1 || fecha.indexOf(valor) > -1;
            $(this).toggle(coincide);
            if(coincide) filasFiltradas++;
        });

        if(valor === ""){
            paginarTabla(1);
        } else {
            $("#infoPaginacion").text("Mostrando resultados de búsqueda (" + filasFiltradas + ")");
            $("#contenedorPaginacion").empty(); 
        }
    });
});

// ==========================================
// FUNCIONES DE SELECCIÓN Y ACCIÓN 
// ==========================================

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
    var linea = $(pos).closest('tr');
    var idPago = linea.find("td:eq(0)").text(); 

    if (confirm("¿Estás seguro de que deseas APROBAR este pago?")) {
        var datos = new FormData();
        datos.append('accion', 'aprobar');
        datos.append('idPago', idPago);
        enviaAjax(datos);
    }
}

function rechazar_pago(pos) {
    var linea = $(pos).closest('tr');
    var idPago = linea.find("td:eq(0)").text(); 

    if (confirm("¿Estás seguro de que deseas RECHAZAR/ANULAR este pago?")) {
        var datos = new FormData();
        datos.append('accion', 'rechazar');
        datos.append('idPago', idPago);
        enviaAjax(datos);
    }
}

// ==========================================
// VALIDACIÓN ANTES DE ENVIAR
// ==========================================
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

function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() { $("#mostrarModal").modal("hide") }, 5000);
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

// ==========================================
// AJAX PRINCIPAL
// ==========================================
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
                    $("#cuerpoTablaPagos").html(lee.mensaje);
                    paginarTabla(1); 
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

// ==========================================
// FUNCIONES PARA LLENAR LOS SELECTS
// ==========================================

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

// ==========================================
// PAGINACIÓN Y LIMPIEZA
// ==========================================

function paginarTabla(pagina) {
    paginaActual = pagina;
    var filas = $("#cuerpoTablaPagos tr");
    var totalFilas = filas.length;
    var totalPaginas = Math.ceil(totalFilas / filasPorPagina);
    
    var inicio = (paginaActual - 1) * filasPorPagina;
    var fin = inicio + filasPorPagina;

    filas.hide().slice(inicio, fin).show();
    $("#infoPaginacion").text("Mostrando " + (inicio + (totalFilas > 0 ? 1 : 0)) + " a " + (fin > totalFilas ? totalFilas : fin) + " de " + totalFilas + " pagos");

    var htmlBotones = "";
    var prevDisabled = (paginaActual === 1) ? "disabled" : "";
    htmlBotones += `<li class="page-item ${prevDisabled}"><a class="page-link text-dark" href="#" onclick="if(${paginaActual} > 1) paginarTabla(${paginaActual - 1}); return false;">&lt;</a></li>`;

    var l = null;
    for (var i = 1; i <= totalPaginas; i++) {
        if (i == 1 || i == totalPaginas || (i >= paginaActual - 1 && i <= paginaActual + 1) || (paginaActual === 1 && i <= 3) || (paginaActual === totalPaginas && i >= totalPaginas - 2)) {
            var activo = (i === paginaActual) ? "active bg-dark text-white border-dark" : "text-dark";
            htmlBotones += `<li class="page-item"><a class="page-link ${activo}" href="#" onclick="paginarTabla(${i}); return false;">${i}</a></li>`;
            l = i;
        } else if (l != null && i != l + 1 && l != '...') {
            htmlBotones += `<li class="page-item disabled"><a class="page-link text-dark" href="#">...</a></li>`;
            l = '...';
        }
    }

    var nextDisabled = (paginaActual === totalPaginas || totalPaginas === 0) ? "disabled" : "";
    htmlBotones += `<li class="page-item ${nextDisabled}"><a class="page-link text-dark" href="#" onclick="if(${paginaActual} < ${totalPaginas}) paginarTabla(${paginaActual + 1}); return false;">&gt;</a></li>`;

    $("#contenedorPaginacion").html(htmlBotones);
}

function limpia(){
    // Limpiamos los nuevos inputs del cliente
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