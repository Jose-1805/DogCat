<div class="modal fade" id="modal-nuevo-rol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-fluid" role="document">
        <div class="modal-content">

            <?php echo Form::open(['id'=>'form-rol','class'=>'no_submit']); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Nuevo rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-nuevo-rol'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('rol.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btn-submit" id="btn-nuevo-rol">Guardar</button>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-editar-rol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-fluid" role="document">
        <div class="modal-content">

            <?php echo Form::open(['id'=>'form-editar-rol','class'=>'no_submit']); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Editar rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-editar-rol'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div id="contenedor-editar-rol">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btn-submit" id="btn-guardar-editar-rol">Guardar</button>
                </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>