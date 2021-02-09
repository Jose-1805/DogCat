var afiliacion = null;
var cols = null;
$(function () {
    $('body').on('click', '.btn-marcar-pagada', function () {
        afiliacion = $(this).data('afiliacion');
        var params = {_token:$('#general_token').val(),afiliacion:afiliacion};
        var url = $('#general_url').val() + '/afiliacion/form-marcar-pagada';
        abrirBlockUiCargando('Cargando');
        $.post(url, params)
            .done(function (data) {
                $('#contenedor-form-marcar-pagada').html(data);
                cerrarBlockUiCargando();
                $('#modal-marcar-pagada').modal('show');
            }).fail(function (jqXHR, state, error) {
                cerrarBlockUiCargando();
                abrirAlerta('alertas-afiliaciones', 'danger', JSON.parse(jqXHR.responseText), null, null);
                //$('#modal-marcar-pagada').modal('hide');
            });
    });
    
    $('#btn-marcar-pagada').click(function () {
        marcarPagada();
    })

    $('body').on('change','#medio_pago',function () {
        if($(this).val() == 'Efectivo'){
            $('#contenedor-codigo-verificacion').addClass('d-none');
            $('#codigo_verificacion').val('');
        }else{
            $('#contenedor-codigo-verificacion').removeClass('d-none');
        }
    })

    $('body').on('change','#cantidad_pagos',function () {
        var valor = $(this).data('valor')/$(this).val();
        $('#valor_pagar').html($.number(valor).replace(',','.'));

        if($(this).val() == 1){
            $('#contenedor-dia-pagar').addClass('d-none');
        }else{
            $('#contenedor-dia-pagar').removeClass('d-none');
        }
    })

    $('body').on('change','#cantidad_pagos_realizar',function () {
        var valor = $(this).data('valor')*$(this).val();
        $('#valor_pagar').html($.number(valor).replace(',','.'));
    })
});

function marcarPagada() {
    if(afiliacion){

        var params = $('#form-marcar-pagada').serialize();

        var url = $('#general_url').val() + '/afiliacion/marcar-pagada';
        abrirBlockUiCargando('Registrando el pago');
        $.post(url, params)
            .done(function (data) {
                if (data.success) {
                    cerrarBlockUiCargando();
                    abrirAlerta('alertas-afiliaciones', 'success', ['El pago ha sido registrado con éxito'], null, null);
                    cargarTablaAfiliaciones();
                    $('#modal-marcar-pagada').modal('hide');
                }
            }).fail(function (jqXHR, state, error) {
                cerrarBlockUiCargando();
                abrirAlerta('alertas-marcar-pagada', 'danger', JSON.parse(jqXHR.responseText), null, null);
                //$('#modal-marcar-pagada').modal('hide');
        });
    }
}

function setCols(c) {
    cols = c;
}

function cargarTablaAfiliaciones() {
    var tabla_registros = $('#tabla-afiliaciones').dataTable({ "destroy": true });
    tabla_registros.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-afiliaciones').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_registros = $('#tabla-afiliaciones').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/afiliacion/lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },300);
        },
    });
}