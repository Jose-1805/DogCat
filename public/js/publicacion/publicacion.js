var publicaciones_cargadas = [];
var publicaciones_creadas = [];
var continuar_scroll = true;
var cargando_publicaciones = false;
$(function () {
    $('#btn-nueva-imagen-publicacion').click(function () {
        nuevaImagen();
        $(this).focusout();
    })

    $('#btn-guardar-nueva-publicacion').click(function () {
        guardarNuevaPublicacion();
    })

    $('body').on('click','.quitar-imagen-publicacion',function () {
        $(this).parent().remove();
    })

    $('body').on('click','.enviar-like',function () {
        likePublicacion($(this));
    })
    
    $('body').on('keyup','.comentario',function (e) {
        if(e.keyCode == 13){
            enviarComentario($(this));
        }
    })

    $('body').on('click','.enviar-comentario',function () {
        var elemento = $(this).parent().parent().children('.comentario').eq(0);
        enviarComentario(elemento);
    })

    $('body').on('click','.contador-comentarios',function () {
        var elemento = $(this).parent().parent().children('.comentarios').eq(0);
        $(elemento).toggleClass('d-none');
    })

    $(window).scroll(function () {
        if(continuar_scroll) {
            var altura = $('body').innerHeight();
            var posicion_scroll = $(window).scrollTop() + $(window).innerHeight()+$('#pie-pagina').innerHeight();
            //console.log(altura+'  '+posicion_scroll);
            if (altura - posicion_scroll <= 1) {
                $(window).scrollTop($(window).scrollTop() - 50);
                cargarPublicacionesAnteriores()
            }
        }
    })

    setInterval(function () {
        actualizarPublicaciones();
    },5000);
})

function nuevaImagen() {
    var html = '<div class="form-group">'+
        '<a href="#!" class="left margin-right-10 quitar-imagen-publicacion" data-toggle="tooltip" data-placement="right" title="Quitar imagen"><i class="fa fa-times-circle red-text text-darken-2 font-medium"></i></a>'+
        '<input type="file" name="imagen[]">'+
        '</div>';
    $('#imagenes-publicacion').append(html);
    inicializarComplementos();
}

function guardarNuevaPublicacion() {
    var params = new FormData(document.getElementById('form-nueva-publicacion'));
    var url = $("#general_url").val()+"/publicacion/nueva";

    abrirBlockUiCargando('Guardando ');
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
                $('#modal-nueva-publicacion').modal('hide');
                $('#form-nueva-publicacion')[0].reset();
                var html = '<div class="form-group">'+
                    '<label for="imagen_principal">Imagen principal</label>'+
                    '<input type="file" name="imagen_principal" id="imagen_principal">'+
                    '</div>';
                $('#imagenes-publicacion').html(html);
                publicaciones_creadas.push(data.publicacion);
                $('#publicaciones').prepend(data.vista);
            }
        },
        error: function (jqXHR, error, state) {
            cerrarBlockUiCargando();
            abrirAlerta("alertas-nueva-publicacion","danger",JSON.parse(jqXHR.responseText),null,"modal-nueva-publicacion");
        }
    });
}

function likePublicacion(elemento) {
    var numero = $(elemento).data('numero');
    var publicacion = $(elemento).data('publicacion');
    numero++
    $(elemento).parent().children('.numero_likes').html(numero);
    $(elemento).removeClass('enviar-like teal-text text-lighten-1 cursor_pointer');
    $(elemento).addClass('white-text teal lighten-1');
    $(elemento).css({
        padding: '3px',
        borderRadius: '30px',
    })

    var url = $('#general_url').val()+'/publicacion/like-publicacion';
    var params = {_token:$('#general_token').val(),publicacion:publicacion};

    $.post(url,params)
        .fail(function (jqXHR,state,error) {
            alert('Lo sentimos, ha ocurrido un error!');
            window.location.reload();
        })
}

function enviarComentario(elemento) {
    if($(elemento).val() != ''){
        var publicacion = $(elemento).data('publicacion');

        var url = $('#general_url').val()+'/publicacion/comentario-publicacion';
        var params = {_token:$('#general_token').val(),publicacion:publicacion,comentario:$(elemento).val()};

        $(elemento).val('');
        $.post(url,params)
            .done(function (data) {
                actualizarPublicacion(publicacion);
            })
            .fail(function (jqXHR,state,error) {
                alert('Lo sentimos, ha ocurrido un error!');
                window.location.reload();
            })
    }
}

function cargarPublicacionesAnteriores() {
    if(cargando_publicaciones == false) {
        cargando_publicaciones = true;
        var contenedor = $('#publicaciones');

        var load = $('#load-publicaciones');
        $(load).removeClass('hide');

        var url = $('#general_url').val() + '/publicacion/anteriores-publicaciones';
        var params = {_token: $('#general_token').val(), excepciones: publicaciones_cargadas, limit: 5};

        abrirBlockUiElemento(load, 'Cargando ', true);

        $.post(url, params)
            .done(function (data) {
                $(load).addClass('hide');
                cerrarBlockUiElemento(load);

                if (data.success) {
                    publicaciones_cargadas = data.excepciones;
                    $(contenedor).append(data.vista);
                    continuar_scroll = data.continuar_scroll;
                }
                cargando_publicaciones = false;
            })
    }
}

function actualizarPublicaciones(){
    var inicio_pantalla = $(document).scrollTop();
    var fin_pantalla = inicio_pantalla + window.innerHeight;

    $('.publicacion-item').each(function (i,el) {
        //console.log('Elemento: '+$(el).data('publicacion'));
        var posicion = $(el).offset().top;
        var altura = $(el).innerHeight();
        //console.log('Posición: '+posicion+' Altura: '+$(el).innerHeight());
        if(
            (posicion >= inicio_pantalla && posicion <= fin_pantalla) //la parte inicial de la pub. esta dentro de la pantalla
            || (posicion + altura >= inicio_pantalla && posicion + altura <= fin_pantalla) //la parte final de la pub. esta dentro de la pantalla
            || (posicion <= inicio_pantalla && posicion + altura >= fin_pantalla) //la publicación es más grande que la pantalla
                                                                                    //pero esta visible una parte
        ){
            //console.log('Visible');
            var elemento_visible = $(el).data('publicacion');
            actualizarPublicacion(elemento_visible);
        }
        //console.log('---------------------------------');
    })
    //console.log('************************************');
}

function actualizarPublicacion(publicacion) {
    var url = $('#general_url').val()+'/publicacion/data';
    var last_comment = $('#p-'+publicacion).find('.last_comment').val();

    //alert(last_comment);
    $('#p-'+publicacion).find('.last_comment').remove();
    params = {_token: $('#general_token').val(), publicacion: publicacion, last_comment: last_comment};

    $.post(url, params)
        .done(function (data) {
            $('#p-' + publicacion + ' .contenedor-likes').html(data.likes);
            $('#p-' + publicacion + ' .contenedor-comentarios .info-comentarios .comentarios .lista-comentarios .contenedor-comentarios').append(data.comentarios);
            $('#p-' + publicacion + ' .contenedor-comentarios .info-comentarios div .contador-comentarios span').html(data.cantidad_comentarios);
        });
}