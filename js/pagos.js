var paginaActual = 1;
var filasPorPagina = 10;

function consultar(){
    var datos = new FormData();
    datos.append('accion', 'consultar');
    enviaAjax(datos);
}

$(document).ready(function(){

    consultar();

    // logica para cambiar dinamicamente las etiquetas y campos segun el metodo
    $("#banco").on("change", function(){
        var metodo = $(this).val();
        
        // limpia los campos al cambiar de método
        $("#input_dato_1, #input_dato_2, #input_dato_3").val("");
        $("#sinput_dato_1, #sinput_dato_2, #sinput_dato_3").text("");

        if(metodo === "Pago Móvil"){
            $("#contenedor_dato_1").show(); 
            $("#label_dato_1").text("BANCO");
            $("#label_dato_2").text("CÉDULA");
            $("#label_dato_3").text("TELÉFONO");
          
            $("#input_dato_1").attr("placeholder", "Ej: Banesco, Mercantil...");
            $("#input_dato_2").attr("placeholder", "Ej: 27000000");
            $("#input_dato_3").attr("placeholder", "Ej: 0414-1234567");
            
        } else if (metodo === "Zelle") {
            $("#contenedor_dato_1").hide(); // oculta el campo banco porque zelle no lo necesita
            $("#label_dato_2").text("CORREO ELECTRÓNICO");
            $("#label_dato_3").text("NOMBRE DEL TITULAR");
            
            $("#input_dato_2").attr("placeholder", "ejemplo@correo.com");
            $("#input_dato_3").attr("placeholder", "Ej: Juan Perez");
        }
    });

    // validaciones dinamicas

    // dato 1 (solo aplica para nombre de banco en pago movil)
    $("#input_dato_1").on("keypress",function(e){
        if($("#banco").val() === "Pago Móvil") validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e);
    });
    $("#input_dato_1").on("keyup",function(){
        if($("#banco").val() === "Pago Móvil") validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,50}$/, $(this), $("#sinput_dato_1"),"Banco inválido - entre 3 y 50 caracteres");
    });

    // dato 2 (cedula para pago movil o correo para zelle)
    $("#input_dato_2").on("keypress",function(e){
        if($("#banco").val() === "Pago Móvil") {
            validarkeypress(/^[0-9\.]*$/,e); // regla cedula
        } else {
            validarkeypress(/^[a-zA-z0-9._@-]*$/, e); // regla correo
        }
    });
    $("#input_dato_2").on("keyup",function(){
        if($("#banco").val() === "Pago Móvil") {
            validarkeyup(/^[0-9\.]{7,12}$/,$(this), $("#sinput_dato_2"),"Cédula inválida - entre 7 y 12 caracteres");
        } else {
            validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/,$(this), $("#sinput_dato_2"),"Correo inválido");
        }
    });

    // dato 3 (telefono para pago movil o titular para zelle)
    $("#input_dato_3").on("keypress",function(e){
        if($("#banco").val() === "Pago Móvil") {
            validarkeypress(/^[0-9\-+ ]*$/, e); // regal telefono
        } else {
            validarkeypress(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/,e); // regla titular
        }
    });
    $("#input_dato_3").on("keyup",function(){
        if($("#banco").val() === "Pago Móvil") {
            validarkeyup(/^[0-9\-+ ]{11,12}$/,$(this), $("#sinput_dato_3"),"Teléfono inválido - ej: 0414-0000000");
        } else {
            validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $(this),$("#sinput_dato_3"),"Titular inválido - entre 3 y 100 caracteres");
        }
    });

    //botones
    
    $("#btnGuardar").on("click", function() {
        if(validarEnvio()){
            var datos = new FormData();
            var accion = $(this).text().trim().toLowerCase(); 
            
            datos.append('accion', accion);
            datos.append('id_metodo', $("#id_metodo").val());
            datos.append('banco', $("#banco").val());
            
            // empaqueta segun los nombres que espera el controlador
            if($("#banco").val() === "Pago Móvil") {
                datos.append('nombre_banco', $("#input_dato_1").val());
                datos.append('cedula', $("#input_dato_2").val());
                datos.append('telefono', $("#input_dato_3").val());
            } else if ($("#banco").val() === "Zelle") {
                datos.append('correo_zelle', $("#input_dato_2").val());
                datos.append('titular_zelle', $("#input_dato_3").val());
            }

            enviaAjax(datos);
        }
    });

    
    $("#btnNuevoPago").on("click", function(){
        limpia();
        $("#btnGuardar").text("incluir"); 
        $("#modalPago").modal("show");
    });

    $("#buscar_pago").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        var filasFiltradas = 0;
        
        $("#cuerpoTablaPagos tr").filter(function() {
            // busca en las columnas de Banco/Tipo y los datos extra
            var banco = $(this).find("td:eq(1)").text().toLowerCase();
            var dato1 = $(this).find("td:eq(2)").text().toLowerCase();
            var dato2 = $(this).find("td:eq(3)").text().toLowerCase();

            var coincide = banco.indexOf(valor) > -1 || dato1.indexOf(valor) > -1 || dato2.indexOf(valor) > -1;
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

// funciones
function validarEnvio() {
    var metodo = $("#banco").val();

    if(!metodo) {
        mostrarMensaje("Debe seleccionar un MÉTODO DE PAGO");
        return false;
    }

    if(metodo === "Pago Móvil") {
        if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,50}$/, $("#input_dato_1"),$("#sinput_dato_1"),"")==0){
            mostrarMensaje("Banco Inválido <br/>(Solo letras entre 3 y 50 caracteres)");
            return false;
        }
        if(validarkeyup(/^[0-9\.]{7,12}$/,$("#input_dato_2"), $("#sinput_dato_2"),"")==0){
            mostrarMensaje("Cédula Inválida <br/>(El formato debe ser numérico)");    
            return false;                   
        }
        if(validarkeyup(/^[0-9\-+ ]{11,12}$/,$("#input_dato_3"), $("#sinput_dato_3"),"")==0){
            mostrarMensaje("Teléfono Inválido <br>(Formato sugerido: 0414-0000000)");    
            return false;                   
        }
    } else if (metodo === "Zelle") {
        if(validarkeyup(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/, $("#input_dato_2"), $("#sinput_dato_2"),"") == 0){
            mostrarMensaje("Correo Zelle Inválido <br/>(Formato incorrecto)");
            return false;
        }
        if(validarkeyup(/^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]{3,100}$/, $("#input_dato_3"),$("#sinput_dato_3"),"")==0){
            mostrarMensaje("Titular Inválido <br>(Solo letras entre 3 y 100 caracteres)");
            return false;
        }
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
    if(!a){
        e.preventDefault();
    }
}

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

