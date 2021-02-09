@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Nueva cuenta veterinaria DogCat</h3>
            {!! Form::open(['id'=>'form-nueva-cuenta-veterinaria','data-toggle'=>'validator']) !!}
                {!! Form::hidden('id',$id) !!}
                {!! Form::hidden('token',$token) !!}
                {!! Form::hidden('iniciar','true') !!}

                @include('layouts.alertas',['id_contenedor'=>'alertas-nueva-cuenta-veterinaria'])

                <div class="contenedor-toggle-render col-12" id="datos_basicos_veterinaria">
                    <div class="row">
                        <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos básicos - veterinaria</h4>
                        <div class="col-12 padding-bottom-30">
                            @include('nueva_cuenta_veterinaria.navegacion',['except'=>['datos_basicos_veterinaria']])
                        </div>
                        @include('nueva_cuenta_veterinaria.datos_basicos_veterinaria')
                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="ubicacion_veterinaria">
                    <div class="row">
                        <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - veterinaria</h4>
                        <div class="col-12 padding-bottom-30">
                            @include('nueva_cuenta_veterinaria.navegacion',['except'=>['ubicacion_veterinaria']])
                        </div>
                        @include('nueva_cuenta_veterinaria.datos_ubicacion_veterinaria')
                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_basicos_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="datos_personales_administrador">
                    <div class="row">
                        <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales - administrador</h4>
                        <div class="col-12 padding-bottom-30">
                            @include('nueva_cuenta_veterinaria.navegacion',['except'=>['datos_personales_administrador']])
                        </div>
                        @include('nueva_cuenta_veterinaria.datos_personales_administrador')

                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="datos_ubicacion_administrador">
                    <div class="row">
                        <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - administrador</h4>
                        <div class="col-12 padding-bottom-30">
                            @include('nueva_cuenta_veterinaria.navegacion',['except'=>['datos_ubicacion_administrador']])
                        </div>
                        @include('nueva_cuenta_veterinaria.datos_ubicacion_administrador')
                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="seguridad_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="seguridad_administrador">
                    <div class="row">
                        <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad - administrador</h4>
                        <div class="col-12 padding-bottom-30">
                            @include('nueva_cuenta_veterinaria.navegacion',['except'=>['seguridad_administrador']])
                        </div>
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
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-success btn-submit" id="guardar-nueva-cuenta-veterinaria">Guardar</a>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/nueva_cuenta_veterinaria/nueva_cuenta_veterinaria.js')}}"></script>
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
            $("#logo").fileinput(
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