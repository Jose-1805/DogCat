
<div class="row justify-content-center">

    <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
            $imagen = $mascota->imagen;
         ?>
        <div class="col-6 col-md-4 col-lg-3 border hoverable cursor_pointer no-padding">
            <?php if($imagen): ?>
                <div class="col-12" style="height: 150px !important;background-image: url(<?php echo e($imagen->urlAlmacen()); ?>); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                </div>
            <?php else: ?>
                <?php if(strtolower($mascota->raza->tipoMascota->nombre) == 'perro'): ?>
                    <div class="col-12" style="height: 150px !important;background-image: url(<?php echo e(\DogCat\Models\Imagen::urlSiluetaPerro()); ?>); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                    </div>
                <?php else: ?>
                    <div class="col-12" style="height: 150px !important;background-image: url(<?php echo e(\DogCat\Models\Imagen::urlSiluetaGato()); ?>); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <p class="col-12 text-center font-small"><?php echo e($mascota->raza->tipoMascota->nombre.': '.$mascota->nombre); ?></p>
            <p class="col-12 text-center font-small" style="margin-top: -20px !important;"><?php echo e($mascota->dataEdad()['edad'].' '.$mascota->dataEdad()['tipo']); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>