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

    // ==== LÓGICA DE BÚSQUEDA DE CLIENTES CON AJAX ====
    $("#buscarCliente").on("keyup", function(){
        var busqueda = $(this).val();
        
        if (busqueda.length > 0) {
            $.ajax({
                url: 'index.php?pagina=rutinas',
                type: 'POST',
                data: { accion: 'buscar_cliente', busqueda: busqueda },
                success: function(respuesta){
                    try {
                        var data = JSON.parse(respuesta);
                        var html = "";
                        if (data.length > 0) {
                            $.each(data, function(index, cliente) {
                                html += `<button type="button" class="list-group-item list-group-item-action opcion-cliente" data-id="${cliente.id_cliente}" data-nombre="${cliente.cedula} - ${cliente.nombre} ${cliente.apellido}">
                                            <i class="bi bi-person"></i> ${cliente.cedula} - ${cliente.nombre} ${cliente.apellido}
                                         </button>`;
                            });
                        } else {
                            html = `<button type="button" class="list-group-item list-group-item-action disabled">No se encontraron resultados</button>`;
                        }
                        $("#listaClientes").html(html).removeClass("d-none");
                    } catch(e) {
                        console.error("Error al analizar la respuesta JSON de clientes:", e);
                    }
                }
            });
        } else {
            $("#listaClientes").addClass("d-none").empty();
            $("#idCliente").val(""); // Si borra todo, limpiamos el ID oculto
        }
    });

    // Evento al hacer clic en un cliente de la lista de resultados
    $("#listaClientes").on("click", ".opcion-cliente", function(){
        var idCliente = $(this).data("id");
        var textoCliente = $(this).data("nombre");

        $("#idCliente").val(idCliente); // Guardamos el ID real en el input hidden
        $("#buscarCliente").val(textoCliente); // Mostramos el texto en el input visible
        $("#listaClientes").addClass("d-none").empty(); // Escondemos la lista
        $("#sCliente").text(""); // Limpiamos mensaje de error si lo hubiera
    });

    // Ocultar lista de clientes si hace clic afuera
    $(document).on("click", function(event) {
        if (!$(event.target).closest("#buscarCliente, #listaClientes").length) {
            $("#listaClientes").addClass("d-none");
        }
    });
    // =================================================

    $("#btnAgregarEjercicio").on("click", function(){ agregarFilaEjercicio(); });

    $("#contenedorEjercicios").on("click", ".btnEliminarFila", function(){
        $(this).closest('.fila-ejercicio').find('.select-ejercicio').select2('destroy');
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
});

function agregarFilaEjercicio(id_ejercicio = "", nombre_ejercicio = "", series = "", repeticiones = "") {
    var fila = `
        <div class="row fila-ejercicio align-items-center mb-2">
            <div class="col-5">
                <select class="form-select rounded-0 select-ejercicio" name="ejercicios[]" required></select>
            </div>
            <div class="col-3">
                <input type="number" class="form-control rounded-0 input-series" name="series[]" value="${series}" min="1" placeholder="Ej: 4" required>
            </div>
            <div class="col-3">
                <input type="text" class="form-control rounded-0 input-reps" name="repeticiones[]" value="${repeticiones}" placeholder="Ej: 10-12" required>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-danger btn-sm rounded-0 btnEliminarFila"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    `;
    
    $("#contenedorEjercicios").append(fila);
    var nuevoSelect = $("#contenedorEjercicios .fila-ejercicio:last-child .select-ejercicio");

    if(id_ejercicio !== "" && nombre_ejercicio !== "") {
        var opcion = new Option(nombre_ejercicio, id_ejercicio, true, true);
        nuevoSelect.append(opcion).trigger('change');
    }

    nuevoSelect.select2({
        dropdownParent: $('#modalUsuario'), 
        width: '100%',
        placeholder: "Buscar...",
        minimumInputLength: 1,
        language: {
            inputTooShort: function () {
                return "Por favor, ingresa 1 o más caracteres";
            },
            noResults: function () {
                return "No se encontraron resultados";
            },
            searching: function () {
                return "Buscando...";
            }
        },
        ajax: {
            url: "index.php?pagina=rutinas",
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { accion: 'buscar_ejercicios_ajax', q: params.term };
            },
            processResults: function (data) {
                return { results: data.results };
            },
            cache: true
        }
    });
}

function empaquetarDatos(accion) {
    var datos = new FormData();
    datos.append('accion', accion);
    datos.append('nombreRutina', $("#nombreRutina").val());
    datos.append('idCliente', $("#idCliente").val()); // Añadimos el ID del cliente al paquete de datos
    
    if (accion === 'modificar') { datos.append('idRutina', $("#idRutina").val()); }

    $(".select-ejercicio").each(function(){ datos.append('ejercicios[]', $(this).val()); });
    $(".input-series").each(function(){ datos.append('series[]', $(this).val()); });
    $(".input-reps").each(function(){ datos.append('repeticiones[]', $(this).val()); });

    return datos;
}

function validarEnvio() {
    if(validarkeyup(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombreRutina"),$("#snombreRutina"),"Nombre Invalido")==0){
        mostrarMensaje("Nombre de Rutina Invalido <br> (Letras/Números entre 3 y 100 caracteres)");
        return false;
    }
    
    // Nueva validación: Asegurar que se haya seleccionado un cliente
    if($("#idCliente").val() === "" || $("#buscarCliente").val().trim() === ""){
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
        var ej = $(this).find(".select-ejercicio").val();
        var ser = $(this).find(".input-series").val();
        var rep = $(this).find(".input-reps").val();
        if (ej === null || ej === "" || ser.trim() === "" || rep.trim() === "") { validacionDetalles = false; }
    });

    if (!validacionDetalles) {
        mostrarMensaje("Completa todos los campos (Ejercicio, Series y Repeticiones).");
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
    
    // Ocultos los datos del cliente que enviaremos desde el backend en la tabla (lo ajustaremos en PHP)
    var idCliente = linea.find("td:eq(4)").text(); // ID Cliente Oculto
    var textoCliente = linea.find("td:eq(3)").text(); // Texto Cliente Visible
    
    $("#idRutina").val(idRutina);
    $("#nombreRutina").val(nombreRutina);   
    
    // Llenamos los inputs del cliente al modificar
    $("#idCliente").val(idCliente);
    $("#buscarCliente").val(textoCliente);

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
                if(lee.resultado == 'consultar'){ $("#cuerpoTablaRutinas").html(lee.mensaje); } 
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
    
    // Limpiamos los campos del cliente
    $("#idCliente").val("");
    $("#buscarCliente").val("");
    $("#sCliente").text("");
    $("#listaClientes").addClass("d-none").empty();
    
    $("#contenedorEjercicios").empty();
}