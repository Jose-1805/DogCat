$(function () {
    $('#guardar-nueva-cuenta').click(function () {
        guardarNuevaCuenta();
    })

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

function guardarNuevaCuenta() {
    var params = new FormData(document.getElementById('form-nueva-cuenta'));
    var url = $('#general_url').val()+'/store-nueva-cuenta';
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
            abrirAlerta("alertas-nueva-cuenta","danger",JSON.parse(jqXHR.responseText),null,'body');
        }
    });
}