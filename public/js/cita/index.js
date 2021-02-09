var cita = null;
$(function () {
    cargarAgenda();
    cargarTablaCitas();

    $('body').on('click','.btn-ver-cita',function () {
        cita = $(this).data('cita');
        ver();
    });

    $('body').on('click','.btn-cancelar-cita',function () {
        cita = $(this).data('cita');
        $('#modal-cancelar-cita').modal('show');
    });

    $('#btn-cancelar-cita-ok').click(function () {
        cancelar();
    })

    $('#btn-confirmar-cancelar-cita-ok').click(function () {
        cancelar(true);
    })

    $('body').on('click','.btn-pagar-cita',function () {
        cita = $(this).data('cita');

        var params = {_token:$('#general_token').val(),cita:cita};
        var url = $('#general_url').val()+'/cita/get-info-valor-pago';

        abrirBlockUiCargando('Cargando ');
        $.post(url,params)
            .done(function (data) {
                $('#contenedor-info-pago').html(data);
                $('#valor_adicional_check').prop('checked',false);
                $('#contenedor-valor-adicional').addClass('d-none');
                $('#valor_adicional').val('');
                $('#descripcion_valor_adicional').val('');
                cerrarBlockUiCargando();
                $('#modal-registrar-pago').modal('show');
                setValorPagar();
            });
    });

    $('#valor_adicional_check').change(function () {
        $('#contenedor-valor-adicional').toggleClass('d-none');
    })

    $('body').on('change','.item-precio',function () {
        setValorPagar();
    })

    $('body').on('keyup','.item-precio',function () {
        setValorPagar();
    })

    $('#btn-registrar-pago-ok').click(function () {
        $('#modal-registrar-pago').modal('hide');
        $('#modal-validar-registrar-pago').modal('show');
    })

    $('#medio_pago').change(function () {
        if($(this).val() == 'Efectivo'){
            $('#contenedor-codigo-verificacion').addClass('d-none');
            $('#codigo_verificacion').val('');
        }else{
            $('#contenedor-codigo-verificacion').removeClass('d-none');
        }
    })

    $('#btn-validar-registrar-pago-ok').click(function () {
        pagar();
    })

    $('body').on('click','.btn-finalizar-cita',function () {
        cita = $(this).data('cita');
        $('#modal-finalizar-cita').modal('show');
    })

    $('#btn-finalizar-cita-ok').click(function () {
        finalizar();
    })
})

function finalizar() {
    var params = {_token:$('#general_token').val(),cita:cita,observaciones:$('#observaciones_cita').val()};
    var url = $('#general_url').val()+'/cita/finalizar';

    abrirBlockUiCargando('Finalizando cita ');
    $('#modal-finalizar-cita').modal('hide');
    $.post(url,params)
        .done(function (data) {
            cerrarBlockUiCargando();
            cita = null;
            cargarTablaCitas();
            cargarAgenda();
            $('#observaciones').val('');
            abrirAlerta('alertas-citas','success',['La cita ha sido finalziada con éxito.'],null,'body');
        })
        .fail(function (jqXHR,state,error) {
            cerrarBlockUiCargando();
            setTimeout(function () {
                $('#modal-finalizar-cita').modal('show');
            },300)
            abrirAlerta('alertas-finalizar-cita','danger',JSON.parse(jqXHR.responseText),null,'body');
        });
}

function pagar() {
    var params = $('#form-registrar-pago').serialize()+'&cita='+cita;
    var url = $('#general_url').val()+'/cita/pagar';

    abrirBlockUiCargando('Cancelando ');
    $('#modal-validar-registrar-pago').modal('hide');
    $.post(url,params)
        .done(function (data) {
            cerrarBlockUiCargando();
            cita = null;
            cargarTablaCitas();
            cargarAgenda();
            abrirAlerta('alertas-citas','success',['La cita ha sido facturada con éxito.'],null,'body');
            $('#form-registrar-pago')[0].reset();
        })
        .fail(function (jqXHR,state,error) {
            $('#modal-registrar-pago').modal('show');
            cerrarBlockUiCargando();
            abrirAlerta('alertas-pago','danger',JSON.parse(jqXHR.responseText),null,'body');
        });
}

