function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();
    //validacion de datos
    //validacion cedula
    $("#cedulaCliente").on("keypress",function(e){
        validarkeypress(/^[0-9-\.]*$/,e);
    });
    $("#cedulaCliente").on("keyup",function(){
        validarkeyup(/^[0-9\.]{7,12}$/,$(this), $("#scedulaCliente"),"Cedula invalida - entre 7 y 12 caracteres");
	});

    //validacion nombre
     $("#nombreCliente").on("keypress",function(e){
		validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
	});
	$("#nombreCliente").on("keyup",function(){
		validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#snombreCliente"),"Nombre invalido - entre 3 y 100 caracteres");
	});

    //validacion apellido
     $("#apellidoCliente").on("keypress",function(e){
		validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
	});
	$("#apellidoCliente").on("keyup",function(){
		validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#sapellidoCliente"),"Apellido invalido - entre 3 y 100 caracteres");
	});

    //validacion telefono 
     $("#tlfCliente").on("keypress",function(e){
        validarkeypress(/^[0-9\-+ ]*$/, e);
    });
    $("#tlfCliente").on("keyup",function(){
        validarkeyup(/^[0-9\-+ ]{11,12}$/,$(this), $("#stlfCliente"),"Telefono invalido - debe ser: 0000-0000000");
	});

    //validacion correo
    $("#correoCliente").on("keypress",function(e){
        validarkeypress(/^[a-zA-z0-9._@-]*$/, e);
    });
    $("#correoCliente").on("keyup",function() {
        validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/,$(this), $("#scorreoCliente"),"Correo invalido - entre 2 y 10 caracteres");
    });

    //validar contrasena
    $("#contraCliente").on("keypress",function(e) {
        validarkeypress(/^[a-zA-Z0-9!@#$%^&*]*$/, e);
    });
    $("#contraCliente").on("keyup", function(e) {
        validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/,$(this), $("#scontraCliente"),"Contrasena invalida - entre 8 y 20 caracteres")
    });

    //botones
    $("#btnGuardar").on("click", function() {
        //guardar
         if($(this).text() == 'incluir'){
            if(validarEnvio()){
              var datos = new FormData();
              datos.append('accion', 'incluir');
              datos.append('cedulaCliente', $("#cedulaCliente").val());
              datos.append('nombreCliente', $("#nombreCliente").val());
              datos.append('apellidoCliente', $("#apellidoCliente").val());
              datos.append('tlfCliente', $("#tlfCliente").val());
              datos.append('correoCliente', $("#correoCliente").val());
              datos.append('contraCliente', $("#contraCliente").val());
              datos.append('membresiaCliente', $("#membresiaCliente").val());
              enviaAjax(datos);
            }
        }
        //modificar
         else if($(this).text() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('cedulaCliente', $("#cedulaCliente").val());
                datos.append('nombreCliente', $("#nombreCliente").val());
                datos.append('apellidoCliente', $("#apellidoCliente").val());
                datos.append('tlfCliente', $("#tlfCliente").val());
                datos.append('correoCliente', $("#correoCliente").val());
                datos.append('contraCliente', $("#contraCliente").val());
                datos.append('membresiaCliente', $("#membresiaCliente").val());
                enviaAjax(datos);
            }
        }
    
    });

        $("#btnNuevoCliente").on("click", function(){
     limpia();
     $("#btnGuardar").text("incluir"); 
     $("#btnEliminar").hide();
     cargarMembresias(); 
     $("#modalUsuario").modal("show");
});

        $("#btnEliminar").on("click", function(){
        var cedula = $("#cedulaCliente").val(); 
        if(confirm("¿Seguro que desea eliminar a este cliente?")){
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('cedulaCliente', cedula);
        enviaAjax(datos);
    }
});
        

        $("#incluir").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir");
        $("#modalUsuario").modal("show");
        });

});

