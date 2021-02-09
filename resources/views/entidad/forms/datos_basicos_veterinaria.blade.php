<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <p class="titulo_secundario">Imagen (logo)</p>
        <input id="logo" name="logo" type="file" class="file-loading">
    </div>

    <div class="col-12 col-md-8 col-lg-9 blockquote bq-success padding-left-50" id="contenedor_datos_basicos_veterinaria">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('nit','NII (*)') !!}
                    {!! Form::text('nit',null,['id'=>'nit','class'=>'form-control','maxlength'=>'20']) !!}
                    <p class="count-length">20</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('nombre','Nombre (*)',['class'=>'control-label']) !!}
                    {!! Form::text('nombre',$veterinaria->nombre,['id'=>'nombre','class'=>'form-control','maxlength'=>200,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']) !!}
                    <p class="count-length">200</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('correo','Correo (*)',['class'=>'control-label']) !!}
                    {!! Form::text('correo',$veterinaria->correo,['id'=>'correo','class'=>'form-control','maxlength'=>250,'pattern'=>'^[A-z0-9@.-]{1,}$','data-error'=>'Caracteres no válidos']) !!}
                    <p class="count-length">250</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('telefono','Teléfono (*)') !!}
                    {!! Form::text('telefono',$veterinaria->telefono,['id'=>'telefono','class'=>'form-control num-int-positivo','maxlength'=>'20']) !!}
                    <p class="count-length">20</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('web_site','Web site') !!}
                    {!! Form::text('web_site',null,['id'=>'web_site','class'=>'form-control','maxlength'=>'250']) !!}
                    <p class="count-length">250</p>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    @parent
    <script>
        $(function () {
            agregarDivisionesDivs('contenedor_datos_basicos_veterinaria',1,1,2,3);
        })
    </script>
@endsection