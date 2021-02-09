var lat = null;
var lng = null;
var precios = null;
var datos_cita = null;
var map = null;
var marker = null;
var direccion = null;
var direccion_full = null;
$(function () {
    $('#btn-modal-nueva-cita').click(function () {
        $('#modal-nueva-cita').modal('show');
        $('#modal-gestion-cita').modal('hide');
        $('#modal-ubicacion-cita').modal('hide');
    })

    $('#veterinaria').change(function () {
        getUsuarios();
    })

    $('body').on('change','#usuario',function () {
        getMascotas();
    })

    getUsuarios();
    
    $('#btn-gestionar-cita').click(function () {
        var params = $('#form-veterinarias').serialize();
        var url = $('#general_url').val()+'/cita/gestion-cita';
        abrirBlockUiCargando('Cargando ');
        $('#modal-nueva-cita').modal('hide');
        $.post(url,params)
            .done(function (data) {
                $('#contenedor-gestion-cita').html(data.html);
                setDataUbicacion(data.ubicacion);
                setTimeout(function () {
                    cerrarBlockUiCargando();
                    $('#modal-gestion-cita').modal('show');
                },500);
            })
            .fail(function (jqXHR,stste,error) {
                cerrarBlockUiCargando();
                abrirAlerta('alertas-citas','danger',JSON.parse(jqXHR.responseText));
            })
    })

    $('body').on('change','#servicio',function () {
        var seleccion = $(this).val();
        $('#servicio option').each(function (i,el) {
            if($(el).val() == seleccion){
                if($(el).data('paseador') == 'si'){
                    $('#modal-gestion-cita').modal('hide');
                    setTimeout(function () {
                        $('#modal-ubicacion-cita').modal('show');
                    },500);
                }
            }
        })
        getEncargados();
    })

    $('body').on('change','#encargado',function () {
        getDisponibilidades();
    })

    $('body').on('change','.disponibilidad',function () {
        $('#fecha').val($(this).data('fecha'));
        getAgenda();
    })

    $('body').on('change','.agendas',function () {
        $('#hora_inicio').val($(this).data('hora-inicio'));
        $('#minuto_inicio').val($(this).data('minuto-inicio'));
        $('#btn-guardar-cita').prop('disabled',false);
        actualizarConfirmacion();
    })

    $('#btn-guardar-cita').click(function () {
        $('#modal-gestion-cita').modal('hide');
        setTimeout(function () {
            $('#modal-confirmar-cita').modal('show');
        },500);
    })

    $('#cancelar-confirmacion-cita').click(function () {
        $('#modal-confirmar-cita').modal('hide');
        setTimeout(function () {
            $('#modal-gestion-cita').modal('show');
        },500);
    })

    $('#btn-confirmar-cita').click(function () {
        guardarCita();
    })

    $('#btn-init-map').click(function () {
        posicionarDireccionEnMapa();
    })

    $('#btn-ubicacion-cita-ok').click(function () {
        $('#modal-ubicacion-cita').modal('hide');
        setTimeout(function () {
            $('#modal-gestion-cita').modal('show');
        },500);
    })

    initMap();
})

function getUsuarios() {
    var params = {_token:$('#general_token').val(),veterinaria:$('#veterinaria').val(),name:'usuario'};
    var url = $('#general_url').val()+'/cita/select-afiliados';

    var elemento_load = $('#contenedor-usuarios');
    abrirBlockUiElemento(elemento_load,'Cargando ');
    $.post(url,params)
        .done(function (data) {
            $(elemento_load).html(data);
            cerrarBlockUiElemento(elemento_load);
            $('#usuario').change();
        });
}

function getMascotas() {
    var params = {_token:$('#general_token').val(),usuario:$('#usuario').val(),name:'mascota'};
    var url = $('#general_url').val()+'/cita/select-mascotas';

    var elemento_load = $('#contenedor-mascotas');
    abrirBlockUiElemento(elemento_load,'Cargando ');
    $.post(url,params)
        .done(function (data) {
            $(elemento_load).html(data);
            cerrarBlockUiElemento(elemento_load);
        });
}

