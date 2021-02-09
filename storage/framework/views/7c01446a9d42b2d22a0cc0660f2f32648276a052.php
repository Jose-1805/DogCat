
<?php
    $estados = [];
    if($solicitud->estado == 'registrada'){
        $estados = [
            'registrada'=>'registrada',
            'en proceso'=>'en proceso',
            'procesada'=>'procesada',
            'descartada'=>'descartada'
        ];
    }else{
        $estados = [
            'en proceso'=>'en proceso',
            'procesada'=>'procesada',
            'descartada'=>'descartada'
        ];
    }
?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="col-12 titulo_principal margin-bottom-20">Historial de solicitud de afiliación</p>

            <div class="col-12 grey lighten-5 margin-bottom-10 padding-10">
                <div class="row">
                    <p class="col-12 titulo_secundario margin-bottom-20">Datos de la solicitud</p>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('identificacion','Identificación'); ?>

                        <p><?php echo e($user->tipo_identificacion.' '.$user->identificacion); ?></p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('usuario','Usuario'); ?>

                        <p><?php echo e($user->nombres.' '.$user->apellidos); ?></p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('fecha','Fecha'); ?>

                        <p><?php echo e($solicitud->created_at); ?></p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('estado','Estado'); ?>

                        <p><?php echo e($solicitud->estado); ?></p>
                    </div>
                </div>
            </div>
            <?php if(Auth::user()->getTipoUsuario() == "personal dogcat"): ?>
                <?php if($solicitud->estado != 'procesada' && $solicitud->estado != 'cancelada'): ?>
                    <?php echo Form::open(['id'=>'form-historial-solicitud-afiliacion','class'=>'col-12 grey lighten-5 padding-10']); ?>

                        <div class="row">
                            <p class="col-12 titulo_secundario margin-bottom-20">Nuevo historal</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-nuevo-historial-solicitud-afiliacion'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                            <?php echo Form::hidden('solicitud',$solicitud->id); ?>

                            <div class="col-12 col-md-7">
                                <div class="form-group">
                                    <?php echo Form::label('observaciones','Observaciones'); ?>


                                    <?php echo Form::textarea('observaciones',null,['id'=>'observaciones','class'=>'form-control','rows'=>'1','maxlength'=>1000]); ?>

                                    <p class="count-length">1000</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <?php echo Form::label('estado','Estado'); ?>


                                    <?php echo Form::select('estado',$estados,$solicitud->estado,['id'=>'estado','class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="col-12 col-md-2 text-center" style="margin-top: 15px !important;">
                                <a href="#!" class="btn btn-success btn-block" id="btn-nuevo-historial-solicitud-afiliacion">Guardar</a>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                <?php else: ?>
                    <div role="alert" class="alert alert-info col-12">.
                        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        La solicitud se encuentra en estado <?php echo e($solicitud->estado); ?>, por lo tanto no será posible registrar más historiales
                    </div>
                <?php endif; ?>
            <?php endif; ?>


            <div class="col-12 no-padding">
                <p class="col-12 margin-top-30 titulo_secundario">Historiales registrados</p>
                <div class="col-12" id="contenedor-lista-historial" style="min-height: 50px;">
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/solicitud_afiliacion/historial.js')); ?>"></script>
    <script>
        $(function () {
            registro = <?php echo e($solicitud->id); ?>;
            cargarHistorialSolicitudAfiliacion();
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>