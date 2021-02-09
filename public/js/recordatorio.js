var recordatorios_cargados = [];
var cargar_mas = true;
var primera_carga = false;
$(function () {
    $('#btn-recordatorios').click(function () {
        $('#modal-recordatorio').modal('show');
    })

    $('#btn-crear-recordatorio').click(function () {
        $('#modal-recordatorio').modal('hide');
        setTimeout(function () {
            $('#modal-crear-recordatorio').modal('show');
        },500);
    })

    $('#btn-ver-recordatorios').click(function () {
        $('#modal-recordatorio').modal('hide');
        setTimeout(function () {
            $('#modal-lista-recordatorios').modal('show');
            if(!primera_carga) {
                cargarListaRecordatorios();
                primera_carga = true;
            }
        },500);
    })

    $('#url_actual').change(function () {
        if($(this).prop('checked')){
            $('#url').val('');
            $('#url').prop('disabled','disabled');
        }else{
            $('#url').prop('disabled', false);
        }
    })
    
    $('#btn-guardar-recordatrio').click(function () {
        guardarRecordatorio();
    })

    $('#btn-cargar-mas').click(function () {
        cargarListaRecordatorios();
    })
})

function guardarRecordatorio() {
    var params = $('#form-nuevo-recordatorio').serialize();
    var url = $('#general_url').val()+"/recordatorio/crear";
    abrirBlockUiCargando();
    
    $.post(url,params)
        .done(function (data) {
            if(data.success) {
                $('#form-nuevo-recordatorio')[0].reset();
                abrirAlerta('alertas-recordatorios', 'success', ['Recordatorio registrado con éxito.'], null, 'body');
                $('#modal-lista-recordatorios').find('#lista-recordatorios').prepend(data.html);
                recordatorios_cargados.push(data.id);
            }
            cerrarBlockUiCargando();
        })
        .fail(function (jqXHR,state,error) {
            abrirAlerta('alertas-recordatorios','danger',JSON.parse(jqXHR.responseText),null,'body');
            cerrarBlockUiCargando();
        })
}

function cargarListaRecordatorios(){
    if(cargar_mas) {
        var params = {_token: $('#general_token').val(), recordatorios_cargados: recordatorios_cargados};
        var url = $('#general_url').val() + "/recordatorio/lista";
        var elemento_load = $('#modal-lista-recordatorios').find('#lista-recordatorios');

        abrirBlockUiElemento(elemento_load);
        $('#btn-cargar-mas').addClass('disabled');

        $.post(url, params)
            .done(function (data) {
                recordatorios_cargados = data.recordatorios_cargados;
                cargar_mas = data.permitir_cargar_mas;
                $(elemento_load).append(data.html);
                cerrarBlockUiElemento(elemento_load);
                $('#btn-cargar-mas').removeClass('disabled');
            })
            .fail(function (jqXHR, state, error) {
                cerrarBlockUiElemento(elemento_load);
            })
    }
}