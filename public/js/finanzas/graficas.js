$(function () {
    $('body').on('change','#tipo_ingr_egre_util',function () {
        if($(this).val() == 'anual'){
            $('#meses-ingr-egre-util').addClass('d-none');
            $('#anios-ingr-egre-util').removeClass('d-none');
        }else{
            $('#anios-ingr-egre-util').addClass('d-none');
            $('#meses-ingr-egre-util').removeClass('d-none');
        }
    })
    $('body').on('change','#tipo_obj_ventas',function () {
        if($(this).val() == 'anual'){
            $('#meses-obj-ventas').addClass('d-none');
            $('#anios-obj-ventas').removeClass('d-none');
        }else{
            $('#anios-obj-ventas').addClass('d-none');
            $('#meses-obj-ventas').removeClass('d-none');
        }
    })

    $('body').on('click','#btn-generar-grafica-ingr-egre-util',function () {
        var element_load = $('#ingresos_egresos');
        abrirBlockUiElemento(element_load);
        var params = $('#form-ingr-egre-util').serialize();
        var url = $('#general_url').val()+'/finanzas/datos-grafica-ingresos-egresos-utilidades';
        $.post(url,params)
            .done(function (data) {
                if(data.success) {
                    cerrarBlockUiElemento(element_load);
                    graficaIngrEgrUtil(data.tipo, data.datos_grafica, 'ingresos_egresos');
                }else{
                    $(element_load).html('');
                    cerrarBlockUiElemento(element_load);
                    alert(data.mensaje);
                }
            })
    })
})

function graficaIngrEgrUtil(tipo,datos_grafica,id_contenedor){
    var datos = [];

    //var tipo = 'Mes';
    /*var datos_grafica = [
        {fecha:'ENERO - 2017', ingreso:5000000, egreso:3000000, utilidad:2000000},
        {fecha:'FEBRERO - 2017', ingreso:4650000, egreso:1700000, utilidad:2950000},
        {fecha:'MARZO - 2017', ingreso:3650000, egreso:5700000, utilidad:2950000},
    ];*/

    datos[0] = [tipo,'Ingresos', 'Egresos', 'Utilidad'];

    var index = 1;
    $.each(datos_grafica,function (i,el) {
        datos[index++] = [el.fecha, el.ingreso, el.egreso, el.utilidad];
    })

    var data = google.visualization.arrayToDataTable(datos);

    var options = {
        chart: {
            title: '',
            subtitle: '',
        },
        colors: ['#00bbc9', '#d95e55', '#1ab300'],
        height:400
    };
    var chart = new google.charts.Bar(document.getElementById(id_contenedor));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}