// Variable global para almacenar el catalogo de ejercicios
var catalogoEjercicios = []; 

$(document).ready(function(){

    // cargar rutinas y catalogo de ejercicios al iniciar
    consultar();
    cargarCatalogoEjercicios();

    // EVENTOS DEL MODAL DE RUTINAS

    $("#btnNuevaRutina").on("click", function(){
        limpiarFormulario();
        $("#tituloModalRutina").text("NUEVA RUTINA");
        $("#accionRutina").val("incluir");
        $("#btnGuardarRutina").text("GUARDAR RUTINA");
        
        agregarFilaEjercicio(); 
        $("#modalRutina").modal("show");
    });

    $("#btnAgregarEjercicio").on("click", function(){
        agregarFilaEjercicio();
    });

    $(document).on("click", ".btn-eliminar-fila", function(){
        $(this).closest(".fila-ejercicio").remove();
    });

    $("#btnGuardarRutina").on("click", function(){
        if(validarEnvioRutina()){
            var form = document.getElementById("formRutina");
            var datos = new FormData(form); 
            enviaAjax(datos);
        }
    });

    $("#btnConfirmarEliminarRutina").on("click", function(){
        var id = $("#id_eliminar_rutina").val();
        var datos = new FormData();
        datos.append('accionRutina', 'eliminar');
        datos.append('id_rutina', id);
        enviaAjax(datos);
    });

    // INTERACTIVIDAD DEL MODO ENTRENAMIENTO

    // clic directo en un item de la playlist
    $(document).on("click", ".playlist-item", function(){
        $(".playlist-item").removeClass("bg-white border-dark shadow-sm").addClass("bg-light border-transparent opacity-75");
        $(this).removeClass("bg-light border-transparent opacity-75").addClass("bg-white border-dark shadow-sm");

        if($(this).prev(".playlist-item").length === 0) {
            $("#btnPrevEjercicio").hide();
        } else {
            $("#btnPrevEjercicio").show();
        }

        if($(this).next(".playlist-item").length === 0) {
            $("#btnNextEjercicio").hide();
        } else {
            $("#btnNextEjercicio").show();
        }

        var nombre = $(this).data("nombre");
        var descripcion = $(this).data("descripcion");
        var imagen = $(this).data("imagen");
        var series = $(this).data("series");
        var reps = $(this).data("reps");

        actualizarEscenarioEntrenamiento(nombre, descripcion, imagen, series, reps);
    });

    $("#btnNextEjercicio").on("click", function(){
        var activo = $(".playlist-item.bg-white"); 
        var siguiente = activo.next(".playlist-item"); 
        
        if(siguiente.length > 0){
            siguiente.click(); 
            var container = $("#playlistEjerciciosContainer");
            container.animate({
                scrollTop: siguiente.offset().top - container.offset().top + container.scrollTop()
            }, 250);
        }
    });

    $("#btnPrevEjercicio").on("click", function(){
        var activo = $(".playlist-item.bg-white");
        var anterior = activo.prev(".playlist-item");
        
        if(anterior.length > 0){
            anterior.click(); 
            var container = $("#playlistEjerciciosContainer");
            container.animate({
                scrollTop: anterior.offset().top - container.offset().top + container.scrollTop()
            }, 250);
        }
    });

    // LÓGICA DE RACHAS (BOTÓN RUTINA COMPLETADA)

    $("#btnMarcarHecha").on("click", function(e) {
        e.preventDefault();
        
        var id_rutina_actual = $(this).data("id-rutina");
        var btn = $(this);
        
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
        $("#mensaje-racha").html('');

        var datos = new FormData();
        datos.append('accionRutina', 'marcar_hecha');
        datos.append('id_rutina', id_rutina_actual);

        $.ajax({
            url: "index.php?pagina=clientes_rutina",
            type: "POST",
            data: datos,
            contentType: false,
            processData: false,
            success: function(respuesta){
                try {
                    var resp = JSON.parse(respuesta);
                    if(resp.estado === 'exito') {
                        $("#mensaje-racha").html('<span class="text-success fs-6">🔥 ¡Racha actual: ' + resp.racha + ' días!</span>');
                        btn.removeClass('btn-success').addClass('btn-secondary').html('<i class="bi bi-check2-all me-2"></i> Registrado');
                        
                        // ACTUALIZAR EL WIDGET PRINCIPAL SIN RECARGAR LA PÁGINA
                        actualizarWidgetRacha(resp.racha, 0); // 0 porque si fue éxito, significa que entrenó hoy
                        
                    } else {
                        $("#mensaje-racha").html('<span class="text-danger">' + resp.mensaje + '</span>');
                        btn.prop('disabled', false).html('<i class="bi bi-check-circle-fill me-2"></i> RUTINA COMPLETADA');
                    }
                } catch(e) {
                    console.log("Error JSON racha: ", respuesta);
                    $("#mensaje-racha").html('<span class="text-danger">Error al procesar.</span>');
                    btn.prop('disabled', false).html('<i class="bi bi-check-circle-fill me-2"></i> REINTENTAR');
                }
            },
            error: function(){
                $("#mensaje-racha").html('<span class="text-danger">Error de red.</span>');
                btn.prop('disabled', false).html('<i class="bi bi-check-circle-fill me-2"></i> REINTENTAR');
            }
        });
    });

});

