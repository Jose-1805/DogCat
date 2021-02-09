var idioma_tablas = {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    };

$(function () {
    $(window).scroll(function () {
        if(($("#welcome").height()- $(window).scrollTop()) > 0){
            $("#menu").addClass("d-none");
        }else{
            $("#menu").removeClass("d-none");
        }
    })

    new WOW().init();

    $('#contenido-pagina').css({
        minHeight:(window.innerHeight-120-$('.pie-pagina').eq(0).height())+'px'
    })
    $(window).resize(function () {
        $('#contenido-pagina').css({
            minHeight:(window.innerHeight-120-$('.pie-pagina').eq(0).height())+'px'
        })

        redimensionMenuFixed();
    })
    redimensionMenuFixed();


    // Instantiate the Bootstrap carousel
    $('.multi-item-carousel').carousel({
        interval: 3000
    });

// for every slide in carousel, copy the next slide's item in the slide.
// Do the same for the next, next item.
    $('.multi-item-carousel .item').each(function(){
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        if (next.next().length>0) {
            next.next().children(':first-child').clone().appendTo($(this));
        } else {
            $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
        }
    });

    //evita que se cierren las alertas como lo hace bootstrap (quitando la clase de la alert) y oculta con la clase d-none la alerta
    $('body').on('click','.alert .close',function () {
        $(this).parent().addClass('d-none');
    })

    //Cuando se presione enter dentro de un formulario se realiza click sobre el elemento que contenga la clase btn-submit
    $("body").on('keyup','form',function (e) {
        if(e.keyCode == 13 && e.target.nodeName != 'TEXTAREA'){
            $(this).find('.btn-submit').click();
        }
    })

    //CLASES PARA INGRESO DE NUMEROS
    iniciarNumerics();

    inicializarComplementos();

    //PARA IMAGENES LIGHTBOX
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            onShown: function() {
                if (window.console) {
                    //return console.log('Checking our the events huh?');
                }
            },
            onNavigate: function(direction, itemIndex) {
                if (window.console) {
                    //return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                }
            }
        });
    });

    //evita que se realice el submit de un form
    $('form.no_submit').submit(function (e) {
        e.preventDefault();
    })

    $(".contenedor-check-imagen input[type='checkbox']").change(function(e){
        if($(this).prop('checked')) {
            $(this).parent().addClass('check');
            $(this).parent().children('img.checked').removeClass('d-none');
            $(this).parent().children('img.unchecked').addClass('d-none');
        }else {
            $(this).parent().removeClass('check');
            $(this).parent().children('img.unchecked').removeClass('d-none');
            $(this).parent().children('img.checked').addClass('d-none');
        }
    });

    $('body').on('keyup','textarea,input',function() {
        var length = $(this).val().length;
        var maxLength = $(this).prop('maxlength');
        if(maxLength) {
            var length = maxLength - length;
            $(this).parent().children('.count-length').html(length);
            $(this).parent().children('.count-length-no-form-control').html(length);
        }
    });

    $('body').on('focusin','textarea,input',function () {
       var element_count = $(this).parent().children('.count-length');
       if($(element_count).length){
           $('.count-length').addClass('d-none');
           $(element_count).removeClass('d-none');
       }
       var element_count = $(this).parent().children('.count-length-no-form-control');
       if($(element_count).length){
           $('.count-length-no-form-control').addClass('d-none');
           $(element_count).removeClass('d-none');
       }
    });

    $('body').on('focusout','textarea,input',function () {
        $('.count-length').addClass('d-none');
        $('.count-length-no-form-control').addClass('d-none');
    });

    $('.count-length').addClass('d-none');
    $('.count-length-no-form-control').addClass('d-none');


    //manejo de navegacion en las vistas toggle render
    $('.btn-navegacion-toggle-render').click(function () {
        var id_nuevo_elemento = $(this).data('element');
        if($('#'+id_nuevo_elemento).length){
            $('.contenedor-toggle-render').addClass('d-none');
            $('#'+id_nuevo_elemento).removeClass('d-none')
        }else {
            alert('no encontrado')
        }
    })

    $('body').on('click','.alert .close', function () {
        $(this).parent().addClass('d-none');
    })

    //utilizado para seleccion de imagenes
    //un ejemplo se encuentra en la creación de una afiliación nueva
    $('body').on('click','.item-select-img',function () {
        var selected = false;
        if(!$(this).hasClass('teal')){
            selected = true;
        }
        $(this).find('.mask').eq(0).toggleClass('pattern-6');
        $(this).toggleClass('teal');
        $(this).toggleClass('lighten-4');

        //variable para elemento que contiene a todos los items
        var element_select = $(this);
        var continuar = true;
        while(continuar){
            element_select = $(element_select).parent();
            if($(element_select).hasClass('content-select-img')){
                continuar = false;
            }
        }
        $(element_select).trigger('changeStateItemSelectImg',[$(this),selected,$(this).data('value')]);
    })

    //cuando se cierra un modal
    $('.modal').on('hide.bs.modal', function () {
        $('.modal-backdrop.fade.in').remove();
    })

    //ajusta la posicion del menu de usuario
    var ancho_menu = $('#dropdown-menu-user').parent().children('.dropdown-toggle').innerWidth();
    $('#dropdown-menu-user').css({
       marginLeft:((ancho_menu/2)-110)+'px',
    });

    $('#btn-cambiar-contrasena').click(function () {
        var params = $('#form-cambiar-contrasena').serialize();
        var url = $('#general_url').val()+'/configuracion/cambio-password';
        abrirBlockUiCargando('Cambiando contraseña ');
        $.post(url,params)
            .done(function (data) {
                $('#form-cambiar-contrasena')[0].reset();
                $('#modal-cambiar-contrasena').modal('hide');
                cerrarBlockUiCargando();
                alert('Contraseña cambiada con exito.');
            })
    })

    $('#btn-actualizar-sistema').click(function () {
        actualizar();
    })
    
    $('.btn-esconter-menu-fixed').click(function () {
        if($('#contenedor-global-contenido').hasClass('d-none')){
            $('#contenedor-global-contenido').removeClass('d-none');
            $('#contenedor-global-menu-fixed').addClass('d-none d-md-block');
            $('.btn-mostrar-menu-fixed').removeClass('d-none');
            redimensionMenuFixed();
        }else {
            $('#contenedor-global-menu-fixed').removeClass('d-md-block');

            $('#contenedor-global-contenido').removeClass('col-md-8 col-lg-9 col-xl-10');
            $('#contenedor-global-contenido').addClass('col-md-12 col-lg-12 col-xl-12');

            $('.btn-mostrar-menu-fixed').removeClass('d-md-none');
        }
    })

    $('.btn-mostrar-menu-fixed').click(function () {
        //esta cerrado por estar en pantalla pequea
        if($('#contenedor-global-menu-fixed').hasClass('d-none d-md-block')){
            $('#contenedor-global-menu-fixed').removeClass('d-none d-md-block');
            $('#contenedor-global-contenido').addClass('d-none');
            $('.btn-mostrar-menu-fixed').addClass('d-none');
        }else{
            $('#contenedor-global-menu-fixed').removeClass('d-none');
            $('#contenedor-global-menu-fixed').addClass('d-none d-md-block');

            $('#contenedor-global-contenido').removeClass('col-md-12 col-lg-12 col-xl-12');
            $('#contenedor-global-contenido').addClass('col-md-8 col-lg-9 col-xl-10');

            $('.btn-mostrar-menu-fixed').addClass('d-md-none');
        }

        redimensionMenuFixed();
    })
})

