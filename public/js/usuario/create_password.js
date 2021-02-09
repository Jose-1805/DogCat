$(function () {
    $('#btn-create-password').click(function () {
        createPassword();
    });
})


function createPassword(){

    var params = $("#form-create-password").serialize();
    var url = $("#general_url").val()+"/store-password";

    abrirBlockUiCargando('Guardando ');

    $.post(url,params)
        .done(function (data) {
            if(data.success) {
                window.location.reload();
            }
        })
        .fail(function (jqXHR,state,error) {
            abrirAlerta("alertas-create-password","danger",JSON.parse(jqXHR.responseText),null,'body');
            cerrarBlockUiCargando();
        })
}