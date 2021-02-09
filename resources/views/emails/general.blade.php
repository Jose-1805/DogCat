@component('mail::message')
<h1 class="text-center">{{$correo->titulo}}</h1>

{!! $correo->mensaje !!}

@if($correo->boton == 'si')
@component('mail::button', ['url' => $correo->url_boton,'color'=>'blue'])
{!! $correo->texto_boton !!}
@endcomponent
@endif

@endcomponent
