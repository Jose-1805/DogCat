<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Bienvenido a DogCat!</p>

            <div class="col-12">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-create-password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12">
                <p class="col-12 margin-bottom-20 no-padding">Señor(a) <?php echo e($user->fullName()); ?>, para ingresar al sistema ingrese una contraseña de acceso y la verificación de la misma.</p>
                <?php echo Form::open(['id'=>'form-create-password']); ?>

                    <div class="row">
                        <div class="col-md-6 col-lg-5">
                            <div class="md-form">
                                <?php echo Form::label('password','Contraseña (*)'); ?>

                                <?php echo Form::password('password',['id'=>'password','class'=>'form-control']); ?>

                            </div>
                        </div>

                        <div class="col-md-6 col-lg-5">
                            <div class="md-form">
                                <?php echo Form::label('password_confirm','Confirmación de contraseña (*)'); ?>

                                <?php echo Form::password('password_confirm',['id'=>'password_confirm','class'=>'form-control']); ?>

                            </div>
                        </div>
                        <div class="col-12 col-lg-2 md-form">
                            <a href="#!" class="col-12 cursor_pointer btn-submit btn btn-success right margin-top-5" id="btn-create-password">Guardar</a>
                        </div>
                        <?php echo Form::hidden('id',$user->id); ?>

                    </div>
                <?php echo Form::close(); ?>

            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/usuario/create_password.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>