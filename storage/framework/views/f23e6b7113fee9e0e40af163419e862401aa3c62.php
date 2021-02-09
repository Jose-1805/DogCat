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

                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Salir
                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </div>
                </li>
            </ul>

            <a href="#" ><i style="line-height: 48px;" class="fa fa-bell right teal-text text-lighten-3"></i></a>
        </div>
    </nav>

</header>