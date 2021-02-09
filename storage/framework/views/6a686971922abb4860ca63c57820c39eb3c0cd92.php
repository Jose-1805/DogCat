<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Editar empleado</p>

            <div class="col-12">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-editar-usuario'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12">
                <?php echo Form::model($usuario,['id'=>'form-usuario']); ?>

                    <?php echo Form::hidden('usuario',$usuario->id,['id'=>'usuario']); ?>

                    <?php echo $__env->make('empleado.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo Form::close(); ?>

            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/empleado/editar.js')); ?>"></script>
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
                    initialPreview: [
                        <?php if($usuario->imagenPerfil): ?>
                            "<img src='<?php echo e(url('/almacen/'.str_replace('/','-',$usuario->imagenPerfil->ubicacion).'-'.$usuario->imagenPerfil->nombre)); ?>' class='col-12'>",
                        <?php endif; ?>
                    ]
                }
            );

            $('#fecha_nacimiento').val('<?php echo e($usuario->fecha_nacimiento); ?>')
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>