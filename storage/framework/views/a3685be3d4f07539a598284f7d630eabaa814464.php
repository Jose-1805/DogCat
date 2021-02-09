<?php
    $imagen_principal = $publicacion->imagenPrincipal();
    $imagenes = $publicacion->imagenes()->where('imagenes_publicaciones.principal','no')->get();
?>

<?php if($imagen_principal): ?>
    <a class="col-12" href="<?php echo e(url('publicacion/imagen/'.$publicacion->id.'/'.$imagen_principal->nombre.'/1')); ?>" data-toggle="lightbox" data-type="image">
        <div class="row hoverable no-margin" style="width:100%;min-height: 300px;max-height: 300px;background: url('<?php echo e(url('publicacion/imagen/'.$publicacion->id.'/'.$imagen_principal->nombre.'/1')); ?>') no-repeat right top;background-size: 100% auto; border-radius: 5px;margin-top: -15px !important;border: 1px #e7e7e7 solid;"></div>
        <?php if(count($imagenes)): ?>
            <a href="<?php echo e(url('publicacion/imagen/'.$publicacion->id.'/'.$imagen_principal->nombre.'/1')); ?>" class="btn btn-circle btn-primary right margin-right-10" style="margin-top: -40px !important; position: relative;" data-title="<a class='teal-text text-lighten-1'><?php echo e($publicacion->usuario->nombres.' '.$publicacion->usuario->apellidos); ?></a>" <?php if($publicacion->publicacion): ?> data-footer="<?php echo e($publicacion->publicacion); ?>" <?php endif; ?> data-toggle="lightbox" data-type="image" data-gallery="gallery-<?php echo e($publicacion->id); ?>"><i class="fa fa-images white-text"></i></a>
        <?php endif; ?>
    </a>
<?php endif; ?>

<?php if(count($imagenes)): ?>
    <?php $__currentLoopData = $imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div data-toggle="lightbox" data-type="image" data-gallery="gallery-<?php echo e($publicacion->id); ?>" data-remote="<?php echo e(url('publicacion/imagen/'.$publicacion->id.'/'.$img->nombre.'/0')); ?>" data-title="<a class='teal-text text-lighten-1'><?php echo e($publicacion->usuario->nombres.' '.$publicacion->usuario->apellidos); ?></a>" <?php if($publicacion->publicacion): ?> data-footer="<?php echo e($publicacion->publicacion); ?>" <?php endif; ?>></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>