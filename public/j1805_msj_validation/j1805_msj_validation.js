/**
 * Created by jose1805 on 17/05/18.
 */
$(function () {
    $('body').on('focus','.input-validado *',function () {
        var parent = $(this).parent();
        var completo = false;
        while (!completo){
            if($(parent).hasClass('input-validado')){
                completo = true;
                $(parent).removeClass('input-validado');
                $(parent).removeClass('input-validado-danger');
                $(parent).find('.contenedor-mensaje-validacion').remove();
            }else{
                parent = $(parent).parent();
            }
        }
    })
})

/**
 * Funcion para mostrar las alertas del sistema
 * @param id_contenedor => contenedor de las alertas
 * @param tipo => info - success - warning - danger
 * @param data => array con la información
 * @param duracion => duracion en segundos
 * @param id_contenedor_scroll => id del contenedor que posee el scroll que debe quedar en top = 0
 */
function abrirAlerta(id_contenedor,tipo, data, duracion = null,id_contenedor_scroll = false){
    var html = "";
    $.each(data, function(key,value){
        html += "• "+value+"<br/>";
    });
    $("#"+id_contenedor+" .alert").addClass("d-none");
    $("#"+id_contenedor+" .alert-"+tipo+" .mensaje").html(html);
    $("#"+id_contenedor+" .alert-"+tipo).removeClass("d-none");

    if(duracion != null && $.isNumeric(duracion)){
        setTimeout(function () {
            $("#"+id_contenedor+" .alert-"+tipo).addClass("d-none");
        },(duracion*1000));
    }

    if(id_contenedor_scroll != false) {
        //$("#" + id_contenedor_scroll).stop().animate({scrollTop: 0}, '5000', 'swing');
        //$("#" + id_contenedor_scroll).scrollTop(0);
        $('html, body').stop().animate({scrollTop: 0}, '500', 'swing');
    }
}

/**
 * Funcion para mostrar las alertas del sistema
 * @param id_contenedor => contenedor de las alertas
 * @param tipo => info - success - warning - danger
 * @param data => array con la información
 * @param duracion => duracion en segundos
 * @param id_contenedor_scroll => id del contenedor que posee el scroll que debe quedar en top = 0
 */
function abrirMensajesValidacion(id_contenedor,tipo, data){

    $.each(data, function(key,value){
        var html = "";
        $.each(value,function (key_,value_) {
            html += "• "+value+"<br/>";
        })
        var parent = $('#'+id_contenedor).find('#'+key).parent();
        html = "<div class='contenedor-mensaje-validacion font-small text-"+tipo+"' style='margin-top: -10px;'>"+html+"</div>";
        $(parent).find('.contenedor-mensaje-validacion').remove();
        $(parent).append(html)
        $(parent).addClass('input-validado');
        $(parent).addClass('input-validado-'+tipo);
    });

    $('html, body').stop().animate({scrollTop: 0}, '500', 'swing');
}