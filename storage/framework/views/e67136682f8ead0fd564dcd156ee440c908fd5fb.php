

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <?php echo Form::open(['id'=>'form-crear-mascota','data-toggle'=>'validator']); ?>

            <div class="row">
                <div class="row contenedor-toggle-render" id="datos-basicos">
                    <div class="col-12">
                        <h3 class="titulo_principal margin-bottom-20 margin-top-20 col-12 no-padding">Nueva mascota </h3>
                        <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-nueva-mascota'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <div class="alert col-12 alert-warning" role="alert">
                            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                            Toda la información suministrada debe ser verídica, los datos ingresados serán verificados en el momento de revisar las afiliaciones de la mascota
                        </div>

                        <div class="col-12">
                            <?php echo $__env->make('mascota.forms.datos_basicos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>

                        <?php if(isset($asistido) && $asistido): ?>
                            <?php echo Form::hidden('asistido',1,['id'=>'asistido']); ?>

                            <div class="col-12 text-right margin-top-30 no-padding">
                                <a href="#!" class="btn btn-default /*btn-submit*/ btn-guardar-seguir-agregando guardar-mascota">Guardar y seguir agregando</a>
                                <a href="#!" class="btn btn-success /*btn-submit*/ guardar-mascota">Guardar y continuar</a>
                            </div>
                        <?php else: ?>
                            <div class="col-12 text-right margin-top-30 no-padding">
                                <a href="#!" class="btn btn-success /*btn-submit*/ guardar-mascota">Guardar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php echo Form::close(); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/mascota/nueva.js')); ?>"></script>
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
                    maxFileSize : <?php echo e(config('params.maximo_peso_archivos')); ?>,
                }
            );

            razas_perros = JSON.parse('<?php echo e($razas_perros); ?>'.replace(/(&quot\;)/g,"\""));
            razas_gatos = JSON.parse('<?php echo e($razas_gatos); ?>'.replace(/(&quot\;)/g,"\""));
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>