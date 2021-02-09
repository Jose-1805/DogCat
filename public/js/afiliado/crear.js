$(function () {
    $('input[name="tipo_usuario"]').change(function () {
        $('#datos-afiliado').addClass('hide');
        $('#datos-personal-dogcat').addClass('hide');
        $("#datos-"+$(this).val()).removeClass('hide');
    })

    $('#btn-guardar-usuario').click(function () {
        guardarUsuario();
    });

    $('#select-pais').change(function () {
        var pais = $(this).val();
        if(pais != ''){
            abrirBlockUiElemento($('#contenedor-select-departamentos'),'Cargando');
            var params = {
                _token:$('#general_token').val(),
                pais:pais,
                name:'select-departamento'
            }
            var url = $('#general_url').val()+'/tareas-sistema/select-departamentos';
            $.post(url,params)
                .done(function (data) {
                    $('#contenedor-select-departamentos').children('#select-departamento').remove();
                    $('#contenedor-select-departamentos').append(data);
                    $('#contenedor-select-departamentos').children('#select-departamento').eq(0).attr('id','select-departamento');
                    $('#contenedor-select-departamentos').children('#select-departamento').eq(0).attr('name','departamento');
                    cerrarBlockUiElemento($('#contenedor-select-departamentos'));
                })
        }
    })

    $('body').on('change','#select-departamento',function () {
        var departamento = $(this).val();
        if(departamento != ''){
            abrirBlockUiElemento($('#contenedor-select-ciudades'),'Cargando');
            var params = {
                _token:$('#general_token').val(),
                departamento:departamento,
                name:'ciudad'
            }
            var url = $('#general_url').val()+'/tareas-sistema/select-ciudades';
            $.post(url,params)
                .done(function (data) {
                    $('#contenedor-select-ciudades').children('#ciudad').remove();
                    $('#contenedor-select-ciudades').append(data);
                    $('#contenedor-select-ciudades').children('#ciudad').eq(0).attr('id','ciudad');
                    $('#contenedor-select-ciudades').children('#ciudad').eq(0).attr('name','ciudad');
                    cerrarBlockUiElemento($('#contenedor-select-ciudades'));
                })
        }
    })

    $('#calle').keyup(function () {
        $('#carrera').val('');
        $('#transversal').val('');
    })

    $('#carrera').keyup(function () {
        $('#calle').val('');
        $('#transversal').val('');
    })

    $('#transversal').keyup(function () {
        $('#carrera').val('');
        $('#calle').val('');
    })
})

function guardarUsuario(){
    var params = new FormData(document.getElementById('form-usuario'));
    var url = $("#general_url").val()+"/afiliado/guardar";

    abrirBlockUiCargando('Guardando ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            if($('#asistido').length == 1){
                window.location.href = $('#general_url').val()+'/mascota/nueva/'+data.usuario+'/true';
            }else {
                $("#form-usuario")[0].reset();
                abrirAlerta("alertas-usuario", "success", ['Afiliado creado con éxito'], null, 'body');
                cerrarBlockUiCargando();
            }
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-usuario","danger",JSON.parse(jqXHR.responseText),null,'body');
            cerrarBlockUiCargando();
        }
    });
}
