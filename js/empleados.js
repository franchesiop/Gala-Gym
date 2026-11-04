var paginaActual = 1;
var filasPorPagina = 10;

function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();
    //validacion de datos
    //validacion cedula
    $("#cedulaEmpleado").on("keypress",function(e){
        validarkeypress(/^[0-9-\.]*$/,e);
    });
    $("#cedulaEmpleado").on("keyup",function(){
        validarkeyup(/^[0-9\.]{7,12}$/,$(this), $("#scedulaEmpleado"),"Cedula invalida - entre 7 y 12 caracteres");
	});

    //validacion nombre
     $("#nombreEmpleado").on("keypress",function(e){
		validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
	});
	$("#nombreEmpleado").on("keyup",function(){
		validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#snombreEmpleado"),"Nombre invalido - entre 3 y 100 caracteres");
	});

    //validacion apellido
     $("#apellidoEmpleado").on("keypress",function(e){
		validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
	});
	$("#apellidoEmpleado").on("keyup",function(){
		validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#sapellidoEmpleado"),"Apellido invalido - entre 3 y 100 caracteres");
	});

    //validacion telefono 
     $("#tlfEmpleado").on("keypress",function(e){
        validarkeypress(/^[0-9\-+ ]*$/, e);
    });
    $("#tlfEmpleado").on("keyup",function(){
        validarkeyup(/^[0-9\-+ ]{11,12}$/,$(this), $("#stlfEmpleado"),"Telefono invalido - debe ser: 0000-0000000");
	});

    //validacion correo
    $("#correoEmpleado").on("keypress",function(e){
        validarkeypress(/^[a-zA-z0-9._@-]*$/, e);
    });
    $("#correoEmpleado").on("keyup",function() {
        validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/,$(this), $("#scorreoEmpleado"),"Correo invalido - entre 2 y 10 caracteres");
    });

    //validar contrasena
    $("#contraEmpleado").on("keypress",function(e) {
        validarkeypress(/^[a-zA-Z0-9!@#$%^&*]*$/, e);
    });
    $("#contraEmpleado").on("keyup", function(e) {
        validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/,$(this), $("#scontraEmpleado"),"Contrasena invalida - entre 8 y 20 caracteres")
    });

    //botones
    $("#btnGuardar").on("click", function() {
        //guardar
         if($(this).text() == 'incluir'){
            if(validarEnvio()){
              var datos = new FormData();
              datos.append('accion', 'incluir');
              datos.append('cedulaEmpleado', $("#cedulaEmpleado").val());
              datos.append('nombreEmpleado', $("#nombreEmpleado").val());
              datos.append('apellidoEmpleado', $("#apellidoEmpleado").val());
              datos.append('tlfEmpleado', $("#tlfEmpleado").val());
              datos.append('correoEmpleado', $("#correoEmpleado").val());
              datos.append('contraEmpleado', $("#contraEmpleado").val());
              datos.append('rolEmpleado', $("#rolEmpleado").val());
              enviaAjax(datos);
            }
        }
        //modificar
         else if($(this).text() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('cedulaEmpleado', $("#cedulaEmpleado").val());
                datos.append('nombreEmpleado', $("#nombreEmpleado").val());
                datos.append('apellidoEmpleado', $("#apellidoEmpleado").val());
                datos.append('tlfEmpleado', $("#tlfEmpleado").val());
                datos.append('correoEmpleado', $("#correoEmpleado").val());
                datos.append('contraEmpleado', $("#contraEmpleado").val());
                datos.append('rolEmpleado', $("#rolEmpleado").val());
                enviaAjax(datos);
            }
        }
    
    });

        $("#btnNuevoEmpleado").on("click", function(){
     limpia();
     $("#btnGuardar").text("incluir"); 
     $("#btnEliminar").hide();
     cargarRoles(); 
     $("#modalUsuario").modal("show");
});

        $("#btnEliminar").on("click", function(){
        var cedula = $("#cedulaEmpleado").val(); 
        
        // Pasa la cédula al modal de confirmación
        $("#id_eliminar_global").val(cedula);
        
        // Oculta el modal de edición y abre el de confirmación
        $("#modalUsuario").modal("hide");
        $("#modal_eliminar").modal("show");
    });

        // Evento del botón "SÍ, ELIMINAR" del modal genérico
    $("#btnConfirmarEliminar").on("click", function(){
        var cedula = $("#id_eliminar_global").val(); 
        
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('cedulaEmpleado', cedula);
        
        enviaAjax(datos);
    });
        

        $("#incluir").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir");
        $("#modalUsuario").modal("show");
        });

        $("#buscar_empleado").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        var filasFiltradas = 0;
        
        $("#cuerpoTablaEmpleados tr").filter(function() {
            var cedula = $(this).find("td:eq(0)").text().toLowerCase();
            var nombre = $(this).find("td:eq(1)").text().toLowerCase();
            var apellido = $(this).find("td:eq(2)").text().toLowerCase();

            var coincide = cedula.indexOf(valor) > -1 || nombre.indexOf(valor) > -1 || apellido.indexOf(valor) > -1;
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

//validar antes de enviar
function validarEnvio() {
    //validar cedula
    if(validarkeyup(/^[0-9\.]{7,12}$/,$("#cedulaEmpleado"), $("#scedulaEmpleado"),"Cedula Invalida - (El Formato debe ser: 999999999)")==0){
        mostrarMensaje("Cedula Invalida <br/>" + "(El formato debe ser: 99999999)");	
		return false;					
	}
    //validar nombre
     else if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombreEmpleado"),$("#snombreEmpleado"),"Nombre Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
		mostrarMensaje("Nombre Invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
		return false;
	}
    //validar apellido 
    else if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#apellidoEmpleado"),$("#sapellidoEmpleado"),"apellido Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
		mostrarMensaje("Apellido Invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
		return false;
	}
    //validar telefono
    else if(validarkeyup(/^[0-9\-+ ]{11,12}$/,$("#tlfEmpleado"), $("#stlfEmpleado"),"Telefono Invalido - (Formato de: 0000-0000000)")==0){
        mostrarMensaje("Telefono Invalido <br>" + "(Formato de: 0000-0000000)");	
		return false;					
	}
    //validar correo
    else if(validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $("#correoEmpleado"), $("#scorreoEmpleado"),"Correo Invalido") == 0){
        mostrarMensaje("Correo Invalido <br/>" + "(Formato incorrecto)");
        return false;
    }
    //validar contrasena
    else {
        var contra = $("#contraEmpleado").val();
        var esModificar = ($("#btnGuardar").text().trim().toLowerCase() == 'modificar');

        // solo validamos si no es modificar o si el usuario escribio algo nuevo
        if (!(esModificar && contra === "")) {
            if (validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/, $("#contraEmpleado"), $("#scontraEmpleado"), "Contrasena Invalida") == 0) {
                mostrarMensaje("Contrasena Invalida <br/> (Debe tener entre 8 y 20 caracteres)");
                return false;
            }
        }
    }
    return true;
}
//fucncion para mostrar el mensaje modal
function mostrarMensaje(mensaje){
    $("#contenidoModal").html(mensaje);
    $("#mostrarModal").modal("show");
    setTimeout(function() {$("#mostrarModal").modal("hide")}, 5000);
}