/**
 * Funcion para mostrar las alertas del sistema
 * @param id_contenedor => contenedor de las alertas
 * @param tipo => info - success - warning - danger
 * @param data => array con la información
 * @param duracion => duracion en segundos
 * @param id_contenedor_scroll => id del contenedor que posee el scroll que debe quedar en top = 0
 */
function abrirAlerta(id_contenedor,tipo, data, duracion = null,id_contenedor_scroll = false){
    var html = "";
    $.each(data, function(key,value){
        html += "• "+value+"<br/>";
        console.log(key);
        console.log(value);
    });
    $("#"+id_contenedor+" .alert").addClass("d-none");
    $("#"+id_contenedor+" .alert-"+tipo+" .mensaje").html(html);
    $("#"+id_contenedor+" .alert-"+tipo).removeClass("d-none");

    if(duracion != null && $.isNumeric(duracion)){
        setTimeout(function () {
            $("#"+id_contenedor+" .alert-"+tipo).addClass("d-none");
        },(duracion*1000));
    }

    if(id_contenedor_scroll != false) {
        //$("#" + id_contenedor_scroll).stop().animate({scrollTop: 0}, '5000', 'swing');
        //$("#" + id_contenedor_scroll).scrollTop(0);
        //$(window).scrollTop(0);
        $('html, body').stop().animate({scrollTop:0}, 500, 'swing');
    }
}

/**
 * Abre dialog de bloqueo de pantalla
 * Debe incluir framework de diseñño MATERIALIZECSS o las clases de color contenidas en él
 *
 * @param mensaje => mensaje a mostrar, si se pasa el valor undefined muestra el mensaje por defecto
 * @param load => si debe mostrar icono de carga o no
 */
