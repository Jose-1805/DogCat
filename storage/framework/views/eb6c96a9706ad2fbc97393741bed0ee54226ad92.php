<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Editar entidad</p>
            <?php echo $__env->make('entidad.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/entidad/editar.js')); ?>"></script>
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
                        <?php if($veterinaria->administrador->imagenPerfil): ?>
                            "<img src='<?php echo e(url('/almacen/'.str_replace('/','-',$veterinaria->administrador->imagenPerfil->ubicacion).'-'.$veterinaria->administrador->imagenPerfil->nombre)); ?>' class='col-12'>",
                        <?php endif; ?>
                    ]
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
                    initialPreview: [
                        <?php if($veterinaria->imagen): ?>
                            "<img src='<?php echo e(url('/almacen/'.str_replace('/','-',$veterinaria->imagen->ubicacion).'-'.$veterinaria->imagen->nombre)); ?>' class='col-12'>",
                        <?php endif; ?>
                    ]
                }
            );
        })
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>