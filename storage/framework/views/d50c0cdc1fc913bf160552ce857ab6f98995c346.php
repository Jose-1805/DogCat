<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Usuarios
        <?php if($servicio): ?>
            - <?php echo e($servicio->nombre); ?> <span class="fa fa-times-circle margin-left-10 cursor_pointer cerrar-usuarios"></span>
        <?php endif; ?>
    </div>

    <!-- List group -->
    <ul class="list-group">
        <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li class="list-group-item">
                <?php if($servicio): ?>
                    <?php if($servicio->tieneUsuario($usuario->id)): ?>
                        <div class="no-margin">
                            <label class="font-medium">
                                <input type="checkbox" class="check-usuario" checked data-usuario="<?php echo e($usuario->id); ?>"> <?php echo e($usuario->fullName().' ('.$usuario->rol->nombre.')'); ?>

                            </label>
                        </div>
                    <?php else: ?>
                        <div class="no-margin">
                            <label class="font-medium">
                                <input type="checkbox" class="check-usuario" data-usuario="<?php echo e($usuario->id); ?>"> <?php echo e($usuario->fullName().' ('.$usuario->rol->nombre.')'); ?>

                            </label>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo e($usuario->fullName().' ('.$usuario->rol->nombre.')'); ?>

                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item">No existen usuarios registradas.</li>
        <?php endif; ?>
    </ul>
</div>