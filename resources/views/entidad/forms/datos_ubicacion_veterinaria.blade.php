<?php
$pais_id = null;
$departamento_id = null;
$ciudad_id = null;
$departamentos = [''=>'Seleccione un departamento'];
$ciudades = [''=>'Seleccione una ciudad'];
if($ubicacion_veterinaria->exists){
    $pais_id = $ubicacion_veterinaria->ciudad->departamento->pais_id;
    $departamento_id = $ubicacion_veterinaria->ciudad->departamento_id;
    $ciudad_id = $ubicacion_veterinaria->ciudad_id;
    $departamentos = [$ubicacion_veterinaria->ciudad->departamento->id=>$ubicacion_veterinaria->ciudad->departamento->nombre];
    $ciudades = [$ubicacion_veterinaria->ciudad->id=>$ubicacion_veterinaria->ciudad->nombre];
}
?>
<div class="row" id="contenedor_datos_ubicacion_veterinaria">
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select">
            {!! Form::label('pais-veterinaria','Pais',['class'=>'active']) !!}
            {!! Form::select('pais-veterinaria',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),$pais_id,['id'=>'select-pais-veterinaria','class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-departamentos-veterinaria">
            {!! Form::label('departamento-veterinaria','Departamento',['class'=>'active']) !!}
            {!! Form::select('departamento-veterinaria',$departamentos,$departamento_id,['id'=>'select-departamento-veterinaria','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-ciudades-veterinaria">
            {!! Form::label('ciudad-veterinaria','Ciudad (*)',['class'=>'active']) !!}
            {!! Form::select('ciudad_veterinaria',$ciudades,$ciudad_id,['id'=>'ciudad-veterinaria','class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('barrio-veterinaria','Barrio (*)') !!}
            {!! Form::text('barrio_veterinaria',$ubicacion_veterinaria->barrio,['id'=>'barrio-veterinaria','class'=>'form-control','maxlength'=>255]) !!}
            <p class="count-length">255</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('calle-veterinaria','Calle') !!}
            {!! Form::text('calle_veterinaria',$ubicacion_veterinaria->calle,['id'=>'calle-veterinaria','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('carrera-veterinaria','Carrera') !!}
            {!! Form::text('carrera_veterinaria',$ubicacion_veterinaria->carrera,['id'=>'carrera-veterinaria','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('numero-veterinaria','Número (*)') !!}
            {!! Form::text('numero_veterinaria',$ubicacion_veterinaria->numero,['id'=>'numero-veterinaria','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('especificaciones-veterinaria','Especificaciones') !!}
            {!! Form::text('especificaciones_veterinaria',$ubicacion_veterinaria->especificaciones,['id'=>'especificaciones-veterinaria','class'=>'form-control','maxlength'=>255]) !!}
            <p class="count-length">255</p>
        </div>
    </div>
</div>