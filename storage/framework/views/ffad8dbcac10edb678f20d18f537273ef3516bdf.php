<style>
    .card {
        margin: 0.5rem 0 1rem 0;
        background-color: #fff;
        border-radius: 2px;
        font-weight: 400;
        word-wrap: break-word;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card .card-title {
        font-size: 24px;
        font-weight: 300;
        margin: 0px;
        padding: 0px;
    }

    .card-body {
        padding: 0px 20px;
    }

    .card-header {
        padding: 10px 20px;
        margin-bottom: 0;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .padding-bottom-10 {
        padding-bottom: 10px !important;
    }

    .mayuscula {
        text-transform: uppercase !important;
    }

    .bg-primary {
        background-color: #4285F4 !important;
    }

    .white-text {
        color: #FFFFFF !important;
    }

    .font-small{
        font-size: small;
    }

    .evidencia{
        width: 48%;
        display: inline-block;
        vertical-align: top;
        margin: 1%;
    }

    .page-break {
        page-break-after: always;
    }
</style>
<div class="col-12 padding-right-none">
    <?php ($items = $revision->items); ?>
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card page-break">
            <div class="card-header bg-primary">
                <h5 class="card-title mayuscula white-text"><?php echo e($item->nombre); ?></h5>
            </div>
            <div class="card-body padding-bottom-10">
                <p><?php echo e($item->observaciones); ?></p>
                <div class="">
                    <p class="">Evidencias</p>
                    <?php ($evidencias = $item->evidencias); ?>
                    <div class="" style="margin-top: -10px;">
                        <?php $__empty_2 = true; $__currentLoopData = $evidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <?php if($e->mimeType() != 'pdf'): ?>
                                <img class="evidencia" src="<?php echo e(storage_path('/app/'.$e->ubicacion.'/'.$e->nombre)); ?>"/>
                            <?php else: ?>
                                <p>Esta evidencia no se puede mostrar porque esta en formato <?php echo e($e->mimeType()); ?>.</p>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <p class="font-small">La revisión de <?php echo e($item->nombre); ?> no tiene evidencias</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="alert alert-warning">No se encontraron elementos</p>
    <?php endif; ?>
</div>