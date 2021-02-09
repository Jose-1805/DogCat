<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Entidades</p>
            <div class="contenedor-opciones-vista-fixed">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/entidad/crear')); ?>"  class="btn btn-primary btn-circle wow fadeInLeftBig" data-toggle="tooltip" data-placement="right" title="Nueva entidad"><i class="fa fa-plus"></i></a>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-veterinarias'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <table id="tabla-veterinarias" class="table-hover DataTable">
                <thead>
                    <th width="300">Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Administrador</th>
                    <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','eliminar'],false,$privilegio_superadministrador)): ?>
                        <th class="text-center">Opciones</th>
                    <?php endif; ?>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-desactivar-veterinaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Desactivar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Desactivar una entidad bloqueará todas las funcionalidades relacionadas con la misma.</p>
                    <p>¿Está seguro de desactivar la entidad seleccionada?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-desactivar">Si</button>
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
    <script src="<?php echo e(asset('js/entidad/index.js')); ?>"></script>
    <script>
        var tiene_opciones = false;

        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','eliminar'],false,$privilegio_superadministrador)): ?>
            tiene_opciones = true;
        <?php endif; ?>

        $(function () {


            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'correo', name: 'correo'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'ubicacion', name: 'ubicacion'},
                    {data: 'estado', name: 'estado'},
                    {data: 'administrador', name: 'administrador'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'correo', name: 'correo'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'ubicacion', name: 'ubicacion'},
                    {data: 'estado', name: 'estado'},
                    {data: 'administrador', name: 'administrador'},
                ]
            }

            setCols(cols);
            cargarTablaVeterinarias();
        })
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>