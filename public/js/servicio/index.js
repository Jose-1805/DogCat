var servicio = null;
var cols = [];
$(function () {
    $('body').on('click','.btn-desactivar-servicio',function () {
        servicio = $(this).data('servicio');
        $('#modal-desactivar-servicio').modal('show');
    })
    $('body').on('click','.btn-activar-servicio',function () {
        servicio = $(this).data('servicio');
        $('#modal-activar-servicio').modal('show');
    })

    $('#btn-activar').click(function () {
        if(servicio != null)
            activar();
    })

    $('#btn-desactivar').click(function () {
        if(servicio != null)
            desactivar();
    })
})

function setCols(colums) {
    cols = colums;
}


function activar() {
    var params = {_token:$('#general_token').val(),servicio:servicio};
    var url = $('#general_url').val()+'/servicio/activar';
    abrirBlockUiCargando('Activando ');
    $.post(url,params)
        .done(function (data) {
            if(data.success){
                $('#modal-activar-servicio').modal('hide');
                servicio = null;
                cerrarBlockUiCargando();
                abrirAlerta('alertas-servicio','success',['EL servicio ha sido activado con éxito'],null,'body');
                cargarTablaServicios();
            }
        }).fail(function (jqXHR,state,error) {
        $('#modal-activar-servicio').modal('hide');
        servicio = null;
        cerrarBlockUiCargando();
        abrirAlerta('alertas-servicio','danger',JSON.parse(jqXHR.responseText),null,'body');
    })
}

function desactivar() {
    var params = {_token:$('#general_token').val(),servicio:servicio};
    var url = $('#general_url').val()+'/servicio/desactivar';
    abrirBlockUiCargando('Desctivando ');
    $.post(url,params)
        .done(function (data) {
            if(data.success){
                $('#modal-desactivar-servicio').modal('hide');
                servicio = null;
                cerrarBlockUiCargando();
                abrirAlerta('alertas-servicio','success',['El servicio ha sido desactivado con éxito'],null,'body');
                cargarTablaServicios();
            }
        }).fail(function (jqXHR,state,error) {
        $('#modal-desactivar-servicio').modal('hide');
        servicio = null;
        cerrarBlockUiCargando();
        abrirAlerta('alertas-servicio','danger',JSON.parse(jqXHR.responseText),null,'body');
    })
}

function cargarTablaServicios() {
    var tabla_servicios = $('#tabla-servicios').dataTable({ "destroy": true });
    tabla_servicios.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-servicios').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_servicios = $('#tabla-servicios').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/servicio/lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id','row_'+aData.id);
            setTimeout(function () {
            },300);
        },
    });
}