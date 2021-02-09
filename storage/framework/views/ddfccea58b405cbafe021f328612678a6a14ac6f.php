<?php ($indice = count($revisiones)); ?>
<?php $__empty_1 = true; $__currentLoopData = $revisiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revision): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-12">
        <div class="card padding-10 btn_cargar_revision cursor_pointer" data-revision="<?php echo e($revision->id); ?>">
            <div class="card-title border-bottom border-info">
                <p class="text-info no-padding no-margin">
                    Revision #<?php echo e($indice--); ?>

                </p>

                <a class="right" href="<?php echo e(url('/mascota/revision-pdf/'.$revision->mascota_id.'/'.$revision->id)); ?>" target="_blank" style="margin-top: -35px;" data-toggle="tooltip" data-placement="right" title="Expotar a pdf">
                    <i class="fas fa-file-pdf"></i>
                </a>
            </div>
            <div class="card-body no-padding">
                <p class="no-margin">Fecha: <?php echo e(date('Y-m-d',strtotime($revision->created_at))); ?></p>
                <p class="no-margin padding-bottom-20">Por: <?php echo e($revision->usuario->fullName()); ?></p>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12">
        <p class="col-12 alert alert-info">
            No se han registrado revisiones para <strong><?php echo e($mascota->nombre); ?></strong>.
        </p>
    </div>
<?php endif; ?>
