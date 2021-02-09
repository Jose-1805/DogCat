<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <p class="titulo_secundario">Imagen (foto)</p>
        <input id="imagen" name="imagen" type="file" class="file-loading">
    </div>

    <div class="col-12 col-md-8 col-lg-9 no-padding" id="datos_personales_usuario">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('tipo_identificacion','Tipo de identificación (*)',['class'=>'active']) !!}
                    {!! Form::select('tipo_identificacion',['C.C'=>'C.C','NIT'=>'NIT'],null,['id'=>'tipo_identificacion','class'=>'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('identificacion','No. de identificación (*)') !!}
                    {!! Form::text('identificacion',null,['id'=>'identificacion','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('nombres','Nombres (*)',['class'=>'control-label']) !!}
                    {!! Form::text('nombres',null,['id'=>'nombres','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']) !!}
                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('apellidos','Apellidos (*)',['class'=>'control-label']) !!}
                    {!! Form::text('apellidos',null,['id'=>'apellidos','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']) !!}
                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('email','Correo (*)',['class'=>'control-label']) !!}
                    {!! Form::text('email',null,['id'=>'email','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z0-9@.-]{1,}$','data-error'=>'Caracteres no válidos']) !!}
                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('celular','N° Celular (*)') !!}
                    {!! Form::text('celular',null,['id'=>'celular','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('telefono','N° Teléfono fijo') !!}
                    {!! Form::text('telefono',null,['id'=>'telefono','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('genero','Gènero (*)',['class'=>'active']) !!}
                    {!! Form::select('genero',['masculino'=>'Masculino','femenino'=>'Femenino'],null,['id'=>'genero','class'=>'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('estado_civil','Estado civil (*)',['class'=>'active']) !!}
                    {!! Form::select('estado_civil',['Casado(a)'=>'Casado(a)', 'Soltero(a)'=>'Soltero(a)', 'Unión marital de hecho'=>'Unión marital de hecho'],null,['id'=>'estado_civil','class'=>'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4 m">
                <div class="md-form">
                    {!! Form::label('fecha_nacimiento','Fecha de nacimiento (*)',['class'=>'active']) !!}
                    @include('layouts.componentes.datepicker',['id'=>'fecha_nacimiento','name'=>'fecha_nacimiento'])
                </div>
            </div>

            @if(Auth::user()->getTipoUsuario() == 'personal dogcat')
                <div class="col-md-6 col-lg-4">
                    <div class="md-form c-select">
                        {!! Form::label('rol','Rol (*)',['class'=>'active']) !!}
                        {!! Form::select('rol',\DogCat\Models\Rol::permitidos()->where('afiliados','no')->where('veterinarias','no')->where('entidades','no')->where('registros','no')->pluck('nombre','id'),$usuario->rol_id,['id'=>'rol','class'=>'form-control']) !!}
                    </div>
                </div>
            @else
                <div class="col-md-6 col-lg-4">
                    <div class="md-form c-select">
                        {!! Form::label('rol','Rol (*)',['class'=>'active']) !!}
                        {!! Form::select('rol',\DogCat\Models\Rol::permitidos()->pluck('nombre','id'),$usuario->rol_id,['id'=>'rol','class'=>'form-control']) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>