//validar antes de enviar
function validarEnvio() {
    //validar cedula
    if(validarkeyup(/^[0-9\.]{7,12}$/,$("#cedulaCliente"), $("#scedulaCliente"),"Cedula Invalida - (El Formato debe ser: 999999999)")==0){
        mostrarMensaje("Cedula Invalida <br/>" + "(El formato debe ser: 99999999)");	
		return false;					
	}
    //validar nombre
     else if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombreCliente"),$("#snombreCliente"),"Nombre Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
		mostrarMensaje("Nombre Invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
		return false;
	}
    //validar apellido 
    else if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#apellidoCliente"),$("#sapellidoCliente"),"apellido Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
		mostrarMensaje("Apellido Invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
		return false;
	}
    //validar telefono
    else if(validarkeyup(/^[0-9\-+ ]{11,12}$/,$("#tlfCliente"), $("#stlfCliente"),"Telefono Invalido - (Formato de: 0000-0000000)")==0){
        mostrarMensaje("Telefono Invalido <br>" + "(Formato de: 0000-0000000)");	
		return false;					
	}
    //validar correo
    else if(validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $("#correoCliente"), $("#scorreoCliente"),"Correo Invalido") == 0){
        mostrarMensaje("Correo Invalido <br/>" + "(Formato incorrecto)");
        return false;
    }
    //validar contrasena
    else {
        var contra = $("#contraCliente").val();
        var esModificar = ($("#btnGuardar").text().trim().toLowerCase() == 'modificar');

        // solo validamos si no es modificar o si el usuario escribio algo nuevo
        if (!(esModificar && contra === "")) {
            if (validarkeyup(/^[a-zA-Z0-9!@#$%^&*]{8,20}$/, $("#contraCliente"), $("#scontraCliente"), "Contrasena Invalida") == 0) {
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
    linea = $(pos).closest('tr');
    
    $("#cedulaCliente").val(linea.find("td:eq(0)").text());
    $("#nombreCliente").val(linea.find("td:eq(1)").text());   
    $("#apellidoCliente").val(linea.find("td:eq(2)").text()); 
    $("#tlfCliente").val(linea.find("td:eq(3)").text());      
    $("#correoCliente").val(linea.find("td:eq(4)").text()); 
    var idMembresia = linea.find("td:eq(5)").text();
    cargarMembresias(idMembresia); 
    $("#contraCliente").val();
    $("#btnGuardar").text('modificar');
    $("#btnEliminar").show();
    $("#modalUsuario").modal("show");
}

function eliminar(pos){
    var linea = $(pos).closest('tr');
    var cedula = $(linea).find("td:eq(0)").text();

    $("#cedulaEliminar").val(cedula);
    $("#modal_eliminar").modal("show");
}

function enviaAjax(datos){
    
    $.ajax({
        async: true,
        url: "index.php?pagina=clientes",
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
                    $("#cuerpoTablaClientes").html(lee.mensaje);
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Cliente Registrado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Cliente Modificado'){
                        $("#modalUsuario").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Cliente Eliminado'){
                        $("#modalUsuario").modal("hide");
                        $("#modal_eliminar").modal("hide");
                        consultar();
                    }
                } 
                else if(lee.resultado == 'buscar'){
                    $('#listaClientes').html(lee.mensaje);
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

function cargarMembresias(valorSeleccionado = "") {
    $.ajax({
        url: "index.php?pagina=clientes",
        type: "POST",
        data: { accion: 'listar_membresias' },
        success: function(respuesta){
            var data = JSON.parse(respuesta);
            var select = $("#membresiaCliente");
            select.find('option:not(:first)').remove();
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_membresia + '">' + item.tipo + '</option>');
            });
            if(valorSeleccionado != "") {
                select.val(valorSeleccionado);
            }
        }
    });
}

function limpia(){
    $("#cedulaCliente").val("");
	$("#nombreCliente").val("");
	$("#apellidoCliente").val("");
    $("#tlfCliente").val("");
    $("#correoCliente").val("");
    $("#membresiaCliente").val("");
    $("#contraCliente").val("");
}


