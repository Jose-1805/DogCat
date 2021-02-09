<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <p class="titulo_secundario">Imagen (foto)</p>
        <input id="imagen" name="imagen" type="file" class="file-loading">
    </div>

    <div class="col-12 col-md-8 col-lg-9 blockquote bq-success padding-left-50" id="contenedor_datos_personales_administrador">

        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('tipo_identificacion','Tipo de identificación (*)',['class'=>'active']); ?>

                    <?php echo Form::select('tipo_identificacion',['C.C'=>'C.C','NIT'=>'NIT'],$administrador->tipo_identificacion,['id'=>'tipo_identificacion','class'=>'form-control']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('identificacion','No. de identificación (*)'); ?>

                    <?php echo Form::text('identificacion',$administrador->identificacion,['id'=>'identificacion','class'=>'form-control num-int-positivo','maxlength'=>'15']); ?>

                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('nombres','Nombres (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('nombres',$administrador->nombres,['id'=>'nombres','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('apellidos','Apellidos (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('apellidos',$administrador->apellidos,['id'=>'apellidos','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('email','Correo (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('email',$administrador->email,['id'=>'email','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z0-9@.-]{1,}$','data-error'=>'Caracteres no válidos']); ?>

                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('telefono_administrador','Teléfono (*)'); ?>

                    <?php echo Form::text('telefono_administrador',$administrador->telefono,['id'=>'telefono_administrador','class'=>'form-control num-int-positivo','maxlength'=>'15']); ?>

                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('genero','Gènero (*)',['class'=>'active']); ?>

                    <?php echo Form::select('genero',['masculino'=>'Masculino','femenino'=>'Femenino'],$administrador->genero,['id'=>'genero','class'=>'form-control']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4 datepicker">
                <div class="md-form">
                    <?php echo Form::label('fecha_nacimiento','Fecha de nacimiento (*)',['class'=>'active']); ?>

                    <?php echo $__env->make('layouts.componentes.datepicker',['id'=>'fecha_nacimiento','name'=>'fecha_nacimiento'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('rol','Rol (*)',['class'=>'active']); ?>

                    <?php echo Form::select('rol',$roles,$administrador->rol_id,['id'=>'rol','class'=>'form-control']); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script>
        $(function () {
            $('#fecha_nacimiento').val('<?php echo e($administrador->fecha_nacimiento?$administrador->fecha_nacimiento:date('Y/m/d')); ?>')
        })
    </script>
<?php $__env->stopSection(); ?>