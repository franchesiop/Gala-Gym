$(document).ready(function(){
    cargarTablaMembresias();

    $("#btnGuardar").on("click", function(e){
        e.preventDefault();
        var accion = $(this).text().toLowerCase() == "guardar" ? "modificar" : "incluir";
        var datos = new FormData();
        datos.append('accion', accion);
        datos.append('id', $("#idMembresia").val());
        datos.append('nombre', $("#nombrePlan").val());
        datos.append('costo', $("#costoPlan").val());
        
        enviaAjaxMembresias(datos);
    });

    $("#eliminar").on("click", function(e){
        e.preventDefault();
        var datos = new FormData();
        datos.append('accion', 'eliminar');
        datos.append('id', $("#idMembresia").val());
        enviaAjaxMembresias(datos);
    });

    $("#btnNuevoPlan").on("click", function(){
        $("#idMembresia").val("");
        $("#nombrePlan").val("");
        $("#costoPlan").val("");
        $("#btnGuardar").text("Incluir");
        $("#eliminar").hide();
        $("#modalMembresia").modal("show");
    });
});

$(document).on('click', '.btn-modificar', function(){
    let linea = $(this).closest('tr');
    
    $("#idMembresia").val(linea.find("td:eq(0)").text());
    $("#nombrePlan").val(linea.find("td:eq(1)").text());
    $("#costoPlan").val(linea.find("td:eq(2)").text().replace('$', ''));
    
    $("#btnGuardar").text("Guardar");
    $("#eliminar").show();
    $("#modalMembresia").modal("show");
});

function enviaAjaxMembresias(datos){
    $.ajax({
        async: true,
        url: '?pagina=membresias',
        type: 'POST',
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: function(respuesta) {
            try {
                let lee = JSON.parse(respuesta);
                if(lee.resultado == 'consultar'){
                    $("#cuerpoTablaMembresias").html(lee.mensaje);
                } else {
                    alert(lee.mensaje); 
                    $("#modalMembresia").modal("hide");
                    cargarTablaMembresias();
                }
            } catch (e) {
                console.error("Error al procesar: ", respuesta);
            }
        },
        error: function(){ alert("Error de conexión"); }
    }); 
}

function cargarTablaMembresias() {
    var d = new FormData(); 
    d.append('accion', 'consultar');
    enviaAjaxMembresias(d);
}