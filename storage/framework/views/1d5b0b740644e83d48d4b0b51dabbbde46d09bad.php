<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Nueva cuenta veterinaria DogCat</p>
            <?php echo Form::open(['id'=>'form-nueva-cuenta-veterinaria','data-toggle'=>'validator']); ?>

                <?php echo Form::hidden('id',$id); ?>

                <?php echo Form::hidden('token',$token); ?>

                <?php echo Form::hidden('iniciar','true'); ?>


                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-nueva-cuenta-veterinaria'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="contenedor-toggle-render col-12" id="datos_basicos_veterinaria">
                    <div class="row">
                        <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos básicos - veterinaria</p>
                        <div class="col-12 padding-bottom-30">
                            <?php echo $__env->make('nueva_cuenta_veterinaria.navegacion',['except'=>['datos_basicos_veterinaria']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <?php echo $__env->make('nueva_cuenta_veterinaria.datos_basicos_veterinaria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="ubicacion_veterinaria">
                    <div class="row">
                        <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - veterinaria</p>
                        <div class="col-12 padding-bottom-30">
                            <?php echo $__env->make('nueva_cuenta_veterinaria.navegacion',['except'=>['ubicacion_veterinaria']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <?php echo $__env->make('nueva_cuenta_veterinaria.datos_ubicacion_veterinaria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_basicos_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="datos_personales_administrador">
                    <div class="row">
                        <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales - administrador</p>
                        <div class="col-12 padding-bottom-30">
                            <?php echo $__env->make('nueva_cuenta_veterinaria.navegacion',['except'=>['datos_personales_administrador']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <?php echo $__env->make('nueva_cuenta_veterinaria.datos_personales_administrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="datos_ubicacion_administrador">
                    <div class="row">
                        <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - administrador</p>
                        <div class="col-12 padding-bottom-30">
                            <?php echo $__env->make('nueva_cuenta_veterinaria.navegacion',['except'=>['datos_ubicacion_administrador']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <?php echo $__env->make('nueva_cuenta_veterinaria.datos_ubicacion_administrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div class="col-12 text-right margin-top-30 no-padding">
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="seguridad_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
                        </div>
                    </div>
                </div>

                <div class="contenedor-toggle-render col-12 d-none" id="seguridad_administrador">
                    <div class="row">
                        <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad - administrador</p>
                        <div class="col-12 padding-bottom-30">
                            <?php echo $__env->make('nueva_cuenta_veterinaria.navegacion',['except'=>['seguridad_administrador']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
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
                            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                            <a href="#!" class="btn btn-success btn-submit" id="guardar-nueva-cuenta-veterinaria">Guardar</a>
                        </div>
                    </div>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/nueva_cuenta_veterinaria/nueva_cuenta_veterinaria.js')); ?>"></script>
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
            $("#logo").fileinput(
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