<h4 class="grey-text mayuscula margin-bottom-40">Listado de ingresos</h4>
<a id="btn-nuevo-ingreso" class="btn btn-primary right" style="margin-top: -80px;"><i class="fas fa-plus-circle margin-right-10"></i>Nuevo ingreso</a>
<?php (
    $fuentes = [
        'Afiliación'=>'Afiliación',
        'Servicio'=>'Servicio',
        'Prestamo'=>'Prestamo',
        'Otro'=>'Otro'
    ]
); ?>

<?php (
    $medios_pago = [
        'Efectivo'=>'Efectivo',
        'PSE'=>'PSE',
        'Consignación'=>'Consignación',
        'Transferencia'=>'Transferencia'
    ]
); ?>
<div class="row">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('ingresos_desde','Desde',['class'=>'active']); ?>

            <?php echo Form::date('ingresos_desde',date('Y-m-d',strtotime('-1 month')),['id'=>'ingresos_desde','class'=>'form-control filtro-ingresos']); ?>

        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="md-form">
            <?php echo Form::label('ingresos_hasta','Hasta',['class'=>'active']); ?>

            <?php echo Form::date('ingresos_hasta',date('Y-m-d'),['id'=>'ingresos_hasta','class'=>'form-control filtro-ingresos']); ?>

        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="md-form c-select">
            <?php echo Form::label('ingresos_fuente','Fuente',['class'=>'active']); ?>

            <?php echo Form::select('ingresos_fuente',['todas'=>'Todas','Afiliación'=>'Afiliación','Servicio'=>'Servicio'],null,['id'=>'ingresos_fuente','class'=>'form-control filtro-ingresos']); ?>

        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="md-form c-select">
            <?php echo Form::label('ingresos_medio_pago','Medio de mago',['class'=>'active']); ?>

            <?php echo Form::select('ingresos_medio_pago',['todos'=>'Todos','Efectivo'=>'Efectivo','PSE'=>'PSE','Consignación'=>'Consignación','Transferencia'=>'Transferencia'],null,['id'=>'ingresos_medio_pago','class'=>'form-control filtro-ingresos']); ?>

        </div>
    </div>
</div>

<table class="dataTable" id="tabla-ingresos">
    <thead>
        <th class="text-center" width="100">Fecha</th>
        <th class="text-center" width="100">Valor</th>
        <th class="text-center">Nª Factura</th>
        <th class="text-center">Fuente</th>
        <th class="text-center">Detalle fuente</th>
        <th class="text-center">Medio de pago</th>
        <th class="text-center" width="100">Còdigo de verificación</th>
        <th class="text-center">Evidencia</th>
        <th class="text-center">Usuario</th>
    </thead>
</table>

<div class="modal fade" id="modal-nuevo-ingreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Nuevo ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-nuevo-ingreso'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo Form::open(['id'=>'form-nuevo-ingreso','class'=>'row']); ?>

                <div class="col-12 margin-top-10">
                    <div class="md-form c-select">
                        <?php echo Form::label('fuente_ingreso','Fuente de ingreso (*)',['class'=>'active']); ?>

                        <?php echo Form::select('fuente_ingreso',$fuentes,null,['id'=>'fuente_ingreso','class'=>'form-control']); ?>

                    </div>
                </div>
                <div class="col-12">
                    <div class="md-form">
                        <?php echo Form::label('descripcion_ingreso','Descripción',['class'=>'active']); ?>

                        <?php echo Form::textarea('descripcion_ingreso',null,['id'=>'descripcion_ingreso','class'=>'form-control md-textarea']); ?>

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('numero_factura_ingreso','Nª Factura',['class'=>'active']); ?>

                        <?php echo Form::text('numero_factura_ingreso',null,['id'=>'numero_factura_ingreso','class'=>'form-control']); ?>

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('valor_ingreso','Valor (*)',['class'=>'active']); ?>

                        <?php echo Form::text('valor_ingreso',null,['id'=>'valor_ingreso','class'=>'form-control num-int-positivo']); ?>

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="md-form c-select">
                        <?php echo Form::label('medio_pago_ingreso','Medio de pago (*)',['class'=>'active']); ?>

                        <?php echo Form::select('medio_pago_ingreso',$medios_pago,null,['id'=>'medio_pago_ingreso','class'=>'form-control']); ?>

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('codigo_verificacion_ingreso','Código de verificación',['class'=>'active']); ?>

                        <?php echo Form::text('codigo_verificacion_ingreso',null,['id'=>'codigo_verificacion_ingreso','class'=>'form-control']); ?>

                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <?php echo Form::label('evidencia_ingreso','Evidencia',['class'=>'active col-12']); ?>

                        <div class="col-12">
                            <?php echo Form::file('evidencia_ingreso',null,['id'=>'evidencia_ingreso','class'=>'form-control']); ?>

                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-submit" id="btn-guardar-ingreso">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirmacion-ingreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Confirmar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Este paso no se puede deshacer, continue si está seguro de guardar la información que ingresó.</p>
                <p>¿Está seguro guardar el nuevo ingreso?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn-guardar-ingreso-no">No</button>
                <button type="button" class="btn btn-primary" id="btn-guardar-ingreso-ok">Si</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('/js/finanzas/ingresos.js')); ?>"></script>
<?php $__env->stopSection(); ?>