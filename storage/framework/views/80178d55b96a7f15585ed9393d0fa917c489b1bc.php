<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>DogCat</title>
        <link rel="icon" type="image/ico" href="<?php echo e(asset('imagenes/sistema/dogcat.ico')); ?>" />

        <link href="<?php echo e(asset('css/helpers.css')); ?>" rel="stylesheet" type="text/css">
        <!--<link href="<?php echo e(asset('bootstrap-3.3.7-dist/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">-->
        <link href="<?php echo e(asset('MDB-Free/css/bootstrap.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('MDB-Free/css/mdb.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('css/global.css')); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset('css/bienvenido.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('j1805_slide/j1805_slide.css')); ?>" rel="stylesheet" type="text/css">
        <style>
            .view {
                background: url("<?php echo e(asset('imagenes/sistema/background_dog.jpg')); ?>")no-repeat center center;
                background-size: cover;
            }

            .navbar {
                background-color: transparent;
            }

            .top-nav-collapse {
                background-color: #009688 ;
            }

            .top-nav-collapse *{
                /*color: #00ad87 !important;*/
            }


            @media  only screen and (max-width: 768px) {
                .navbar {
                    background-color: #009688 ;
                }

                .navbar *{
                    /*color: #00ad87 !important;*/
                }
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
        <div class="col-12 no-padding">
            <div class="row" id="contenedor-intro">
                <div class="col-12 no-padding">
                    <?php echo $__env->make('layouts.menus.bienvenido', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
            <div class="row d-none" id="contenedor-contenido-general">
                <a class="btn btn-teal btn-mostrar-menu-fixed d-md-none">
                    <img src="<?php echo e(asset('imagenes/sistema/dogcat_xs.png')); ?>" class="img-fluid margin-right-10" style="height: 30px;">
                    <i class="fas fa-bars font-large"></i>
                </a>

                <div id="contenedor-global-menu-fixed" class="d-none d-md-block col-11 col-md-4 col-lg-3 col-xl-2 no-padding teal darken-2" style="opacity: 0;">
                    <?php echo $__env->make('layouts.menus.menu_fixed', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>

                <div id="contenedor-global-contenido" class="col-12 col-md-8 col-lg-9 col-xl-10 no-padding">

                    <div id="servicios" class="container-fluid no-padding transparent padding-bottom-50 padding-top-50" >
                        <?php echo $__env->make('bienvenido.servicios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <div id="precios" class="container-fluid transparent padding-bottom-50 padding-top-50" style="/*background-image: url(<?php echo e(asset('imagenes/sistema/background_perro.jpg')); ?>);background-repeat: no-repeat;background-size: 100% auto;*/">
                        <?php echo $__env->make('bienvenido.precios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <div id="quienes_somos" class="container-fluid text-center transparent padding-bottom-50 padding-top-50" >
                        <?php echo $__env->make('bienvenido.quienes_somos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <div id="asociaciones" class="container-fluid transparent padding-bottom-50 padding-top-50" style="/*background-image: url(<?php echo e(asset('imagenes/sistema/background_perro.jpg')); ?>);background-repeat: no-repeat;background-size: 100% auto;*/">
                        <?php echo $__env->make('bienvenido.alianzas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <!--<div class="container-fluid no-padding">
                        <img style="width: 100%;" src="<?php echo e(asset('imagenes/sistema/donaciones.jpg')); ?>">
                        <div class="col-12 col-md-5 offset-md-1" style="margin-top: -600px;">
                            <h1 class="teal-text text-lighten-1 text-left">Con tu afiliación estas ayudando a nuestros amigos de la calle.</h1>
                            <p class="text-left" style="font-weight: 600 !important;margin-top: -40px;">Por cada pago de tu afiliación a Dog Cat estas aportando también para comida, alimentación, medicina y más cosas que necesitas nuestras Mascotas de la calle. </p>
                        </div>
                        <div class="col-12 text-right" style="">
                            <img style="height: 150px;" src="<?php echo e(asset('imagenes/sistema/alianzas/comedog.png')); ?>">
                        </div>
                    </div>-->

                    <div id="pie-pagina" class="container-fluid padding-top-50" style="min-height: 150px; margin-top: 158px;">

                        <?php echo $__env->make('layouts.secciones.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    </div>
                </div>
            </div>
            </div>
        </div>

        <?php if(Auth::guest()): ?>
            <?php echo $__env->make('bienvenido.modales', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>

        <input type="hidden" id="general_url" value="<?php echo e(url('/')); ?>">
        <input type="hidden" id="general_token" value="<?php echo e(csrf_token()); ?>">

    </body>

    <?php $__env->startSection('js'); ?>
        <script src="<?php echo e(asset('MDB-Free/js/jquery-3.2.1.min.js')); ?>"></script>
        <script src="<?php echo e(asset('MDB-Free/js/popper.min.js')); ?>"></script>
        <script src="<?php echo e(asset('MDB-Free/js/bootstrap.js')); ?>"></script>
        <script src="<?php echo e(asset('MDB-Free/js/mdb.js')); ?>"></script>
        <!--<script src="https://use.fontawesome.com/a8d29b5cc4.js"></script>-->
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
        <script src="<?php echo e(asset('js/numeric.js')); ?>"></script>

            <script>
                $(function () {
                    $(window).scrollTop(10);
                })
            </script>
        <script src="<?php echo e(asset('js/blockUi.js')); ?>"></script>
        <script src="<?php echo e(asset('js/global.js')); ?>"></script>
        <script src="<?php echo e(asset('js/params.js')); ?>"></script>
        <script src="<?php echo e(asset('js/bienvenido.js')); ?>"></script>
        <script src="<?php echo e(asset('j1805_slide/j1805_slide.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery.imageScroll.min.js')); ?>"></script>

        <script>
            <?php if($errors->has('email') || $errors->has('password')): ?>
                $(function () {
                    $("#modal-login").modal('show');
                })
            <?php endif; ?>
        </script>
        <script>
            $('.img-holder').imageScroll({
//            image: null,
//            imageAttribute: 'image',
//            container: $('body'),
//            speed: 0.2,
//            coverRatio: 0.75,
//            holderClass: 'imageHolder',
//            holderMinHeight: 200,
//            extraHeight: 0,
//            mediaWidth: 1600,
//            mediaHeight: 900,
//            parallax: true,
//            touch: false
            });
        </script>
        <script>
            $(function () {
                minHeightBgImg();
                $(window).resize(function () {
                    minHeightBgImg();
                })
            })

            function minHeightBgImg() {
                var h_cont = $('.full-bg-img .container').eq(0).height();
                var h_win = window.innerHeight;

                if(h_cont > h_win){
                    $('.intro').css({
                        minHeight: h_cont+'px'
                    })
                }else {
                    $('.intro').css({
                        minHeight: h_win+'px'
                    })
                }
            }
        </script>

    <?php echo $__env->yieldSection(); ?>
</html>
