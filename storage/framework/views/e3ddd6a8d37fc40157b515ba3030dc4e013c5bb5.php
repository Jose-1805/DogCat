

<?php 
    $item_revision = config('params.items_revisiones')[0];
    if(isset($revision) && $revision->exists)$item_revision = $revision->item_actual;
 ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">Revisión de <span id="item_revision"><?php echo e($item_revision); ?></span> para <span class="teal-text"><?php echo e($mascota->nombre); ?></span></h3>

            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-revisiones'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <p class="alert alert-warning">
                Si la mascota no presenta anomalías puede guardar sin diligenciar ningún campo, el
                sistema guardará automáticamente en siguiente texto en la observacion (<?php echo e(config('params.default_revision_periodica')); ?>)
            </p>
            <?php echo Form::open(['id'=>'form_revision','class'=>'col-12']); ?>


                <?php echo Form::hidden('revision',(isset($revision) && $revision->exists)?$revision->id:null,['id'=>'revision']); ?>

                <?php echo Form::hidden('mascota',$mascota->id); ?>

                <div class="row">
                    <div class="col-12 col-md-7">
                        <h5 class="grey-text col-12 no-padding">Observaciones</h5>
                        <?php echo Form::textarea('observaciones',null,['id'=>'observaciones','class'=>'md-textarea','placeholder'=>'Diligencie las anomalías encontradas en la mascota']); ?>

                    </div>
                    <div class="col-12 col-md-5">
                        <h5 class="grey-text col-12 no-padding margin-bottom-20">Evidencias</h5>
                        <div id="contenedor-evidencias">
                            <?php echo Form::file('evidencias[]',null); ?>

                            <?php echo Form::file('evidencias[]',null); ?>

                            <?php echo Form::file('evidencias[]',null); ?>

                        </div>
                        <a href="#!" id="btn_agregar_evidencia" class="btn btn-circle btn-primary right" style="margin-top: -30px;" data-toggle='tooltip' data-placement='right' title='Agregar evidencia'><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="col-12 text-right margin-top-30">
                        <a href="#" id="btn_guardar_revision" class="btn btn-success">Guardar</a>
                    </div>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/mascota/nueva_revision.js')); ?>"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>