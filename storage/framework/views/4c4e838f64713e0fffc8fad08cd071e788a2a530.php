<?php
    if(!isset($id_contenedor))$id_contenedor="alertas";
?>
<div class="" id="<?php echo e($id_contenedor); ?>">
    <div class="alert <?php if(!session()->has('msj_success')): ?> d-none <?php endif; ?> col-12 alert-success alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php if(session()->has('msj_success')): ?>
                <?php echo session('msj_success'); ?>

            <?php endif; ?>
        </div>
    </div>

    <div class="alert <?php if(!session()->has('msj_info')): ?> d-none <?php endif; ?> col-12 alert-info alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php if(session()->has('msj_info')): ?>
                <?php echo session('msj_info'); ?>

            <?php endif; ?>
        </div>
    </div>

    <div class="alert <?php if(!session()->has('msj_warning')): ?> d-none <?php endif; ?> col-12 alert-warning alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php if(session()->has('msj_warning')): ?>
                <?php echo session('msj_warning'); ?>

            <?php endif; ?>
        </div>
    </div>

    <div class="alert <?php if(!session()->has('msj_danger')): ?> d-none <?php endif; ?> col-12 alert-danger alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php if(session()->has('msj_danger')): ?>
                <?php echo session('msj_danger'); ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
    session()->forget('msj_success');
    session()->forget('msj_info');
    session()->forget('msj_warning');
    session()->forget('msj_danger');
 ?>