// FUNCIONES PRINCIPALES

function consultar(){
    var datos = new FormData();
    datos.append('accionRutina', 'consultar');
    enviaAjax(datos);
}

function cargarCatalogoEjercicios() {
    var datos = new FormData();
    datos.append('accionRutina', 'listar_ejercicios');
    
    $.ajax({
        async: true,
        url: "index.php?pagina=clientes_rutina",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta){
            try {
                catalogoEjercicios = JSON.parse(respuesta); 
            } catch(e) {
                console.log("Error al parsear el catalogo de ejercicios", e);
            }
        }
    });
}

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=clientes_rutina",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        timeout: 10000,
        success: function (respuesta){
            try{
                var lee = JSON.parse(respuesta);
                
                if(lee.resultado == 'consultar'){
                    $("#contenedor_rutinas").html(lee.mensaje);
                    
                    // inicializar el widget de racha con los datos que trajo la consulta
                    if(lee.racha_actual !== undefined) {
                        actualizarWidgetRacha(lee.racha_actual, lee.dias_diferencia);
                    }
                } 
                else if(lee.resultado == 'incluir' || lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    $("#modalRutina").modal("hide");
                    consultar();
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    $("#modalEliminarRutina").modal("hide");
                    consultar();
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
        }
    });
}

// NUEVA FUNCIÓN: DIBUJAR CALENDARIO RACHA

function actualizarWidgetRacha(rachaTotal, diasDiferencia) {
    $("#contenedor_racha").removeClass('d-none');
    
    // actualizar el número global
    $("#badgeRachaGlobal").html("🔥 " + rachaTotal + (rachaTotal == 1 ? " día" : " días") + " seguidos");
    if(rachaTotal > 0) {
        $("#badgeRachaGlobal").removeClass('bg-secondary').addClass('bg-danger');
    } else {
        $("#badgeRachaGlobal").removeClass('bg-danger').addClass('bg-secondary');
    }

    var contenedorCalendario = $("#calendarioRacha");
    contenedorCalendario.empty();

    // nombres de los días de la semana
    var nombresDias = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    var fechaActual = new Date();

    // calcula que dias de los ultimos 7 estuvieron activos
    // diasDiferencia = 0 (entrenó hoy), 1 (entrenó ayer)
    for (var i = 6; i >= 0; i--) {
        // obtiene la fecha de hace 'i' días
        var d = new Date(fechaActual);
        d.setDate(fechaActual.getDate() - i);
        var nombreDiaStr = nombresDias[d.getDay()];
        
        // logica para determinar si ese dia debe estar coloreado
        // i representa cuántos días hacia atras esta evaluando (0 = hoy, 6 = hace 6 días)
        // si la racha es mayor que 'i' (los días hacia atras) Y no hay un hueco que rompa la racha en ese día...
        var diaEntrenado = false;
        
        if (diasDiferencia === 0) {
            // entrenó hoy, colorear todos los días que abarque su racha
            if (i < rachaTotal) diaEntrenado = true;
        } else if (diasDiferencia === 1) {
            // entrenó ayer, hoy (i=0) es gris, los anteriores dependen de la racha
            if (i > 0 && i <= rachaTotal) diaEntrenado = true;
        } else {
            // faltó 2 o más días. La racha actual es 0 (o 1 si ya entrenó hoy, pero eso cae en diasDiferencia=0). Todo gris.
            diaEntrenado = false;
        }

        // diseño de la bolita del día
        var colorCirculo = diaEntrenado ? "bg-success text-white shadow-sm" : "bg-light text-muted border";
        var etiquetaHover = i === 0 ? "Hoy" : (i === 1 ? "Ayer" : nombreDiaStr);
        var resalteHoy = i === 0 ? "fw-bold" : "";
        
        var htmlDia = `
        <div class="d-flex flex-column align-items-center">
            <div class="rounded-circle d-flex justify-content-center align-items-center mb-1 ${colorCirculo} transition-all" 
                 style="width: 40px; height: 40px; font-size: 1.1rem; transition: all 0.3s ease;">
                ${diaEntrenado ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-dash"></i>'}
            </div>
            <span class="small text-uppercase ${resalteHoy}" style="font-size: 0.75rem;">${etiquetaHover}</span>
        </div>`;
        
        contenedorCalendario.append(htmlDia);
    }
}