// funcion para llenar el formulario desde la tabla
function pone(pos){
    var linea = $(pos).closest('tr');
    
    var id_metodo = linea.find("td:eq(0)").text().trim();
    
    var banco_db = linea.find("td:eq(1)").text().trim(); 
    var dato_1 = linea.find("td:eq(2)").text().trim();   
    var dato_2 = linea.find("td:eq(3)").text().trim();   

    $("#id_metodo").val(id_metodo);

    // dispara el .trigger("change") para que el formulario se adapte visualmente antes de meter los datos
    if(banco_db.toLowerCase() === "zelle") {
        $("#banco").val("Zelle").trigger("change");
        $("#input_dato_2").val(dato_1); // Correo
        $("#input_dato_3").val(dato_2); // Titular
    } else {
        $("#banco").val("Pago Móvil").trigger("change");
        $("#input_dato_1").val(banco_db); // nombre del  banco
        $("#input_dato_2").val(dato_1); // cedula
        $("#input_dato_3").val(dato_2); // teleono
    }
    
    $("#btnGuardar").text('modificar');
    $("#modalPago").modal("show");
}

function eliminar(pos){
    var linea = $(pos).closest('tr');
    var id_metodo = $(linea).find("td:eq(0)").text().trim();
    
    var detalle = $(linea).find("td:eq(1)").text().trim(); 

    if(confirm("¿Seguro que deseas eliminar este método de pago?")){
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id_metodo', id_metodo);
        
        enviaAjax(datos);
    }
}

function enviaAjax(datos){
    $.ajax({
        async: true,
        url: "index.php?pagina=pagos", 
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        beforeSend: function () {},
        timeout: 10000,
        success: function (respuesta){
            try{
                var lee = JSON.parse(respuesta);
                if(lee.resultado == 'consultar'){
                    $("#cuerpoTablaPagos").html(lee.mensaje);
                    paginarTabla(1);
                } 
                else if(lee.resultado == 'incluir'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Método Registrado'){
                        $("#modalPago").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'modificar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Método Modificado'){
                        $("#modalPago").modal("hide");
                        consultar();
                    }
                }
                else if(lee.resultado == 'eliminar'){
                    mostrarMensaje(lee.mensaje);
                    if(lee.mensaje == 'Método Eliminado'){
                        $("#modalPago").modal("hide");
                        consultar();
                    }
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
        },
        complete: function () {},
    });
}
    function paginarTabla(pagina) {
    paginaActual = pagina;
    var filas = $("#cuerpoTablaPagos tr");
    var totalFilas = filas.length;
    var totalPaginas = Math.ceil(totalFilas / filasPorPagina);
    
    var inicio = (paginaActual - 1) * filasPorPagina;
    var fin = inicio + filasPorPagina;

    filas.hide().slice(inicio, fin).show();
    $("#infoPaginacion").text("Mostrando " + (inicio + (totalFilas > 0 ? 1 : 0)) + " a " + (fin > totalFilas ? totalFilas : fin) + " de " + totalFilas + " métodos de pago");

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
    $("#id_metodo").val("");
    $("#banco").val("Pago Móvil").trigger("change"); // reinicia el select
    $("#input_dato_1").val("");
    $("#input_dato_2").val("");
    $("#input_dato_3").val("");
    $("#sinput_dato_1").text("");
    $("#sinput_dato_2").text("");
    $("#sinput_dato_3").text("");
}