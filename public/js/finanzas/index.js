$(function () {
    $('.btn-cargar-contenido-finanzas').click(function () {
        if($(this).data('contenido')){
            cargarContenido($(this).data('contenido'));
        }
    })
})

function cargarContenido(contenido) {
    $('.contenido-finanzas').addClass('d-none');
    $('#contenedor-'+contenido).removeClass('d-none');
}