function getEncargados() {
    var params = $('#form-gestion-cita').serialize();
    var url = $('#general_url').val()+'/cita/select-encargados';

    var elemento_load = $('#contenedor-encargados');
    abrirBlockUiElemento(elemento_load,'Cargando ');
    $.post(url,params)
        .done(function (data) {
            $(elemento_load).html(data);
            cerrarBlockUiElemento(elemento_load);
            getDisponibilidades();
        });
}

function getDisponibilidades() {
    var params = $('#form-gestion-cita').serialize();
    var url = $('#general_url').val()+'/cita/get-disponibilidades';

    var elemento_load = $('#contenedor-disponibilidades');
    abrirBlockUiElemento(elemento_load,'Cargando ');
    $.post(url,params)
        .done(function (data) {
            $(elemento_load).html(data);
            cerrarBlockUiElemento(elemento_load);
            $('#fecha').val('');
            $('#contenedor-agenda').html('');
        });
}

function getAgenda() {
    var params = $('#form-gestion-cita').serialize()+'&longitud='+lng+'&latitud='+lat;
    var url = $('#general_url').val()+'/cita/get-agenda';

    var elemento_load = $('#contenedor-agenda');
    abrirBlockUiElemento(elemento_load,'Cargando ');
    $.post(url,params)
        .done(function (data) {
            $(elemento_load).html(data.html);
            precios = data.precios;
            datos_cita = data.datos_cita;
            cerrarBlockUiElemento(elemento_load);
            $('#hora_inicio').val('');
            $('#minuto_inicio').val('');
            $('#btn-guardar-cita').prop('disabled',true);
        });
}

function guardarCita() {
    var params = $('#form-gestion-cita').serialize()+'&longitud='+lng+'&latitud='+lat+'&direccion='+direccion_full;
    var url = $('#general_url').val()+'/cita/guardar';
    $('#modal-confirmar-cita').modal('hide');
    abrirBlockUiCargando('Agendando ');
    $.post(url,params)
        .done(function (data) {
            abrirAlerta('alertas-citas','success',[data.mensaje],null,'body');
            precios = null;
            datos_cita = null;
            cerrarBlockUiCargando();
            $('#hora_inicio').val('');
            $('#minuto_inicio').val('');
            $('#usuario_').val('');
            $('#mascota').val('');
            $('#btn-guardar-cita').prop('disabled',true);
            cargarAgenda();
            cargarTablaCitas();
        }).fail(function (jqXHR,state,error) {
            cerrarBlockUiCargando();
            abrirAlerta('alertas-citas','danger',JSON.parse(jqXHR.responseText),null,'body');
        });
}

function actualizarConfirmacion() {
    if(typeof datos_cita != 'undefined') {
        $('#fecha_cita span').eq(0).html(datos_cita.dia);
        $('#fecha_cita span').eq(1).html(datos_cita.fecha);
        $('#fecha_cita span').eq(2).html($('#hora_inicio').val() + ':' + $('#minuto_inicio').val());
        $('#mascota_cita span').eq(1).html(datos_cita.mascota);
        $('#servicio_cita span').eq(1).html(datos_cita.servicio);
        $('#encargado_cita span').eq(1).html(datos_cita.encargado);
        if(precios.valor){
            $('#contenedor_con_precio_fijo').removeClass('d-none');
            $('#contenedor_sin_precio_fijo').addClass('d-none');
            $('#contenedor_con_precio_fijo #valor span').eq(1).html('$ '+$.number(parseInt(precios.valor),0,',','.'));
            $('#contenedor_con_precio_fijo #descuento span').eq(1).html(precios.descuento+' %');
            var valor_pagar = parseInt(precios.valor) - ((parseInt(precios.valor)*parseInt(precios.descuento))/100);
            $('#contenedor_con_precio_fijo p #total').eq(0).html('$ '+$.number(valor_pagar,0,',','.'));
        }else{
            $('#contenedor_sin_precio_fijo').removeClass('d-none');
            $('#contenedor_con_precio_fijo').addClass('d-none');
            $('#contenedor_sin_precio_fijo p #valor_descuento').eq(0).html(parseInt(precios.descuento)+' %');
        }
    }
}

