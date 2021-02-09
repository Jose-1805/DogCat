var valor_afiliacion = 35000;
var maxima_edad_prevision = 0;
var minima_edad_prevision = 0;
$(function () {
    $('.btn-toggle-precio').click(function () {
        $('#contenedor-precio').toggleClass('d-none animated slideInUp');
    })

    $('#veterinaria').change(function () {
        veterinaria = $(this).val();

        var params = {_token:$('#general_token').val(),veterinaria:veterinaria};
        var url = $('#general_url').val()+'/tareas-sistema/select-afiliados-sin-afiliacion'
        abrirBlockUiElemento($('#contenedor-select-afiliados'),'Cargando');
        $.post(url,params,function (data) {
            $('#contenedor-select-afiliados').html(data);
            cerrarBlockUiElemento($('#contenedor-select-afiliados'));
        })
    })

    $('body').on('change','#usuario',function () {
        usuario = $(this).val();

        var params = {_token:$('#general_token').val(),usuario:usuario};
        var url = $('#general_url').val()+'/afiliacion/lista-mascotas'
        abrirBlockUiElemento($('#contenedor-mascotas'),'Cargando');

        $.post(url,params,function (data) {
            $('#contenedor-mascotas').html(data);
            cerrarBlockUiElemento($('#contenedor-mascotas'));
        })
    })

    //evento producido al seleccionar o deseleccionar una imagen de mascota para la afiliaciòn
    $('body').on('changeStateItemSelectImg','#selector-imagenes',function (e,item,selected,value) {
        var url_image = $(item).find('.view').eq(0).css('background-image');

        url_image = url_image.replace(/"/,'');
        url_image = url_image.replace(/"/,'');


        //determina si es una seleccion y no una deseleccion
        if(selected) {
            //se consulta la edad de la mascota
            var url = $('#general_url').val()+'/mascota/edad';
            var params ={_token:$('#general_token').val(),mascota:value,tipo:'años'};
            $.post(url,params)
                .done(function (anios) {
                    var meses = (anios*12).toFixed(2);

                    var html_imagen = '<div class="animated zoomInDown" style="height: 50px;width: 50px;margin: 0 auto;border-radius: 50%; background-image: ' + url_image + '; background-repeat: no-repeat; background-size: auto 100%; background-position: center;"></div>' +
                        '<p class="text-center font-small">'+$(item).find('.nombre_mascota').html()+'</p>';

                    var html_inicio = '<div class="col-6 col-md-4 col-lg-3" id="mc-' + value + '">';
                    var html_ahorrativo = '' +
                        '<div class="">' +
                            '<input type="hidden" name="mascota_' + value + '" id="mascota_' + value + '" class="" value="seleccionada">' +
                            '<div class="md-form">' +
                                '<select name="funeraria_mascota_' + value + '" id="funeraria_mascota_' + value + '" class="item-precio select-funeraria form-control">' +
                                    '<option>Sin funeraria</option>' +
                                    '<option value="cremación">Cremación</option>' +
                                    '<option value="sepultura">Sepultura</option>' +
                                '</select>' +
                            '</div>' +
                            '<div class="d-none contenedor-funeraria" id="contenedor_funeraria_'+value+'">' +
                                '<div class="md-form">' +
                                    '<input type="checkbox" name="incluir_transporte_mascota_' + value + '" id="incluir_transporte_mascota_' + value + '" class="item-precio check_incluir_transporte" value="si" disabled>' +
                                    '<label for="incluir_transporte_mascota_'+value+'" class="font-small" style="margin-top: -11px;margin-left: 20px;">' +
                                    ' Incluir transporte</label>' +
                                '</div>'+
                                '<div class="md-form" style="margin-top: -10px;">' +
                                    '<p class="font-small no-margin">Pagar a</p>' +
                                    '<select name="pagar_a_' + value + '" id="pagar_a_' + value + '" class="item-precio pagar_a form-control" disabled="disabled">' +
                                        '<option value="1">1 año</option>' +
                                        '<option value="2">2 años</option>' +
                                        '<option value="3">3 años</option>' +
                                        '<option value="4">4 años</option>' +
                                        '<option value="5">5 años</option>' +
                                        '<option value="6">6 años</option>' +
                                        '<option value="7">7 años</option>' +
                                        '<option value="8">8 años</option>' +
                                    '</select>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

                    var html_prevision =
                        '<div class="">' +
                            '<input type="hidden" name="mascota_' + value + '" id="mascota_' + value + '" class="" value="seleccionada">' +
                            '<div class="md-form">' +
                                '<select name="plan_funeraria_mascota_' + value + '" id="plan_funeraria_mascota_' + value + '" class="item-precio select-funeraria form-control">' +
                                    '<option>Sin funeraria</option>' +
                                    '<option value="Previsión">Previsión</option>' +
                                    '<option value="Ahorrativo">Ahorrativo</option>' +
                                '</select>' +
                            '</div>' +

                            '<div class="d-none contenedor-funeraria" id="contenedor_funeraria_'+value+'">' +
                                '<div class="md-form">' +
                                    '<select name="funeraria_mascota_' + value + '" id="funeraria_mascota_' + value + '" class="item-precio select-funeraria form-control" disabled>' +
                                        '<option value="cremación">Cremación</option>' +
                                        '<option value="sepultura">Sepultura</option>' +
                                    '</select>' +
                                '</div>' +
                                '<div class="md-form">' +
                                    '<input type="checkbox" name="incluir_transporte_mascota_' + value + '" id="incluir_transporte_mascota_' + value + '" class="item-precio check_incluir_transporte" value="si" disabled>' +
                                    '<label for="incluir_transporte_mascota_'+value+'" class="font-small" style="margin-top: -11px;margin-left: 20px;">' +
                                    ' Incluir transporte</label>' +
                                '</div>' +
                                '<div class="d-none contenedor_pagar_a" id="contenedor_pagar_a_'+value+'">'+
                                    '<div class="md-form" style="margin-top: -10px;">' +
                                        '<p class="font-small no-margin">Pagar a</p>' +
                                        '<select name="pagar_a_' + value + '" id="pagar_a_' + value + '" class="item-precio pagar_a form-control" disabled="disabled">' +
                                            '<option value="1">1 año</option>' +
                                            '<option value="2">2 años</option>' +
                                            '<option value="3">3 años</option>' +
                                            '<option value="4">4 años</option>' +
                                            '<option value="5">5 años</option>' +
                                            '<option value="6">6 años</option>' +
                                            '<option value="7">7 años</option>' +
                                            '<option value="8">8 años</option>' +
                                        '</select>' +
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';

                    var html_fin = '</div>';

                    if(anios > maxima_edad_prevision || meses < minima_edad_prevision){
                        var elemento_agregar = html_inicio
                            + html_imagen
                            + html_ahorrativo
                            + html_fin;
                    }else if (anios <= maxima_edad_prevision){
                        var elemento_agregar = html_inicio
                            + html_imagen
                            + html_prevision
                            + html_fin;
                    }

                    $('#content-mascotas-afiliar').append(elemento_agregar);
                    iniciarNumerics();
                    valorAfiliacion();

                })
        }else {
            $('#content-mascotas-afiliar').find('#mc-'+value).remove();
            valorAfiliacion();
        }
    })

    $('#btn-guardar-afiliacion').click(function () {
        $('#modal-confirmar-guardar-afiliacion').modal('show');
    })

    $('#btn-confirmar-guardar-afiliacion').click(function () {
        guardarAfiliacion();
    })

    $('body').on('change','.item-precio',function () {
        setTimeout(function () {
            valorAfiliacion();
        },500);
    })

    $('body').on('change','.select-funeraria',function () {
        //se bloquean los controles de funeraria cuando no se selecciona ningùn servicio de funeraria
        if($(this).val() == 'Sin funeraria'){
            $(this).parent().parent().find('.contenedor-funeraria').addClass('d-none');
            $(this).parent().parent().find('.contenedor-funeraria *').prop('disabled','disabled');
        }else{
            $(this).parent().parent().find('.contenedor-funeraria').removeClass('d-none');
            $(this).parent().parent().find('.contenedor-funeraria *').prop('disabled',false);

            if($(this).val() == 'Ahorrativo'){
                $(this).parent().parent().find('.contenedor-funeraria').eq(0).find('.contenedor_pagar_a').removeClass('d-none');
                $(this).parent().parent().find('.contenedor-funeraria').eq(0).find('.contenedor_pagar_a *').prop('disabled',false);
            }else{
                $(this).parent().parent().find('.contenedor-funeraria').eq(0).find('.contenedor_pagar_a').addClass('d-none');
                $(this).parent().parent().find('.contenedor-funeraria').eq(0).find('.contenedor_pagar_a *').prop('disabled','disabled');

            }
        }
    })

    $('#cantidad_pagos').change(function () {
        valorPagar();

        if($(this).val() == 1){
            $('#contenedor-dia-pagar').addClass('d-none');
        }else{
            $('#contenedor-dia-pagar').removeClass('d-none');
        }
    })
})

function valorAfiliacion() {
    var params = $('#form-afiliacion').serialize();
    var url = $('#general_url').val()+'/afiliacion/get-valor';
    var contenedor_precio = $('#contenedor-precio');
    abrirBlockUiElemento(contenedor_precio,'Calculando valor');
    $.post(url,params)
        .done(function (data) {
            cerrarBlockUiElemento(contenedor_precio);
            valor_afiliacion = data;
            $('#valor_afiliacion').text('$ '+ $.number(data).replace(',','.'));
            valorPagar();
        }).fail(function (jqXHR,state,error) {
            cerrarBlockUiElemento(contenedor_precio);
            console.log(JSON.parse(jqXHR.responseText));
            $('#valor_afiliacion').text('Ocurrio un error al calcular el valor de la afiliaciòn. Recargue la pàgina e intente nuevamente.');
        })
}

function valorPagar() {
    var cantidad_pagos = 1;
    if($('#cantidad_pagos').length > 0)
        cantidad_pagos = parseInt($('#cantidad_pagos').val());
    var valor = valor_afiliacion/cantidad_pagos;

    $('#valor_pagar').html('$ '+$.number(valor).replace(',','.'));
}

function guardarAfiliacion() {
    var params = $('#form-afiliacion').serialize();
    var url = $('#general_url').val()+'/afiliacion/guardar';
    abrirBlockUiCargando('Guardando afiliación');
    $.post(url,params)
        .done(function (data) {
            cerrarBlockUiCargando();
            window.location.href = $('#general_url').val()+'/afiliacion/nueva';
        }).fail(function (jqXHR,state,error) {
            $('#modal-confirmar-guardar-afiliacion').modal('hide');
            cerrarBlockUiCargando();
            abrirAlerta('alertas-afiliacion','danger',JSON.parse(jqXHR.responseText),null,null);
        })
}