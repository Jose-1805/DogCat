<div class="row">
    <div class="col-12">
        <!--<div class="btn-group col-12" data-toggle="buttons">-->
        <div class="row">
            <?php if(count($disponibilidades)): ?>
                <p class="col-12 padding-left-2 margin-bottom-5">A continuación seleccione la fecha para asignar a la cita</p>
            <?php endif; ?>
            <?php $__empty_1 = true; $__currentLoopData = $disponibilidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disponibilidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-6 col-sm-4 col-lg-2 padding-5">
                    <label class="col-12 btn btn-outline-info waves-effect padding-left-2 padding-right-2 padding-top-10 padding-bottom-10 no-margin">
                        <input class="disponibilidad" data-fecha="<?php echo e($disponibilidad->fecha); ?>" type="radio" name="options" autocomplete="off"> <span class=""><?php echo e($disponibilidad->strDiaFecha()); ?></span><br><?php echo e($disponibilidad->fecha); ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="col-12 alert alert-warning">Lo sentimos, no se han encontrado disponibilidades cercanas con el encargado seleccionado</p>
            <?php endif; ?>
        </div>
    </div>
</div>