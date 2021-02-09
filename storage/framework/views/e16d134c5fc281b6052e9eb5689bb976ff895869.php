<?php ($imagen_perfil = Auth::user()->imagenPerfil); ?>
<?php ($mascotas = Auth::user()->mascotas); ?>
<?php if($imagen_perfil): ?>
    <div class="contenedor-icono-usuario d-none d-md-flex align-items-center justify-content-center">
        <i class="fas fa-user fa-3x"></i>
    </div>
<?php else: ?>
    <div class="d-none d-md-flex align-items-center justify-content-center padding-left-30 padding-right-30 padding-top-20 padding-bottom-10">
        <div class="col-6 col-md-10">
            <img src="<?php echo e(asset('imagenes/sistema/dogcat_md.png')); ?>" class="img-fluid">
        </div>
    </div>
<?php endif; ?>
<h3 class="d-md-none col-12 text-center">
    <span class="font-weight-bold teal-text text-lighten-3">DOG</span>
    <span class="font-weight-bold white-text">CAT</span>
</h3>

<div class="dropdown text-center margin-top-10">
    <a href="#" class="dropdown-toggle white-text" data-toggle="dropdown" role="button" aria-expanded="false">
        <?php if(strlen(Auth::user()->nombres." ".Auth::user()->apellidos) > 20): ?>
            <?php if(strlen(Auth::user()->nombres." ".substr(Auth::user()->apellidos,0,1)) > 20): ?>
                <?php if(strlen(Auth::user()->nombres) > 20): ?>
                    <?php echo e(substr(Auth::user()->nombres,0,15)); ?>... <span class="caret"></span>
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
        <a class="dropdown-item" data-toggle="modal" data-target="#modal-cambiar-contrasena"><i class="fas fa-key margin-right-10"></i> Cambiar contraseña</a>
    </div>
</div>

<div class="contenedor-mascotas-menu d-flex justify-content-center">
    <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <a href="<?php echo e(url('/mascota/'.$m->id)); ?>">
            <div class="mascota-menu white d-flex justify-content-center" data-toggle="tooltip" data-placement="bottom" title="<?php echo e($m->nombre); ?>" style="
                <?php if($m->imagen): ?>
                    background-image:url(<?php echo e(url('/almacen/'.str_replace('/','-',$m->imagen->ubicacion).'-'.$m->imagen->nombre)); ?>);
                <?php else: ?>
                    <?php if(strtolower($m->raza->tipoMascota->nombre) == 'perro'): ?>
                            background-image: url(<?php echo e(\DogCat\Models\Imagen::urlSiluetaPerro()); ?>);
                    <?php else: ?>
                        background-image: url(<?php echo e(\DogCat\Models\Imagen::urlSiluetaGato()); ?>);
                    <?php endif; ?>
                <?php endif; ?>
                background-repeat: no-repeat;
                background-position: center;
                background-size: auto 100%;
                ">
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>