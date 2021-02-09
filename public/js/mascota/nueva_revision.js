$(function () {
    $('#btn_agregar_evidencia').click(function () {
        var html = '<input type="file" name="evidencias[]" />';
        $('#contenedor-evidencias').append(html);
    })
    
    $('#btn_guardar_revision').click(function () {
        abrirBlockUiCargando('Guardando revisiòn');
        var params = new FormData(document.getElementById('form_revision'));
        var url = $("#general_url").val()+"/mascota/guardar-revision";

        $.ajax({
            url: url,
            data: params,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                if(data.success) {
                    if(data.revision.estado == 'terminada'){
                        window.location.href = data.url_lista_revisiones
                    }else {
                        $("#form_revision")[0].reset();
                        abrirAlerta("alertas-revisiones", "success", [data.mensaje], null, 'body');
                        $('#item_revision').html(data.revision.item_actual);
                        $('#revision').val(data.revision.id);
                        cerrarBlockUiCargando();
                    }
                }
            },
            error: function (jqXHR, error, state) {
                abrirAlerta("alertas-revisiones","danger",JSON.parse(jqXHR.responseText),null,'body');
                cerrarBlockUiCargando();
            }
        });
    })
})