<?php
    if(!isset($id_contenedor))$id_contenedor="alertas";
?>
<div class="" id="<?php echo e($id_contenedor); ?>">
    <div class="alert d-none col-12 alert-success alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje"></div>
    </div>

    <div class="alert d-none col-12 alert-info alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje"></div>
    </div>

    <div class="alert d-none col-12 alert-warning alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje"></div>
    </div>

    <div class="alert d-none col-12 alert-danger alert-dismissible" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje"></div>
    </div>
</div>