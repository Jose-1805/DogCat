<div class="col-12 col-md-4 col-lg-3">
    <p class="titulo_secundario">Imagen (foto)</p>
    <input id="imagen" name="imagen" type="file" class="file-loading">
</div>

<div class="col-12 col-md-8 col-lg-9 blockquote bq-success padding-left-50" id="contenedor_datos_personales_administrador">
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
                {!! Form::label('telefono_administrador','Teléfono') !!}
                {!! Form::text('telefono_administrador',null,['id'=>'telefono_administrador','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                <p class="count-length">15</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="md-form">
                {!! Form::label('celular_administrador','N° Celular (*)') !!}
                {!! Form::text('celular_administrador',null,['id'=>'celular_administrador','class'=>'form-control num-int-positivo','maxlength'=>'15']) !!}
                <p class="count-length">15</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="md-form c-select">
                {!! Form::label('genero','Gènero (*)',['class'=>'active']) !!}
                {!! Form::select('genero',['masculino'=>'Masculino','femenino'=>'Femenino'],null,['id'=>'genero','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="col-md-6 col-lg-4 datepicker">
            <div class="md-form">
                {!! Form::label('fecha_nacimiento','Fecha de nacimiento (*)',['class'=>'active']) !!}
                @include('layouts.componentes.datepicker',['id'=>'fecha_nacimiento','name'=>'fecha_nacimiento'])
            </div>
        </div>
    </div>
</div>
@section('js')
    @parent
    <script>
        $(function () {
            agregarDivisionesDivs('contenedor_datos_personales_administrador',1,1,2,3);
        })
    </script>
@endsection