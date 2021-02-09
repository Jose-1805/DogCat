<?php ($usuario = $publicacion->usuario); ?>
<?php ($imagen = $usuario->imagenPerfil); ?>
<div class="col-12 no-padding no-margin margin-top-40 encabezado-publicacion">
    <div class="avatar">
        <?php if(!$imagen): ?>
            <?php if($usuario->getTipoUsuario() == 'personal dogcat'): ?>
                <?php ($color = 'teal lighten-1'); ?>
            <?php elseif($usuario->getTipoUsuario() == 'empleado'): ?>
                <?php ($color = 'blue lighten-1'); ?>
                <?php ($color = 'green'); ?>
            <?php else: ?>
                <?php ($color = 'green'); ?>
            <?php endif; ?>
            <div class="<?php echo e($color); ?> text-center padding-top-5" style="width: 50px; height: 50px;border-radius: 50%;">
                <p class="white-text font-x-large margin-top-2"><?php echo e($usuario->nombres[0]); ?></p>
            </div>
        <?php else: ?>
            <div style="width: 50px;
             height: 50px;
             border-radius: 50%;
             background-position: center;
             background-size: 100% auto;
             background-repeat: no-repeat;
             background-image: url(<?php echo e($imagen->urlAlmacen()); ?>);
            "></div>
        <?php endif; ?>
    </div>
    <div class="padding-left-5 data">
        <p class="font-medium grey-text text-darken-3"><strong><?php echo e($usuario->fullName()); ?></strong> </p>
        <?php if($usuario->getTipoUsuario() == 'personal dogcat'): ?>
            <p class="font-small teal-text text-lighten-1" style="margin-top: -20px;">DOGCAT <i class="fas fa-check-circle"></i></p>
        <?php elseif($usuario->getTipoUsuario() == 'empleado'): ?>
            <p class="font-small teal-text text-lighten-1" style="margin-top: -20px;"><?php echo e(strtoupper($usuario->getVeterinaria()->nombre)); ?> <i class="fas fa-paw" data-fa-transform="rotate-30"></i></p>
        <?php endif; ?>
        <p class="font-small grey-text text-darken-1" style="margin-top: -20px;"><?php echo e($publicacion->formatoFecha()); ?></p>
    </div>
</div>