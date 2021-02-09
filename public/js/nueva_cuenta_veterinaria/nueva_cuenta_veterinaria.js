$(function () {
    $('#guardar-nueva-cuenta-veterinaria').click(function () {
        guardarNuevaCuenta();
    })

    $('#select-pais-veterinaria').change(function () {
        var pais = $(this).val();
        if(pais != ''){
            abrirBlockUiElemento($('#contenedor-select-departamentos-veterinaria'),'Cargando');
            var params = {
                _token:$('#general_token').val(),
                pais:pais,
                name:'select-departamento'
            }
            var url = $('#general_url').val()+'/tareas-sistema/select-departamentos';
            $.post(url,params)
                .done(function (data) {
                    $('#contenedor-select-departamentos-veterinaria').children('#select-departamento-veterinaria').remove();
                    $('#contenedor-select-departamentos-veterinaria').append(data);
                    $('#contenedor-select-departamentos-veterinaria').children('#select-departamento').eq(0).attr('id','select-departamento-veterinaria');
                    $('#contenedor-select-departamentos-veterinaria').children('#select-departamento-veterinaria').eq(0).attr('name','departamento_veterinaria');
                    cerrarBlockUiElemento($('#contenedor-select-departamentos-veterinaria'));
                })
        }
    })

    $('body').on('change','#select-departamento-veterinaria',function () {
        var departamento = $(this).val();
        if(departamento != ''){
            abrirBlockUiElemento($('#contenedor-select-ciudades-veterinaria'),'Cargando');
            var params = {
                _token:$('#general_token').val(),
                departamento:departamento,
                name:'ciudad'
            }
            var url = $('#general_url').val()+'/tareas-sistema/select-ciudades';
            $.post(url,params)
                .done(function (data) {
                    $('#contenedor-select-ciudades-veterinaria').children('#ciudad-veterinaria').remove();
                    $('#contenedor-select-ciudades-veterinaria').append(data);
                    $('#contenedor-select-ciudades-veterinaria').children('#ciudad').eq(0).attr('id','ciudad-veterinaria');
                    $('#contenedor-select-ciudades-veterinaria').children('#ciudad-veterinaria').eq(0).attr('name','ciudad_veterinaria');
                    cerrarBlockUiElemento($('#contenedor-select-ciudades-veterinaria'));
                })
        }
    })

    $('#select-pais-administrador').change(function () {
        var pais = $(this).val();
        if(pais != ''){
            abrirBlockUiElemento($('#contenedor-select-departamentos-administrador'),'Cargando');
            var params = {
                _token:$('#general_token').val(),
                pais:pais,
                name:'select-departamento'
            }
            var url = $('#general_url').val()+'/tareas-sistema/select-departamentos';
            $.post(url,params)
                .done(function (data) {
                    $('#contenedor-select-departamentos-administrador').children('#select-departamento-administrador').remove();
                    $('#contenedor-select-departamentos-administrador').append(data);
                    $('#contenedor-select-departamentos-administrador').children('#select-departamento').eq(0).attr('id','select-departamento-administrador');
                    $('#contenedor-select-departamentos-administrador').children('#select-departamento-administrador').eq(0).attr('name','departamento_administrador');
                    cerrarBlockUiElemento($('#contenedor-select-departamentos-administrador'));
                })
        }
    })

    $('body').on('change','#select-departamento-administrador',function () {
        var departamento = $(this).val();
        if(departamento != ''){
            abrirBlockUiElemento($('#contenedor-select-ciudades-administrador'),'Cargando');
            var params = {
                _token:$('#general_token').val(),
                departamento:departamento,
                name:'ciudad'
            }
            var url = $('#general_url').val()+'/tareas-sistema/select-ciudades';
            $.post(url,params)
                .done(function (data) {
                    $('#contenedor-select-ciudades-administrador').children('#ciudad-administrador').remove();
                    $('#contenedor-select-ciudades-administrador').append(data);
                    $('#contenedor-select-ciudades-administrador').children('#ciudad').eq(0).attr('id','ciudad-administrador');
                    $('#contenedor-select-ciudades-administrador').children('#ciudad-administrador').eq(0).attr('name','ciudad_administrador');
                    cerrarBlockUiElemento($('#contenedor-select-ciudades-administrador'));
                })
        }
    })

    $('#calle-veterinaria').keyup(function () {
        $('#carrera-veterinaria').val('');
        $('#transversal-veterinaria').val('');
    })

    $('#carrera-veterinaria').keyup(function () {
        $('#calle-veterinaria').val('');
        $('#transversal-veterinaria').val('');
    })

    $('#transversal-veterinaria').keyup(function () {
        $('#carrera-veterinaria').val('');
        $('#calle-veterinaria').val('');
    })

    $('#calle-administrador').keyup(function () {
        $('#carrera-administrador').val('');
        $('#transversal-administrador').val('');
    })

    $('#carrera-administrador').keyup(function () {
        $('#calle-administrador').val('');
        $('#transversal-administrador').val('');
    })

    $('#transversal-administrador').keyup(function () {
        $('#carrera-administrador').val('');
        $('#calle-administrador').val('');
    })

})

function guardarNuevaCuenta() {
    var params = new FormData(document.getElementById('form-nueva-cuenta-veterinaria'));
    var url = $('#general_url').val()+'/store-nueva-cuenta-veterinaria';
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
                window.location.reload(true);
            }
        },
        error: function (jqXHR, error, state) {
            cerrarBlockUiCargando();
            abrirAlerta("alertas-nueva-cuenta-veterinaria","danger",JSON.parse(jqXHR.responseText),null,'body');
        }
    });
}