<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Privilegios  <?php echo e(isset($rol) ? ' - '.$rol->nombre:''); ?></div>

    <!-- List group -->
    <div class="list-group">
        <?php if(isset($rol)): ?>
            <?php if($rol->privilegios): ?>
                <?php $__currentLoopData = $rol->dataPrivilegios(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $funciones = '';
                        for($i = 0; $i < count($pr['funciones']);$i++){
                            $funciones .= $pr['funciones'][$i].', ';
                        }
                        $funciones = trim($funciones);
                        $funciones = trim($funciones,',');
                    ?>
                    <li class="list-group-item"><?php echo e($pr['nombre'].' ('.$funciones.')'); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <li class="list-group-item">Rol sin privilegios asociados</li>
            <?php endif; ?>
        <?php else: ?>
            <li class="list-group-item">Lista de privilegios asociados a un rol</li>
        <?php endif; ?>
    </div>
</div>