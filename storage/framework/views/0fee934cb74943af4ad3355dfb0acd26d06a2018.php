<header>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <img alt="Brand" src="<?php echo e(asset('imagenes/sistema/dogcat.png')); ?>" style="height: 35px;margin-top: -7px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars font-xx-large"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="#precios">Precios</a></li>
                <li class="nav-item"><a class="nav-link" href="#quienes_somos">¿Quienes somos?</a></li>
                <li class="nav-item"><a class="nav-link" href="#alianzas">Alianzas</a></li>
            </ul>
        </div>
    </nav>

    <?php
        $colores = [/*'blue-light','blue-strong',*/'grey-strong'/*,'purple-light','indigo-strong','white-light'*/];
    ?>
    <div class="view intro hm-<?php echo e($colores[rand(0,count($colores)-1)]); ?>">
        <div class="full-bg-img flex-center">
            <div class="container text-center white-text animated fadeInUp">
                <div class="row padding-top-50">
                    <div class="col-10 offset-1 padding-top-50">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-5">
                                <img class="img-fluid" src="<?php echo e(asset('imagenes/sistema/dogcat.png')); ?>">
                            </div>

                            <div class="col-12 col-md-7">
                                <h1 class="white-text text-left margin-bottom-5" style="font-size: 50px;">Porque tu mascota es nuestra mascota</h1>
                                <h3 class="white-text text-left">Salud, recreación y cuidado para tu mascota.</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="">
                    <div class="col-10 offset-1 padding-top-50 padding-bottom-50">
                            <a class="btn btn-success" data-toggle="modal" data-target="#modal-registro">Registrarse</a>
                            <a class="btn btn-primary" data-toggle="modal" data-target="#modal-login">Ingresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>