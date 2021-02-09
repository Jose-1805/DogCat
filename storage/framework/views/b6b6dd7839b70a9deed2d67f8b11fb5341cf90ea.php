<?php
    $administrador = $veterinaria->administrador;
?>
<p>La cuenta para la veterinaria <strong><?php echo e($veterinaria->nombre); ?></strong> ha sido registrada en
el sistema web de <a href="<?php echo e(url('/')); ?>">DogCat</a>.</p>

<?php if($create_password): ?>
<p>Para ingresar al sistema ingrese a este <a href="<?php echo e(url('/create-password/'.$administrador->token.'/'.\Illuminate\Support\Facades\Crypt::encrypt($administrador->id))); ?>">link</a> y registre su contraseña de ingreso.</p>
<?php else: ?>
<p>Para ingresar al sistema dirijase a <a href="<?php echo e(url('/login')); ?>">DogCat</a> e inicie sesión con los siguientes datos.</p>
<p><strong>Usuario: </strong> <?php echo e($administrador->email); ?></p>
<p><strong>Contraseña: <?php echo e($clave); ?></strong></p>
<?php endif; ?>

