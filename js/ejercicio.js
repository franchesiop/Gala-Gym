var paginaActual = 1;
var filasPorPagina = 10;

function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();

    $("#formEjercicios").on("submit", function(e){
        e.preventDefault();
    });

    // validacion de imagen (Preview, formato y peso)
    $("#imagen_ejercicio").on("change", function(){
        var archivo = this.files[0];
        if(archivo){
            if(archivo.size > 2097152){ // 2MB
                mostrarMensaje("Imagen Invalida <br/> (La imagen es muy pesada. Máximo 2MB)");
                $(this).val(""); 
                $("#vista_previa").attr("src", "img/default.jpg");
                return;
            }
            
            var tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if(!tiposPermitidos.includes(archivo.type)){
                mostrarMensaje("Formato Invalido <br/> (Solo JPG, PNG o WEBP)");
                $(this).val("");
                $("#vista_previa").attr("src", "img/default.jpg");
                return;
            }
            
            var reader = new FileReader();
            reader.onload = function(e){
                $("#vista_previa").attr("src", e.target.result);
            }
            reader.readAsDataURL(archivo);
        } else {
            $("#vista_previa").attr("src", "img/default.jpg");
        }
    });

    // Buscador en tiempo real
    $("#buscar_ejercicio").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        var filasFiltradas = 0;
        
        $("#tablaEjercicios tr").filter(function() {
            var coincide = $(this).find("td:eq(2)").text().toLowerCase().indexOf(valor) > -1;
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

    // Validacion nombre
    $("#nombre_ejercicio").on("keypress",function(e){
        validarkeypress(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#nombre_ejercicio").on("keyup",function(){
        validarkeyup(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this), $("#snombre_ejercicio"), "Nombre invalido - entre 3 y 100 caracteres");
    });

    // Botones
    $("#btnGuardar").on("click", function() {
        // guardar
        if($(this).text().toUpperCase() == 'INCLUIR' || $(this).text() == 'incluir'){
            if(validarEnvio()){
                // Usamos el formulario completo para que capture la imagen automáticamente
                var datos = new FormData($("#formEjercicios")[0]);
                datos.append('accion', 'incluir');
                enviaAjax(datos);
            }
        }
        // modificar
        else if($(this).text().toUpperCase() == 'MODIFICAR' || $(this).text() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData($("#formEjercicios")[0]);
                datos.append('accion', 'modificar');
                enviaAjax(datos);
            }
        }
    });

    $("#btnNuevoEjercicio").on("click", function(){
        limpia();
        $("#btnGuardar").text("INCLUIR"); 
        $("#modalUsuario").modal("show");
    });

    $("#btnConfirmarEliminar").on("click", function(){
        var id = $("#id_eliminar_global").val(); 
        
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_ejercicio', id);
        
        enviaAjax(datos);
    });

});

// Validar antes de enviar
function validarEnvio() {
    // validar nombre
    if(validarkeyup(/^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombre_ejercicio"), $("#snombre_ejercicio"), "Nombre Invalido - (Entre 3 y 100 caracteres)") == 0){
        mostrarMensaje("Nombre Invalido <br>" + "(Entre 3 y 100 caracteres)");
        return false;
    }
    return true;
}

// Funcion para mostrar el mensaje modal
function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

// Funcion para validar por keypress
function validarkeypress(er,e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
        e.preventDefault();
    }
}

// Funcion para validar por keyup
function validarkeyup(er,etiqueta,etiquetamensaje,mensaje){
    a = er.test(etiqueta.val());
    if(a){
        etiquetamensaje.text("");
        return 1;
    } else{
        etiquetamensaje.text(mensaje);
        return 0;
    }
}

// Funcion para llenar el formulario
function pone(pos){
    linea = $(pos).closest('tr');
    
    var id = linea.find("td:eq(0)").text();
    var srcImagen = linea.find("td:eq(1) img").attr("src"); 
    var nombre = linea.find("td:eq(2)").text();
    var descripcion = linea.find("td:eq(4)").text(); // El td 4 es el texto oculto limpio (sin HTML)

    $("#id_ejercicio").val(id);
    $("#nombre_ejercicio").val(nombre);
    $("#descripcion_ejercicio").val(descripcion !== "Sin descripción" ? descripcion : "");
    
    if(srcImagen) { 
        $("#vista_previa").attr("src", srcImagen); 
    } else { 
        $("#vista_previa").attr("src", "img/default.jpg"); 
    }

    $("#btnGuardar").text('MODIFICAR');
    $("#modalUsuario").modal("show");
}

function eliminar(pos){
    var linea = $(pos).closest('tr');
    var id = $(linea).find("td:eq(0)").text();

    // Guardamos el ID en el input oculto del modal generico
    $("#id_eliminar_global").val(id);
    
    // Mostramos el modal de Bootstrap
    $("#modal_eliminar").modal("show");
}

// Funcion Ajax estandarizada a la estructura de clientes
function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=ejercicio",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        beforeSend: function () {},
        timeout: 10000,
        success: function (respuesta){
            console.log(respuesta);
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'consultar'){
                    $("#tablaEjercicios").html(lee.mensaje);
                    paginarTabla(1);
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Ejercicio Registrado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Ejercicio Modificado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Ejercicio Eliminado'){
                        $("#modal_eliminar").modal("hide");
                        consultar();
                    }
                } 
                else if(lee.resultado == "error"){
                    mostrarMensaje("ERROR: <br/>" + lee.mensaje);
                }
            } catch(e){
                alert("Error en JSON " + e.name);
            }
        },
        error: function(request, status, err){
            if(status == "timeout"){
                mostrarMensaje("Servidor Ocupado, Intente de Nuevo");
            } else {
                mostrarMensaje("ERROR: <br/>" + request + status + err);
            }
        },
        complete: function () {},
    });
}

// logica de paginacion matematica exacta (< 1 2 3 ... >)
function paginarTabla(pagina) {
    paginaActual = pagina;
    var filas = $("#tablaEjercicios tr");
    var totalFilas = filas.length;
    var totalPaginas = Math.ceil(totalFilas / filasPorPagina);
    
    var inicio = (paginaActual - 1) * filasPorPagina;
    var fin = inicio + filasPorPagina;

    filas.hide().slice(inicio, fin).show();
    $("#infoPaginacion").text("Mostrando " + (inicio + (totalFilas > 0 ? 1 : 0)) + " a " + (fin > totalFilas ? totalFilas : fin) + " de " + totalFilas + " ejercicios");

    var htmlBotones = "";

    // Boton <
    var prevDisabled = (paginaActual === 1) ? "disabled" : "";
    htmlBotones += `<li class="page-item ${prevDisabled}"><a class="page-link text-dark" href="#" onclick="if(${paginaActual} > 1) paginarTabla(${paginaActual - 1}); return false;">&lt;</a></li>`;

    // Numeros y puntos suspensivos (...)
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

    // Boton >
    var nextDisabled = (paginaActual === totalPaginas || totalPaginas === 0) ? "disabled" : "";
    htmlBotones += `<li class="page-item ${nextDisabled}"><a class="page-link text-dark" href="#" onclick="if(${paginaActual} < ${totalPaginas}) paginarTabla(${paginaActual + 1}); return false;">&gt;</a></li>`;

    $("#contenedorPaginacion").html(htmlBotones);
}

function limpia(){
    $("#id_ejercicio").val("");
    $("#formEjercicios")[0].reset();
    $("#snombre_ejercicio").text("");
    $("#vista_previa").attr("src", "img/default.jpg");
}