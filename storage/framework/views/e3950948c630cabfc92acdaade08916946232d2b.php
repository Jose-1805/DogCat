<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Roles</p>
            <div class="contenedor-opciones-vista-fixed">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                    <a href="#!"  class="btn btn-primary btn-circle wow fadeInLeftBig" data-toggle="modal" data-target="#modal-nuevo-rol" title="Nuevo afiliado"><i class="fa fa-plus"></i></a>
                <?php endif; ?>
            </div>
            <div class="col-md-7 no-padding" style="min-height: 100px;" id="contenedor-roles">
            </div>

            <div class="col-md-5" style="min-height: 100px;" id="contenedor-privilegios">
                <?php echo $__env->make('rol.lista_privilegios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
    <?php echo $__env->make('rol.modales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/rol/roles.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>