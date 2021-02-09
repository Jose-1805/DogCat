<div class="col-12 no-padding publicacion-item" style="border-top: 1px solid #26a6b1;" data-publicacion="{{$publicacion->id}}">
    @include('publicacion.publicacion.encabezado')
    @include('publicacion.publicacion.imagenes')


    <div class="col-12 padding-10 no-margin info-publicacion" id="p-{{$publicacion->id}}" data-publicacion="{{$publicacion->id}}" style="margin-top: 0px !important;">
        @if($publicacion->publicacion)
        <p class="col-12 no-padding margin-top-10 font-small">
            {{$publicacion->publicacion}}
        </p>
        @endif

        <div class="contenedor-likes">
            @include('publicacion.publicacion.likes')
        </div>
        <div class="contenedor-comentarios">
            @include('publicacion.publicacion.comentarios')
        </div>
    </div>
</div>