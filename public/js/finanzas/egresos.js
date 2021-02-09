var cols_egresos = [
    {data: 'fecha', name: 'fecha',"className": "text-center"},
    {data: 'tipo', name: 'tipo'},
    {data: 'descripcion', name: 'descripcion'},
    {data: 'valor', name: 'valor',"className": "text-center"},
    {data: 'numero_factura', name: 'numero_factura',"className": "text-center"},
    {data: 'evidencia', name: 'evidencia',"className": "text-center"},
    {data: 'usuario', name: 'usuario'}
];

$(function () {
    cargarTablaEgresos();

    $('body').on('change','.filtro-egresos',function () {
        cargarTablaEgresos();
    })

    $('body').on('click','#btn-nuevo-egreso',function () {
        $('#modal-nuevo-egreso').modal('show');
    })

    $('body').on('click','#btn-guardar-egreso',function () {
        $('#modal-nuevo-egreso').modal('hide');
        setTimeout(function () {
            $('#modal-confirmacion-egreso').modal('show');
        },500);
    })

    $('body').on('click','#btn-guardar-egreso-no',function () {
        $('#modal-confirmacion-egreso').modal('hide');
        setTimeout(function () {
            $('#modal-nuevo-egreso').modal('show');
        },500);
    })

    $('body').on('click','#btn-guardar-egreso-ok',function () {
        $('#modal-confirmacion-egreso').modal('hide');
        setTimeout(function () {
            $('#modal-nuevo-egreso').modal('show');
        },500);
        guardarEgreso();
    })
})

function cargarTablaEgresos(){
    var tabla_egresos = $('#tabla-egresos').dataTable({ "destroy": true });
    tabla_egresos.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-egresos').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_egresos.on('preXhr.dt', function (e,settings,data) {
        data.desde = $('#egresos_desde').val();
        data.hasta = $('#egresos_hasta').val();
        data.tipo = $('#egresos_tipo').val();
    })

    tabla_egresos = $('#tabla-egresos').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/finanzas/lista-egresos",
        columns: cols_egresos,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },500);
        },
    });
}

function guardarEgreso() {

    var params = new FormData(document.getElementById('form-nuevo-egreso'));
    var url = $('#general_url').val()+'/finanzas/nuevo-egreso';

    abrirBlockUiCargando('Guardando egreso ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            $("#form-nuevo-egreso")[0].reset();
            abrirAlerta("alertas-nuevo-egreso","success",['Egreso registrado con éxito'],null,'body');
            cerrarBlockUiCargando();
            cargarTablaEgresos();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta('alertas-nuevo-egreso','danger',JSON.parse(jqXHR.responseText),null,'body');
            cerrarBlockUiCargando();
        }
    });
}