function setDataUbicacion(ubicacion) {
    if(ubicacion.carrera){
        $('#tipo_direccion option').each(function (i,el) {
            if($(el).val() == 'Cra.')$(el).prop('selected','selected');
        })
        $('#numero_tipo_direccion').val(ubicacion.carrera);
    }else if(ubicacion.calle){
        $('#tipo_direccion option').each(function (i,el) {
            if($(el).val() == 'Cl.')$(el).prop('selected','selected');
        })
        $('#numero_tipo_direccion').val(ubicacion.calle);
    }else if(ubicacion.transversal){
        $('#tipo_direccion option').each(function (i,el) {
            if($(el).val() == 'Tv.')$(el).prop('selected','selected');
        })
        $('#numero_tipo_direccion').val(ubicacion.transversal);
    }else if(ubicacion.diagonal){
        $('#tipo_direccion option').each(function (i,el) {
            if($(el).val() == 'Dg.')$(el).prop('selected','selected');
        })
        $('#numero_tipo_direccion').val(ubicacion.diagonal);
    }

    $('#numero_direccion').val(ubicacion.numero.replace('n',' Norte').replace('-',' '));
    $('#barrio_direccion').val(ubicacion.barrio);

    posicionarDireccionEnMapa();
}



function establecerDireccion() {
    if($('#tipo_direccion').val() && $('#numero_tipo_direccion').val() && $('#numero_direccion').val()) {
        direccion = $('#tipo_direccion').val() + ' ' + $('#numero_tipo_direccion').val() + ' ' + $('#numero_direccion').val() + ', Popayán - Cauca - Colombia';
        direccion_full = $('#tipo_direccion').val() + ' ' + $('#numero_tipo_direccion').val() + ' #' + $('#numero_direccion').val() + ' B/'+$('#barrio_direccion').val()+', Popayán - Cauca - Colombia';
        return true;
    }else{
        direccion = 'Cl. 7 11-36 Popayán - Cauca - Colombia';
        direccion_full = 'Cl. 7 #11-36 B/Valencia, Popayán - Cauca - Colombia';
    }
    return false;
}

function initMap() {
    var latlng = new google.maps.LatLng(0, 0);
    map = new google.maps.Map(document.getElementById('mapa_cita'), {
        zoom: 16,
        center: latlng
    });
    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: 'Mi ubicación',
        draggable: true,
    });

    google.maps.event.addListener(marker, 'dragend', function () {
        lat = marker.getPosition().lat();
        lng = marker.getPosition().lng();
    });

    lat = marker.getPosition().lat();
    lng = marker.getPosition().lng();
}

function posicionarDireccionEnMapa(establecer_direccion = true) {
    if(establecer_direccion)establecerDireccion();

    if(direccion) {
        $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + direccion + '&sensor=false', null, function (data) {
            if(data.results[0]){
                if (data.results[0].geometry) {
                    var p = data.results[0].geometry.location
                    var latlng = new google.maps.LatLng(p.lat, p.lng);
                } else {
                    var latlng = new google.maps.LatLng('0', '0');
                }
            } else {
                if(($("#modal-ubicacion-cita").data('bs.modal') || {})._isShown)
                    alert('Dirección no encontrada');
                direccion = 'Cl. 7 11-36 Popayán - Cauca - Colombia';
                posicionarDireccionEnMapa(false);
                return false;
            }

            marker.setPosition(latlng);
            map.setCenter(marker.getPosition());

            lat = marker.getPosition().lat();
            lng = marker.getPosition().lng();
        });
    }
}