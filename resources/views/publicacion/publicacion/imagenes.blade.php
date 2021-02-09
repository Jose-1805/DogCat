<?php
    $imagen_principal = $publicacion->imagenPrincipal();
    $imagenes = $publicacion->imagenes()->where('imagenes_publicaciones.principal','no')->get();
?>

@if($imagen_principal)
    <a class="col-12" href="{{url('publicacion/imagen/'.$publicacion->id.'/'.$imagen_principal->nombre.'/1')}}" data-toggle="lightbox" data-type="image">
        <div class="row hoverable no-margin" style="width:100%;min-height: 300px;max-height: 300px;background: url('{{url('publicacion/imagen/'.$publicacion->id.'/'.$imagen_principal->nombre.'/1')}}') no-repeat right top;background-size: 100% auto; border-radius: 5px;margin-top: -15px !important;border: 1px #e7e7e7 solid;"></div>
        @if(count($imagenes))
            <a href="{{url('publicacion/imagen/'.$publicacion->id.'/'.$imagen_principal->nombre.'/1')}}" class="btn btn-circle btn-primary right margin-right-10" style="margin-top: -40px !important; position: relative;" data-title="<a class='teal-text text-lighten-1'>{{$publicacion->usuario->nombres.' '.$publicacion->usuario->apellidos}}</a>" @if($publicacion->publicacion) data-footer="{{$publicacion->publicacion}}" @endif data-toggle="lightbox" data-type="image" data-gallery="gallery-{{$publicacion->id}}"><i class="fa fa-images white-text"></i></a>
        @endif
    </a>
@endif

@if(count($imagenes))
    @foreach($imagenes as $img)
        <div data-toggle="lightbox" data-type="image" data-gallery="gallery-{{$publicacion->id}}" data-remote="{{url('publicacion/imagen/'.$publicacion->id.'/'.$img->nombre.'/0')}}" data-title="<a class='teal-text text-lighten-1'>{{$publicacion->usuario->nombres.' '.$publicacion->usuario->apellidos}}</a>" @if($publicacion->publicacion) data-footer="{{$publicacion->publicacion}}" @endif></div>
    @endforeach
@endif