<?php (
    $usuarios = \DogCat\User::permitidos()
    ->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos," (",roles.nombre,")") as nombre'))
    ->join('roles','users.rol_id','=','roles.id')
    ->where('users.estado','activo')->get()->pluck('nombre','id')
); ?>



<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">Solicitud de afiliaciones</h3>
            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-solicitud-afiliacion'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-12 no-padding">
                <?php if(Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro"): ?>
                    <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador) && !$solicitud_activa && !Auth::user()->afiliacionActivaOProceso()): ?>
                        <a href="#!" class="btn btn-primary right margin-right-none btn-nueva-solicitud-afiliacion"><i class="fa fa-plus-circle margin-right-10"></i>Nueva solicitud</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="col-12 no-padding">
                <table id="tabla-solicitudes-afiliaciones" class="table-hover DataTable">
                    <thead>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Asesor asignado</th>
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


            <div class="modal fade" id="modal-asignar-solicitud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Asignar solicitud</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Seleccione el usuario al cual será asignada la solicitud seleccionada.</p>
                            <?php echo Form::select('usuario',$usuarios,null,['id'=>'usuario','class'=>'form-control']); ?>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success" id="btn-asignar-solicitud-ok">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/solicitud_afiliacion/solicitud_afiliacion.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>