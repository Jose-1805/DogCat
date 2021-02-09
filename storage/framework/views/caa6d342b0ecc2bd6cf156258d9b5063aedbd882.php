<?php
    if(!isset($last_comment))$last_comment = 0;
    $last = (object)array('id'=>$last_comment);
?>
<?php $__currentLoopData = $comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $last = $c;
    ?>
    <div>
        <p><strong class="teal-text text-lighten-1 font-small"><?php echo e($c->usuario->nombres.' '.$c->usuario->apellidos); ?></strong></p>
        <p class="font-small" style="margin-top: -10px;"><?php echo e($c->comentario); ?></p>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<input type="hidden" class="last_comment" value="<?php echo e($last->id); ?>">