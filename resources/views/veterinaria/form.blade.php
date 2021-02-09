<?php
    $administrador = new \DogCat\User();
    $ubicacion_veterinaria = new \DogCat\Models\Ubicacion();
    $ubicacion_administrador = new \DogCat\Models\Ubicacion();
    if($veterinaria->exists){
        $administrador = $veterinaria->administrador;
        $ubicacion_veterinaria = $veterinaria->ubicacion;
        $ubicacion_administrador = $administrador->ubicacion;
    }
?>
{!! Form::model($veterinaria,['id'=>'form-veterinaria']) !!}
@if($veterinaria->exists)
    {!! Form::hidden('veterinaria',$veterinaria->id) !!}
@endif
@include('layouts.alertas',['id_contenedor'=>'alertas-veterinaria'])

<div class="contenedor-toggle-render" id="datos_basicos_veterinaria">
    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos básicos - veterinaria</h4>
    <div class="col-12 padding-bottom-30 padding-left-none padding-right-none">
        @include('veterinaria.forms.navegacion',['except'=>['datos_basicos_veterinaria']])
    </div>
    @include('veterinaria.forms.datos_basicos_veterinaria')
    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
    </div>
</div>

<div class="contenedor-toggle-render d-none" id="ubicacion_veterinaria">
    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - veterinaria</h4>
    <div class="col-12 padding-bottom-30 padding-left-none padding-right-none">
        @include('veterinaria.forms.navegacion',['except'=>['ubicacion_veterinaria']])
    </div>
    @include('veterinaria.forms.datos_ubicacion_veterinaria')
    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_basicos_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
    </div>
</div>

<div class="contenedor-toggle-render d-none" id="datos_personales_administrador">
    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales - administrador</h4>
    <div class="col-12 padding-bottom-30 padding-left-none padding-right-none">
        @include('veterinaria.forms.navegacion',['except'=>['datos_personales_administrador']])
    </div>
    @include('veterinaria.forms.datos_personales_administrador')

    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
    </div>
</div>

<div class="contenedor-toggle-render d-none" id="datos_ubicacion_administrador">
    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - administrador</h4>
    <div class="col-12 padding-bottom-30 padding-left-none padding-right-none">
        @include('veterinaria.forms.navegacion',['except'=>['datos_ubicacion_administrador']])
    </div>
    @include('veterinaria.forms.datos_ubicacion_administrador')
    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
        @if(!$administrador->exists)
            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="seguridad_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
        @else
            <a href="#!" class="btn btn-success btn-submit" id="guardar-veterinaria">Guardar</a>
        @endif
    </div>
</div>

@if(!$administrador->exists)
    <div class="contenedor-toggle-render d-none" id="seguridad_administrador">
        <div class="col-12">
            <div class="row">
                <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad - administrador</h4>
                <div class="col-12 padding-bottom-30 padding-left-none padding-right-none">
                    @include('veterinaria.forms.navegacion',['except'=>['seguridad_administrador']])
                </div>
                <div class="col-12 no-padding">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="md-form">
                                {!! Form::label('password','Contraseña',['class'=>'control-label']) !!}
                                <input type="password" name="password" id="password" class="form-control" data-minlength="6" autocomplete="off">
                                <div class="help-block">Mínimo 6 caracteres</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="md-form">
                                {!! Form::label('password_confirm','Confirmación de contraseña',['class'=>'control-label']) !!}
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control" data-minlength="6" data-match="#password" data-minlength-error="Mínimo 6 caracteres" data-match-error="La confirmación no coincide" autocomplete="off">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-success btn-submit" id="guardar-veterinaria">Guardar</a>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
@endif
{!! Form::close() !!}