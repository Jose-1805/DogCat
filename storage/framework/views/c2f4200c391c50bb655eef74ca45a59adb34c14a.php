<div class="col-12" style="margin-top: -10px;">
    <?php if(!$publicacion->userLike(Auth::user()->id)): ?>

        <?php
            if(Auth::user()->tieneFuncion($identificador_modulo,'like',$privilegio_superadministrador)){
                $class = 'enviar-like';
            }else{
                $class = 'grey-text';
            }
            $numero = $publicacion->likes()->get()->count();
        ?>
        <p class="col-12 no-padding"><i class="fa fa-paw teal-text text-lighten-1 cursor_pointer <?php echo e($class); ?>" data-publicacion="<?php echo e($publicacion->id); ?>" data-numero="<?php echo e($numero); ?>"></i> <span class="numero_likes"><?php echo e($numero); ?></span></p>
    <?php else: ?>
        <p class="col-12 no-padding"><i class="fa fa-paw white-text teal lighten-1" style="padding: 3px;border-radius: 30px;"></i> <span class="numero_likes"><?php echo e($publicacion->likes()->count()); ?></span></p>
    <?php endif; ?>
</div>