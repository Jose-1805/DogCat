<div class="col-12 padding-right-none">
    <?php ($items = $revision->items); ?>
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card card-primary">
            <div class="card-header bg-primary white-text">
                <h5 class="card-title mayuscula white-text"><?php echo e($item->nombre); ?></h5>
            </div>
            <div class="card-body padding-bottom-10">
                <p><?php echo e($item->observaciones); ?></p>
                <div class="row text-right">
                    <p class="col-12 border-bottom border-primary">Evidencias</p>
                    <?php ($evidencias = $item->evidencias); ?>
                    <div class="col-12 no-padding" style="margin-top: -10px;">
                        <?php $__empty_2 = true; $__currentLoopData = $evidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <a href="<?php echo e(url('/mascota/evidencia-revision/'.$mascota->id.'/'.$e->id)); ?>" target="_blank" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="bottom" title="<?php echo e($e->nombre); ?>"><i class="fas fa-paperclip"></i></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <p class="col-12 font-small">La revisión de <?php echo e($item->nombre); ?> no tiene evidencias</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="alert alert-warning">No se encontraron elementos</p>
    <?php endif; ?>
</div>