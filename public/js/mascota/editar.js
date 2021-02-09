var razas_perros = [];
var razas_gatos = [];
var raza = null;
var mascota_seleccionada = null;
$(function () {
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
            }
        });
    })

    $('#guardar-mascota').click(function () {
        guardar();
    })

    $('.btn-navegacion-datos-mascota').click(function () {
        var id_nuevo_elemento = $(this).data('element');
        if($('#'+id_nuevo_elemento).length){
            $('.contenedor-datos-mascota').addClass('hide');
            $('#'+id_nuevo_elemento).removeClass('hide')
        }else {
            alert('no encontrado')
        }
    })

    $('body').on('change','.consulta-datos-afiliacion',function () {
        //datosAproximadosAfiliacion();
    })

    $('body').on('click','.btn-validar',function () {
        mascota_seleccionada = $(this).data('mascota');
        $('#modal-validar').modal('show');
    })

    $('#btn-validar-ok').click(function () {
        if(mascota_seleccionada){
            var params = {_token:$('#general_token').val(),mascota:mascota_seleccionada};
            var url = $('#general_url').val()+'/mascota/validar';
            abrirBlockUiCargando('Validando mascota ');
            $.post(url,params)
                .done(function () {
                    abrirAlerta('alertas-editar-mascota','success',['Mascota validada con éxito'],null,'body');
                    $('#modal-validar').modal('hide');
                    $('.btn-validar').eq(0).remove();
                    cerrarBlockUiCargando();
                })
                .fail(function (jqXHR,error,state) {
                    abrirAlerta('alertas-editar-mascota','danger',['Ocurrio un error inesperado, recargue la pàgina e intente nuevamente']);
                    $('#modal-validar').modal('hide');
                    cerrarBlockUiCargando();
                })
            mascota_seleccionada = null;
        }
    })

    $('body').on('click','.btn-validar-informacion',function () {
        mascota_seleccionada = $(this).data('mascota');
        $('#modal-validar-informacion').modal('show');
    })

    $('#btn-validar-informacion-ok').click(function () {
        if(mascota_seleccionada){
            var params = {_token:$('#general_token').val(),mascota:mascota_seleccionada};
            var url = $('#general_url').val()+'/mascota/validar-informacion';
            abrirBlockUiCargando('Validando información ');
            $.post(url,params)
                .done(function () {
                    abrirAlerta('alertas-editar-mascota','success',['Información de la mascota validada con éxito'],null,'body');
                    $('#modal-validar-informacion').modal('hide');
                    $('.btn-validar-informacion').eq(0).remove();
                    cerrarBlockUiCargando();
                })
                .fail(function (jqXHR,error,state) {
                    abrirAlerta('alertas-editar-mascota','danger',['Ocurrio un error inesperado, recargue la pàgina e intente nuevamente']);
                    $('#modal-validar-informacion').modal('hide');
                    cerrarBlockUiCargando();
                })
            mascota_seleccionada = null;
        }
    })
})

function guardar(){
    var params = new FormData(document.getElementById('form-editar-mascota'));
    var url = $('#general_url').val()+'/mascota/editar';

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
                $('html, body').stop().scrollTop(0);
                window.location.reload();
                //$('#form-crear-mascota')[0].reset();
                //abrirAlerta("alertas-editar-mascota","success",['La mascota ha sido editada con éxito'],null,'body');
            }
        },
        error: function (jqXHR, error, state) {
            cerrarBlockUiCargando();
            abrirAlerta("alertas-editar-mascota","danger",JSON.parse(jqXHR.responseText),null,'body');
        }
    });
}

function cargarFormVacunas(tipo_mascota) {
    var url = $('#general_url').val()+'/mascota/form-vacunas';
    var params = {_token:$('#general_token').val(),tipo_mascota:tipo_mascota,fecha_nacimiento:$('#fecha_nacimiento').val(),'mascota':$('#mascota').val()};
    $.post(url,params,function (data) {
        $('#contenedor-vacunas').html(data);
        inicializarComplementos();
    })
}