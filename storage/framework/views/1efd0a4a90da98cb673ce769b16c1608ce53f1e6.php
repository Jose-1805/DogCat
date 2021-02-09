<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal"><?php echo e(Auth::user()->getTipoUsuario() == 'afiliado'?'Mis citas':'Citas'); ?></h3>
            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-citas'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-12 no-padding">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                    <a href="#!"  class="btn btn-primary right margin-right-none" id="btn-modal-nueva-cita"><i class="fa fa-plus-circle margin-right-10"></i>Nueva cita</a>
                <?php endif; ?>
            </div>

            <div class="col-12 no-padding">
                <?php echo $__env->make('cita.lista', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <?php echo $__env->make('cita.modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(config('params.google_maps_api_key')); ?>&callback=initMap"></script>
    <script src="<?php echo e(asset('/js/cita/index.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/cita/gestion.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>