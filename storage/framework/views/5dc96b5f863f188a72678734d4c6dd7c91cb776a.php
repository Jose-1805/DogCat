<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark teal scrolling-navbar">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <img alt="Brand" src="<?php echo e(asset('imagenes/sistema/dogcat.png')); ?>" style="height: 35px;margin-top: -7px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars font-xx-large"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <?php if(Auth::user()->rol->superadministrador == "si"): ?>
                <?php echo $__env->make('layouts.menus.opciones_superadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('layouts.menus.opciones_user', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <a id="btn-notificaciones" href="#" class="btn btn-circle btn-white btn-outline-white opcion-menu" style="padding: 0px !important;" data-toggle="tooltip" data-placement="bottom" title="Notificaciones">
                <i style="" class="far fa-bell teal-text text-darken-2"></i>
            </a>
            <?php if(Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'ver',true) ||
                Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'crear',true)): ?>
                <a href="#" id="btn-recordatorios" class="btn btn-circle btn-white btn-outline-white opcion-menu" style="padding: 0px !important;" data-toggle="tooltip" data-placement="bottom" title="Recordatorios">
                    <i style="margin-top: 2px;" class="far fa-clock teal-text text-darken-2"></i>
                </a>
            <?php endif; ?>
            <ul class="navbar-nav navbar-right" style="max-width: 15%;">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <?php if(strlen(Auth::user()->nombres." ".Auth::user()->apellidos) > 15): ?>
                            <?php if(strlen(Auth::user()->nombres." ".substr(Auth::user()->apellidos,0,1)) > 15): ?>
                                <?php if(strlen(Auth::user()->nombres) > 15): ?>
                                    <?php echo e(substr(Auth::user()->nombres,0,12)); ?>... <span class="caret"></span>
                                <?php else: ?>
                                    <?php echo e(Auth::user()->nombres); ?> <span class="caret"></span>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo e(Auth::user()->nombres." ".substr(Auth::user()->apellidos,0,1)); ?>. <span class="caret"></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php echo e(Auth::user()->nombres." ".Auth::user()->apellidos); ?> <span class="caret"></span>
                        <?php endif; ?>
                    </a>

                    <div id="dropdown-menu-user" class="dropdown-menu hoverable" style="margin-top: 10px;" role="menu">

                        <a class="dropdown-item" data-toggle="modal" data-target="#modal-cambiar-contrasena">Cambiar contraseña</a>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Salir
                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

</header>
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