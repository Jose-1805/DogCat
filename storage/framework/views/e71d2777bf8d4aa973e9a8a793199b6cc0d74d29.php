

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">Revisiones para <span class="teal-text"><?php echo e($mascota->nombre); ?></span></h3>
            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-revisiones'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12 no-padding">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear_revision', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/mascota/nueva-revision/'.$mascota->id)); ?>" class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i>Nueva revisión</a>
                <?php endif; ?>
            </div>


            <div class="col-12 col-md-3 no-padding">
                <div class="row" id="contenedor-revisiones" style="min-height: 200px;">
                </div>
            </div>

            <div class="col-12 col-md-9">
                <div class="row" id="contenedor-informacion-revision" style="min-height: 200px;">
                    <div class="col-12 text-center">
                        <img src="<?php echo e(asset('/imagenes/sistema/dogcat.png')); ?>" class="col-10 col-md-6 col-lg-5" style="opacity: .2;">
                    </div>
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