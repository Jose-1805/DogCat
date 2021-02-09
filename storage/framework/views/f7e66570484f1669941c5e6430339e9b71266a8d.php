<?php 
    if(!isset($tabla))$tabla = '';
    if(!isset($class_btn))$class_btn = 'btn-primary';
    if(!isset($align_menu))$align_menu = 'dropdown-menu-right';
 ?>
<div class="btn-group">
    <button class="btn <?php echo e($class_btn); ?> dropdown-toggle btn-filter-colums-table" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-tabla="<?php echo e($tabla); ?>">
        <i class="fas fa-columns"></i>
    </button>

    <div class="dropdown-menu <?php echo e($align_menu); ?> padding-20">
    </div>
</div>