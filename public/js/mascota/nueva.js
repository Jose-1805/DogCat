var razas_perros = [];
var razas_gatos = [];
var raza = null;
$(function () {
    $('#veterinaria').change(function () {
        veterinaria = $(this).val();

        var params = {_token:$('#general_token').val(),veterinaria:veterinaria};
        var url = $('#general_url').val()+'/tareas-sistema/select-afiliados'
        abrirBlockUiElemento($('#contenedor-select-afiliados'),'Cargando');
        $.post(url,params,function (data) {
            $('#contenedor-select-afiliados').html(data);
            cerrarBlockUiElemento($('#contenedor-select-afiliados'));
        })
    })
    $('#fecha_nacimiento').focusin(function () {
        var tipo_mascota = $('#tipo_mascota').val();
        if(tipo_mascota){
            cargarFormVacunas(tipo_mascota);
            //datosAproximadosAfiliacion();
        }
    });

    $('#tipo_mascota').change(function () {
        $('#raza_').prop('disabled',false);
        var tipo_mascota = $(this).children('option[value="'+$(this).val()+'"]').text();
        var tipo_mascota_id = $(this).val();
        cargarFormVacunas(tipo_mascota_id);
        var opciones = [];
        if(tipo_mascota == 'Perro')opciones = razas_perros;
        else if(tipo_mascota == 'Gato')opciones = razas_gatos;

        raza = null;
        $('#raza_seleccionada').text("");
        $("#raza_").val("");
        $('#raza').val("");

        $('#raza_').autocomplete({
            lookup: opciones,
            onSelect: function (suggestion) {
                raza = suggestion.data;
                $('#raza_seleccionada').text("("+suggestion.value+")");
                $('#raza').val(raza);
                //datosAproximadosAfiliacion();
            },
            lookupFilter: function (suggestion, query, queryLowerCase) {
                var lowerCaseNoAccent = quitarTildes(suggestion.value).toLowerCase();
                var queryLowerCaseNoAccent = quitarTildes(queryLowerCase);
                return lowerCaseNoAccent.indexOf(queryLowerCaseNoAccent) > -1;
            }
        });
    })

    $('.guardar-mascota').click(function () {
        guardar($(this));
    })

    $('body').on('change','.consulta-datos-afiliacion',function () {
        //datosAproximadosAfiliacion();
    })
})

function guardar(boton){
    //le asignamos el valor '2' al input de asistid para manejar el msj en el controlador
    if($('#asistido').length == 1 && !$(boton).hasClass('btn-guardar-seguir-agregando')){
        $('#asistido').val('2');
    }

    var params = new FormData(document.getElementById('form-crear-mascota'));
    var url = $('#general_url').val()+'/mascota/crear';

    abrirBlockUiCargando('Guardando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            cerrarBlockUiCargando();
            if(data.success){
                if($('#asistido').length == 1 && !$(boton).hasClass('btn-guardar-seguir-agregando')){
                    window.location.href = $('#general_url').val()+'/afiliacion/nueva/ignorar/'+data.usuario;
                }else {
                    $('#form-crear-mascota')[0].reset();
                    abrirAlerta("alertas-nueva-mascota", "success", ['La mascota ha sido registrada con éxito'], null, 'body');
                }
            }
        },
        error: function (jqXHR, error, state) {
            cerrarBlockUiCargando();
            abrirAlerta("alertas-nueva-mascota","danger",JSON.parse(jqXHR.responseText),null,'body');
        }
    });
}

function cargarFormVacunas(tipo_mascota) {
    var url = $('#general_url').val()+'/mascota/form-vacunas';
    var params = {_token:$('#general_token').val(),tipo_mascota:tipo_mascota,fecha_nacimiento:$('#fecha_nacimiento').val()};
    $.post(url,params,function (data) {
        $('#contenedor-vacunas').html(data);
        inicializarComplementos();
    })
}

function datosAproximadosAfiliacion(){

    if($('#tipo_mascota').val() && raza && $('#tipo_afiliacion').val() && $('#fecha_nacimiento').val() && $('.check-servicios:checked').length > 0){
        var elemento_load = $('#datos-aproximados-afiliacion');
        abrirBlockUiElemento(elemento_load,'Calculando datos');
        var params = $('#form-crear-mascota').serialize()+'&raza='+raza;
        var url = $('#general_url').val()+'/mascota/datos-aproximados-afiliacion';
        $.post(url,params,function (data) {
            if(data.success) {
                $('#valor_afiliacion').text(data.valor);
                $('#porcentaje_funeraria').text(data.porcentaje_funeraria);

                if(data.error){
                    $('#error_datos_afiliacion').text(data.error);
                    $('#error_datos_afiliacion').removeClass('hide');
                }else{

                    $('#error_datos_afiliacion').addClass('hide');
                }
            }
            cerrarBlockUiElemento(elemento_load);
        })
    }else{
        $('#valor_afiliacion').text('0');
        $('#porcentaje_funeraria').text('0');
    }
}