<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal">Solicitud de afiliaciones</p>
            <div class="contenedor-opciones-vista-fixed">
                <?php if(Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro"): ?>
                    <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador) && !$solicitud_activa): ?>
                        <a href="#!" class="btn btn-primary btn-circle wow fadeInLeftBig" data-toggle="tooltip" data-placement="right" title="Nueva solicitud de afiliación"><i class="fa fa-plus"></i></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="col-12 no-padding">
                <table id="tabla-solicitudes-afiliaciones" class="table-hover DataTable">
                    <thead>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['ver'],false,$privilegio_superadministrador)): ?>
                        <th class="text-center">Opciones</th>
                    <?php endif; ?>
                    </thead>
                </table>
        </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/solicitud_afiliacion/solicitud_afiliacion.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>