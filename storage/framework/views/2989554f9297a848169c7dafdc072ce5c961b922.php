<?php
    if(!isset($ciudad))$ciudad = new \DogCat\Models\Ciudad();
    if(!isset($departamento))$departamento = new \DogCat\Models\Departamento();

    $departamentos = [''=>'Seleccione un departamento'];
    $ciudades = [''=>'Seleccione una ciudad'];

    if($ciudad->exists){
        $ciudades[$ciudad->id] = $ciudad->nombre;
    }

    if($departamento->exists){
        $departamentos[$departamento->id] = $departamento->nombre;
    }
?>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select">
            <?php echo Form::label('pais','Pais',['class'=>'active']); ?>

            <?php echo Form::select('pais',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),$departamento->pais_id,['id'=>'select-pais','class'=>'form-control']); ?>

        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-departamentos">
            <?php echo Form::label('departamento','Departamento',['class'=>'active']); ?>

            <?php echo Form::select('departamento',$departamentos,$departamento->id,['id'=>'select-departamento','class'=>'form-control']); ?>

        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-ciudades">
            <?php echo Form::label('ciudad','Ciudad (*)',['class'=>'active']); ?>

            <?php echo Form::select('ciudad',$ciudades,$ciudad->id,['id'=>'ciudad','class'=>'form-control']); ?>

        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('barrio','Barrio (*)'); ?>

            <?php echo Form::text('barrio',null,['id'=>'barrio','class'=>'form-control','maxlength'=>255]); ?>

            <p class="count-length">255</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('calle','Calle'); ?>

            <?php echo Form::text('calle',null,['id'=>'calle','class'=>'form-control','maxlength'=>20]); ?>

            <p class="count-length">20</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('carrera','Carrera'); ?>

            <?php echo Form::text('carrera',null,['id'=>'carrera','class'=>'form-control','maxlength'=>20]); ?>

            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('numero','Número (*)'); ?>

            <?php echo Form::text('numero',null,['id'=>'numero','class'=>'form-control']); ?>

        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('especificaciones','Especificaciones'); ?>

            <?php echo Form::text('especificaciones',null,['id'=>'especificaciones','class'=>'form-control','maxlength'=>255]); ?>

            <p class="count-length">255</p>
        </div>
    </div>
</div>