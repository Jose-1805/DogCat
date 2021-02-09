<?php $__env->startComponent('mail::message'); ?>
<h1 class="text-center"><?php echo e($correo->titulo); ?></h1>

<?php echo $correo->mensaje; ?>


<?php if($correo->boton == 'si'): ?>
<?php $__env->startComponent('mail::button', ['url' => $correo->url_boton,'color'=>'blue']); ?>
<?php echo $correo->texto_boton; ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php echo $__env->renderComponent(); ?>
