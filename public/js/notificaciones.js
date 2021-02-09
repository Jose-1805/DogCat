var notificaciones_cargadas = [];
var cargar_mas_notificaciones = true;
var primera_carga_notificaciones = false;

$(function () {
    $('body').on('click','.btn_cerrar_notificacion_show',function () {
        var elemento_notificacion = $(this).parent().parent();
        eliminarNotificacionShow(elemento_notificacion);
    });
    
    $('#btn-notificaciones').click(function () {
        if(!primera_carga_notificaciones) {
            cargarListaNotificaciones();
            primera_carga_notificaciones = true;
        }
        $('#modal-lista-notificaciones').modal('show');
    });

    $('#btn-cargar-mas-notificaciones').click(function () {
        cargarListaNotificaciones();
    })
})

function eliminarNotificacionShow(elemento_notificacion) {
    $(elemento_notificacion).css({
        opacity:'0'
    })
    setTimeout(function () {
        $(elemento_notificacion).remove();
    },500)
}

//abrirNotificacionShow('Prueba','Mensaje de prueba de notificaciones para compactar con firebase','/imagenes/gato.jpg','importancia_media',null,5,'notificacion);
function abrirNotificacionShow(titulo,mensaje,icono,importancia,url,duracion,tipo) {
    var html = '<div class="notificacion_show '+importancia+' z-depth-4">'
        +'<div class="notificacion_show_header">'
            +'<p class="white-text">'+titulo+'</p>'
            +'<a href="#!" class="btn_cerrar_notificacion_show"><i class="fas fa-times-circle"></i></a>'
        +'</div>'
        +'<div class="notificacion_show_body">'
            +'<div class="notificacion_show_icono">';

    var clases = '';
    if(tipo == 'recordatorio') {
        clases = 'icono_alarma_animado';
        icono = '/imagenes/sistema/reloj_alarma.png';
    }
    if(icono)
        html += '<img src="'+icono+'" class="'+clases+'">';
    else
        html += '<img src="/imagenes/sistema/dogcat.png" class="'+clases+'">';

    html += '</div>'
        +'<div class="notificacion_show_mensaje">'
        +'<p class="font-small">'+mensaje+'</p>'
        +'</div>';

    if(url){
        html += '<div class="text-right">'
                    +'<a href="'+url+'" class="btn btn-outline-default btn_outline_'+importancia+' btn-sm">Ir</a>'
                '</div>';
    }

        html += '</div>'
        +'</div>';

    $('#contenedor_notificaciones_show').append(html);
    var elemento = $('#contenedor_notificaciones_show .notificacion_show').last();

    if(duracion){
        setTimeout(function () {
            eliminarNotificacionShow(elemento);
        },duracion*1000);
    }
}

function cargarListaNotificaciones(){
    if(cargar_mas_notificaciones) {
        var params = {_token: $('#general_token').val(), notificaciones_cargadas: notificaciones_cargadas};
        var url = $('#general_url').val() + "/notificacion/lista";
        var elemento_load = $('#modal-lista-notificaciones').find('#lista-notificaciones');

        abrirBlockUiElemento(elemento_load);
        $('#btn-cargar-mas').addClass('disabled');

        $.post(url, params)
            .done(function (data) {
                notificaciones_cargadas = data.notificaciones_cargadas;
                cargar_mas_notificaciones = data.permitir_cargar_mas;
                $(elemento_load).append(data.html);
                cerrarBlockUiElemento(elemento_load);
                $('#btn-cargar-mas').removeClass('disabled');
            })
            .fail(function (jqXHR, state, error) {
                cerrarBlockUiElemento(elemento_load);
            })
    }
}