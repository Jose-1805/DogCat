<div class="col-md-6 col-lg-3">
    <div class="md-form c-select">
        {!! Form::label('pais','Pais',['class'=>'active']) !!}
        {!! Form::select('pais',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),null,['id'=>'select-pais','class'=>'form-control']) !!}
    </div>
</div>
<div class="col-md-6 col-lg-3">
    <div class="md-form c-select" id="contenedor-select-departamentos">
        {!! Form::label('departamento','Departamento',['class'=>'active']) !!}
        {!! Form::select('departamento',[''=>'Seleccione un departamento'],null,['id'=>'select-departamento','class'=>'form-control']) !!}
    </div>
</div>

<div class="col-md-6 col-lg-3">
    <div class="md-form c-select" id="contenedor-select-ciudades">
        {!! Form::label('ciudad','Ciudad (*)',['class'=>'active']) !!}
        {!! Form::select('ciudad',[''=>'Seleccione uns ciudad'],null,['id'=>'ciudad','class'=>'form-control']) !!}
    </div>
</div>
<div class="col-md-6 col-lg-3">
    <div class="md-form">
        {!! Form::label('barrio','Barrio (*)') !!}
        {!! Form::text('barrio',null,['id'=>'barrio','class'=>'form-control','maxlength'=>255]) !!}
        <p class="count-length">255</p>
    </div>
</div>

<div class="col-md-6 col-lg-3">
    <div class="md-form">
        {!! Form::label('calle','Calle') !!}
        {!! Form::text('calle',null,['id'=>'calle','class'=>'form-control','maxlength'=>20]) !!}
        <p class="count-length">20</p>
    </div>
</div>
<div class="col-md-6 col-lg-3">
    <div class="md-form">
        {!! Form::label('carrera','Carrera') !!}
        {!! Form::text('carrera',null,['id'=>'carrera','class'=>'form-control','maxlength'=>20]) !!}
        <p class="count-length">20</p>
    </div>
</div>
<div class="col-md-6 col-lg-3">
    <div class="md-form">
        {!! Form::label('transversal','Transversal') !!}
        {!! Form::text('transversal',null,['id'=>'transversal','class'=>'form-control','maxlength'=>20]) !!}
        <p class="count-length">20</p>
    </div>
</div>

<div class="col-md-6 col-lg-3">
    <div class="md-form">
        {!! Form::label('numero','Número (*)') !!}
        {!! Form::text('numero',null,['id'=>'numero','class'=>'form-control']) !!}
    </div>
</div>
<div class="col-12">
    <div class="md-form">
        {!! Form::label('especificaciones','Especificaciones') !!}
        {!! Form::textarea('especificaciones',null,['id'=>'especificaciones','class'=>'form-control md-textarea','maxlength'=>255]) !!}
        <p class="count-length">255</p>
    </div>
</div>