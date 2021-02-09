<div class="row justify-content-center content-select-img" id="selector-imagenes">
{{--@for($i = 0;$i < 10;$i++)--}}
    @foreach($mascotas as $mascota)
        @php
            $imagen = $mascota->imagen;
        @endphp
        <div class="col-6 col-md-4 col-lg-3 padding-5">
            <div class="col-12 border hoverable cursor_pointer no-padding item-select-img" data-value="{{$mascota->id}}">
                @if($imagen)
                    <div class="col-12 view" style="height: 150px !important;background-image: url({{$imagen->urlAlmacen()}}); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                        <div class="mask cursor_pointer"></div>
                    </div>
                @else
                    @if(strtolower($mascota->raza->tipoMascota->nombre) == 'perro')
                        <div class="col-12 view" style="height: 150px !important;background-image: url({{\DogCat\Models\Imagen::urlSiluetaPerro()}}); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                            <div class="mask cursor_pointer"></div>
                        </div>
                    @else
                        <div class="col-12 view" style="height: 150px !important;background-image: url({{\DogCat\Models\Imagen::urlSiluetaGato()}}); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                            <div class="mask cursor_pointer"></div>
                        </div>
                    @endif
                @endif
                <p class="col-12 text-center font-small nombre_mascota">{{$mascota->raza->tipoMascota->nombre.': '.$mascota->nombre}}</p>
                <p class="col-12 text-center font-small" style="margin-top: -20px !important;">{{$mascota->strDataEdad()}}</p>
            </div>
        </div>
    @endforeach
{{--@endfor--}}
</div>