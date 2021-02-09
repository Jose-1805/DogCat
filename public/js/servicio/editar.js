$(function () {

    $('#btn-guardar-servicio').click(function () {
        guardarServicio();
    });
})

function guardarServicio(){
    var params = new FormData(document.getElementById('form-servicio'));
    var url = $("#general_url").val()+"/servicio/actualizar";

    abrirBlockUiCargando('Guardando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            abrirAlerta("alertas-servicio","success",['Servicio editado con éxito'],null,'body');
            cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-servicio","danger",JSON.parse(jqXHR.responseText),null,'body');
            cerrarBlockUiCargando();
        }
    });
}