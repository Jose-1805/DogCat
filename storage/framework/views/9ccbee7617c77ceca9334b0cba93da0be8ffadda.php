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
        <!--<link href="<?php echo e(asset('bootstrap-3.3.7-dist/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">-->

        <link href="<?php echo e(asset('MDB-Free/css/bootstrap.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('MDB-Free/css/mdb.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('fuelux/css/fuelux.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('lightbox/lightbox.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('tabdrop/css/tabdrop.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('DataTables-1.10.15/media/css/jquery.dataTables.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('css/global.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(url('kartik_v_bootstrap_fileinput/css/fileinput.min.css')); ?>" media="all" rel="stylesheet" type="text/css" />
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
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>

        <div id="pie-pagina" class="container-fluid padding-top-50" style="min-height: 150px; margin-top: 158px;">

            <?php echo $__env->make('layouts.secciones.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </div>

        <input type="hidden" id="general_url" value="<?php echo e(url('/')); ?>">
        <input type="hidden" id="general_token" value="<?php echo e(csrf_token()); ?>">
    </div>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <?php $__env->startSection('js'); ?>
        <script src="<?php echo e(asset('MDB-Free/js/jquery-3.2.1.min.js')); ?>"></script>
        <script src="<?php echo e(asset('MDB-Free/js/popper.min.js')); ?>"></script>
        <script src="<?php echo e(asset('MDB-Free/js/bootstrap.js')); ?>"></script>
        <script src="<?php echo e(asset('MDB-Free/js/mdb.js')); ?>"></script>
        <script src="<?php echo e(asset('fuelux/js/fuelux.js')); ?>"></script>
        <script src="<?php echo e(asset('lightbox/lightbox.js')); ?>"></script>
        <script src="<?php echo e(asset('DataTables-1.10.15/media/js/jquery.dataTables.js')); ?>"></script>
        <script src="https://use.fontawesome.com/a8d29b5cc4.js"></script>
        <script src="<?php echo e(asset('js/numeric.js')); ?>"></script>
        <script src="<?php echo e(asset('tabdrop/js/bootstrap-tabdrop.js')); ?>"></script>

        <script src="<?php echo e(asset('js/blockUi.js')); ?>"></script>
        <script src="<?php echo e(asset('js/global.js')); ?>"></script>
        <script src="<?php echo e(asset('js/params.js')); ?>"></script>

        <script>
            $(function () {
                $('.nav-pills, .nav-tabs').tabdrop();
            })
        </script>

        <script src="<?php echo e(url('kartik_v_bootstrap_fileinput/js/plugins/piexif.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('kartik_v_bootstrap_fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('kartik_v_bootstrap_fileinput/js/plugins/purify.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('kartik_v_bootstrap_fileinput/js/fileinput.js')); ?>"></script>
        <script src="<?php echo e(url('kartik_v_bootstrap_fileinput/js/locales/es.js')); ?>"></script>
        <script src="<?php echo e(url('js/jquery.autocomplete.js')); ?>"></script>
        <script src="<?php echo e(url('bootstrap-validator-master/dist/validator.min.js')); ?>"></script>
    <?php echo $__env->yieldSection(); ?>
</body>
</html>
