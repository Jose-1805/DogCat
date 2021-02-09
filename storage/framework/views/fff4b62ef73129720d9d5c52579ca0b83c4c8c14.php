

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal">Nueva revisión para <span class="teal-text"><?php echo e($mascota->nombre); ?></span></p>

            <div class="col-12">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <!--<script src="<?php echo e(asset('js/mascota/revision.js')); ?>"></script>
    <script>
        $(function () {
            mascota = <?php echo e($mascota->id); ?>;
            cargarRevisiones();
        })
    </script>-->
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>