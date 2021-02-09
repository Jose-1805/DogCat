<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Módulos</div>

    <!-- List group -->
    <div class="list-group">
        <?php $__empty_1 = true; $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="list-group-item"> <?php echo e($modulo->nombre); ?>

                <span class="badge badge-pill teal white-text left margin-right-10"><?php echo e($modulo->identificador); ?></span>
                <span class="fa fa-angle-right right btn-funciones-modulo cursor_pointer green-text font-large" data-modulo="<?php echo e($modulo->id); ?>"></span>
                <?php if(Auth::user()->tieneFuncion($identificador_modulo,'editar',$privilegio_superadministrador)): ?>
                    <span class="fa fa-edit right btn-editar-modulo cursor_pointer margin-right-20 blue-text" data-modulo="<?php echo e($modulo->id); ?>"></span>
                <?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item">No existen módulos registrados.</li>
        <?php endif; ?>
    </div>
</div>