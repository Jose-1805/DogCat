<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <p class="titulo_secundario">Imagen (foto)</p>
        <input id="imagen" name="imagen" type="file" class="file-loading">
    </div>

    <div class="col-12 col-md-8 col-lg-9 blockquote bq-success padding-left-50" id="contenedor_datos_personales_administrador">

        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('tipo_identificacion','Tipo de identificación (*)',['class'=>'active']) !!}
                    {!! Form::select('tipo_identificacion',['C.C'=>'C.C','NIT'=>'NIT'],$administrador->tipo_identificacion,['id'=>'tipo_identificacion','class'=>'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('identificacion','No. de identificación (*)') !!}
                    {!! Form::text('identificacion',$administrador->identificacion,['id'=>'identificacion','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('nombres','Nombres (*)',['class'=>'control-label']) !!}
                    {!! Form::text('nombres',$administrador->nombres,['id'=>'nombres','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']) !!}
                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('apellidos','Apellidos (*)',['class'=>'control-label']) !!}
                    {!! Form::text('apellidos',$administrador->apellidos,['id'=>'apellidos','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']) !!}
                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('email','Correo (*)',['class'=>'control-label']) !!}
                    {!! Form::text('email',$administrador->email,['id'=>'email','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z0-9@.-]{1,}$','data-error'=>'Caracteres no válidos']) !!}
                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('telefono_administrador','Teléfono') !!}
                    {!! Form::text('telefono_administrador',$administrador->telefono,['id'=>'telefono_administrador','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('celular_administrador','N° Celular (*)') !!}
                    {!! Form::text('celular_administrador',$administrador->celular,['id'=>'celular_administrador','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('genero','Gènero (*)',['class'=>'active']) !!}
                    {!! Form::select('genero',['masculino'=>'Masculino','femenino'=>'Femenino'],$administrador->genero,['id'=>'genero','class'=>'form-control']) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4 datepicker">
                <div class="md-form">
                    {!! Form::label('fecha_nacimiento','Fecha de nacimiento (*)',['class'=>'active']) !!}
                    @include('layouts.componentes.datepicker',['id'=>'fecha_nacimiento','name'=>'fecha_nacimiento'])
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('rol','Rol (*)',['class'=>'active']) !!}
                    {!! Form::select('rol',$roles,$administrador->rol_id,['id'=>'rol','class'=>'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    @parent
        <script>
            $(function () {
                $('#fecha_nacimiento').val('{{$administrador->fecha_nacimiento?$administrador->fecha_nacimiento:date('Y/m/d')}}')
            })
        </script>
@endsection