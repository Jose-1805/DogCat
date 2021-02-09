<?php $__empty_1 = true; $__currentLoopData = $revisiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revision): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-12 col-md-4 col-md-3">
        <a href="#!" class="card padding-10">
            <div class="card-title border-bottom border-info">
                <p class="text-info no-padding no-margin">Revision #1</p>
            </div>
            <div class="card-body no-padding">
                <p class="no-margin">Fecha: 22-06-2018</p>
                <p class="no-margin padding-bottom-20">Por: Santiago</p>
            </div>
        </a>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="col-12 alert alert-info">
        No se han registrado revisiones para <strong><?php echo e($mascota->nombre); ?></strong>.
    </p>
<?php endif; ?>