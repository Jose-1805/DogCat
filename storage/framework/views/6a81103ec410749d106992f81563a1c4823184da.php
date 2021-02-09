<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <?php echo Form::model($mascota,['id'=>'form-editar-mascota','data-toggle'=>'validator']); ?>

            <?php echo Form::hidden('mascota',$mascota->id,['id'=>'mascota']); ?>

            <div class="row">

                <div class="row contenedor-datos-mascota" id="datos-basicos">
                    <p class="titulo_principal margin-bottom-20 margin-top-20 col-12 no-padding">Editar mascota - Datos básicos</p>

                    <div class="col-12">
                        <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-editar-mascota'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <div class="col-12">
                        <?php echo $__env->make('mascota.forms.datos_basicos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <div class="col-12 text-right margin-top-30">
                            <a href="#!" class="btn btn-success /*btn-submit*/" id="guardar-mascota">Guardar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php echo Form::close(); ?>

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
                    maxFileSize : 500,
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
            $('#fecha_nacimiento').val('<?php echo e(date('Y-m-d',strtotime('+1days',strtotime($mascota->fecha_nacimiento)))); ?>');
            cargarFormVacunas(tipo_mascota);
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>