<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Afiliados</p>

            <div class="contenedor-opciones-vista-fixed">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/afiliado/crear')); ?>"  class="btn btn-primary btn-circle wow fadeInLeftBig" data-toggle="tooltip" data-placement="right" title="Nuev@ afiliad@"><i class="fa fa-plus"></i></a>
                <?php endif; ?>
            </div>

            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-usuario'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-12 no-padding">
                <table id="tabla-usuarios" class="table-hover">
                    <thead>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha nacimiento</th>
                    <th>Genero</th>
                    <th>Rol</th>
                    <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
                        <th>Veterinaria</th>
                    <?php endif; ?>
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
                        {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
                        {data: 'genero', name: 'genero'},
                        {data: 'rol', name: 'rol'},
                        {data: 'veterinaria', name: 'veterinaria'},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                    ];
                }else{
                    var cols = [
                        {data: 'identificacion', name: 'identificacion'},
                        {data: 'nombre', name: 'nombre'},
                        {data: 'email', name: 'email'},
                        {data: 'telefono', name: 'telefono'},
                        {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
                        {data: 'genero', name: 'genero'},
                        {data: 'rol', name: 'rol'},
                        {data: 'veterinaria', name: 'veterinaria'}
                    ]
                }
            <?php else: ?>
                if(tiene_opciones){
                    var cols = [
                        {data: 'identificacion', name: 'identificacion'},
                        {data: 'nombre', name: 'nombre'},
                        {data: 'email', name: 'email'},
                        {data: 'telefono', name: 'telefono'},
                        {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
                        {data: 'genero', name: 'genero'},
                        {data: 'rol', name: 'rol'},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                    ];
                }else{
                    var cols = [
                        {data: 'identificacion', name: 'identificacion'},
                        {data: 'nombre', name: 'nombre'},
                        {data: 'email', name: 'email'},
                        {data: 'telefono', name: 'telefono'},
                        {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
                        {data: 'genero', name: 'genero'},
                        {data: 'rol', name: 'rol'}
                    ]
                }
            <?php endif; ?>
            setCols(cols);
            cargarTablaUsuarios();
        })
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>