// FUNCIONES DE INTERFAZ Y DOM

function agregarFilaEjercicio(id_ejercicio, series, reps) {
    if(id_ejercicio === undefined) id_ejercicio = "";
    if(series === undefined) series = "";
    if(reps === undefined) reps = "";
    
    var idUnicoSelect = "select_ejercicio_" + new Date().getTime() + Math.floor(Math.random() * 1000);

    var opcionesSelect = '<option value="" disabled selected>Elegir...</option>';
    $.each(catalogoEjercicios, function(index, ej){
        var seleccionado = (ej.id_ejercicio == id_ejercicio) ? "selected" : "";
        opcionesSelect += '<option value="' + ej.id_ejercicio + '" ' + seleccionado + '>' + ej.nombre + '</option>';
    });

    var htmlFila = '' +
    '<div class="row g-2 align-items-center mb-2 fila-ejercicio">' +
        '<div class="col-md-5">' +
            '<select id="' + idUnicoSelect + '" class="form-select bg-light border-0 rounded-3 py-2 px-3 shadow-none form-ejercicio-validar" name="id_ejercicio[]" required>' +
                opcionesSelect +
            '</select>' +
        '</div>' +
        '<div class="col-md-3">' +
            '<input type="number" class="form-control bg-light border-0 rounded-3 py-2 px-3 shadow-none text-center form-serie-validar" name="series[]" placeholder="Ej: 4" value="' + series + '" min="1" required>' +
        '</div>' +
        '<div class="col-md-3">' +
            '<input type="number" class="form-control bg-light border-0 rounded-3 py-2 px-3 shadow-none text-center form-rep-validar" name="reps[]" placeholder="Ej: 12" value="' + reps + '" min="1" required>' +
        '</div>' +
        '<div class="col-md-1 text-center">' +
            '<button type="button" class="btn btn-light text-danger border-0 rounded-circle btn-eliminar-fila p-2" title="Eliminar fila">' +
                '<i class="bi bi-x-lg fw-bold"></i>' +
            '</button>' +
        '</div>' +
    '</div>';
    
    $("#contenedorEjercicios").append(htmlFila);

    $("#" + idUnicoSelect).select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modalRutina'),
        width: '100%',
        placeholder: 'Escribe para buscar...',
        minimumInputLength: 1 
    });
}

function limpiarFormulario(){
    $("#id_rutina").val("");
    $("#nombre_rutina").val("");
    $("#contenedorEjercicios").empty(); 
}

function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

function validarEnvioRutina() {
    var nombre = $("#nombre_rutina").val().trim();
    if (nombre.length < 3) {
        mostrarMensaje("El nombre de la rutina debe tener al menos 3 caracteres.");
        return false;
    }

    var filas = $(".fila-ejercicio").length;
    if (filas === 0) {
        mostrarMensaje("Debes agregar al menos un ejercicio a la rutina.");
        return false;
    }

    var camposValidos = true;
    $(".form-ejercicio-validar, .form-serie-validar, .form-rep-validar").each(function() {
        if ($(this).val() === "" || $(this).val() === null) {
            camposValidos = false;
        }
    });

    if (!camposValidos) {
        mostrarMensaje("Por favor, completa todos los campos de los ejercicios.");
        return false;
    }

    return true;
}

// FUNCIONES INVOCADAS DESDE LAS TARJETAS HTML

