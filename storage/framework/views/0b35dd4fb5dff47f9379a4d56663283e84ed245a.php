

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Finanzas <span class="teal-text mayuscula">Dogcat</span></h3>
        </div>

        <div class="row">
            <div class="col-12 col-lg-3 no-padding" style="padding-top: 20px !important;">
                <p class="alert alert-warning">
                    El sistema de finanzas <strong>DOGCAT</strong> permite visualizar y gestionar información sobre
                    ingresos, egresos, utilidades, objetivos de ventas y obligaciones económicas o financieras
                    de la empresa, ya sea de manera mensual o anual.
                    <br>
                    <br>
                    Los botónes de abajo le permiten cargar el contenido.

                </p>

                <a data-contenido="graficas" class="btn btn-block btn-primary btn-cargar-contenido-finanzas"><i class="fas fa-chart-line margin-right-5"></i>Gráficas</a>
                <a data-contenido="ingresos" class="btn btn-block btn-primary btn-cargar-contenido-finanzas"><i class="fas fa-thumbs-up margin-right-5"></i>Ingresos</a>
                <a data-contenido="egresos" class="btn btn-block btn-primary btn-cargar-contenido-finanzas"><i class="fas fa-thumbs-down margin-right-5"></i>Egresos</a>
                <a data-contenido="" class="btn btn-block btn-primary btn-cargar-contenido-finanzas disabled"><i class="fas fa-flag-checkered margin-right-5"></i>Objetivos de ventas</a>
                <a data-contenido="" class="btn btn-block btn-primary btn-cargar-contenido-finanzas disabled"><i class="fas fa-exclamation-circle margin-right-5"></i>Obligaciones</a>
            </div>
            <div class="col-12 col-lg-9 padding-top-20">
                <div id="contenedor-graficas" class="contenido-finanzas">
                    <?php echo $__env->make('finanzas.contenido.graficas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="contenedor-ingresos" class="contenido-finanzas d-none">
                    <?php echo $__env->make('finanzas.contenido.ingresos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="contenedor-egresos" class="contenido-finanzas d-none">
                    <?php echo $__env->make('finanzas.contenido.egresos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal-activar-veterinaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Activar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Activar una entidad activará todas las funcionalidades relacionadas con la misma</p>
                    <p>¿Está seguro de activar la entidad seleccionada?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btn-submit" id="btn-activar">Si</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/finanzas/index.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>