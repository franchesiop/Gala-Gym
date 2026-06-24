function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function() {
    consultar();
    // validaciond de datos
    // validacion nombre
    $("#nombreRol").on("keypress", function(e) {
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#nombreRol").on("keyup",function(){
		validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#snombreRol"),"Nombre invalido - entre 3 y 100 caracteres");
	});
    // validacion descripcion
    $("#descripcionRol").on("keypress", function(e) {
        validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#descripcionRol").on("keyup",function(){
		validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#sdescripcionRol"),"Descripcion invalida - entre 3 y 100 caracteres");
	});



$("#btnGuardar").on("click", function() {
        //guardar
         if($(this).text() == 'incluir'){
            if(validarEnvio()){
              var datos = new FormData();
              datos.append('accion', 'incluir');
              datos.append('nombreRol', $("#nombreRol").val());
              datos.append('descripcion', $("#descripcionRol").val());
              enviaAjax(datos);
            }
        }
        //modificar
         else if($(this).text() == 'modificar'){
            if(validarEnvio()){
                var datos = new FormData();
                datos.append('accion', 'modificar');
                datos.append('idRol', $("#idRol").val());
                datos.append('nombreRol', $("#nombreRol").val());
                datos.append('descripcion', $("#descripcionRol").val());
                enviaAjax(datos);
            }
        }
    
    });
     $("#btnNuevoRol").on("click", function(){
     limpia();
     $("#btnGuardar").text("incluir"); 
     $("#btnEliminar").hide();
     
     $("#modalRol").modal("show");
});

     
});

// validar antes de enviar
function validarEnvio() {
    // validar nombre
    if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#nombreRol"),$("#snombreRol"),"Nombre Invalido - (Solo letras entre 3 y 100 caracteres)")==0){
		mostrarMensaje("Nombre invalido <br>" + "(Solo letras entre 3 y 100 caracteres)");
		return false;
    }
    else if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#descripcionRol"),$("#sdescripcionRol"),"Descripcion Invalida - (Solo letras entre 3 y 100 caracteres)")==0){
		mostrarMensaje("Descripcion Invalida <br>" + "(Solo letras entre 3 y 100 caracteres)");
		return false;
	}
    return true;
}
// fucncion para mostrar el mensaje modal
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
    $("#idRol").val(linea.find("td:eq(0)").text());
    $("#nombreRol").val(linea.find("td:eq(1)").text()); 
    $("#descripcionRol").val(linea.find("td:eq(2)").text());  
    $("#btnGuardar").text('modificar');
    $("#btnEliminar").show();
    $("#modalRol").modal("show");
}
function eliminar(pos){
    var linea = $(pos).closest('tr');
    var id_rol = $(linea).find("td:eq(0)").text();

    if(confirm("¿Seguro que deseas eliminar el rol?")){
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('idRol', id_rol);
        enviaAjax(datos);
    }
}

function enviaAjax(datos){
    
    $.ajax({
        async: true,
        url: "index.php?pagina=roles",
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
                    $("#cuerpoTablaRoles").html(lee.mensaje);
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Rol registrado'){
                        $("#modalRol").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Rol modificado'){
                        $("#modalRol").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Rol eliminado'){
                        
                        consultar();
                    }
                } 
                else if(lee.resultado == 'buscar'){
                    $('#listaRoles').html(lee.mensaje);
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
function limpia(){
    $("#nombreRol").val("");
    $("#descripcionRol").val("");
    $("#idRol").val("");
}
