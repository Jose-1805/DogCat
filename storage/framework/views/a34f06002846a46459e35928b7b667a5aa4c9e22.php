<div id="contenedor-menu-fixed" style="
        background-image: url('<?php echo e(url('/imagenes/sistema/background_menu.jpg')); ?>');
        background-size: auto 100%;
        background-repeat: no-repeat;
        background-position: center;
        ">
    <div id="menu-fixed" class="z-depth-3">
        <a class="btn btn-white btn-esconter-menu-fixed right">
            <i class="fas fa-bars"></i>
        </a>
        <div class="menu-fixed-header padding-top-10">
            <?php if(auth()->guard()->guest()): ?>
                <?php echo $__env->make('layouts.menus.menu_fixed.header_guest', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <?php echo $__env->make('layouts.menus.menu_fixed.header_auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
        </div>

        <ul class="navbar-nav col-12 no-padding margin-top-10">
            <?php if(auth()->guard()->check()): ?>
                <?php echo $__env->make('layouts.menus.menu_fixed.opciones_auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php if(auth()->guard()->guest()): ?>
                <?php echo $__env->make('layouts.menus.menu_fixed.opciones_guest', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
        </ul>

            <div style="position:fixed;bottom: 0px;" id="contenedor-botones-estaticos-menu-fixed">
            <?php if(auth()->guard()->check()): ?>
                <a id="btn-notificaciones" class="btn btn-primary btn-block"><i class="fas fa-bell margin-right-10"></i>Notificaciones</a>
                <?php if(Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'ver',true) ||
                    Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'crear',true)): ?>
                    <a id="btn-recordatorios" class="btn btn-success btn-block no-margin"><i class="fas fa-clock margin-right-10"></i>Recordatorios</a>
                <?php endif; ?>
                <a href="<?php echo e(route('logout')); ?>" class="btn btn-white btn-block no-margin border-right" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt margin-right-10"></i>Salir</a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                </form>
            <?php endif; ?>

            <?php if(auth()->guard()->guest()): ?>
                <?php if(
                    !Request::is('password') && !Request::is('password/*') && !Request::is('simulador-afiliacion')
                    && !Request::is('login')
                ): ?>
                    <a class="btn btn-success btn-block no-margin" data-toggle="modal" data-target="#modal-registro"><i class="fab fa-wpforms margin-right-10"></i>Registrarse</a>
                    <a class="btn btn-primary btn-block no-margin" data-toggle="modal" data-target="#modal-login"><i class="fas fa-sign-in-alt margin-right-10"></i>Ingresar</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>