// funcion apra validar por keypress
function validarkeypress(er,e){
    key = e.keyCode;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
	if(!a){
        e.preventDefault();
    }
}

// funcion para validar por keyup
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

// funcion para llenar el formulario
function pone(pos){
    var linea = $(pos).closest('tr');
    
    $("#cedulaEmpleado").val(linea.find("td:eq(0)").text());
    $("#nombreEmpleado").val(linea.find("td:eq(1)").text());   
    $("#apellidoEmpleado").val(linea.find("td:eq(2)").text()); 
    $("#tlfEmpleado").val(linea.find("td:eq(4)").text());      
    $("#correoEmpleado").val(linea.find("td:eq(5)").text()); 
    var idRol = linea.find("td:eq(6)").text();               
    
    cargarRoles(idRol); 
    
    $("#contraEmpleado").val(""); 
    $("#btnGuardar").text('modificar');
    $("#btnEliminar").show();
    $("#modalUsuario").modal("show");
}

function eliminar(pos){
    var linea = $(pos).closest('tr');
    var cedula = $(linea).find("td:eq(0)").text();

    // Guardamos la cédula en el input oculto del modal genérico
    $("#id_eliminar_global").val(cedula);
    
    // Mostramos el modal de Bootstrap
    $("#modal_eliminar").modal("show");
}

function enviaAjax(datos){
    
    $.ajax({
        async: true,
        url: "index.php?pagina=empleados",
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
                    $("#cuerpoTablaEmpleados").html(lee.mensaje);
                    paginarTabla(1);
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Empleado Registrado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Empleado Modificado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Empleado Eliminado'){
                        $("#modalUsuario").modal("hide");
                        $("#modal_eliminar").modal("hide");
                        consultar();
                    }
                } 
                else if(lee.resultado == 'buscar'){
                    $('#listaEmpleados').html(lee.mensaje);
                }
                else if(lee.resultado == "error"){
                    mostrarMensaje(lee.mensaje);
                }
            } catch(e){
                alert("Error en JSON" + e.name);
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

function cargarRoles(valorSeleccionado = "") {
    $.ajax({
        url: "index.php?pagina=empleados",
        type: "POST",
        data: { accion: 'listar_roles' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#rolEmpleado");
            select.find('option:not(:first)').remove();
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_rol + '">' + item.nombre + '</option>');
            });
            if(valorSeleccionado != "") {
                select.val(valorSeleccionado);
            }
        }
    });
}
function paginarTabla(pagina) {
    paginaActual = pagina;
    var filas = $("#cuerpoTablaEmpleados tr");
    var totalFilas = filas.length;
    var totalPaginas = Math.ceil(totalFilas / filasPorPagina);
    
    var inicio = (paginaActual - 1) * filasPorPagina;
    var fin = inicio + filasPorPagina;

    filas.hide().slice(inicio, fin).show();
    $("#infoPaginacion").text("Mostrando " + (inicio + (totalFilas > 0 ? 1 : 0)) + " a " + (fin > totalFilas ? totalFilas : fin) + " de " + totalFilas + " empleados");

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
    $("#cedulaEmpleado").val("");
	$("#nombreEmpleado").val("");
	$("#apellidoEmpleado").val("");
    $("#tlfEmpleado").val("");
    $("#correoEmpleado").val("");
    $("#rolEmpleado").val("");
    $("#contraEmpleado").val("");
}


