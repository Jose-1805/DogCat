

<?php $__env->startSection('content'); ?>
        <div class="container-fluid white padding-50">
            <div class="row">
                <h3 class="titulo_principal margin-bottom-20">Módulos y Funciones</h3>

                <div class="col-12 no-padding">
                <div class="alert alert-warning" role="alert">.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Alerta! </strong>esta funcionalidad es de vital importancía para el correcto funcionamiento del sistema, debe ser manipulada con el respectivo cuidado y responsabilidad.
                </div>
                </div>
                <div class="col-md-6 no-padding" id="contenedor-modulos" style="min-height: 50px;">

                </div>

                <div class="col-md-4">
                    <div class="row" >
                        <div class="col-12 ">
                            <div class="col-12 no-padding" id="contenedor-funciones" style="min-height: 50px;">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 padding-right-none padding-left-none">
                    <?php $disabled = ''; ?>
                    <?php if(!Auth::user()->tieneFuncion($identificador_modulo,'crear',$privilegio_superadministrador)): ?>
                            <?php $disabled = 'disabled'; ?>
                    <?php endif; ?>
                    <a class="btn btn-block btn-success" data-toggle="modal" <?php if($disabled == ''): ?> data-target="#modal-nuevo-modulo" <?php endif; ?><?php echo e($disabled); ?>>Nuevo Módulo</a>
                    <a class="btn btn-block btn-success" data-toggle="modal" <?php if($disabled == ''): ?> data-target="#modal-nueva-funcion" <?php endif; ?><?php echo e($disabled); ?>>Nueva Función</a>
                </div>
            </div>
        </div>

        <?php echo $__env->make('modulos_funciones.modales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/modulos_funciones/modulos_funciones.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>