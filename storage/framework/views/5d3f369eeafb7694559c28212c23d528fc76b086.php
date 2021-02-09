

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Servicios</h3>

            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-servicio'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-12 no-padding">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/servicio/crear')); ?>"  class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i>Nuevo servicio</a>
                <?php endif; ?>
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'asignar', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/servicio/asignar')); ?>"  class="btn btn-primary right"><i class="fa fa-users margin-right-10"></i>Asignar servicios</a>
                <?php endif; ?>
            </div>

            <div class="col-12 no-padding">
                <table id="tabla-servicios" class="table-hover">
                    <thead>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
                        <th>Entidad</th>
                    <?php endif; ?>
                    <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador)): ?>
                        <th class="text-center">Opciones</th>
                    <?php endif; ?>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-desactivar-servicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Desactivar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Desactivar un servicio inhabilitará la asignación a usuarios y la solicitud de nuevas citas relacionadas con el servicio.</p>
                    <p>¿Está seguro de desactivar el servicio seleccionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-desactivar">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-activar-servicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Activar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Activar un servicio habilitará la asignación a usuarios y la solicitud de nuevas citas relacionadas con el servicio.</p>
                    <p>¿Está seguro de activar el servicio seleccionado?</p>
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
    <script src="<?php echo e(asset('js/servicio/index.js')); ?>"></script>
    <script>
        var tiene_opciones = false;

        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador)): ?>
            tiene_opciones = true;
        <?php endif; ?>

        $(function () {

            <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                    {data: 'entidad', name: 'entidad'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                    {data: 'entidad', name: 'entidad'},
                ]
            }
            <?php else: ?>
            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'estado', name: 'estado'},
                ]
            }
            <?php endif; ?>
            setCols(cols);
            cargarTablaServicios();
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>