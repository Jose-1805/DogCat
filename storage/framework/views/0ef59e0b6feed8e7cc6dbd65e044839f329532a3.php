<?php if(auth()->guard()->check()): ?>
<div class="modal fade" id="modal-cambiar-contrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Cambio de contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                <?php echo Form::open(['id'=>'form-cambiar-contrasena']); ?>

                <div class="md-form margin-top-10">
                    <?php echo Form::label('password_old','Contraseña antigua',['class'=>'active']); ?>

                    <?php echo Form::password('password_old',null,['id'=>'password_old','class'=>'form-control']); ?>

                </div>
                <div class="md-form">
                    <?php echo Form::label('password','Contraseña nueva',['class'=>'active']); ?>

                    <?php echo Form::password('password',null,['id'=>'password','class'=>'form-control']); ?>

                </div>
                <div class="md-form">
                    <?php echo Form::label('password_confirm','Confirmación de contraseña',['class'=>'active']); ?>

                    <?php echo Form::password('password_confirm',null,['id'=>'password_confirm','class'=>'form-control']); ?>

                </div>
                <?php echo Form::close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-submit" id="btn-cambiar-contrasena">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('notificacion.modales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php if(Auth::user()->tieneModulo(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO) || Auth::user()->esSuperadministrador()): ?>
    <?php echo $__env->make('recordatorio.modales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>
<?php endif; ?>