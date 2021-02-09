

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Afiliados</h3>

            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-usuario'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-12 no-padding text-right">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/afiliado/crear')); ?>"  class="btn btn-primary"><i class="fa fa-plus-circle margin-right-10"></i> Nuevo afiliado</a>
                <?php endif; ?>
                <?php echo $__env->make('layouts.componentes.btn_filter_table',['tabla'=>'tabla-usuarios'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12 no-padding">
                <table id="tabla-usuarios" class="table-hover tabla-filter-colums-table">
                    <thead>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
                        <th>Veterinaria</th>
                    <?php endif; ?>
                    <th>Afiliación activa</th>
                    <th>Asesor asignado</th>
                    <th>Última visita periodica</th>
                    <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador)): ?>
                        <th class="text-center">Opciones</th>
                    <?php endif; ?>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-desactivar-usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Desactivar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Desactivar un afiliado bloqueará todas las funcionalidades habilitadas para él.</p>
                    <p>¿Está seguro de desactivar el afiliado seleccionado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-desactivar">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-activar-usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Activar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Activar un afiliado activará todas las funcionalidades relacionadas a él</p>
                    <p>¿Está seguro de activar el afiliado seleccionado?</p>
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
    <script src="<?php echo e(asset('js/afiliado/index.js')); ?>"></script>
    <script>
        var tiene_opciones = false;

        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador)): ?>
            tiene_opciones = true;
        <?php endif; ?>

        $(function () {

            <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
                if(tiene_opciones){
                    var cols = [
                        {data: 'identificacion', name: 'identificacion'},
                        {data: 'nombre', name: 'nombre'},
                        {data: 'email', name: 'email'},
                        {data: 'telefono', name: 'telefono'},
                        {data: 'rol', name: 'rol'},
                        {data: 'veterinaria', name: 'veterinaria'},
                        {data: 'afiliacion_activa', name: 'afiliacion_activa',"className": "text-center"},
                        {data: 'asesor', name: 'asesor'},
                        {data: 'ultima_visita_periodica', name: 'ultima_visita_periodica',"className": "text-center"},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                    ];
                }else{
                    var cols = [
                        {data: 'identificacion', name: 'identificacion'},
                        {data: 'nombre', name: 'nombre'},
                        {data: 'email', name: 'email'},
                        {data: 'telefono', name: 'telefono'},
                        {data: 'rol', name: 'rol'},
                        {data: 'veterinaria', name: 'veterinaria'},
                        {data: 'afiliacion_activa', name: 'afiliacion_activa',"className": "text-center"},
                        {data: 'asesor', name: 'asesor'},
                        {data: 'ultima_visita_periodica', name: 'ultima_visita_periodica',"className": "text-center"},
                    ]
                }
            <?php else: ?>
                if(tiene_opciones){
                    var cols = [
                        {data: 'identificacion', name: 'identificacion'},
                        {data: 'nombre', name: 'nombre'},
                        {data: 'email', name: 'email'},
                        {data: 'telefono', name: 'telefono'},
                        {data: 'rol', name: 'rol'},
                        {data: 'afiliacion_activa', name: 'afiliacion_activa',"className": "text-center"},
                        {data: 'asesor', name: 'asesor'},
                        {data: 'ultima_visita_periodica', name: 'ultima_visita_periodica',"className": "text-center"},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                    ];
                }else{
                    var cols = [
                        {data: 'identificacion', name: 'identificacion'},
                        {data: 'nombre', name: 'nombre'},
                        {data: 'email', name: 'email'},
                        {data: 'telefono', name: 'telefono'},
                        {data: 'rol', name: 'rol'},
                        {data: 'afiliacion_activa', name: 'afiliacion_activa',"className": "text-center"},
                        {data: 'asesor', name: 'asesor'},
                        {data: 'ultima_visita_periodica', name: 'ultima_visita_periodica',"className": "text-center"},
                    ]
                }
            <?php endif; ?>
            setCols(cols);
            cargarTablaUsuarios();
        })
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>