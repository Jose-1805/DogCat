/**
 * Created by jose1805 on 30/05/18.
 */
$(function () {
    $('#check_aprobar_terminos').change(function () {
        if($(this).prop('checked')){
            $('#btn-terminos-condiciones').removeClass('disabled');
        }else{
            $('#btn-terminos-condiciones').addClass('disabled');
        }
    })

    $('#btn-terminos-condiciones').click(function () {
        if($('#check_aprobar_terminos:checked').length){
            abrirBlockUiCargando('Aprobando términos y condiciones');
            var params = {_token:$('#general_token').val()};
            var url = $('#general_url').val()+'/aprobar-terminos-condiciones';
            $.post(url,params)
                .done(function (data) {
                    window.location.reload();
                })
        }else {
            alert('Seleccione la casilla de aprobación de términos y condiciones');
        }
    })
})