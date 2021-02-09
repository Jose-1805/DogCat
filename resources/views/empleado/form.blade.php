<?php
    if(!isset($usuario))$usuario = new \DogCat\User();
?>
{!! Form::model($usuario,['id'=>'form-usuario','data-toggle'=>'validator']) !!}

    @include('layouts.alertas',['id_contenedor'=>'alertas-usuario'])

    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales</h4>
    <div class="col-12">
        @include('empleado.datos_personales')
    </div>

    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos de ubicación</h4>
    <div class="col-12 no-padding">
        @include('empleado.datos_ubicacion')
    </div>
    @if(!$usuario->exists)
        <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad</h4>
        <div class="col-12 no-padding">
            <div class="row">
                <div class="col-md-6">
                    <div class="md-form">
                        {!! Form::label('password','Contraseña',['class'=>'control-label']) !!}
                        <input type="password" name="password" id="password" class="form-control" data-minlength="6" autocomplete="off">
                        <div class="help-block">Mínimo 6 caracteres</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        {!! Form::label('password_confirm','Confirmación de contraseña',['class'=>'control-label']) !!}
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" data-minlength="6" data-match="#password" data-minlength-error="Mínimo 6 caracteres" data-match-error="La confirmación no coincide" autocomplete="off">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="col-12 text-right margin-top-30">
        <a href="#!" class="btn btn-success btn-submit" id="btn-guardar-usuario">Guardar</a>
    </div>
{!! Form::close() !!}