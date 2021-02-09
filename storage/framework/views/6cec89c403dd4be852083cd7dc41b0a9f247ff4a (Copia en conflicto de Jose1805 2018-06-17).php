<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Dogcat')); ?></title>
    <link rel="icon" type="image/ico" href="<?php echo e(asset('imagenes/sistema/dogcat.ico')); ?>" />

    <?php $__env->startSection('css'); ?>
        <!-- Styles -->
        <!--<link href="<?php echo e(asset('bootstrap-3.3.7-dist/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">-->

        <link href="<?php echo e(asset('MDB-Free/css/bootstrap.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('MDB-Free/css/mdb.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('fuelux/css/fuelux.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('lightbox/lightbox.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('tabdrop/css/tabdrop.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('DataTables-1.10.15/media/css/jquery.dataTables.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('css/global.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(url('kartik_v_bootstrap_fileinput/css/fileinput.min.css')); ?>" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('css/helpers.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('css/notificaciones.css')); ?>" rel="stylesheet" type="text/css">
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

            <div class="row padding-left-20 padding-right-20 margin-top-20">
                <div class="col-12 no-padding">
                    <ol class="breadcrumb white d-none" style="margin-bottom: -50px;" id="breadcrump">
                    </ol>
                </div>
            </div>

            <div class="row">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

            <div id="contenedor_notificaciones_show">
                <div class="notificacion_show">
                    <div class="notificacion_show_header">
                        <p>Prueba de notificacion</p>
                        <a href="#!" class=""><i class="fas fa-times-circle"></i></a>
                    </div>
                    <div class="notificacion_show_body">
                        <p>Cuerpo de la notificacion</p>
                    </div>
                </div>
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
        <!--<script src="https://use.fontawesome.com/a8d29b5cc4.js"></script>-->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"></script>
        <script src="<?php echo e(asset('js/numeric.js')); ?>"></script>
        <script src="<?php echo e(asset('tabdrop/js/bootstrap-tabdrop.js')); ?>"></script>

        <script src="<?php echo e(asset('js/blockUi.js')); ?>"></script>
        <script src="<?php echo e(asset('js/global.js')); ?>"></script>
        <script src="<?php echo e(asset('js/params.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery.number.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/recordatorio.js')); ?>"></script>

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
        <script>
            $(function () {
                var home = "<li class='breadcrumb-item'><a href='"+window.location.origin+"/home' class='font-small'>Inicio</a></li>";

                var path = window.location.pathname;
                path = path.substr(1,path.length);
                var links = "";
                var lastUrl = window.location.origin;

                var excepciones = {login:'login',password:'password',public:'public',home:'home',publicacion:'publicacion'};
                var mostrar_breadcrump = true;
                if(path.length > 0) {
                    for (var i = 0; i < path.split("/").length; i++) {
                        if(excepciones[path.split("/")[i]] != undefined && i == 0){
                            mostrar_breadcrump = false;
                        }
                        if(path.split('/')[(i+1)] && $.isNumeric(path.split('/')[(i+1)])){
                            links += "<li class='breadcrumb-item'><a href='"+lastUrl+"/"+path.split('/')[i]+"/"+path.split('/')[(i+1)]+"' class='font-small'>"+path.split('/')[i].replace("-"," ")+"</a></li>";
                            break;
                        }else {
                            if(path.split('/')[i] != "home") {
                                var get="";
                                if((i+1) == path.split("/").length)
                                    get = window.location.search;
                                links += "<li class='breadcrumb-item'><a href='" + lastUrl + "/" + path.split('/')[i] +  get +  "' class='font-small'>" + path.split('/')[i].replace("-"," ") + "</a></li>";
                                lastUrl = lastUrl + "/" + path.split('/')[i];
                            }
                        }
                    }
                }

                if(links.length && mostrar_breadcrump) {
                    $("#breadcrump").html(home + links);
                    $("#breadcrump").removeClass("d-none");
                }
            })
        </script>
    <?php echo $__env->yieldSection(); ?>
    <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
    <!--<script src="<?php echo e(url('js/main.js')); ?>"></script>-->
    <!--<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-messaging.js"></script>-->
    <!--<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>-->

    <script src="<?php echo e(asset('firebase_messaging.js')); ?>"></script>
</body>
</html>
<!--
curl -X POST -H "Authorization: Bearer ya29.c.ElrcBUugiFDxoNQuLh8wUsZGzeg35M1YOaW1EEaD9LTrdWbhkrR94dHC7OcufQFh4o6Cae_LHcFn5u-ZHNuQEfJeGjE0Wh98qpxi_i94w-6elz6Z3PR_Wo2i3ww" -H "Content-Type: application/json" -d '{ "message":{ "notification": { "title": "FCM Message", "body": "This is an FCM Message", }, "token": "feNY_MTIM5E:APA91bH9226LQl4YOLjCgtBv2UdHwnKtg0Z-3TlqAtLNQmFZYPa7GJp6cxwZqW3kxhoTKOOlyvnaC6VDQmBCoL8Bv3gf5EhX4DqJKEkfS9WSCxAmnOFOdvS9TaakP2R_u4seblWDYVtl" } }' "https://fcm.googleapis.com/v1/projects/dogcat-1526672577530/messages:send"
-->
