<?php
    $pais_id = null;
    $departamento_id = null;
    $ciudad_id = null;
    $departamentos = [''=>'Seleccione un departamento'];
    $ciudades = [''=>'Seleccione una ciudad'];
    if($ubicacion_administrador->exists){
        $pais_id = $ubicacion_administrador->ciudad->departamento->pais_id;
        $departamento_id = $ubicacion_administrador->ciudad->departamento_id;
        $ciudad_id = $ubicacion_administrador->ciudad_id;
        $departamentos = [$ubicacion_administrador->ciudad->departamento->id=>$ubicacion_administrador->ciudad->departamento->nombre];
        $ciudades = [$ubicacion_administrador->ciudad->id=>$ubicacion_administrador->ciudad->nombre];
    }
?>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select">
            {!! Form::label('pais-administrador','Pais',['class'=>'active']) !!}
            {!! Form::select('pais-administrador',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),$pais_id,['id'=>'select-pais-administrador','class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-departamentos-administrador">
            {!! Form::label('departamento-administrador','Departamento',['class'=>'active']) !!}
            {!! Form::select('departamento-administrador',$departamentos,$departamento_id,['id'=>'select-departamento-administrador','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-ciudades-administrador">
            {!! Form::label('ciudad-administrador','Ciudad (*)',['class'=>'active']) !!}
            {!! Form::select('ciudad_administrador',$ciudades,$ciudad_id,['id'=>'ciudad-administrador','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('barrio-administrador','Barrio (*)') !!}
            {!! Form::text('barrio_administrador',$ubicacion_administrador->barrio,['id'=>'barrio-administrador','class'=>'form-control','maxlength'=>255]) !!}
            <p class="count-length">255</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('calle-administrador','Calle') !!}
            {!! Form::text('calle_administrador',$ubicacion_administrador->calle,['id'=>'calle-administrador','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('carrera-administrador','Carrera') !!}
            {!! Form::text('carrera_administrador',$ubicacion_administrador->carrera,['id'=>'carrera-administrador','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('transversal-administrador','Transversal') !!}
            {!! Form::text('transversal_administrador',$ubicacion_administrador->transversal,['id'=>'transversal-administrador','class'=>'form-control','maxlength'=>20]) !!}
            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('numero-administrador','Número (*)') !!}
            {!! Form::text('numero_administrador',$ubicacion_administrador->numero,['id'=>'numero-administrador','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="col-12">
        <div class="md-form">
            {!! Form::label('especificaciones-administrador','Especificaciones') !!}
            {!! Form::textarea('especificaciones_administrador',$ubicacion_administrador->especificaciones,['id'=>'especificaciones-administrador','class'=>'form-control md-textarea','maxlength'=>255]) !!}
            <p class="count-length">255</p>
        </div>
    </div>
</div>