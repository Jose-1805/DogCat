var servicio_seleccionado = null;
var usuario_seleccionada = null;
$(function () {
    cargarServicios();
    cargarUsuarios();

    $('body').on('click','.btn-usuarios-servicio',function () {
        servicio_seleccionado = $(this).data('servicio');
        cargarUsuarios();
    })

    $('body').on('click','.cerrar-usuarios',function () {
        servicio_seleccionado = null;
        cargarUsuarios();
    })

    $('body').on('change','.check-usuario',function () {
        actualizarRelacion($(this));

    })
})

/**
 * Actualiza la relacion entre el servicio (seleccionado en variable servicio_seleccionado)
 * y la usuario perteneciente al checkbox seleccionado.
 *
 * La información se actualiza de acuerdo al estado del checkbox seleccionado
 *
 * @param checkbox_element
 */
function actualizarRelacion(checkbox_element) {
    //accion a realizar con la usuario en el módulo
    var accion = "eliminar";
    //se esta checkeando una opción
    if($(checkbox_element).prop("checked")){
        accion = "agregar";
    }

    var elemento_contenedor = $("#contenedor-usuarios");
    abrirBlockUiElemento(elemento_contenedor);

    var params = {_token:$('#general_token').val(),servicio:servicio_seleccionado,usuario:$(checkbox_element).data('usuario'),accion:accion};
    var url = $('#general_url').val()+'/servicio/actualizar-relacion';
    
    $.post(url,params,function (data) {
        cerrarBlockUiElemento(elemento_contenedor);
    })
}

function cargarServicios() {
    var elemento = $("#contenedor-servicios");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/servicio/vista-servicios';
    var params = {_token:$('#general_token').val()};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}

function cargarUsuarios() {
    var elemento = $("#contenedor-usuarios");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/servicio/vista-usuarios';
    var params = {_token:$('#general_token').val(),servicio:servicio_seleccionado};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}