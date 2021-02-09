<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Funciones
        <?php if($modulo): ?>
            - <?php echo e($modulo->nombre); ?> <span class="fa fa-times-circle margin-left-10 cursor_pointer cerrar-funciones"></span>
        <?php endif; ?>
    </div>

    <!-- List group -->
    <ul class="list-group">
        <?php $__empty_1 = true; $__currentLoopData = $funciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li class="list-group-item">
                <?php if($modulo): ?>
                    <?php $disabled = ''; ?>
                    <?php if(!Auth::user()->tieneFuncion($identificador_modulo,'editar',$privilegio_superadministrador)): ?>
                        <?php $disabled = 'disabled' ?>
                    <?php endif; ?>

                    <?php if($modulo->tieneFuncion($funcion->id)): ?>
                        <div class="no-margin">
                            <label>
                                <input type="checkbox" class="check-funcion" <?php echo e($disabled); ?> checked data-funcion="<?php echo e($funcion->id); ?>"> <?php echo e($funcion->nombre.' ('.$funcion->identificador.')'); ?>

                            </label>
                        </div>
                    <?php else: ?>
                        <div class="no-margin">
                            <label>
                                <input type="checkbox" class="check-funcion" <?php echo e($disabled); ?> data-funcion="<?php echo e($funcion->id); ?>"> <?php echo e($funcion->nombre.' ('.$funcion->identificador.')'); ?>

                            </label>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo e($funcion->nombre); ?>

                    <span class="badge badge-pill teal white-text left margin-right-10"><?php echo e($funcion->identificador); ?></span>
                    <?php if(Auth::user()->tieneFuncion($identificador_modulo,'editar',$privilegio_superadministrador)): ?>
                        <span class="fa fa-edit right btn-editar-funciones-modulo cursor_pointer blue-text" data-funcion="<?php echo e($funcion->id); ?>"></span>
                    <?php endif; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item">No existen funciones registradas.</li>
        <?php endif; ?>
    </ul>
</div>