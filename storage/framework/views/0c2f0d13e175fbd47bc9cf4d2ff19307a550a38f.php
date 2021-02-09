<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal">Información de veterinarias</p>

            <?php if(count($veterinarias)): ?>
                <?php $__currentLoopData = $veterinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <?php if($v->imagen): ?>
                                <img class="img-fluid" src="<?php echo e(url('/almacen/'.str_replace('/','-',$v->imagen->ubicacion).'-'.$v->imagen->nombre)); ?>" alt="Nombre">
                            <?php endif; ?>
                            <!--Card content-->
                            <div class="card-body">
                                <!--Title-->
                                <h4 class="card-title border-bottom"><?php echo e($v->nombre); ?></h4>
                                <!--Text-->
                                <p class="card-text"><strong>Correo: </strong><?php echo e($v->correo); ?></p>
                                <p class="card-text"><strong>Teléfono: </strong><?php echo e($v->telefono); ?></p>
                                <p class="card-text"><strong>Dirección: </strong><?php echo e($v->ubicacion->stringDireccion()); ?></p>
                                <?php if($v->web_site): ?>
                                    <a href="<?php echo e($v->web_site); ?>" class="btn btn-info" target="_blank">WebSite</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <strong><i class="fa fa-info-circle"></i></strong> No existen veterinarias registradas en el sistema
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/mascota/mascota.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>