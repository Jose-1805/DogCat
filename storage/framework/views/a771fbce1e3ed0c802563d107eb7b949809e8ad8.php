<?php $__env->startSection('content'); ?>
    <div class="container-fluid padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Registros</p>
            <table id="tabla-registros" class="table-hover">
                <thead>
                    <th width="300">Nombre</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Dirección</th>
                    <th>Veterinaria</th>
                    <th>Estado</th>
                    <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','historial'],false,$privilegio_superadministrador)): ?>
                        <th class="text-center">Opciones</th>
                    <?php endif; ?>
                </thead>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script>
        var tiene_opciones = false;

        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','historial'],false,$privilegio_superadministrador)): ?>
            tiene_opciones = true;
        <?php endif; ?>

        $(function () {
            var tabla_registros = $('#tabla-registros').dataTable({ "destroy": true });
            tabla_registros.fnDestroy();
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabla-registros').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'DATATABLES ERROR: ', message);
            })

            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'email', name: 'email'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'veterinaria', name: 'veterinaria'},
                    {data: 'estado', name: 'estado'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'email', name: 'email'},
                    {data: 'telefono', name: 'telefono'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'estado', name: 'estado'}
                ]
            }

            tabla_registros = $('#tabla-registros').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: $("#general_url").val()+"/registro/datos",
                columns: cols,
                fnRowCallback: function (nRow, aData, iDisplayIndex) {
                    setTimeout(function () {
                        inicializarComplementos();
                    },300);
                },
            });
        })
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>