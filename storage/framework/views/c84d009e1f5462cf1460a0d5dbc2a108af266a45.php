<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select">
            <?php echo Form::label('pais-administrador','Pais',['class'=>'active']); ?>

            <?php echo Form::select('pais-administrador',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),null,['id'=>'select-pais-administrador','class'=>'form-control']); ?>

        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-departamentos-administrador">
            <?php echo Form::label('departamento-administrador','Departamento',['class'=>'active']); ?>

            <?php echo Form::select('departamento-administrador',[''=>'Seleccione un departamento'],null,['id'=>'select-departamento-administrador','class'=>'form-control']); ?>

        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form c-select" id="contenedor-select-ciudades-administrador">
            <?php echo Form::label('ciudad-administrador','Ciudad (*)',['class'=>'active']); ?>

            <?php echo Form::select('ciudad_administrador',[''=>'Seleccione uns ciudad'],null,['id'=>'ciudad-administrador','class'=>'form-control']); ?>

        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('barrio-administrador','Barrio (*)'); ?>

            <?php echo Form::text('barrio_administrador',null,['id'=>'barrio-administrador','class'=>'form-control','maxlength'=>255]); ?>

            <p class="count-length">255</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('calle-administrador','Calle'); ?>

            <?php echo Form::text('calle_administrador',null,['id'=>'calle-administrador','class'=>'form-control','maxlength'=>20]); ?>

            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('carrera-administrador','Carrera'); ?>

            <?php echo Form::text('carrera_administrador',null,['id'=>'carrera-administrador','class'=>'form-control','maxlength'=>20]); ?>

            <p class="count-length">20</p>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('numero-administrador','Número (*)'); ?>

            <?php echo Form::text('numero_administrador',null,['id'=>'numero-administrador','class'=>'form-control']); ?>

        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('especificaciones-administrador','Especificaciones'); ?>

            <?php echo Form::text('especificaciones_administrador',null,['id'=>'especificaciones-administrador','class'=>'form-control','maxlength'=>255]); ?>

            <p class="count-length">255</p>
        </div>
    </div>
</div>