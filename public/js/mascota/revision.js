var mascota = null;
$(function () {
    $('body').on('click','.btn_cargar_revision',function () {
        var revision = $(this).data('revision');
        if(revision)
            cargarRevision(revision);
    })
})

function cargarRevisiones() {
    var url = $('#general_url').val()+'/mascota/lista-revisiones';
    var params = {_token:$('#general_token').val(),mascota:mascota};

    var elemento_load = $('#contenedor-revisiones');
    abrirBlockUiElemento(elemento_load,'Cargando revisiones');

    $.post(url,params)
        .done(function (data) {
            $('#contenedor-revisiones').html(data);
            cerrarBlockUiElemento(elemento_load);
        })
}

function cargarRevision(id) {
    var url = $('#general_url').val()+'/mascota/datos-revision';
    var params = {_token:$('#general_token').val(),mascota:mascota,revision:id};

    var elemento_load = $('#contenedor-informacion-revision');
    abrirBlockUiElemento(elemento_load,'Cargando revisión');

    $.post(url,params)
        .done(function (data) {
            $('#contenedor-informacion-revision').html(data);
            cerrarBlockUiElemento(elemento_load);
        })
}