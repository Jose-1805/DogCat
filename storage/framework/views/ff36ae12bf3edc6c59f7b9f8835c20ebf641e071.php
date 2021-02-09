<?php
    $estados = [];
    if($registro->estado == 'registrado'){
        $estados = [
            'registrado'=>'registrado',
            'en proceso'=>'en proceso',
            'completo'=>'completo',
            'descartado'=>'descartado'
        ];
    }else{
        $estados = [
            'en proceso'=>'en proceso',
            'completo'=>'completo',
            'descartado'=>'descartado'
        ];
    }

    if($registro->veterinaria == 'si')
        $roles = \DogCat\Models\Rol::where('veterinarias','si')->pluck('nombre','id')->toArray();
    else
        $roles = \DogCat\Models\Rol::where('registros','si')->pluck('nombre','id')->toArray();
?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="col-12 titulo_principal margin-bottom-20">Historial registro <strong class="teal-text text-lighten-2"><?php echo e($registro->nombre.' '.($registro->veterinaria == 'si'?'- Veterinaria':'')); ?></strong></p>

            <div class="col-12 grey lighten-5 margin-bottom-10 padding-10">
                <div class="row">
                    <p class="col-12 titulo_secundario margin-bottom-20">Datos del registro</p>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('nombre','Nombre'); ?>

                        <p><?php echo e($registro->nombre); ?></p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('email','Email'); ?>

                        <p><?php echo e($registro->email); ?></p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('telefono','Teléfono'); ?>

                        <p><?php echo e($registro->telefono); ?></p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <?php echo Form::label('direccion','Dirección'); ?>

                        <p><?php echo e($registro->direccion); ?></p>
                    </div>
                </div>
            </div>

            <?php if(Auth::user()->tieneFuncion($identificador_modulo,'editar',$privilegio_superadministrador)): ?>
                <?php if($registro->estado != 'completo'): ?>
                    <?php echo Form::open(['id'=>'form-historial-registro','class'=>'col-12 grey lighten-5 padding-10']); ?>

                        <p class="col-12 titulo_secundario margin-bottom-20">Nuevo historal</p>
                        <div class="row">
                            <div class="col-12">
                                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-nuevo-historial-registro'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                            <?php echo Form::hidden('registro',$registro->id); ?>

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


                                    <?php echo Form::select('estado',$estados,$registro->estado,['id'=>'estado','class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="col-12 col-md-2 text-center" style="margin-top: 15px !important;">
                                <a href="#!" class="btn btn-success btn-block btn-submit" id="btn-nuevo-historial">Guardar</a>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                <?php else: ?>
                    <div role="alert" class="alert alert-info">.
                        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        El registro se encuentra en estado completo, por lo tanto ha sido creada una cuenta de usuario con los datos y no será posible registrar más historiales
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

    <div class="modal fade" id="modal-rol-registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Seleccione el rol que será asignado al usuario que se creará con la información del registro seleccionado.</p>
                    <?php echo Form::select('rol',[''=>'Seleccione un rol']+$roles,null,['id'=>'rol','class'=>'form-control']); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btn-rol-registro">Guardar</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/registro/historial.js')); ?>"></script>
    <script>
        $(function () {
            registro = <?php echo e($registro->id); ?>;
            cargarHistorialRegistro();
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>