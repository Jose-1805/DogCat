

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Control de disponibilidades</h3>

            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-disponibilidad'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-12 margin-top-10">
                <div class="row">
                    <div class="col-12 col-lg-4 padding-left-none padding-top-20">
                        <?php echo Form::open(['id'=>'form-disponibilidad']); ?>

                            <div class="md-form">
                                <?php echo Form::label('usuario','Usuario',['class'=>'active']); ?>

                                <?php echo Form::select('usuario',$usuarios,null,['id'=>'usuario','class'=>'form-control']); ?>

                            </div>

                            <div class="md-form" id="contenedor-fecha-inicio">
                                <?php echo Form::label('fecha_inicio','Fecha de inicio',['class'=>'active']); ?>

                                <?php echo $__env->make('layouts.componentes.datepicker',['id'=>'fecha_inicio','name'=>'fecha_inicio'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>

                            <div class="md-form" id="contenedor-fecha-fin">
                                <?php echo Form::label('fecha_fin','Fecha fin',['class'=>'active']); ?>

                                <?php echo $__env->make('layouts.componentes.datepicker',['id'=>'fecha_fin','name'=>'fecha_fin'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>

                            <div class="md-form margin-bottom-none">
                                <a class="btn btn-success btn-block" id="btn-buscar-disponibilidad">Buscar</a>
                            </div>


                            <div class="md-form">
                                <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'asignar', $privilegio_superadministrador)): ?>
                                    <a href="#!"  class="btn btn-primary btn-block" id="btn-asignar"><i class="fa fa-plus-circle margin-right-10"></i>Nueva disponibilidad</a>
                                <?php endif; ?>
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                    <div class="col-12 col-lg-8 padding-top-20 padding-bottom-20 border-left teal lighten-5">
                        <div id="contenedor-disponibilidad" class="col-12 text-center">
                            <img style="max-height: 250px;opacity: .7;" src="<?php echo e(asset('/imagenes/sistema/paseador.png')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-eliminar-disponibilidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Eliminar disponibilidades</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar la disponibilidad seleccionada?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-borrar-disponibilidad-ok">Si</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/disponibilidad/index.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>