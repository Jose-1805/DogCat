var registro = null;
$(function () {
    $('#btn-nuevo-historial-solicitud-afiliacion').click(function () {
       nuevoHistorialSolicitudAfiliacion();
    });
})


function cargarHistorialSolicitudAfiliacion() {
    var elemento = $("#contenedor-lista-historial");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/solicitud-afiliacion/lista-historial';
    var params = {_token:$('#general_token').val(),'id':registro};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}

function nuevoHistorialSolicitudAfiliacion() {

    var eliminar_regsitrado = false;
    var recargar_pagina = false;
    if ($('#estado').val() != 'registrada')
        eliminar_regsitrado = true;


    var params = $("#form-historial-solicitud-afiliacion").serialize();
    var url = $("#general_url").val() + "/solicitud-afiliacion/store-historial";


    if ($('#estado').val() == 'procesada') {
        recargar_pagina = true;
    }


    abrirBlockUiCargando('Guardando ');

    $.post(url, params)
        .done(function (data) {
            if (recargar_pagina) {
                window.location.reload();
            } else {
                if (eliminar_regsitrado) {
                    $("#estado").find("option[value='registrado']").remove();
                }
                $("#form-historial-solicitud-afiliacion #observaciones").val('');
                cerrarBlockUiCargando();
                cargarHistorialSolicitudAfiliacion();
            }
        })
        .fail(function (jqXHR, state, error) {
            abrirAlerta("alertas-nuevo-historial-solicitud-afiliacion", "danger", JSON.parse(jqXHR.responseText), null, "body");
            cerrarBlockUiCargando();
        })
}