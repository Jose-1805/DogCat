

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">Créditos de afiliación</h3>
            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-credito-afiliacion'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-12 no-padding text-right">
                <?php echo $__env->make('layouts.componentes.btn_filter_table',['tabla'=>'tabla-creditos-afiliacion'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12 no-padding">
                <table id="tabla-creditos-afiliacion" class="table-hover DataTable tabla-filter-colums-table">
                    <thead>
                        <th class="text-center">Afiliación</th>
                        <th>Estado de afiliación</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th class="text-center">Valor crédito</th>
                        <th class="text-center">Valor cuota</th>
                        <th class="text-center">Cantidad cuotas</th>
                        <th class="text-center">Opciones</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/credito_afiliacion/credito_afiliacion.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>