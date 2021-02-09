

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal">Revisiones para <span class="teal-text"><?php echo e($mascota->nombre); ?></span></p>
            <div class="contenedor-opciones-vista-fixed">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear_revision', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/mascota/nueva-revision/'.$mascota->id)); ?>" class="btn btn-primary btn-circle wow fadeInLeftBig" data-toggle="tooltip" data-placement="right" title="Nueva revisión"><i class="fa fa-plus"></i></a>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <div class="row" id="contenedor-revisiones">
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/mascota/revision.js')); ?>"></script>
    <script>
        $(function () {
            mascota = <?php echo e($mascota->id); ?>;
            cargarRevisiones();
        })
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>