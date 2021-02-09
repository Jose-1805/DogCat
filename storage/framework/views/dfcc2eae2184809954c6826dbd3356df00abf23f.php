<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal">Solicitud de afiliaciones</p>
            <div class="contenedor-opciones-vista-fixed">
                <?php if(Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro"): ?>
                    <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador) && !$solicitud_activa && !Auth::user()->afiliacionActivaOProceso()): ?>
                        <a href="#!" class="btn btn-primary btn-circle wow fadeInLeftBig btn-nueva-solicitud-afiliacion" data-toggle="tooltip" data-placement="right" title="Nueva solicitud de afiliación"><i class="fa fa-plus"></i></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-solicitud-afiliacion'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
            <?php if(Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro"): ?>
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador) && !$solicitud_activa): ?>
                    <div class="modal fade" id="modal-solicitud-afiliacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Enviar solicitud</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Está seguro de enviar una nueva solicitud de afiliación?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-primary" id="btn-enviar-solicitud">Si</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/solicitud_afiliacion/solicitud_afiliacion.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>