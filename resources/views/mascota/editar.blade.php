@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        {!! Form::model($mascota,['id'=>'form-editar-mascota','data-toggle'=>'validator']) !!}
            {!! Form::hidden('mascota',$mascota->id,['id'=>'mascota']) !!}
            <div class="row">

                <div class="row contenedor-datos-mascota" id="datos-basicos">
                    <div class="col-12">
                        <h3 class="titulo_principal margin-bottom-20 margin-top-20 col-12 no-padding">Editar mascota - Datos básicos</h3>
                        @include('layouts.alertas',['id_contenedor'=>'alertas-editar-mascota'])

                        <div class="col-12">
                            @include('mascota.forms.datos_basicos')

                            <div class="col-12 text-right margin-top-30">
                                @if($mascota->validado == 'no')
                                    @if(Auth::user()->tieneFuncion($identificador_modulo, 'validar', $privilegio_superadministrador))
                                        <a data-mascota='{{$mascota->id}}' href='#!' class='btn btn-primary btn-validar'>Validar</a>
                                    @endif
                                @elseif($mascota->validado == 'si' && $mascota->informacion_validada == 'no')
                                    @if(Auth::user()->tieneFuncion($identificador_modulo, 'validar informacion', $privilegio_superadministrador))
                                        <a data-mascota='{{$mascota->id}}' href='#!' class='btn btn-primary btn-validar-informacion'>Validar información</a>
                                    @endif
                                @endif

                                @if($mascota->informacion_validada == 'si' && Auth::user()->tieneFuncion($identificador_modulo, 'ver_revision', $privilegio_superadministrador))
                                    <a href="{{url('/mascota/revision/'.$mascota->id)}}" class="btn btn-primary">Revisiones</a>
                                @endif
                                <a href="#!" class="btn btn-success /*btn-submit*/" id="guardar-mascota">Guardar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="modal-validar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Validar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Validar la mascota habilitará la asociación de la mascota a una afiliación e inhabilitará
                        alguna información de la mascota en su edición (para personal diferente a DOGCAT).</p>
                    <p>¿Está seguro de validar esta mascota?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btn-submit" id="btn-validar-ok">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-validar-informacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Validar información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Validar la información de la mascota inhabilitará
                        la edición de algunos datos para todos los usuarios.</p>
                    <p>¿Está seguro de validar la información de esta mascota?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btn-submit" id="btn-validar-informacion-ok">Si</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent
    <script src="{{asset('js/mascota/editar.js')}}"></script>
    <script>
        $(function () {
            $("#imagen").fileinput(
                {
                    previewSettings: {
                        image:{width:"auto", height:"160px"},
                    },
                    allowedFileTypes:['image'],
                    AllowedFileExtensions:['jpg','jpeg','png'],
                    removeFromPreviewOnError:true,
                    showCaption: false,
                    showUpload: false,
                    showClose:false,
                    maxFileSize : {{config('params.maximo_peso_archivos')}},
                    initialPreview: [
                        @if($mascota->imagen)
                            "<img src='{{url('/almacen/'.str_replace('/','-',$mascota->imagen->ubicacion).'-'.$mascota->imagen->nombre)}}' class='col-12'>",
                        @endif
                    ]
                }
            );

            razas_perros = JSON.parse('{{$razas_perros}}'.replace(/(&quot\;)/g,"\""));
            razas_gatos = JSON.parse('{{$razas_gatos}}'.replace(/(&quot\;)/g,"\""));

            var tipo_mascota = $('#tipo_mascota').val();
            //$('#fecha_nacimiento').val('{{date('Y-m-d',strtotime('+1days',strtotime($mascota->fecha_nacimiento)))}}');
            cargarFormVacunas(tipo_mascota);
        })
    </script>
@stop
