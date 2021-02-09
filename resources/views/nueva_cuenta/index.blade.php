@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Nueva cuenta DogCat</h3>
            {!! Form::open(['id'=>'form-nueva-cuenta','data-toggle'=>'validator']) !!}
                {!! Form::hidden('id',$id) !!}
                {!! Form::hidden('token',$token) !!}
                {!! Form::hidden('iniciar','true') !!}

                @include('layouts.alertas',['id_contenedor'=>'alertas-nueva-cuenta'])

                <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales</h4>
                <div class="row">
                    @include('nueva_cuenta.datos_personales')
                </div>
                <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos de ubicación</h4>
                <div class="row">
                    @include('nueva_cuenta.datos_ubicacion')
                </div>
                <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="md-form">
                            {!! Form::label('password','Contraseña (*)',['class'=>'control-label']) !!}
                            <input type="password" name="password" id="password" class="form-control" data-minlength="6" autocomplete="off">
                            <div class="help-block">Mínimo 6 caracteres</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="md-form">
                            {!! Form::label('password_confirm','Confirmación de contraseña (*)',['class'=>'control-label']) !!}
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" data-minlength="6" data-match="#password" data-minlength-error="Mínimo 6 caracteres" data-match-error="La confirmación no coincide" autocomplete="off">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-12 text-right margin-top-30">
                        <a href="#!" class="btn btn-success btn-submit" id="guardar-nueva-cuenta">Guardar</a>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/nueva_cuenta/nueva_cuenta.js')}}"></script>
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
                    maxFileSize : 500,
                }
            );
        })
    </script>
@endsection