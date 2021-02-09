var valor_afiliacion = 35000;
var maxima_edad_prevision = 0;
var minima_edad_prevision = 0;
var razas_perros = [];
var razas_gatos = [];
var raza = null;
var maxima_cantidad_meses_credito = 1;
var valor_minimo_cuota_credito = 1;
$(function () {
    $('.btn-toggle-precio').click(function () {
        $('#contenedor-precio').toggleClass('d-none animated slideInUp');
    })

    $('#btn-agregar-mascota').click(function () {
        $('#modal-agregar-mascota').modal('show');
    })

    $('#tipo_mascota').change(function () {
        $('#raza').prop('disabled',false);
        var tipo_mascota = $(this).children('option[value="'+$(this).val()+'"]').text();
        var opciones = [];
        if(tipo_mascota == 'Perro')opciones = razas_perros;
        else if(tipo_mascota == 'Gato')opciones = razas_gatos;

        raza = null;
        $('#raza').val("");
        $('#raza').parent().children('label').eq(0).text("Raza");
        $('#raza_id').val("");

        $('#raza').autocomplete({
            lookup: opciones,
            onSelect: function (suggestion) {
                raza = suggestion.data;
                $('#raza').text("("+suggestion.value+")");
                $('#raza').parent().children('label').eq(0).text("Raza ("+suggestion.value+")");
                $('#raza_id').val(raza);
            },
            lookupFilter: function (suggestion, query, queryLowerCase) {
                var lowerCaseNoAccent = quitarTildes(suggestion.value).toLowerCase();
                var queryLowerCaseNoAccent = quitarTildes(queryLowerCase);
                return lowerCaseNoAccent.indexOf(queryLowerCaseNoAccent) > -1;
            }
        });
    });
    
    $('#btn-agregar-mascota-ok').click(function () {
        var error = false;
        var mensajes = [];
        if(!$('#nombre').val()){
            mensajes.push('El nombre de la mascota es obligatorio.');
            error = true;
        }
        if(!$('#tipo_mascota').val()){
            mensajes.push('Seleccione el tipo de mascota.');
            error = true;
        }else{
            if(!$('#raza_id').val()){
                mensajes.push('Seleccione la raza de la mascota.');
                error = true;
            }
        }

        if(!$('#fecha_nacimiento').val()){
            mensajes.push('Seleccione la fecha de nacimiento de la mascota.');
            error = true;
        }else{
            var hoy = new Date();
            var fecha = new Date($('#fecha_nacimiento').val());
            if(hoy.getTime() < fecha.getTime()){
                mensajes.push('Seleccione una fecha de nacimiento igual o menor a le fecha actual.');
                error = true;
            }
        }

        if(error){
            abrirAlerta('alertas-agregar-mascota','danger',mensajes,null,null);
        }else{
            var nombre = $('#nombre').val();
            var raza = $('#raza_id').val();
            var tipo = $('#tipo_mascota').val();
            var fecha_nacimiento = $('#fecha_nacimiento').val();

            var anios = new Date().getTime() - new Date(fecha_nacimiento).getTime();
            anios = (anios/(1000*60*60*24)/365).toFixed(2);

            var meses = (anios*12).toFixed(2);

            var url_image = $('#general_url').val()+"/imagenes/sistema/silueta_perro.png";
            if(tipo == 'Gato')url_image = $('#general_url').val()+"/imagenes/sistema/silueta_gato.png";

            var html_imagen = '<div class="animated zoomInDown" style="height: 50px;width: 50px;margin: 0 auto;border-radius: 50%; background-image: url(' + url_image + '); background-repeat: no-repeat; background-size: auto 100%; background-position: center;"></div>' +
                '<p class="text-center font-small">'+nombre+'</p>';

            var value = $('.mascota-simulador').length+1;
            var html_inicio = '<div class="col-10 col-md-4 col-lg-3 mascota-simulador hoverable" id="mc-' + value + '"><a href="#!" class="btn-quitar-mascota"><i class="fas fa-times-circle" data-toggle="tooltip" data-placement="left" title="Quitar a '+nombre+'"></i></a>';
            var html_ahorrativo = '' +
                '<div class="">' +
                '<input type="hidden" name="nombre_' + value + '" id="nombre_' + value + '" class="nombre-simulador" value="'+nombre+'">' +
                '<input type="hidden" name="fecha_nacimiento_mascota_' + value + '" id="fecha_nacimiento_mascota_' + value + '" class="fecha-nacimiento-simulador" value="'+fecha_nacimiento+'">' +
                '<input type="hidden" name="raza_mascota_' + value + '" id="raza_mascota_' + value + '" class="raza-simulador" value="'+raza+'">' +
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
                '<label for="incluir_transporte_mascota_'+value+'" class="font-small label-incluir-transporte" style="margin-top: -11px;margin-left: 20px;">' +
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
                '<input type="hidden" name="nombre_' + value + '" id="nombre_' + value + '" class="nombre-simulador" value="'+nombre+'">' +
                '<input type="hidden" name="fecha_nacimiento_mascota_' + value + '" id="fecha_nacimiento_mascota_' + value + '" class="fecha-nacimiento-simulador" value="'+fecha_nacimiento+'">' +
                '<input type="hidden" name="raza_mascota_' + value + '" id="raza_mascota_' + value + '" class="raza-simulador" value="'+raza+'">' +
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
                '<label for="incluir_transporte_mascota_'+value+'" class="font-small label-incluir-transporte" style="margin-top: -11px;margin-left: 20px;">' +
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

            $('#msj_sin_mascota').addClass('d-none');
            $('#contenedor-mascotas-simulador').append(elemento_agregar);
            $('#form-agregar-mascota')[0].reset();
            $('#modal-agregar-mascota').modal('hide');
            setTimeout(function () {
                valorAfiliacion();
            },500);
        }
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

    $('body').on('change','.item-precio',function () {
        setTimeout(function () {
            valorAfiliacion();
        },500);
    })

    $('#cantidad_pagos').change(function () {
        valorPagar();
    })

    $('#modal-agregar-mascota').modal('show');

    setTimeout(function () {
        //$('#nombre').focus();
        document.getElementById('nombre').focus();
    },500);

    $('body').on('click','.btn-quitar-mascota',function () {
        $(this).parent().remove();

        $('.mascota-simulador').each(function (i,el) {
            $(el).attr('id',i+1);
            var elemento_nombre = $(el).find('.nombre-simulador');
            $(elemento_nombre).attr('id','nombre_'+(i+1));
            $(elemento_nombre).attr('name','nombre_'+(i+1));

            var elemento_fecha = $(el).find('.fecha-nacimiento-simulador');
            $(elemento_fecha).attr('id','fecha_nacimiento_mascota_'+(i+1));
            $(elemento_fecha).attr('name','fecha_nacimiento_mascota_'+(i+1));

            var elemento_raza = $(el).find('.raza-simulador');
            $(elemento_raza).attr('id','raza_mascota_'+(i+1));
            $(elemento_raza).attr('name','raza_mascota_'+(i+1));

            var elemento_select_funeraria = $(el).find('.select-funeraria');
            $(elemento_select_funeraria).attr('id','funeraria_mascota_'+(i+1));
            $(elemento_select_funeraria).attr('name','funeraria_mascota_'+(i+1));

            var elemento_contenedor_funeraria = $(el).find('.contenedor-funeraria');
            $(elemento_contenedor_funeraria).attr('id','contenedor_funeraria_'+(i+1));

            var elemento_check_incluir_transporte = $(el).find('.check_incluir_transporte');
            $(elemento_check_incluir_transporte).attr('id','incluir_transporte_mascota_'+(i+1));
            $(elemento_check_incluir_transporte).attr('name','incluir_transporte_mascota_'+(i+1));

            var elemento_label_incluir_transporte = $(el).find('.label-incluir-transporte');
            $(elemento_label_incluir_transporte).prop('for','incluir_transporte_mascota_'+(i+1));

            var elemento_contenedor_pagar_a = $(el).find('.contenedor_pagar_a');
            $(elemento_contenedor_pagar_a).attr('id','contenedor_pagar_a_'+(i+1));

            var elemento_pagar_a = $(el).find('.pagar_a');
            $(elemento_pagar_a).attr('id','pagar_a_'+(i+1));
            $(elemento_pagar_a).attr('name','pagar_a_'+(i+1));
        })

        setTimeout(function () {
            valorAfiliacion();
        },500);
    });

    $('.btn-detalle-afiliacion').click(function () {
        detalleAfiliacion();
    })

    valorAfiliacion();
})

function valorAfiliacion() {
    var params = $('#form-simulador-afiliacion').serialize();
    var url = $('#general_url').val()+'/simulador-afiliacion/get-valor';

    var contenedor_precio = $('#contenedor-precio');
    abrirBlockUiElemento(contenedor_precio,'Calculando valor');
    $.post(url,params)
        .done(function (data) {
            cerrarBlockUiElemento(contenedor_precio);
            valor_afiliacion = data;
            $('#valor_afiliacion').text('$ '+ $.number(data).replace(',','.'));

            //se actualiza el select de credito de acuerdo al valor de la afiliación
            var cantidad_cuotas = 1;
            if (data > valor_minimo_cuota_credito)
                cantidad_cuotas = parseInt(data/valor_minimo_cuota_credito);

            if(cantidad_cuotas > maxima_cantidad_meses_credito)cantidad_cuotas = maxima_cantidad_meses_credito;

            var seleccion_anterior = $('#cantidad_pagos').val();
            var html = '';
            for (i = 1;i <= cantidad_cuotas;i++){
                var texto = i+" meses";
                if(i == 1)texto = i+" mes";

                if(i == seleccion_anterior)
                    html += "<option value='"+i+"' selected>"+texto+"</option>";
                else
                    html += "<option value='"+i+"'>"+texto+"</option>";
            }

            $('#cantidad_pagos').html(html);

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

function detalleAfiliacion() {
    var params = $('#form-simulador-afiliacion').serialize();
    var url = $('#general_url').val()+'/simulador-afiliacion/detalle-afiliacion';

    abrirBlockUiCargando('Generando detalle de afiliación');

    $.post(url,params)
        .done(function (data) {
            $('#contenedor-detalle-afiliacion').html(data);
            $('#modal-detalle-afiliacion').modal('show');
            cerrarBlockUiCargando();
        }).fail(function (jqXHR,state,error) {
            cerrarBlockUiCargando()
            console.log(JSON.parse(jqXHR.responseText));
            $('#contenedor-detalle-afiliacion').html('<p class="text-center">Ocurrio un error al calcular el valor de la afiliaciòn. Recargue la pàgina e intente nuevamente.</p>');
        })
}