function editarRutina(id_rutina) {
    var datos = new FormData();
    datos.append('accionRutina', 'consultar_rutina_id');
    datos.append('id_rutina', id_rutina);
    
    $.ajax({
        url: "index.php?pagina=clientes_rutina",
        type: "POST",
        data: datos,
        contentType: false,
        processData: false,
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            
            limpiarFormulario();
            $("#tituloModalRutina").text("EDITAR RUTINA");
            $("#accionRutina").val("modificar");
            $("#btnGuardarRutina").text("ACTUALIZAR RUTINA");
            
            $("#id_rutina").val(data.id_rutina);
            $("#nombre_rutina").val(data.nombre);
            
            $.each(data.ejercicios, function(index, ej){
                agregarFilaEjercicio(ej.id_ejercicio, ej.series, ej.reps);
            });
            
            $("#modalRutina").modal("show");
        }
    });
}

function modalEliminarRutina(id_rutina) {
    $("#id_eliminar_rutina").val(id_rutina);
    $("#modalEliminarRutina").modal("show");
}

function abrirEntrenamiento(id_rutina, nombre_rutina) {
    $("#btnMarcarHecha")
        .data("id-rutina", id_rutina)
        .prop('disabled', false)
        .removeClass('btn-secondary')
        .addClass('btn-success')
        .html('<i class="bi bi-check-circle-fill me-2"></i> RUTINA COMPLETADA');
    $("#mensaje-racha").html('');

    var datos = new FormData();
    datos.append('accionRutina', 'consultar_rutina_id');
    datos.append('id_rutina', id_rutina);
    
    $.ajax({
        url: "index.php?pagina=clientes_rutina",
        type: "POST",
        data: datos,
        contentType: false,
        processData: false,
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            
            $("#offcanvasRutinaLabel").text(nombre_rutina); 
            $("#playlistEjerciciosContainer").empty();
            
            if(data.ejercicios && data.ejercicios.length > 0) {
                $("#contadorPlaylist").text(data.ejercicios.length + " ejercicios");
                
                $.each(data.ejercicios, function(index, ej){
                    var itemPlaylist = '' +
                    '<div class="card border rounded-4 mb-2 playlist-item bg-light border-transparent opacity-75" style="cursor:pointer;" ' +
                         'data-nombre="' + ej.nombre_ejercicio + '" ' +
                         'data-descripcion="' + ej.descripcion + '" ' +
                         'data-imagen="' + ej.imagen + '" ' +
                         'data-series="' + ej.series + '" ' +
                         'data-reps="' + ej.reps + '">' +
                        '<div class="card-body p-3 d-flex align-items-center gap-3">' +
                            '<div class="rounded bg-dark text-white d-flex justify-content-center align-items-center fw-bold" style="width: 45px; height: 45px; flex-shrink: 0;">' +
                                (index + 1) +
                            '</div>' +
                            '<div>' +
                                '<h6 class="fw-bold mb-1 text-uppercase small text-dark">' + ej.nombre_ejercicio + '</h6>' +
                                '<span class="text-muted small">' + ej.series + ' Series x ' + ej.reps + ' Reps</span>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
                    
                    $("#playlistEjerciciosContainer").append(itemPlaylist);
                });
                
                $(".playlist-item").first().click();
                
            } else {
                $("#contadorPlaylist").text("0 ejercicios");
                $("#btnPrevEjercicio, #btnNextEjercicio").hide();
                actualizarEscenarioEntrenamiento("Rutina vacia", "Agrega ejercicios a esta rutina para empezar.", "", "--", "--");
            }
            
            $("#modalEntrenamiento").modal("show");
        }
    });
}

function actualizarEscenarioEntrenamiento(nombre, descripcion, imagen, series, reps) {
    var rutaImagen = (imagen && imagen !== "" && imagen !== "null") ? "img/ejercicios/" + imagen : "img/default.jpg";
    
    $("#detalleImagen").attr("src", rutaImagen);
    $("#detalleNombreEjercicio").text(nombre);
    $("#detalleDescripcionEjercicio").text(descripcion || "No hay descripcion disponible para este ejercicio.");
    
    if (series !== "--") {
        $("#detalleSeriesRepsBadge").text(series + " Series x " + reps + " Reps");
        $("#detalleSeriesRepsBadge").show();
    } else {
        $("#detalleSeriesRepsBadge").hide();
    }
}