function abrirBlockUiCargando(mensaje = "Cargando",load = true) {
    var html = '<img src="'+$('#general_url').val()+'/imagenes/sistema/dogcat.png" style="width: 100px !important;" /><h4 class="white-text">'+mensaje;
    if(load)
        html += ' <i class="fas fa-spin fa-spinner white-text"></i>';
    html += '</h4>';
    $.blockUI({ message: html });
}


function cerrarBlockUiCargando() {
    $.unblockUI();
}


function abrirBlockUiElemento(elemento, mensaje = "Cargando",load = true) {
    var html = '<h4 class="white-text">'+mensaje;
    if(load)
        html += ' <i class="fas fa-spin fa-spinner white-text"></i>';
    html += '</h4>';
    $(elemento).block({ message: html });
}

function cerrarBlockUiElemento(elemento) {
    $(elemento).unblock();
}

/**
 * Inicializa complementos javascript para la funcionalidad general del sistema
 */
function inicializarComplementos() {
    //inicialización de tooltips
    $('[data-toggle="tooltip"]').tooltip();
    if($('.datepicker').length) {
        $('.datepicker').datepicker({
            allowPastDates: true,
            formatDate: function (objectDate) {
                return objectDate.getFullYear() + '/' + (objectDate.getMonth() + 1) + '/' + objectDate.getDate();
            }
        });
    }
}

function agregarDivisionesDivs(id,cantidad_x_small,cantidad_small,cantidad_medium,cantidad_large) {
    $('#'+id+' .item_division_div').each(function (i,el) {
        if(cantidad_x_small > 1){
            if((i+1)%cantidad_x_small == 0){
                var html = '<div class="row d-sm-none d-md-none d-lg-none"></div>';
                $(el).after(html);
            }
        }
        if(cantidad_small > 1){
            if((i+1)%cantidad_small == 0){
                var html = '<div class="row d-none d-md-none d-lg-none"></div>';
                $(el).after(html);
            }
        }
        if(cantidad_medium > 1){
            if((i+1)%cantidad_medium == 0){
                var html = '<div class="row d-sm-none d-none d-lg-none"></div>';
                $(el).after(html);
            }
        }
        if(cantidad_large > 1){
            if((i+1)%cantidad_large == 0){
                var html = '<div class="row d-sm-none d-md-none d-none"></div>';
                $(el).after(html);
            }
        }
    })
}

function quitarTildes(cadena) {
    return cadena.replace(/([àáâãäå])|([ç])|([èéêë])|([ìíîï])|([ñ])|([òóôõöø])|([ß])|([ùúûü])|([ÿ])|([æ])/g, function(str,a,c,e,i,n,o,s,u,y,ae) { if(a) return 'a'; else if(c) return 'c'; else if(e) return 'e'; else if(i) return 'i'; else if(n) return 'n'; else if(o) return 'o'; else if(s) return 's'; else if(u) return 'u'; else if(y) return 'y'; else if(ae) return 'ae'; })
}

//manejo de inputs con clases para ingreso de numeros
function iniciarNumerics() {
    $("body .num-int-positivo").numericInput({ allowNegative: false,allowFloat: false});
    $("body .num-int").numericInput({ allowNegative: true,allowFloat: false});
    $("body .num-float-positivo").numericInput({ allowNegative: false,allowFloat: true});
    $("body .num-float").numericInput({ allowNegative: true,allowFloat: true});
}

function actualizar() {
    var url = $('#general_url').val()+'/actualizar-sistema';
    var params = {_token:$('#general_token').val()};
    abrirBlockUiCargando('Actualizando ');
    $.post(url,params)
        .done(function (data) {
            window.location.reload(true);
        })
}

function redimensionMenuFixed() {
    $('#contenedor-menu-fixed').css({
        width:$('#contenedor-menu-fixed').parent().innerWidth()+'px',
        maxWidth:$('#contenedor-menu-fixed').parent().innerWidth()+'px'
    });
    $('#contenedor-botones-estaticos-menu-fixed').css({
        width:$('#contenedor-menu-fixed').parent().innerWidth()+'px',
        maxWidth:$('#contenedor-menu-fixed').parent().innerWidth()+'px'
    });
    $('#contenedor-global-menu-fixed').css({
        opacity:1
    })
    calcularAltoNavbarMenuFixed();
}

function calcularAltoNavbarMenuFixed() {
    var menu = $('#menu-fixed');
    var alto_menu = $(menu).innerHeight();
    var alto_encabezado = $(menu).children('.menu-fixed-header').innerHeight();
    var alto_botones_estaticos = $(menu).children('#contenedor-botones-estaticos-menu-fixed').innerHeight();

    var maxima_altura = alto_menu - (alto_encabezado+alto_botones_estaticos)-40;
    $(menu).children('.navbar-nav').css({
        height:maxima_altura+'px',
    });
}