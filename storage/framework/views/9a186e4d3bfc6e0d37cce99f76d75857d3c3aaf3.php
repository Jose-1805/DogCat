<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Dogcat')); ?></title>

<?php $__env->startSection('css'); ?>
    <!-- Styles -->
        <link href="<?php echo e(asset('css/helpers.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('MDB-Free/css/bootstrap.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('MDB-Free/css/mdb.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('css/global.css')); ?>" rel="stylesheet" type="text/css">
<?php echo $__env->yieldSection(); ?>

<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
<body class="fuelux" id="body">
<div id="app">
    <?php if(\Illuminate\Support\Facades\Auth::guest()): ?>
        <?php echo $__env->make('layouts.menus.no_autenticado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('layouts.menus.autenticado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
    <div style="height: 60px;"></div>
    <div id="contenido-pagina" class="container-fluid margin-bottom-50">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1 margin-top-50 text-center" style="min-height: 355px;">
                <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(url('imagenes/sistema/dogcat.png')); ?>" style="height: 250px;display: inline-block;margin-bottom: 30px;"></a>
                <div style="display: inline-block; padding-left: 50px;" class="text-left">
                    <strong class="font-xx-large">Lo sentimos!!</strong>
                    <p class="font-xx-large"><?php echo e($mensaje); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div id="pie-pagina" class="container-fluid padding-top-50" style="min-height: 150px;">

        <?php echo $__env->make('layouts.secciones.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div>

</div>

<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('MDB-Free/js/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('MDB-Free/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('MDB-Free/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('MDB-Free/js/mdb.js')); ?>"></script>
    <script src="https://use.fontawesome.com/a8d29b5cc4.js"></script>


<?php echo $__env->yieldSection(); ?>
</body>
</html>
