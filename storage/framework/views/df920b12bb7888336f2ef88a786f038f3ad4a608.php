<?php if(Auth::user()->rol->superadministrador == "si"): ?>
    <?php echo $__env->make('layouts.menus.menu_fixed.opciones_superadministrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('layouts.menus.menu_fixed.opciones_user', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>