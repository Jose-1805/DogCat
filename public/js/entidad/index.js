var cols = null;
var veterinaria = null;
$(function () {
    $('body').on('click','.btn-desactivar-veterinaria',function () {
        veterinaria = $(this).data('veterinaria');
        $('#modal-desactivar-veterinaria').modal('show');
    })
    $('body').on('click','.btn-activar-veterinaria',function () {
        veterinaria = $(this).data('veterinaria');
        $('#modal-activar-veterinaria').modal('show');
    })
    
    $('#btn-activar').click(function () {
        if(veterinaria != null)
            activar();
    })

    $('#btn-desactivar').click(function () {
        if(veterinaria != null)
            desactivar();
    })
})

function activar() {
    var params = {_token:$('#general_token').val(),veterinaria:veterinaria};
    var url = $('#general_url').val()+'/entidad/activar';
    abrirBlockUiCargando('Activando ');
    $.post(url,params)
        .done(function (data) {
            if(data.success){
                $('#modal-activar-veterinaria').modal('hide');
                veterinaria = null;
                cerrarBlockUiCargando();
                abrirAlerta('alertas-veterinarias','success',['La entidad ha sido activada con éxito'],null,'body');
                cargarTablaVeterinarias();
            }
        }).fail(function (jqXHR,state,error) {
            $('#modal-activar-veterinaria').modal('hide');
            veterinaria = null;
            cerrarBlockUiCargando();
            abrirAlerta('alertas-veterinarias','danger',JSON.parse(jqXHR.responseText),null,'body');
        })
}

function desactivar() {
    var params = {_token:$('#general_token').val(),veterinaria:veterinaria};
    var url = $('#general_url').val()+'/entidad/desactivar';
    abrirBlockUiCargando('Desctivando ');
    $.post(url,params)
        .done(function (data) {
            if(data.success){
                $('#modal-desactivar-veterinaria').modal('hide');
                veterinaria = null;
                cerrarBlockUiCargando();
                abrirAlerta('alertas-veterinarias','success',['La entidad ha sido desactivada con éxito'],null,'body');
                cargarTablaVeterinarias();
            }
        }).fail(function (jqXHR,state,error) {
            $('#modal-desactivar-veterinaria').modal('hide');
            veterinaria = null;
            cerrarBlockUiCargando();
            abrirAlerta('alertas-veterinarias','danger',JSON.parse(jqXHR.responseText),null,'body');
        })
}

function setCols(cols) {
    this.cols = cols;
}

function cargarTablaVeterinarias() {
    var tabla_veterinarias = $('#tabla-veterinarias').dataTable({ "destroy": true });
    tabla_veterinarias.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla-veterinarias').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    tabla_veterinarias = $('#tabla-veterinarias').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $("#general_url").val()+"/entidad/lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            setTimeout(function () {
                inicializarComplementos();
            },300);
        },
    });
}