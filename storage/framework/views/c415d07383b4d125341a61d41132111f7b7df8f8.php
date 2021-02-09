

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Nueva cuenta DogCat</p>
            <?php echo Form::open(['id'=>'form-nueva-cuenta','data-toggle'=>'validator']); ?>

                <?php echo Form::hidden('id',$id); ?>

                <?php echo Form::hidden('token',$token); ?>

                <?php echo Form::hidden('iniciar','true'); ?>


                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-nueva-cuenta'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales</p>
                <div class="row">
                    <?php echo $__env->make('nueva_cuenta.datos_personales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos de ubicación</p>
                <div class="row">
                    <?php echo $__env->make('nueva_cuenta.datos_ubicacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="md-form">
                            <?php echo Form::label('password','Contraseña (*)',['class'=>'control-label']); ?>

                            <input type="password" name="password" id="password" class="form-control" data-minlength="6" autocomplete="off">
                            <div class="help-block">Mínimo 6 caracteres</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="md-form">
                            <?php echo Form::label('password_confirm','Confirmación de contraseña (*)',['class'=>'control-label']); ?>

                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" data-minlength="6" data-match="#password" data-minlength-error="Mínimo 6 caracteres" data-match-error="La confirmación no coincide" autocomplete="off">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-12 text-right margin-top-30">
                        <a href="#!" class="btn btn-success btn-submit" id="guardar-nueva-cuenta">Guardar</a>
                    </div>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/nueva_cuenta/nueva_cuenta.js')); ?>"></script>
    <script>
        $(function () {
            $("#imagen").fileinput(
                {
                    previewSettings: {
                        image:{width:"auto", height:"160px"},
                    },
                    allowedFileTypes:['image'],
                    AllowedFileExtensions:['jpg','jpeg','png'],
                    removeFromPreviewOnError:true,
                    showCaption: false,
                    showUpload: false,
                    showClose:false,
                    maxFileSize : 500,
                }
            );
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>