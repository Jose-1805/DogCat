
<div class="row justify-content-center content-select-img" id="selector-imagenes">

    <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
            $imagen = $mascota->imagen;
         ?>
        <div class="col-6 col-md-4 col-lg-3 padding-5">
            <div class="col-12 border hoverable cursor_pointer no-padding item-select-img" data-value="<?php echo e($mascota->id); ?>">
                <?php if($imagen): ?>
                    <div class="col-12 view" style="height: 150px !important;background-image: url(<?php echo e($imagen->urlAlmacen()); ?>); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                        <div class="mask cursor_pointer"></div>
                    </div>
                <?php else: ?>
                    <?php if(strtolower($mascota->raza->tipoMascota->nombre) == 'perro'): ?>
                        <div class="col-12 view" style="height: 150px !important;background-image: url(<?php echo e(\DogCat\Models\Imagen::urlSiluetaPerro()); ?>); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                            <div class="mask cursor_pointer"></div>
                        </div>
                    <?php else: ?>
                        <div class="col-12 view" style="height: 150px !important;background-image: url(<?php echo e(\DogCat\Models\Imagen::urlSiluetaGato()); ?>); background-size: auto 100%; background-repeat: no-repeat;background-position: center;">
                            <div class="mask cursor_pointer"></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <p class="col-12 text-center font-small"><?php echo e($mascota->raza->tipoMascota->nombre.': '.$mascota->nombre); ?></p>
                <p class="col-12 text-center font-small" style="margin-top: -20px !important;"><?php echo e($mascota->dataEdad()['edad'].' '.$mascota->dataEdad()['tipo']); ?></p>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>