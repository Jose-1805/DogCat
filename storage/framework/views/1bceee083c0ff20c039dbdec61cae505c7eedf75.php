<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark teal scrolling-navbar">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <img alt="Brand" src="<?php echo e(asset('imagenes/sistema/dogcat.png')); ?>" style="height: 35px;margin-top: -7px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars font-xx-large"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" >
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="btn btn-sm btn-primary" href="<?php echo e(route('login')); ?>">Ingresar</a></li>
            </ul>
        </div>
    </nav>

</header>