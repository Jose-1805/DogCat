<!-- MODAL DE INICIO DE SESION -->

<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Inicio Sesion DogCat</h4>-->

                <h5 class="modal-title" id="myModalLabel">Inicio Sesion DogCat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $__env->make('layouts.alertas',["id_contenedor"=>"alertas-login"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo e(csrf_field()); ?>


                    <div class="md-form">
                        <label for="email" class="control-label">Correo</label>

                        <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus>

                        <?php if($errors->has('email')): ?>
                            <span class="help-block text-danger">
                                    <strong class="text-danger"><?php echo e($errors->first('email')); ?></strong>
                                </span>
                        <?php endif; ?>
                    </div>

                    <div class="md-form">
                        <label for="password" class="control-label">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>

                    <div class="">
                        <label>
                            <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> Recordarme
                        </label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            Ingresar
                        </button>
                    </div>

                    <div class="text-center">
                        <a class="" href="<?php echo e(route('password.request')); ?>">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE REGISTRO -->
<div class="modal fade" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Registro DogCat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
            </div>
            <?php echo Form::open(["id"=>"form-registro"]); ?>

            <div class="modal-body">
                <?php echo $__env->make('layouts.alertas',["id_contenedor"=>"alertas-registro"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="md-form">
                    <?php echo Form::label("nombre","Nombre"); ?>

                    <?php echo Form::text("nombre",null,["id"=>"nombre","class"=>"form-control"]); ?>

                </div>
                <div class="md-form">
                    <?php echo Form::label("email","Correo"); ?>

                    <?php echo Form::text("email",null,["id"=>"email","class"=>"form-control"]); ?>

                </div>
                <div class="md-form">
                    <?php echo Form::label("telefono","Celular"); ?>

                    <?php echo Form::text("telefono",null,["id"=>"telefono","class"=>"form-control"]); ?>

                </div>
                <div class="md-form">
                    <?php echo Form::label("direccion","Dirección"); ?>

                    <?php echo Form::text("direccion",null,["id"=>"direccion","class"=>"form-control"]); ?>

                </div>
                <div class="md-form">
                    <input type="checkbox" name="veterinaria" id="veterinaria" value="si">
                    <label for="veterinaria">Veterinaria (Si desea relacionarse con el rol de veterinaria)</label>
                </div>
                <div class="md-form">
                    <input type="checkbox" name="permiso_notificaciones" id="permiso_notificaciones" value="si" checked>
                    <label for="permiso_notificaciones">Permitir notificaciones de información vía correo electrónico.</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success btn-submit" id="enviar_registro">Enviar</button>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
