<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select">
            {!! Form::label('pais-administrador','Pais',['class'=>'active']) !!}
            {!! Form::select('pais-administrador',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),null,['id'=>'select-pais-administrador','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-departamentos-administrador">
            {!! Form::label('departamento-administrador','Departamento',['class'=>'active']) !!}
            {!! Form::select('departamento-administrador',[''=>'Seleccione un departamento'],null,['id'=>'select-departamento-administrador','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-ciudades-administrador">
            {!! Form::label('ciudad-administrador','Ciudad (*)',['class'=>'active']) !!}
            {!! Form::select('ciudad_administrador',[''=>'Seleccione uns ciudad'],null,['id'=>'ciudad-administrador','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('barrio-administrador','Barrio (*)') !!}
            {!! Form::text('barrio_administrador',null,['id'=>'barrio-administrador','class'=>'form-control','maxlength'=>255]) !!}
            <p class="count-length">255</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('calle-administrador','Calle') !!}
            {!! Form::text('calle_administrador',null,['id'=>'calle-administrador','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('carrera-administrador','Carrera') !!}
            {!! Form::text('carrera_administrador',null,['id'=>'carrera-administrador','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('transversal-administrador','Transversal') !!}
            {!! Form::text('transversal_administrador',null,['id'=>'transversal-administrador','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('numero-administrador','Número (*)') !!}
            {!! Form::text('numero_administrador',null,['id'=>'numero-administrador','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-12">
        <div class="md-form">
            {!! Form::label('especificaciones-administrador','Especificaciones') !!}
            {!! Form::textarea('especificaciones_administrador',null,['id'=>'especificaciones-administrador','class'=>'form-control md-textarea','maxlength'=>255]) !!}
            <p class="count-length">255</p>
        </div>
    </div>
</div>