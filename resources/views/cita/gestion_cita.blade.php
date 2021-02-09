<div class="col-12">
    <div class="row">
        <div class="col-12 no-padding">
            <p class="alert alert-warning"><strong>DogCat</strong> le recuerda que para visualizar los precios correctos de su servicio, el peso de la màscota debe estar actualizado en el sistema. De ser necesario, esta informaciòn serà verificada antes de prestar el servicio</p>
        </div>
        <div class="col-12 col-lg-3 no-padding border">
            <p class="text-center alertt alert-info bg-info white-text font-large mayuscula padding-10">{{$mascota->nombre}}</p>

            @php
                $imagen = $mascota->imagen;
            @endphp

            <div class="col-12">
                @if($imagen)
                    <div class="card" style="
                            margin: 0 auto;
                            border-radius: 50%;
                            height: 150px !important;
                            width:150px !important;
                            background-image: url({{$imagen->urlAlmacen()}});
                            background-size: auto 100%; background-repeat: no-repeat;background-position: center;"></div>
                @else
                    @if(strtolower($mascota->raza->tipoMascota->nombre) == 'perro')
                        <div class="card" style="
                                margin: 0 auto;
                                border-radius: 50%;
                                height: 150px !important;
                                width: 150px !important;
                                background-image: url({{\DogCat\Models\Imagen::urlSiluetaPerro()}});
                                background-size: auto 100%;
                                background-repeat: no-repeat;
                                background-position: center;
                                "></div>
                    @else
                        <div class="card" style="
                                margin: 0 auto;
                                border-radius: 50%;
                                height: 150px !important;
                                width: 150px !important;
                                background-image: url({{\DogCat\Models\Imagen::urlSiluetaGato()}});
                                background-size: auto 100%;
                                background-repeat: no-repeat;
                                background-position: center;
                                "></div>
                    @endif
                @endif
            </div>
            <p class="col-12 text-center font-medium margin-top-30 no-padding">{{$mascota->strDataEdad()}}</p>
            <p class="col-12 text-center font-medium no-padding text-info" style="margin-top: -15px;">{{$mascota->peso.' KG'}}</p>
            <p class="col-12 text-justify font-small">En el siguiente panel seleccione el servicio deseado y el personal que desea que atienda a su mascota, el sistema
            cargará más información que debe ir seleccionando paso a paso.</p>
        </div>
        <div class="col-12 col-lg-9 padding-top-20">
            <div class="row padding-10">
                {!! Form::open(['id'=>'form-gestion-cita','class'=>'col-12 no-padding']) !!}
                    <div class="row">
                        {!! Form::hidden('usuario_',$usuario->id) !!}
                        {!! Form::hidden('mascota',$mascota->id) !!}
                        {!! Form::hidden('fecha',null,['id'=>'fecha']) !!}
                        {!! Form::hidden('hora_inicio',null,['id'=>'hora_inicio']) !!}
                        {!! Form::hidden('minuto_inicio',null,['id'=>'minuto_inicio']) !!}
                        <div class="col-12 col-md-6">
                            <div class="md-form c-select">
                                {!! Form::label('servicio','Servicio',['class'=>'active']) !!}
                                <select id="servicio" name="servicio" class="form-control">
                                    <option selected>Seleccione un servicio</option>
                                    @foreach($servicios as $s)
                                        <option value="{{$s->id}}" data-paseador="{{$s->paseador}}">{{$s->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="md-form c-select">
                                {!! Form::label('encargado','Encargado',['class'=>'active']) !!}
                                <div id="contenedor-encargados">
                                    {!! Form::select('encargado',['Seleccione un encargado'],null,['id'=>'encargado','class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}

                <div class="col-12">
                    <div class="row">
                        <div class="col-12" id="contenedor-disponibilidades"></div>
                        <div class="col-12" id="contenedor-agenda"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>