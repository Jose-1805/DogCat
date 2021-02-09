$(function () {
    $('.btn-filter-colums-table').each(function (i,el) {
        inicializarFiltros(el)
    })
    
    $('body').on('change','.check-filter-colums-table',function () {

        var tabla = $(this).parent().parent().parent().find('.btn-filter-colums-table').eq(0).data('tabla');
        tabla = $('#'+tabla);
        if($(this).prop('checked')){
            mostrarColumna(tabla,$(this).val());
        }else{
            ocultarColumna(tabla,$(this).val());
        }
    })

    $('.tabla-filter-colums-table').on('draw.dt', function () {
        mostrarOcultarColumnas($(this));
    });
})

function inicializarFiltros(el) {
    var id_tabla = $(el).data('tabla');
    var tabla = $('#'+id_tabla);

    $(tabla).find('thead th').each(function (i,elem) {
        var checked = 'checked';
        if($(elem).hasClass('filter-column-no-render'))checked = '';
        var html = '<div class="form-check">'
                    +'<input type="checkbox" id="'+id_tabla+i+'" class="form-check-input check-filter-colums-table" value="'+i+'" '+checked+'>'
                    +'<label class="form-check-label" for="'+id_tabla+i+'">'+$(elem).html()+'</label>'
                +'</div>';
        $(el).parent().find('.dropdown-menu').eq(0).append(html);
    })
}

function ocultarColumna(tabla,indice) {
    $(tabla).find('tr').each(function(i,el){
        $(el).find('td').eq(indice).addClass('d-none');
        $(el).find('th').eq(indice).addClass('d-none');
    });
}

function mostrarColumna(tabla,indice) {
    $(tabla).find('tr').each(function(i,el){
        $(el).find('td').eq(indice).removeClass('d-none');
        $(el).find('th').eq(indice).removeClass('d-none');
    });
}

function mostrarOcultarColumnas(tabla) {
    var btn_filter = $('.btn-filter-colums-table[data-tabla="'+$(tabla).attr('id')+'"]').eq(0);

    $(btn_filter).parent().find('.dropdown-menu .form-check .check-filter-colums-table').each(function (i,el) {
        if($(el).prop('checked')){
            mostrarColumna(tabla,$(this).val());
        }else{
            ocultarColumna(tabla,$(this).val());
        }
    })
}