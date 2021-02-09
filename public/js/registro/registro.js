/**
 * Created by jose1805 on 30/05/18.
 */
var cols = null;
var registro = null;
$(function () {
    $('body').on('click','.btn-asignar-registro',function () {
        registro = $(this).data('registro');
        $('#modal-asignar-registro').modal('show');
    })

    $('body').on('click','#btn-asignar-registro-ok',function () {
        if(registro){
            abrirBlockUiCargando();
            var url = $('#general_url').val()+'/registro/asignar';
            var params = {_token:$('#general_token').val(),'registro':registro,usuario:$('#registro').val()};

            $.post(url,params,function (data) {
                cerrarBlockUiCargando();
                $('#modal-asignar-registro').modal('hide');
                abrirAlerta('alertas-registros','success',['El registro ha sido asignado con éxito'],null,'body');
                cargarTablaRegistros();
            }).fail(function (jqXHR,error,state) {
                cerrarBlockUiCargando();
                $('#modal-asignar-registro').modal('hide');
                abrirAlerta('alertas-registros','danger',JSON.parse(jqXHR.responseText),null,'body');
            })
        }
    })
})

function setCols(colums) {
    cols = colums;
}

function cargarTablaRegistros() {
    var tabla_registros = $('#tabla-registros').dataTable({
        "destroy": true
    });
    tabla_registros.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-registros').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_registros = $('#tabla-registros').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/registro/datos",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },300);
        },
        "order":[0,'desc']
    });
}