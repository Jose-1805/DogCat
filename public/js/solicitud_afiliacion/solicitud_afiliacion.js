var solicitud = null;
var cols = [
    {data: 'created_at', name: 'created_at'},
    {data: 'estado', name: 'estado'},
    {data: 'usuario', name: 'usuario'},
    {data: 'asesor_asignado', name: 'asesor_asignado'},
    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
];

$(function () {


    $('body').on('click','.btn-asignar-solicitud',function () {
        solicitud = $(this).data('solicitud');
        $('#modal-asignar-solicitud').modal('show');
    })

    $('body').on('click','#btn-asignar-solicitud-ok',function () {
        if(solicitud){
            abrirBlockUiCargando();
            var url = $('#general_url').val()+'/solicitud-afiliacion/asignar';
            var params = {_token:$('#general_token').val(),'solicitud':solicitud,usuario:$('#usuario').val()};

            $.post(url,params,function (data) {
                cerrarBlockUiCargando();
                $('#modal-asignar-solicitud').modal('hide');
                abrirAlerta('alertas-solicitud-afiliacion','success',['La solicitud ha sido asignada con éxito'],null,'body');
                cargarTablaSolicitudesAfiliaciones();
            }).fail(function (jqXHR,error,state) {
                cerrarBlockUiCargando();
                $('#modal-asignar-solicitud').modal('hide');
                abrirAlerta('alertas-solicitud-afiliacion','danger',JSON.parse(jqXHR.responseText),null,'body');
            })
        }
    })

    $('.btn-nueva-solicitud-afiliacion').click(function () {
        $('#modal-solicitud-afiliacion').modal('show');
    })

    $('#btn-enviar-solicitud').click(function () {
        var url = $('#general_url').val()+'/solicitud-afiliacion/enviar';
        var params = {_token:$('#general_token').val()};
        abrirBlockUiCargando('Enviando solicitud');
        $.post(url,params)
            .done(function () {
                $('.contenedor-opciones-vista-fixed').eq(0).remove();
                $('#modal-solicitud-afiliacion').modal('hide');
                cargarTablaSolicitudesAfiliaciones();
                cerrarBlockUiCargando();
                abrirAlerta('alertas-solicitud-afiliacion','success',['La solicitud ha sido enviada con éxito, proximamente personal de DogCat se pondrá en contacto con usted.'],null,'body');
                setTimeout(function () {
                    $('#modal-solicitud-afiliacion').eq(0).remove();
                },500);
            });
    })
    
    cargarTablaSolicitudesAfiliaciones();
})

function cargarTablaSolicitudesAfiliaciones() {
    var tabla_solicitudes_afiliaciones = $('#tabla-solicitudes-afiliaciones').dataTable({ "destroy": true });
    tabla_solicitudes_afiliaciones.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-solicitudes-afiliaciones').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_solicitudes_afiliaciones = $('#tabla-solicitudes-afiliaciones').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/solicitud-afiliacion/lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },300);
        },
    });
}