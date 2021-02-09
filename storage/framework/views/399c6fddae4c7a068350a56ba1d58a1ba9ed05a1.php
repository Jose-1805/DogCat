

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Afiliaciones</h3>
            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-afiliaciones'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12 no-padding">
                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                    <a href="<?php echo e(url('/afiliacion/nueva')); ?>"  class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i>Nueva afiliación</a>
                <?php endif; ?>
            </div>
            <table id="tabla-afiliaciones" class="table-hover dataTable">
                <thead>
                <th width="180">Fecha</th>
                <th>Consecutivo</th>
                <th>Asesor</th>
                <th>Usuario</th>
                <th>Fecha último pago</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th width="100">Valor</th>
                <th>Estado</th>
                <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','pagos','ver'],false,$privilegio_superadministrador)): ?>
                    <th class="text-center">Opciones</th>
                <?php endif; ?>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="modal-marcar-pagada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Marcar como pagada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 no-padding">
                            <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-marcar-pagada'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="" id="contenedor-form-marcar-pagada">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-submit" id="btn-marcar-pagada">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/afiliacion/afiliacion.js')); ?>"></script>
    <script>
        var tiene_opciones = false;

        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','pagos','ver'],false,$privilegio_superadministrador)): ?>
            tiene_opciones = true;
        <?php endif; ?>

        $(function () {

            if(tiene_opciones){
                var cols = [
                    {data: 'fecha', name: 'fecha'},
                    {data: 'consecutivo', name: 'consecutivo'},
                    {data: 'asesor', name: 'asesor'},
                    {data: 'usuario', name: 'usuario'},
                    {data: 'fecha_ultimo_pago', name: 'fecha_ultimo_pago'},
                    {data: 'fecha_inicio', name: 'fecha_inicio'},
                    {data: 'fecha_fin', name: 'fecha_fin'},
                    {data: 'valor', name: 'valor'},
                    {data: 'estado', name: 'estado'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'fecha', name: 'fecha'},
                    {data: 'consecutivo', name: 'consecutivo'},
                    {data: 'asesor', name: 'asesor'},
                    {data: 'usuario', name: 'usuario'},
                    {data: 'fecha_ultimo_pago', name: 'fecha_ultimo_pago'},
                    {data: 'fecha_inicio', name: 'fecha_inicio'},
                    {data: 'fecha_fin', name: 'fecha_fin'},
                    {data: 'valor', name: 'valor'},
                    {data: 'estado', name: 'estado'},
                ]
            }

            setCols(cols);
            cargarTablaAfiliaciones();
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>