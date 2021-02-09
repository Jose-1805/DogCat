var registro = null;
$(function () {
    $('#btn-nuevo-historial').click(function () {
       nuevoHistorialRegistro();
    });
    $('#btn-rol-registro').click(function () {
       nuevoHistorialRegistro(false);
    });
})


function cargarHistorialRegistro() {
    var elemento = $("#contenedor-lista-historial");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/registro/lista-historial';
    var params = {_token:$('#general_token').val(),'registro':registro};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}

function nuevoHistorialRegistro(validar_completo = true) {

    if($('#estado').val() == 'completo' && validar_completo){
        $('#modal-rol-registro').modal('show');
    }else {
        var eliminar_regsitrado = false;
        var recargar_pagina = false;
        if ($('#estado').val() != 'registrado')
            eliminar_regsitrado = true;


        var params = $("#form-historial-registro").serialize();
        var url = $("#general_url").val() + "/registro/store-historial";


        if ($('#estado').val() == 'completo') {
            recargar_pagina = true;
            params += '&rol='+$('#rol').val();
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
                    $("#form-historial-registro #observaciones").val('');
                    cerrarBlockUiCargando();
                    cargarHistorialRegistro();
                }
            })
            .fail(function (jqXHR, state, error) {
                $('#modal-rol-registro').modal('hide');
                abrirAlerta("alertas-nuevo-historial-registro", "danger", JSON.parse(jqXHR.responseText), null, "modal-nuevo-rol");
                cerrarBlockUiCargando();
            })
    }
}