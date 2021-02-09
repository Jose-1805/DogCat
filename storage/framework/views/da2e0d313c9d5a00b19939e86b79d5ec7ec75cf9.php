<div class="row">
    <div class="col-12 margin-top-30">
        <!--<div class="btn-group col-12" data-toggle="buttons">-->
        <div class="row">
            <?php if(count($agendas)): ?>
                <p class="col-12 padding-left-2 margin-bottom-5">A continuación seleccione la hora para asignar a la cita</p>
            <?php else: ?>
                <p class="col-12 alert alert-warning">Lo sentimos, no se han encontrado agendas disponibles para la fecha seleccionada</p>
            <?php endif; ?>

            <?php $__currentLoopData = $agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-sm-4 col-lg-2 padding-5">
                    <label class="col-12 btn btn-outline-success waves-effect padding-left-2 padding-right-2 padding-top-10 padding-bottom-10 no-margin">
                        <input class="agendas" data-hora-inicio="<?php echo e($agenda['hora_inicio']); ?>" data-minuto-inicio="<?php echo e($agenda['minuto_inicio']); ?>" type="radio" name="agenda" autocomplete="off"><?php echo e($agenda['hora_inicio'].':'.$agenda['minuto_inicio']); ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>