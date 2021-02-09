<div class="col-12 no-padding publicacion-item" style="border-top: 1px solid #26a6b1;" data-publicacion="<?php echo e($publicacion->id); ?>">
    <?php echo $__env->make('publicacion.publicacion.encabezado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('publicacion.publicacion.imagenes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <div class="col-12 padding-10 no-margin info-publicacion" id="p-<?php echo e($publicacion->id); ?>" data-publicacion="<?php echo e($publicacion->id); ?>" style="margin-top: 0px !important;">
        <?php if($publicacion->publicacion): ?>
        <p class="col-12 no-padding margin-top-10 font-small">
            <?php echo e($publicacion->publicacion); ?>

        </p>
        <?php endif; ?>

        <div class="contenedor-likes">
            <?php echo $__env->make('publicacion.publicacion.likes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="contenedor-comentarios">
            <?php echo $__env->make('publicacion.publicacion.comentarios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
</div>