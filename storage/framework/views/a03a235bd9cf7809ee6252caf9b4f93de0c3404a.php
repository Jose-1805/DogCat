<div class="col-12">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="md-form c-select">
                <?php echo Form::label('pais-veterinaria','Pais',['class'=>'active']); ?>

                <?php echo Form::select('pais-veterinaria',[''=>'Seleccione un país']+\DogCat\Models\Pais::pluck('nombre','id')->toArray(),null,['id'=>'select-pais-veterinaria','class'=>'form-control']); ?>

            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="md-form c-select" id="contenedor-select-departamentos-veterinaria">
                <?php echo Form::label('departamento-veterinaria','Departamento',['class'=>'active']); ?>

                <?php echo Form::select('departamento-veterinaria',[''=>'Seleccione un departamento'],null,['id'=>'select-departamento-veterinaria','class'=>'form-control']); ?>

            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form c-select" id="contenedor-select-ciudades-veterinaria">
                <?php echo Form::label('ciudad-veterinaria','Ciudad (*)',['class'=>'active']); ?>

                <?php echo Form::select('ciudad_veterinaria',[''=>'Seleccione uns ciudad'],null,['id'=>'ciudad-veterinaria','class'=>'form-control']); ?>

            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                <?php echo Form::label('barrio-veterinaria','Barrio (*)'); ?>

                <?php echo Form::text('barrio_veterinaria',null,['id'=>'barrio-veterinaria','class'=>'form-control','maxlength'=>255]); ?>

                <p class="count-length">255</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                <?php echo Form::label('calle-veterinaria','Calle'); ?>

                <?php echo Form::text('calle_veterinaria',null,['id'=>'calle-veterinaria','class'=>'form-control','maxlength'=>20]); ?>

                <p class="count-length">20</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                <?php echo Form::label('carrera-veterinaria','Carrera'); ?>

                <?php echo Form::text('carrera_veterinaria',null,['id'=>'carrera-veterinaria','class'=>'form-control','maxlength'=>20]); ?>

                <p class="count-length">20</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                <?php echo Form::label('numero-veterinaria','Número (*)'); ?>

                <?php echo Form::text('numero_veterinaria',null,['id'=>'numero-veterinaria','class'=>'form-control']); ?>

            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="md-form">
                <?php echo Form::label('especificaciones-veterinaria','Especificaciones'); ?>

                <?php echo Form::text('especificaciones_veterinaria',null,['id'=>'especificaciones-veterinaria','class'=>'form-control','maxlength'=>255]); ?>

                <p class="count-length">255</p>
            </div>
        </div>
    </div>
</div>