<?php if(count($agendas)): ?>
    <ul class="list-group list-group-flush">
<?php endif; ?>
    <?php $__empty_1 = true; $__currentLoopData = $agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php ($cita = $agenda->cita); ?>
        <?php ($mascota = $cita->getMascota()); ?>
        <li class="list-group-item hoverable">
            <p class="font-small no-padding no-margin"><?php echo e($cita->servicio->nombre); ?></p>
            <p class="font-small no-padding no-margin teal-text text-lighten-2">
                <?php if(Auth::user()->tieneFuncion(\DogCat\Http\Controllers\MascotaController::$identificador_modulo_static, 'editar', \DogCat\Http\Controllers\MascotaController::$privilegio_superadministrador_static)): ?>
                    <a target="_blank" class="teal-text text-lighten-2" href="<?php echo e(url('/mascota/editar/'.$mascota->id)); ?>">
                        <?php echo e($mascota->nombre.' ('.$mascota->raza->tipoMascota->nombre.') - '); ?> <i class="fas fa-pen-square"> </i>
                    </a>
                <?php else: ?>
                    <?php echo e($mascota->nombre.' ('.$mascota->raza->tipoMascota->nombre.') - '); ?>

                <?php endif; ?>
                <i><?php echo e($mascota->user->fullName()); ?></i>
            </p>
            <p class="font-small no-padding no-margin"><u><?php echo e($mascota->peso.' KG'); ?></u></p>
            <p class="font-small no-padding no-margin">De <?php echo e($agenda->strHoraInicio()); ?> a <?php echo e($agenda->strHoraFin()); ?></p>
            <div class="right">
                <span data-cita="<?php echo e($cita->id); ?>" class="btn-ver-cita cursor_pointer teal-text text-lighten-1 fas fa-eye margin-5" data-toggle="tooltip" data-placement="bottom" title="Ver completo"></span>
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'cancelar', $privilegio_superadministrador) && $cita->estado == 'Agendada'): ?>
                    <span data-cita="<?php echo e($cita->id); ?>" class="btn-cancelar-cita cursor_pointer teal-text text-lighten-1 fas fa-minus-square margin-5" data-toggle="tooltip" data-placement="bottom" title="Cancelar cita"></span>
                <?php endif; ?>

                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'pagos', $privilegio_superadministrador) && $cita->estado == 'Agendada'): ?>
                    <span data-cita="<?php echo e($cita->id); ?>" class="btn-pagar-cita cursor_pointer teal-text text-lighten-1 fas fa-hand-holding-usd margin-5" data-toggle="tooltip" data-placement="bottom" title="Facturar cita"></span>
                <?php endif; ?>

                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'editar', $privilegio_superadministrador) && $cita->estado == 'Facturada'): ?>
                    <span data-cita="<?php echo e($cita->id); ?>" class="btn-finalizar-cita cursor_pointer teal-text text-lighten-1 fas fa-handshake margin-5" data-toggle="tooltip" data-placement="bottom" title="Atender cita (finalizar)"></span>
                <?php endif; ?>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="alert alert-info">No hay citas registradas para la fecha.</p>
    <?php endif; ?>
<?php if(count($agendas)): ?>
    </ul>
<?php endif; ?>