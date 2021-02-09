<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Roles</div>

    <!-- List group -->
    <div class="list-group">
        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="list-group-item"> <?php echo e($rol->nombre); ?>

                <span class="fa fa-angle-right right btn-privilegios-rol cursor_pointer green-text font-large" data-rol="<?php echo e($rol->id); ?>"></span>
                <?php if(Auth::user()->tieneFuncion($identificador_modulo,'editar',$privilegio_superadministrador)): ?>
                    <span class="fa fa-edit right btn-editar-rol cursor_pointer margin-right-20 blue-text" data-rol="<?php echo e($rol->id); ?>"></span>
                <?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item">No existen roles registrados.</li>
        <?php endif; ?>
    </div>
</div>