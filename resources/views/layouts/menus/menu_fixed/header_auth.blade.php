@php($imagen_perfil = Auth::user()->imagenPerfil)
@php($mascotas = Auth::user()->mascotas)
@if($imagen_perfil)
    <div class="contenedor-icono-usuario d-none d-md-flex align-items-center justify-content-center">
        <i class="fas fa-user fa-3x"></i>
    </div>
@else
    <div class="d-none d-md-flex align-items-center justify-content-center padding-left-30 padding-right-30 padding-top-20 padding-bottom-10">
        <div class="col-6 col-md-10">
            <img src="{{asset('imagenes/sistema/dogcat_md.png')}}" class="img-fluid">
        </div>
    </div>
@endif
<h3 class="d-md-none col-12 text-center">
    <span class="font-weight-bold teal-text text-lighten-3">DOG</span>
    <span class="font-weight-bold white-text">CAT</span>
</h3>

<div class="dropdown text-center margin-top-10">
    <a href="#" class="dropdown-toggle white-text" data-toggle="dropdown" role="button" aria-expanded="false">
        @if(strlen(Auth::user()->nombres." ".Auth::user()->apellidos) > 20)
            @if(strlen(Auth::user()->nombres." ".substr(Auth::user()->apellidos,0,1)) > 20)
                @if(strlen(Auth::user()->nombres) > 20)
                    {{ substr(Auth::user()->nombres,0,15)}}... <span class="caret"></span>
                @else
                    {{ Auth::user()->nombres}} <span class="caret"></span>
                @endif
            @else
                {{ Auth::user()->nombres." ".substr(Auth::user()->apellidos,0,1)}}. <span class="caret"></span>
            @endif
        @else
            {{ Auth::user()->nombres." ".Auth::user()->apellidos}} <span class="caret"></span>
        @endif
    </a>

    <div id="dropdown-menu-user" class="dropdown-menu hoverable" style="margin-top: 10px;" role="menu">
        <a class="dropdown-item" data-toggle="modal" data-target="#modal-cambiar-contrasena"><i class="fas fa-key margin-right-10"></i> Cambiar contraseña</a>
    </div>
</div>

<div class="contenedor-mascotas-menu d-flex justify-content-center">
    @foreach($mascotas as $m)

        <a href="{{url('/mascota/'.$m->id)}}">
            <div class="mascota-menu white d-flex justify-content-center" data-toggle="tooltip" data-placement="bottom" title="{{$m->nombre}}" style="
                @if($m->imagen)
                    background-image:url({{url('/almacen/'.str_replace('/','-',$m->imagen->ubicacion).'-'.$m->imagen->nombre)}});
                @else
                    @if(strtolower($m->raza->tipoMascota->nombre) == 'perro')
                            background-image: url({{\DogCat\Models\Imagen::urlSiluetaPerro()}});
                    @else
                        background-image: url({{\DogCat\Models\Imagen::urlSiluetaGato()}});
                    @endif
                @endif
                background-repeat: no-repeat;
                background-position: center;
                background-size: auto 100%;
                ">
            </div>
        </a>
    @endforeach
</div>