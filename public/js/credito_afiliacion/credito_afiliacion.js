var solicitud = null;
var cols = [
    {data: 'afiliacion', name: 'afiliacion',"className": "text-center"},
    {data: 'estado_afiliacion', name: 'estado_afiliacion'},
    {data: 'cliente', name: 'cliente'},
    {data: 'telefono', name: 'telefono'},
    {data: 'valor_credito', name: 'valor_credito',"className": "text-center"},
    {data: 'valor_cuota', name: 'valor_cuota',"className": "text-center"},
    {data: 'cantidad_cuotas', name: 'cantidad_cuotas',"className": "text-center"},
    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
];

$(function () {
    cargarTablaCreditosAfiliacion();
})

function cargarTablaCreditosAfiliacion() {
    var tabla_creditos_afiliacion = $('#tabla-creditos-afiliacion').dataTable({ "destroy": true });
    tabla_creditos_afiliacion.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-creditos-afiliacion').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_creditos_afiliacion = $('#tabla-creditos-afiliacion').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/credito-afiliacion/lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },300);
        },
    });
}