function cancelar(confirmacion = false) {
    if(confirmacion)
        var params = {_token:$('#general_token').val(),cita:cita,motivo_cancelacion:$('#motivo_cancelacion').val(),confirmar_cancelar:'si'};
    else
        var params = {_token:$('#general_token').val(),cita:cita,motivo_cancelacion:$('#motivo_cancelacion').val()};
    var url = $('#general_url').val()+'/cita/cancelar';

    abrirBlockUiCargando('Cancelando ');
    $.post(url,params)
        .done(function (data) {
            $('#modal-cancelar-cita').modal('hide');
            $('#modal-confirmar-cancelar-cita').modal('hide');
            cerrarBlockUiCargando();
            if(data.success){
                cita = null;
                cargarTablaCitas();
                cargarAgenda();
                abrirAlerta('alertas-citas','success',['La cita ha sido cancelada con éxito.'],null,'body');
                $('#motivo_cancelacion').val('');
            }else{
                $('#modal-confirmar-cancelar-cita').modal('show');
            }
        })
        .fail(function (jqXHR,state,error) {
            $('#modal-cancelar-cita').modal('hide');
            $('#modal-confirmar-cancelar-cita').modal('hide');
            cerrarBlockUiCargando();
            abrirAlerta('alertas-citas','danger',JSON.parse(jqXHR.responseText),null,'body');
        });
}

function ver() {
    var params = {_token:$('#general_token').val(),cita:cita};
    var url = $('#general_url').val()+'/cita/get-datos';

    abrirBlockUiCargando('Cargando ');
    $.post(url,params)
        .done(function (data) {
            $('#modal-datos-cita .modal-body').html(data);
            cerrarBlockUiCargando();
            $('#modal-datos-cita').modal('show');
        });
}

function cargarAgenda(){
    var element_load = $('#contenedor-agenda-hoy');
    abrirBlockUiElemento(element_load,'Cargando ');
    var url = $('#general_url').val()+'/cita/agenda-fecha';
    var params = {_token:$('#general_token').val()};
    $.post(url,params)
        .done(function (data) {
            $(element_load).html(data);
        })
}

function cargarTablaCitas() {
        var tabla_citas = $('#tabla-citas').dataTable({ "destroy": true });
        tabla_citas.fnDestroy();
        $.fn.dataTable.ext.errMode = 'none';
        $('#tabla-citas').on('error.dt', function(e, settings, techNote, message) {
            console.log( 'DATATABLES ERROR: ', message);
        })

        tabla_citas = $('#tabla-citas').DataTable({
            lenguage: idioma_tablas,
            processing: true,
            serverSide: true,
            ajax: $("#general_url").val()+"/cita/lista",
            columns: [
                {data: 'fecha', name: 'fecha'},
                {data: 'hora', name: 'hora'},
                {data: 'servicio', name: 'servicio'},
                {data: 'estado', name: 'estado'},
                {data: 'mascota', name: 'mascota'},
                {data: 'propietario', name: 'propietario'},
                {data: 'direccion', name: 'direccion'},
                {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
            ],
            fnRowCallback: function (nRow, aData, iDisplayIndex) {
                $(nRow).attr('id','row_'+aData.id);
                setTimeout(function () {
                },300);
            },
        });
}

function setValorPagar() {
    var valor = 0;
    if($.isNumeric($('#valor_servicio').val())){
        valor += parseInt($('#valor_servicio').val());
        valor = valor - ((parseInt($('#valor_servicio').data('descuento')) * valor)/100);
    }else if($.isNumeric($('#valor_servicio').data('total'))){
        valor += parseInt($('#valor_servicio').data('total'));
        valor = valor - ((parseInt($('#valor_servicio').data('descuento')) * valor)/100);
    }

    if($('#valor_adicional_check').prop('checked')){
        if(parseInt($('#valor_adicional').val()))
            valor += parseInt($('#valor_adicional').val());
    }

    $('#valor_cita').html('$ '+$.number(valor,0,',','.'));
}