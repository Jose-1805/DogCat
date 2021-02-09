<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Servicios</div>

    <!-- List group -->
    <div class="list-group">
        <?php $__empty_1 = true; $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="list-group-item"> <?php echo e($servicio->nombre); ?>

                <span class="fa fa-angle-right right btn-usuarios-servicio cursor_pointer green-text font-large" data-servicio="<?php echo e($servicio->id); ?>"></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item">No existen servicios registrados.</li>
        <?php endif; ?>
    </div>
</div>