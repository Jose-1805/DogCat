<?php
    if(!isset($usuario))$usuario = new \DogCat\User();
?>
<?php echo Form::model($usuario,['id'=>'form-usuario','data-toggle'=>'validator']); ?>


    <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-usuario'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales</h4>
    <div class="col-12">
        <?php echo $__env->make('empleado.datos_personales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos de ubicación</h4>
    <div class="col-12 no-padding">
        <?php echo $__env->make('empleado.datos_ubicacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php if(!$usuario->exists): ?>
        <h4 class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad</h4>
        <div class="col-12 no-padding">
            <div class="row">
                <div class="col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('password','Contraseña',['class'=>'control-label']); ?>

                        <input type="password" name="password" id="password" class="form-control" data-minlength="6" autocomplete="off">
                        <div class="help-block">Mínimo 6 caracteres</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('password_confirm','Confirmación de contraseña',['class'=>'control-label']); ?>

                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" data-minlength="6" data-match="#password" data-minlength-error="Mínimo 6 caracteres" data-match-error="La confirmación no coincide" autocomplete="off">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-12 text-right margin-top-30">
        <a href="#!" class="btn btn-success btn-submit" id="btn-guardar-usuario">Guardar</a>
    </div>
<?php echo Form::close(); ?>