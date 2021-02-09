<?php (
    $usuarios = \DogCat\User::permitidos()
    ->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos," (",roles.nombre,")") as nombre'))
    ->join('roles','users.rol_id','=','roles.id')
    ->where('users.estado','activo')->get()->pluck('nombre','id')
); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-fluid padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Registros</h3>
            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-registros'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12 no-padding text-right">
                <?php echo $__env->make('layouts.componentes.btn_filter_table',['tabla'=>'tabla-registros'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <table id="tabla-registros" class="table-hover tabla-filter-colums-table">
                <thead>
                    <!-- utilizar la clase filter-column-no-render para no
                    mostrar una columna al renderizar la tabla por primera vez-->
                    <th class="">Fecha de registro</th>
                    <th width="300">Nombre</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Dirección</th>
                    <th>Barrio</th>
                    <th>Veterinaria</th>
                    <th>Usuario asignado</th>
                    <th>Estado</th>
                    <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','historial'],false,$privilegio_superadministrador)): ?>
                        <th class="text-center">Opciones</th>
                    <?php endif; ?>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-asignar-registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Asignar registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Seleccione el usuario al cual será asignado el registro seleccionado.</p>
                    <?php echo Form::select('registro',$usuarios,null,['id'=>'registro','class'=>'form-control']); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btn-asignar-registro-ok">Guardar</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/registro/registro.js')); ?>"></script>
    <script>
        var tiene_opciones = false;

        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','historial'],false,$privilegio_superadministrador)): ?>
            tiene_opciones = true;
        <?php endif; ?>

        $(function () {
            if(tiene_opciones){
                var cols = [
                    {data: 'fecha', name: 'fecha'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'email', name: 'email'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'barrio', name: 'barrio'},
                    {data: 'veterinaria', name: 'veterinaria'},
                    {data: 'usuario_asignado', name: 'usuario_asignado'},
                    {data: 'estado', name: 'estado'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'fecha', name: 'fecha'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'email', name: 'email'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'veterinaria', name: 'veterinaria'},
                    {data: 'usuario_asignado', name: 'usuario_asignado'},
                    {data: 'estado', name: 'estado'},
                ]
            }

            setCols(cols);
            cargarTablaRegistros();
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>