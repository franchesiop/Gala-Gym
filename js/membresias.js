var paginaActual = 1;
var filasPorPagina = 10;

function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();
    $("#formMembresia").on("submit", function(e){
        e.preventDefault();
        });

    
    
    // Validacion de datos
    // Validacion nombre
    $("#nombrePlan").on("keypress", function(e){
        // Regex para un solo carácter: Solo letras, acentos, ñ y espacios. Nada de = _ o números.
        validarkeypress(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]$/, e);
    });
    
    $("#nombrePlan").on("keyup", function(){
        // Regex para la cadena completa: entre 3 y 100 caracteres.
        validarkeyup(/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{3,100}$/, $(this), $("#snombrePlan"), "Solo letras (entre 3 y 100 caracteres)");
    });

    $("#costoPlan").on("keypress", function(e){
        // Regex para un solo carácter: Exclusivamente números del 0 al 9.
        validarkeypress(/^[0-9]$/, e);
    });
    
    $("#costoPlan").on("keyup", function(){
        // Regex para la cadena completa: 1 o más números.
        validarkeyup(/^[0-9]+$/, $(this), $("#scostoPlan"), "Solo se aceptan números");
    });

    // Botón Guardar / Modificar
    $("#btnGuardar").on("click", function() {
        // Guardar (Incluir)
        if($(this).text().toLowerCase() == 'incluir'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'incluir');
                datos.append('tipo', $("#nombrePlan").val());
                datos.append('monto', $("#costoPlan").val());
                enviaAjax(datos);
            }
        }
        // Modificar
        else if($(this).text().toLowerCase() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('id_membresia', $("#idMembresia").val());
                datos.append('tipo', $("#nombrePlan").val());
                datos.append('monto', $("#costoPlan").val());
                enviaAjax(datos);
            }
        }
    }); // 

    // Botón Nuevo Ejercicio
    $("#btnNuevoPlan").on("click", function(){
        limpia();
        $("#btnGuardar").text("INCLUIR"); 
        $("#modalMembresia").modal("show"); 
    });

    // Botón Eliminar del Modal
    $("#btnEliminar").on("click", function(){
        var id_membresia = $("#idMembresia").val(); 
        
        // Pasa el ID al modal de confirmación
        $("#id_eliminar_global").val(id_membresia);
        
        // Oculta el modal de edición y abre el de confirmación
        $("#modalMembresia").modal("hide");
        $("#modal_eliminar").modal("show");
    });

    // Evento del botón "SÍ, ELIMINAR" 
    $("#btnConfirmarEliminar").on("click", function(){
        var id_membresia = $("#id_eliminar_global").val(); 
        
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_membresia', id_membresia);
        
        enviaAjax(datos);
    });

    // Botón Incluir alternativo 
    $("#incluir").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir");
        $("#modalUsuario").modal("show");
    });

    // Buscador en tiempo real
    $("#buscar_membresia").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        var filasFiltradas = 0;
        
        $("#cuerpoTablaMembresias tr").filter(function() {
            var plan = $(this).find("td:eq(1)").text().toLowerCase();
            var costo = $(this).find("td:eq(2)").text().toLowerCase();

            var coincide = plan.indexOf(valor) > -1 || costo.indexOf(valor) > -1;
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
}); // Fin del $(document).ready

// Validar antes de enviar
function validarEnvio() {
    if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombrePlan"),$("#snombrePlan"),"Nombre Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
        mostrarMensaje("Nombre de Membresía Invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
        return false;
    }
    if($("#costoPlan").val() == ""){
        mostrarMensaje("El costo no puede estar vacío");
        return false;
    }
    return true;
}

// Función para mostrar el mensaje modal
function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

// Función para validar por keypress
function validarkeypress(er,e){
    var key = e.keyCode || e.which;
    var tecla = String.fromCharCode(key);
    var a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

// Función para validar por keyup
function validarkeyup(er,etiqueta,etiquetamensaje,mensaje){
    var a = er.test(etiqueta.val());
    if(a){
        etiquetamensaje.text("");
        return 1;
    } else{
        etiquetamensaje.text(mensaje);
        return 0;
    }
}

// Función para llenar el formulario al editar
function pone(pos){
    var linea = $(pos).closest('tr');
    
    $("#idMembresia").val(linea.find("td:eq(0)").text());
    $("#nombrePlan").val(linea.find("td:eq(1)").text()); 
    $("#costoPlan").val(linea.find("td:eq(2)").text());

    $("#btnGuardar").text('MODIFICAR');
    $("#modalMembresia").modal("show");
}

// Función eliminar directa desde la tabla
// Función eliminar directa desde la tabla
function eliminar(pos){
    var linea = $(pos).closest('tr');
    var id_membresia = $(linea).find("td:eq(0)").text();

    // Guardamos el ID en el input oculto del modal 
    $("#id_eliminar_global").val(id_membresia);
    
    $("#modal_eliminar").modal("show");
}

// Función AJAX
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=membresias",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function (respuesta){
            console.log("Respuesta del servidor:", respuesta); 
            try {
                var lee = JSON.parse(respuesta);
                
                // Si la acción fue consultar, dibuja las filas en la tabla
                if(lee.resultado == 'consultar'){
                    $("#cuerpoTablaMembresias").html(lee.mensaje);
                    paginarTabla(1);
                } 
                // Si se incluyó con éxito, limpia, cierra el modal y recarga la tabla
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Membresía Registrada'){
                        $("#modalMembresia").modal("hide");
                        consultar(); // <-- vuelve a llamar a la base de datos para actualizar la vista
                    }
                }
               else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Membresía Modificada'){
                        $("#modalMembresia").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Membresía Eliminada'){
                        $("#modalMembresia").modal("hide");
                        $("#modal_eliminar").modal("hide");
                        consultar();
                    }
                } 
            } catch(e) {
                alert("Error procesando los datos del servidor (JSON): " + e.message);
            }
        },
        error: function(request, status, err){
            mostrarMensaje("ERROR DE RED o SERVIDOR: <br/>" + err);
        }
    });
}

function paginarTabla(pagina) {
    paginaActual = pagina;
    var filas = $("#cuerpoTablaMembresias tr");
    var totalFilas = filas.length;
    var totalPaginas = Math.ceil(totalFilas / filasPorPagina);
    
    var inicio = (paginaActual - 1) * filasPorPagina;
    var fin = inicio + filasPorPagina;

    filas.hide().slice(inicio, fin).show();
    $("#infoPaginacion").text("Mostrando " + (inicio + (totalFilas > 0 ? 1 : 0)) + " a " + (fin > totalFilas ? totalFilas : fin) + " de " + totalFilas + " membresías");

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
// Limpiar formulario
function limpia(){
    $("#idMembresia").val("");
    $("#nombrePlan").val("");
    $("#costoPlan").val("");
}