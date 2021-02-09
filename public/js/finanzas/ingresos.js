var cols_ingresos = [
    {data: 'fecha', name: 'fecha',"className": "text-center"},
    {data: 'valor', name: 'valor',"className": "text-center"},
    {data: 'numero_factura', name: 'numero_factura',"className": "text-center"},
    {data: 'fuente', name: 'fuente',"className": "text-center"},
    {data: 'detalle_fuente', name: 'detalle_fuente'},
    {data: 'medio_pago', name: 'medio_pago',"className": "text-center"},
    {data: 'codigo_verificacion', name: 'codigo_verificacion',"className": "text-center"},
    {data: 'evidencia', name: 'evidencia',"className": "text-center"},
    {data: 'usuario', name: 'usuario'},
];

$(function () {
    cargarTablaIngresos();

    $('body').on('change','.filtro-ingresos',function () {
        cargarTablaIngresos();
    })

    $('body').on('click','#btn-nuevo-ingreso',function () {
        $('#modal-nuevo-ingreso').modal('show');
    })

    $('body').on('click','#btn-guardar-ingreso',function () {
        $('#modal-nuevo-ingreso').modal('hide');
        setTimeout(function () {
            $('#modal-confirmacion-ingreso').modal('show');
        },500);
    })

    $('body').on('click','#btn-guardar-ingreso-no',function () {
        $('#modal-confirmacion-ingreso').modal('hide');
        setTimeout(function () {
            $('#modal-nuevo-ingreso').modal('show');
        },500);
    })

    $('body').on('click','#btn-guardar-ingreso-ok',function () {
        $('#modal-confirmacion-ingreso').modal('hide');
        setTimeout(function () {
            $('#modal-nuevo-ingreso').modal('show');
        },500);
        guardarIngreso();
    })
})

function cargarTablaIngresos(){
    var tabla_ingresos = $('#tabla-ingresos').dataTable({ "destroy": true });
    tabla_ingresos.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-ingresos').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_ingresos.on('preXhr.dt', function (e,settings,data) {
        data.desde = $('#ingresos_desde').val();
        data.hasta = $('#ingresos_hasta').val();
        data.fuente = $('#ingresos_fuente').val();
        data.medio_pago = $('#ingresos_medio_pago').val();
    })

    tabla_ingresos = $('#tabla-ingresos').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/finanzas/lista-ingresos",
        columns: cols_ingresos,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },500);
        },
    });
}

function guardarIngreso() {

    var params = new FormData(document.getElementById('form-nuevo-ingreso'));
    var url = $('#general_url').val()+'/finanzas/nuevo-ingreso';

    abrirBlockUiCargando('Guardando ingreso ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            $("#form-nuevo-ingreso")[0].reset();
            abrirAlerta("alertas-nuevo-ingreso","success",['Ingreso registrado con éxito'],null,'body');
            cerrarBlockUiCargando();
            cargarTablaIngresos();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta('alertas-nuevo-ingreso','danger',JSON.parse(jqXHR.responseText),null,'body');
            cerrarBlockUiCargando();
        }
    });
}