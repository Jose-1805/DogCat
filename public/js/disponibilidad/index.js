var disponibilidad_seleccionada = null;
$(function () {
    $('#btn-buscar-disponibilidad').click(function () {
        var params = $('#form-disponibilidad').serialize();
        var url = $('#general_url').val()+'/disponibilidad/lista';
        var element_load = $('#contenedor-disponibilidad');
        abrirBlockUiElemento(element_load,'Consultando ');
        $.post(url,params)
            .done(function (data) {
                $(element_load).html(data);
                $('#contenedor-disponibilidad').parent().removeClass('teal lighten-5');
                cerrarBlockUiElemento(element_load);
            }).fail(function (jqXHR,state,error) {
                cerrarBlockUiElemento(element_load);
                abrirAlerta('alertas-disponibilidad','danger',JSON.parse(jqXHR.responseText));
            })
    })

    $('#btn-asignar').click(function () {
        if($('.check-fecha:checked').length > 0) {
            $('#modal-registro-disponibilidades').modal('show');
        }else{
            abrirAlerta('alertas-disponibilidad','danger',['Para registrar disponibilidades seleccione por lo menos una fecha.']);
        }
    })

    $('body').on('click','#btn-guardar-disponibilidad',function () {
        var params = $('#form-disponibilidades').serialize();
        var url = $('#general_url').val()+'/disponibilidad/guardar';
        abrirBlockUiCargando('Guardando ');
        $.post(url,params)
            .done(function (data) {
                if(data.success){
                    abrirAlerta('alertas-disponibilidad','success',['Disponibilidad registrada con éxito.']);
                    $('#modal-registro-disponibilidades').modal('hide');
                    cerrarBlockUiCargando();
                    setTimeout(function () {
                        $('#btn-buscar-disponibilidad').click();
                    },200);
                }else{
                    window.location.reload();
                }
            }).fail(function (jqXHR,state,error) {
                cerrarBlockUiCargando();
                $('#modal-registro-disponibilidades').modal('hide');
                abrirAlerta('alertas-disponibilidad','danger',JSON.parse(jqXHR.responseText));
            })
    })

    $('body').on('click','.btn-borrar-disponibilidad',function () {
        disponibilidad_seleccionada = $(this).data('disponibilidad');
        $('#modal-eliminar-disponibilidad').modal('show');
    })

    $('#btn-borrar-disponibilidad-ok').click(function () {
        var params = {_token:$('#general_token').val(),disponibilidad:disponibilidad_seleccionada};
        var url = $('#general_url').val()+'/disponibilidad/eliminar';
        abrirBlockUiCargando('Eliminando ');
        $.post(url,params)
            .done(function (data) {
                if(data.success){
                    abrirAlerta('alertas-disponibilidad','success',['Disponibilidad eliminada con éxito.']);
                    $('#modal-eliminar-disponibilidad').modal('hide');
                    cerrarBlockUiCargando();
                    setTimeout(function () {
                        $('#btn-buscar-disponibilidad').click();
                    },200);
                }else{
                    window.location.reload();
                }
            }).fail(function (jqXHR,state,error) {
                cerrarBlockUiCargando();
                $('#modal-eliminar-disponibilidad').modal('hide');
                abrirAlerta('alertas-disponibilidad','danger',JSON.parse(jqXHR.responseText));
            })
    })

    /*var tour = new Tour({
        steps: [
            {
                element: "#usuario",
                title: "Seleccione un usuario",
                content: "Content of my step"
            }
        ],
        backdrop: true,
    });

    tour.addStep({
        element: "#contenedor-fecha-inicio",
        placement: "right",
        title: "Ingrese la fecha de inicio",
        content: "Fecha",
        next: 2,
        prev: 0,
        backdrop: false,
    });

    tour.addStep({
        element: "#contenedor-fecha-fin",
        placement: "right",
        title: "Ingrese la fecha de fin",
        content: "Fecha",
        next: 3,
        prev: 1,
        backdrop: false,
    });

    tour.addStep({
        element: "#btn-buscar-disponibilidad",
        placement: "bottom",
        title: "Click para buscar",
        content: "Click",
        //next: 0,
        prev: 2,
        backdrop: true,
    });

    // Initialize the tour
    tour.init();

    // Start the tour
    tour.start();*/
})