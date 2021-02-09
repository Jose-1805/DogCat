<?php $__empty_1 = true; $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php ($url = $n->link?$n->link:'#!'); ?>
    <a href="<?php echo e($url); ?>" class="margin-top-5 list-group-item list-group-item-action flex-column align-items-start notificacion_importancia_<?php echo e($n->importancia); ?>">
        <div class="row">
            <div class="col-auto">
                <?php if($n->tipo == 'recordatorio'): ?>
                    <img src="/imagenes/sistema/reloj_alarma.png" style="max-width: 60px;">
                <?php else: ?>
                    <img src="<?php echo e($n->icon); ?>" style="max-width: 60px;">
                <?php endif; ?>
            </div>
            <div class="col">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo e($n->titulo); ?></h5>
                </div>
                <p class="mb-1"><?php echo $n->mensaje; ?></p>
                <small class="text-muted"><?php echo e(date('Y-m-d H:i',strtotime($n->created_at))); ?></small>
            </div>
        </div>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="alert alert-info margin-top-20">No existen más notificaciones para mostrar</p>
<?php endif; ?>