/**
 * Created by jose1805 on 17/05/18.
 */
//cada cuanto se debe hacer un moviemiento
var moviemiento_segundos = 3;
$(function () {
    calcularWidth();

    setInterval(function () {
        calcularWidth();
        $('.j1805-slide-contenedor').each(function (i,el) {
            var padre = $(el).parent();
            if($(el).width() > $(padre).width()) {
                var inicio_pantalla = $(document).scrollTop();
                var fin_pantalla = inicio_pantalla + window.innerHeight;

                var posicion = $(padre).offset().top;
                var altura = $(padre).innerHeight();
                if(
                    (posicion >= inicio_pantalla && posicion <= fin_pantalla) //la parte inicial del elemento esta dentro de la pantalla
                    || (posicion + altura >= inicio_pantalla && posicion + altura <= fin_pantalla) //la parte final del elemento esta dentro de la pantalla
                    || (posicion <= inicio_pantalla && posicion + altura >= fin_pantalla) //El elemento es más grande que la pantalla pero esta visible una parte
                )
                moverSlide($(el));
            }
        })
    },moviemiento_segundos*1000);
})

/**
 * Calcula el ancho que debe tener cada contenedor de acuerdo a sus items
 */
function calcularWidth() {
    $('.j1805-slide-contenedor').each(function (i,el) {
        var width = 0;
        $(el).children('.j1805-slide-item').each(function (index,elem) {
            width += $(elem).width()+4;
        })
        $(el).css({width:width+'px'});
    })
}

/**
 * Realiza el movimiento de un slide
 * @param contenedor
 */
function moverSlide(contenedor) {
    var primer_elemento = $(contenedor).children('.j1805-slide-item').eq(0);
    var left_inicial = $(contenedor).css('marginLeft');
    if(typeof left_inicial == 'undefined')
        left_inicial = 0;
    else
        left_inicial = left_inicial.replace('px','');

    var left = left_inicial - ($(primer_elemento).width());

    //se corre el contenedor a la izquierda
    //la cantidad de pixeles del primer elemento encontrado en el
    $(contenedor).css({
        marginLeft:(left)+'px'
    })

    setTimeout(function () {
        //el primer elemento ahora pasa a estar al final
        $(primer_elemento).appendTo(contenedor);
        //se quita la clase para efectuar cambios css sin animacion
        $(contenedor).removeClass('j1805-slide-contenedor');
        //se ubica el contenedor en si posicion inicial
        $(contenedor).css({
            marginLeft:(left_inicial)+'px',
        });
        setTimeout(function () {
            //se agrega nuevamente la clase
            $(contenedor).addClass('j1805-slide-contenedor');
        },50);
    },750);

}
//moverSlide($('.j1805-slide-contenedor').eq(0))