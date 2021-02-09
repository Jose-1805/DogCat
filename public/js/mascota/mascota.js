var cols = null;
var mascota_seleccionada = null;
$(function () {
    $('.lista-mascotas').on('click','li',function () {
        $('.lista-mascotas li').removeClass('list-group-item-info');
        $(this).addClass('list-group-item-info');

        var id = $(this).data('m');
        $('#contenedor-mascotas div .info-mascota').addClass('d-none');
        $('#m-'+id).removeClass('d-none');
    })

    $('body').on('click','.btn-validar',function () {
        mascota_seleccionada = $(this).data('mascota');
        $('#modal-validar').modal('show');
    })
    
    $('#btn-validar-ok').click(function () {
        if(mascota_seleccionada){
            var params = {_token:$('#general_token').val(),mascota:mascota_seleccionada};
            var url = $('#general_url').val()+'/mascota/validar';
            abrirBlockUiCargando('Validando mascota ');
            $.post(url,params)
                .done(function () {
                    abrirAlerta('alertas-mascotas','success',['Mascota validada con éxito']);
                    cargarTablaMascotas();
                    $('#modal-validar').modal('hide');
                    cerrarBlockUiCargando();
                })
                .fail(function (jqXHR,error,state) {
                    abrirAlerta('alertas-mascotas','danger',['Ocurrio un error inesperado, recargue la pàgina e intente nuevamente']);
                    $('#modal-validar').modal('hide');
                    cerrarBlockUiCargando();
                })
            mascota_seleccionada = null;
        }
    })

    $('body').on('click','.btn-validar-informacion',function () {
        mascota_seleccionada = $(this).data('mascota');
        $('#modal-validar-informacion').modal('show');
    })

    $('#btn-validar-informacion-ok').click(function () {
        if(mascota_seleccionada){
            var params = {_token:$('#general_token').val(),mascota:mascota_seleccionada};
            var url = $('#general_url').val()+'/mascota/validar-informacion';
            abrirBlockUiCargando('Validando información ');
            $.post(url,params)
                .done(function () {
                    abrirAlerta('alertas-mascotas','success',['Información de la mascota validada con éxito']);
                    cargarTablaMascotas();
                    $('#modal-validar-informacion').modal('hide');
                    cerrarBlockUiCargando();
                })
                .fail(function (jqXHR,error,state) {
                    abrirAlerta('alertas-mascotas','danger',['Ocurrio un error inesperado, recargue la pàgina e intente nuevamente']);
                    $('#modal-validar-informacion').modal('hide');
                    cerrarBlockUiCargando();
                })
            mascota_seleccionada = null;
        }
    })
})

function setCols(cols) {
    this.cols = cols;
}

function cargarTablaMascotas() {
    var tabla_mascotas = $('#tabla-mascotas').dataTable({ "destroy": true });
    tabla_mascotas.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-mascotas').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_mascotas = $('#tabla-mascotas').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/mascota/lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },300);
        },
    });
}