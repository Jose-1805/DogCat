<?php
    $index = count($historial);
?>
<?php $__empty_1 = true; $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card">
        <div class="card-header">Registro #<?php echo e($index--); ?> - <?php echo e($item->created_at); ?></div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php echo Form::label('observaciones','Observaciones'); ?>

                    <p><?php echo e($item->observaciones); ?></p>
                </div>
                <div class="col-12 col-md-3">
                    <?php echo Form::label('estado_anterior','Estado anterior',['class'=>'grey-text text-lighten-1']); ?>

                    <p class="grey-text text-lighten-1"><?php echo e($item->estado_anterior); ?></p>
                </div>
                <div class="col-12 col-md-3">
                    <?php echo Form::label('estado_nuevo','Estado nuevo'); ?>

                    <p><?php echo e($item->estado_nuevo); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div role="alert" class="alert alert-info">.
        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        No existen datos de historial para este registro
    </div>
<?php endif; ?>