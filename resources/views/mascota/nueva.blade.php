@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        {!! Form::open(['id'=>'form-crear-mascota','data-toggle'=>'validator']) !!}
            <div class="row">
                <div class="row contenedor-toggle-render" id="datos-basicos">
                    <div class="col-12">
                        <h3 class="titulo_principal margin-bottom-20 margin-top-20 col-12 no-padding">Nueva mascota </h3>
                        @include('layouts.alertas',['id_contenedor'=>'alertas-nueva-mascota'])
                        <div class="alert col-12 alert-warning" role="alert">
                            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                            Toda la información suministrada debe ser verídica, los datos ingresados serán verificados en el momento de revisar las afiliaciones de la mascota
                        </div>

                        <div class="col-12">
                            @include('mascota.forms.datos_basicos')
                        </div>

                        @if(isset($asistido) && $asistido)
                            {!! Form::hidden('asistido',1,['id'=>'asistido']) !!}
                            <div class="col-12 text-right margin-top-30 no-padding">
                                <a href="#!" class="btn btn-default /*btn-submit*/ btn-guardar-seguir-agregando guardar-mascota">Guardar y seguir agregando</a>
                                <a href="#!" class="btn btn-success /*btn-submit*/ guardar-mascota">Guardar y continuar</a>
                            </div>
                        @else
                            <div class="col-12 text-right margin-top-30 no-padding">
                                <a href="#!" class="btn btn-success /*btn-submit*/ guardar-mascota">Guardar</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

@endsection

@section('js')
    @parent
    <script src="{{asset('js/mascota/nueva.js')}}"></script>
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
                }
            );

            razas_perros = JSON.parse('{{$razas_perros}}'.replace(/(&quot\;)/g,"\""));
            razas_gatos = JSON.parse('{{$razas_gatos}}'.replace(/(&quot\;)/g,"\""));
        })
    </script>
@stop