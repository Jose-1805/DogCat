<?php $__empty_1 = true; $__currentLoopData = $recordatorios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php ($url = $r->url?$r->url:'#!'); ?>
    <a href="<?php echo e($url); ?>" class="margin-top-5 list-group-item list-group-item-action flex-column align-items-start notificacion_importancia_<?php echo e($r->importancia); ?>">
        <p class="mb-1"><?php echo $r->mensaje; ?></p>
        <small class="text-muted"><?php echo e($r->fecha.' '.$r->hora); ?></small>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="alert alert-info margin-top-20">No existen más recordatorios para mostrar</p>
<?php endif; ?>