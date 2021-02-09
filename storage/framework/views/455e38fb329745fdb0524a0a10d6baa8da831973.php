

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <?php echo Form::model($mascota,['id'=>'form-editar-mascota','data-toggle'=>'validator']); ?>

            <?php echo Form::hidden('mascota',$mascota->id,['id'=>'mascota']); ?>

            <div class="row">

                <div class="row contenedor-datos-mascota" id="datos-basicos">
                    <div class="col-12">
                        <h3 class="titulo_principal margin-bottom-20 margin-top-20 col-12 no-padding">Editar mascota - Datos básicos</h3>
                        <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-editar-mascota'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <div class="col-12">
                            <?php echo $__env->make('mascota.forms.datos_basicos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <div class="col-12 text-right margin-top-30">
                                <?php if($mascota->validado == 'no'): ?>
                                    <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'validar', $privilegio_superadministrador)): ?>
                                        <a data-mascota='<?php echo e($mascota->id); ?>' href='#!' class='btn btn-primary btn-validar'>Validar</a>
                                    <?php endif; ?>
                                <?php elseif($mascota->validado == 'si' && $mascota->informacion_validada == 'no'): ?>
                                    <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'validar informacion', $privilegio_superadministrador)): ?>
                                        <a data-mascota='<?php echo e($mascota->id); ?>' href='#!' class='btn btn-primary btn-validar-informacion'>Validar información</a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if($mascota->informacion_validada == 'si' && Auth::user()->tieneFuncion($identificador_modulo, 'ver_revision', $privilegio_superadministrador)): ?>
                                    <a href="<?php echo e(url('/mascota/revision/'.$mascota->id)); ?>" class="btn btn-primary">Revisiones</a>
                                <?php endif; ?>
                                <a href="#!" class="btn btn-success /*btn-submit*/" id="guardar-mascota">Guardar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php echo Form::close(); ?>

    </div>

    <div class="modal fade" id="modal-validar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Validar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Validar la mascota habilitará la asociación de la mascota a una afiliación e inhabilitará
                        alguna información de la mascota en su edición (para personal diferente a DOGCAT).</p>
                    <p>¿Está seguro de validar esta mascota?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btn-submit" id="btn-validar-ok">Si</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-validar-informacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Validar información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Validar la información de la mascota inhabilitará
                        la edición de algunos datos para todos los usuarios.</p>
                    <p>¿Está seguro de validar la información de esta mascota?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary btn-submit" id="btn-validar-informacion-ok">Si</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/mascota/editar.js')); ?>"></script>
    <script>
        $(function () {
            $("#imagen").fileinput(
                {
                    previewSettings: {
                        image:{width:"auto", height:"160px"},
                    },
                    allowedFileTypes:['image'],
                    AllowedFileExtensions:['jpg','jpeg','png'],
                    removeFromPreviewOnError:true,
                    showCaption: false,
                    showUpload: false,
                    showClose:false,
                    maxFileSize : <?php echo e(config('params.maximo_peso_archivos')); ?>,
                    initialPreview: [
                        <?php if($mascota->imagen): ?>
                            "<img src='<?php echo e(url('/almacen/'.str_replace('/','-',$mascota->imagen->ubicacion).'-'.$mascota->imagen->nombre)); ?>' class='col-12'>",
                        <?php endif; ?>
                    ]
                }
            );

            razas_perros = JSON.parse('<?php echo e($razas_perros); ?>'.replace(/(&quot\;)/g,"\""));
            razas_gatos = JSON.parse('<?php echo e($razas_gatos); ?>'.replace(/(&quot\;)/g,"\""));

            var tipo_mascota = $('#tipo_mascota').val();
            //$('#fecha_nacimiento').val('<?php echo e(date('Y-m-d',strtotime('+1days',strtotime($mascota->fecha_nacimiento)))); ?>');
            cargarFormVacunas(tipo_mascota);
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>