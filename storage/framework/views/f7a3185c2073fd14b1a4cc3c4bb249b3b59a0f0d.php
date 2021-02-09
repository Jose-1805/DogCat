<p>Su cuenta de usuario con el rol de <strong><?php echo e($usuario->rol->nombre); ?></strong> ha sido creada con éxito en el sistema web de <a href="<?php echo e(url('/')); ?>">DogCat</a>.</p>

<?php if($create_password): ?>
<p>Para ingresar al sistema ingrese a este <a href="<?php echo e(url('/create-password/'.$usuario->token.'/'.\Illuminate\Support\Facades\Crypt::encrypt($usuario->id))); ?>">link</a> y registre su contraseña de ingreso.</p>
<?php else: ?>
<p>Para ingresar al sistema dirijase a <a href="<?php echo e(url('/login')); ?>">DogCat</a> e inicie sesión con los siguientes datos.</p>
<p><strong>Usuario: </strong> <?php echo e($usuario->email); ?></p>
<p><strong>Contraseña: <?php echo e($clave); ?></strong></p>
<?php endif; ?>

