$(function () {

    $('#btn-guardar-servicio').click(function () {
        guardarServicio();
    });
})

function guardarServicio(){
    var params = new FormData(document.getElementById('form-servicio'));
    var url = $("#general_url").val()+"/servicio/guardar";

    abrirBlockUiCargando('Guardando ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
                $("#form-servicio")[0].reset();
                abrirAlerta("alertas-servicio","success",['Servicio creado con éxito'],null,'body');
                cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-servicio","danger",JSON.parse(jqXHR.responseText),null,'body');
            cerrarBlockUiCargando();
        }
    });
}