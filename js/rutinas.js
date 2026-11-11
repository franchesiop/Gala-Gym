var paginaActual = 1;
var filasPorPagina = 10;
var filaEjercicioGlobal = null; 

function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){
    consultar();

    $("#formRutina").on("submit", function(e){ e.preventDefault(); });

    $("#nombreRutina").on("keypress",function(e){ validarkeypress(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e); });
    $("#nombreRutina").on("keyup",function(){ validarkeyup(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#snombreRutina"),"Nombre inválido"); });

    $("#contenedorEjercicios").on("keypress", ".input-series", function(e){
        validarkeypress(/^[0-9]$/, e);
    });
    
    $("#contenedorEjercicios").on("keyup", ".input-series", function(){
        validarkeyup(/^[0-9]{1,3}$/, $(this), $(this).siblings('.s-error-series'), "Solo números");
    });

    $("#contenedorEjercicios").on("keypress", ".input-reps", function(e){
        validarkeypress(/^[0-9-]$/, e);
    });
    
    $("#contenedorEjercicios").on("keyup", ".input-reps", function(){
        validarkeyup(/^[0-9]{1,3}(-[0-9]{1,3})?$/, $(this), $(this).siblings('.s-error-reps'), "Formato: 12 o 10-12");
    });

    // ==========================================
    // LÓGICA DEL MODAL DE CLIENTES
    // ==========================================
    $("#listarClienteBtn").on("click", function(){
        $.ajax({
            url: 'index.php?pagina=rutinas',
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

    // ==========================================
    // LÓGICA DEL MODAL DE EJERCICIOS
    // ==========================================
    $("#contenedorEjercicios").on("click", ".btnBuscarEjercicio", function(){
        filaEjercicioGlobal = $(this).closest('.fila-ejercicio').attr('id');
        
        $.ajax({
            url: 'index.php?pagina=rutinas',
            type: 'POST',
            data: { accion: 'listar_ejercicios' }, 
            success: function(respuesta){
                try {
                    var data = JSON.parse(respuesta);
                    var html = "";
                    if (data.length > 0) {
                        $.each(data, function(index, ejercicio) {
                             // Si no hay imagen en BD, le ponemos una por defecto
                             var rutaImg = (ejercicio.imagen && ejercicio.imagen !== "") ? "img/ejercicios/" + ejercicio.imagen : "img/default.jpg";
                             
                             html += `<tr style="cursor:pointer" onclick="colocaejercicio(this);">
                                         <td style="display:none">${ejercicio.id_ejercicio}</td>
                                         <td class="text-center">
                                            <img src="${rutaImg}" alt="img" class="rounded object-fit-cover shadow-sm" style="width: 50px; height: 50px;">
                                         </td>
                                         <td class="text-start fw-bold">${ejercicio.nombre}</td>
                                     </tr>`;
                        });
                    } else {
                        html = `<tr><td colspan="2" class="text-center text-muted py-3">No hay ejercicios registrados</td></tr>`;
                    }
                    $("#listaEjerciciosModal").html(html);
                    $("#modal_ejercicios").modal("show");
                } catch(e) {
                    console.error("Error al cargar ejercicios:", e);
                }
            }
        });
    });

    $("#filtrarEjerciciosModal").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        $("#listaEjerciciosModal tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });

    // ==========================================
    // BOTONES GENERALES
    // ==========================================
    $("#btnAgregarEjercicio").on("click", function(){ agregarFilaEjercicio(); });

    $("#contenedorEjercicios").on("click", ".btnEliminarFila", function(){
        $(this).closest('.fila-ejercicio').remove();
    });

    $("#btnGuardar").on("click", function() {
        if($(this).text().toLowerCase() == 'incluir'){
            if(validarEnvio()){ enviaAjax(empaquetarDatos('incluir')); }
        } else if($(this).text().toLowerCase() == 'modificar'){
            if(validarEnvio()){ enviaAjax(empaquetarDatos('modificar')); }
        }
    });

    $("#btnNuevaRutina").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir"); 
        agregarFilaEjercicio(); 
        $("#modalUsuario").modal("show");
    });

    $("#btnConfirmarEliminar").on("click", function(){
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_rutina', $("#id_eliminar_global").val());
        enviaAjax(datos);
    });

    // Buscador en tiempo real tabla principal
    $("#buscar_rutina").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        var filasFiltradas = 0;
        
        $("#cuerpoTablaRutinas tr").filter(function() {
            var nombreRutina = $(this).find("td:eq(1)").text().toLowerCase();
            var entrenador = $(this).find("td:eq(2)").text().toLowerCase();
            var cliente = $(this).find("td:eq(3)").text().toLowerCase();

            var coincide = nombreRutina.indexOf(valor) > -1 || entrenador.indexOf(valor) > -1 || cliente.indexOf(valor) > -1;
            $(this).toggle(coincide);
            if(coincide) filasFiltradas++;
        });

        if(valor === ""){
            paginarTabla(1);
        } else {
            $("#infoPaginacion").text("Mostrando resultados (" + filasFiltradas + ")");
            $("#contenedorPaginacion").empty(); 
        }
    });

}); 

// ==========================================
// SELECCIÓN DE MODALES
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

function colocaejercicio(tr) {
    var id = $(tr).find("td:eq(0)").text();
    var nombre = $(tr).find("td:eq(2)").text(); // El nombre ahora está en la columna 2, no en la 1

    var filaDestino = $("#" + filaEjercicioGlobal);
    
    filaDestino.find(".input-id-ejercicio").val(id); 
    filaDestino.find(".input-info-ejercicio").val(nombre); 
    
    $("#modal_ejercicios").modal("hide"); 
}

// ==========================================
// GESTIÓN DE FILAS DINÁMICAS
// ==========================================
function agregarFilaEjercicio(id_ejercicio = "", nombre_ejercicio = "", series = "", repeticiones = "") {
    var idFilaUnico = 'fila_ej_' + new Date().getTime() + Math.floor(Math.random() * 1000); 
    
    var fila = `
        <div class="row fila-ejercicio align-items-center mb-2" id="${idFilaUnico}">
            <div class="col-5">
                <div class="input-group">
                    <input type="hidden" class="input-id-ejercicio" name="ejercicios[]" value="${id_ejercicio}">
                    <input type="text" class="form-control rounded-0 border-end-0 bg-white input-info-ejercicio" placeholder="Seleccione..." value="${nombre_ejercicio}" readonly required>
                    <button class="btn btn-dark rounded-0 px-2 btnBuscarEjercicio" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-3">
                <input type="text" class="form-control rounded-0 input-series" name="series[]" value="${series}" placeholder="Ej: 4" required>
                <span class="text-danger small s-error-series"></span>
            </div>
            <div class="col-3">
                <input type="text" class="form-control rounded-0 input-reps" name="repeticiones[]" value="${repeticiones}" placeholder="Ej: 10-12" required>
                <span class="text-danger small s-error-reps"></span>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-danger btn-sm rounded-0 btnEliminarFila"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    `;
    
    $("#contenedorEjercicios").append(fila);
}

function empaquetarDatos(accion) {
    var datos = new FormData();
    datos.append('accion', accion);
    datos.append('nombreRutina', $("#nombreRutina").val());
    datos.append('idCliente', $("#idCliente").val()); 
    
    if (accion === 'modificar') { datos.append('idRutina', $("#idRutina").val()); }

    $(".input-id-ejercicio").each(function(){ datos.append('ejercicios[]', $(this).val()); });
    $(".input-series").each(function(){ datos.append('series[]', $(this).val()); });
    $(".input-reps").each(function(){ datos.append('repeticiones[]', $(this).val()); });

    return datos;
}

function validarEnvio() {
    if(validarkeyup(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombreRutina"),$("#snombreRutina"),"Nombre Invalido")==0){
        mostrarMensaje("Nombre de Rutina Invalido <br> (Letras/Números entre 3 y 100 caracteres)");
        return false;
    }
    
    if($("#idCliente").val() === "" || $("#clienteInfo").val().trim() === ""){
        $("#sCliente").text("Debe seleccionar un cliente del listado");
        mostrarMensaje("Por favor, asigne esta rutina a un cliente.");
        return false;
    }
    
    if ($(".fila-ejercicio").length === 0) {
        mostrarMensaje("Debes añadir al menos un ejercicio a la rutina.");
        return false;
    }

    var validacionDetalles = true;
    $(".fila-ejercicio").each(function() {
        var ej = $(this).find(".input-id-ejercicio").val();
        var ser = $(this).find(".input-series").val();
        var rep = $(this).find(".input-reps").val();
        
        var regexSer = /^[0-9]{1,3}$/;
        var regexRep = /^[0-9]{1,3}(-[0-9]{1,3})?$/;

        if (ej === null || ej === "" || !regexSer.test(ser) || !regexRep.test(rep)) { 
            validacionDetalles = false; 
        }
    });

    if (!validacionDetalles) {
        mostrarMensaje("Revisa los ejercicios. Asegúrate de haber seleccionado un ejercicio y colocado series/reps válidas.");
        return false;
    }
    return true;
}

function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

function validarkeypress(er,e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){ e.preventDefault(); }
}

function validarkeyup(er,etiqueta,etiquetamensaje,mensaje){
    a = er.test(etiqueta.val());
    if(a){ etiquetamensaje.text(""); return 1; } 
    else { etiquetamensaje.text(mensaje); return 0; }
}

function pone(pos){
    var linea = $(pos).closest('tr');
    var idRutina = linea.find("td:eq(0)").text();
    var nombreRutina = linea.find("td:eq(1)").text();
    var idCliente = linea.find("td:eq(4)").text(); 
    var textoCliente = linea.find("td:eq(3)").text(); 
    
    $("#idRutina").val(idRutina);
    $("#nombreRutina").val(nombreRutina);   
    $("#idCliente").val(idCliente);
    $("#clienteInfo").val(textoCliente);

    $("#btnGuardar").text('modificar');
    $("#contenedorEjercicios").empty(); 

    $.ajax({
        url: "index.php?pagina=rutinas",
        type: "POST",
        data: { accion: 'consultar_detalles', id_rutina: idRutina },
        success: function(respuesta){
            try {
                var data = JSON.parse(respuesta);
                $.each(data, function(index, item) {
                    agregarFilaEjercicio(item.id_ejercicio, item.nombre, item.series, item.repeticiones);
                });
                $("#modalUsuario").modal("show");
            } catch(e) {
                mostrarMensaje("Error al cargar los ejercicios.");
            }
        }
    });
}

function eliminar(pos){
    $("#id_eliminar_global").val($(pos).closest('tr').find("td:eq(0)").text());
    $("#modal_eliminar").modal("show");
}

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=rutinas",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta){
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'consultar'){ $("#cuerpoTablaRutinas").html(lee.mensaje); paginarTabla(1); } 
                else if(lee.resultado == 'incluir' || lee.resultado == 'modificar' || lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    $("#modalUsuario").modal("hide");
                    $("#modal_eliminar").modal("hide"); 
                    consultar();
                } else if(lee.resultado == "error"){ mostrarMensaje(lee.mensaje); }
            } catch(e){ alert("Error en JSON: " + e.name); }
        },
        error: function(request, status, err){
            if(status == "timeout"){ mostrarMensaje("Servidor Ocupado, Intente de Nuevo"); } 
            else { mostrarMensaje("ERROR: <br/>" + request + status + err); }
        }
    });
}

function limpia(){
    $("#idRutina").val("");
    $("#nombreRutina").val("");
    $("#snombreRutina").text("");
    
    $("#idCliente").val("");
    $("#clienteInfo").val("");
    $("#sCliente").text("");
    
    $("#contenedorEjercicios").empty();
}

function paginarTabla(pagina) {
    paginaActual = pagina;
    var filas = $("#cuerpoTablaRutinas tr");
    var totalFilas = filas.length;
    var totalPaginas = Math.ceil(totalFilas / filasPorPagina);
    
    var inicio = (paginaActual - 1) * filasPorPagina;
    var fin = inicio + filasPorPagina;

    filas.hide().slice(inicio, fin).show();
    $("#infoPaginacion").text("Mostrando " + (inicio + (totalFilas > 0 ? 1 : 0)) + " a " + (fin > totalFilas ? totalFilas : fin) + " de " + totalFilas + " rutinas");

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