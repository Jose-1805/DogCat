<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Nueva afiliación</p>
            <?php 
                $disabled = '';
                $veterinarias = [''=>'Seleccione una veterinaria']+\DogCat\Models\Veterinaria::where('estado','aprobada')->where('veterinaria','si')->pluck('nombre','id')->toArray();
                $veterinaria_select = null;
                $usuarios = [''=>'Seleccione un usuario'];
                $user_select = null;

                if(isset($solicitud) && $solicitud->exists){
                    $disabled = 'disabled';
                    $veterinaria = $solicitud->usuario->veterinariaAfiliado;
                    $usuario = $solicitud->usuario;
                    $veterinarias = [$veterinaria->id=>$veterinaria->nombre];
                    $veterinaria_select = $veterinaria->id;
                    $usuarios = [$usuario->id=>$usuario->nombres.' '.$usuario->apellidos];
                    $user_select = $usuario->id;
                }
             ?>

            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-afiliacion'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <?php echo Form::open(['id'=>'form-afiliacion','class'=>'col-12']); ?>

                <div class="row">
                    <div class="col-12 col-md-5 border padding-top-10">
                        <p class="titulo_secundario border-bottom margin-bottom-30">Busque el usuario a afiliar</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="md-form c-select">
                                    <?php echo Form::label('veterinaria','Veterinaria',['class'=>'active']); ?>

                                    <?php echo Form::select('veterinaria',$veterinarias,$veterinaria_select,['id'=>'veterinaria','class'=>'form-control',$disabled]); ?>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="md-form c-select">
                                    <?php echo Form::label('usuario','Usuario (*)',['class'=>'active']); ?>

                                    <div id="contenedor-select-afiliados">
                                        <?php echo Form::select('usuario',$usuarios,$user_select,['id'=>'usuario','class'=>'form-control',$disabled]); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($solicitud) && $solicitud->exists): ?>
                            <?php echo Form::hidden('solicitud',$solicitud->id); ?>

                        <?php endif; ?>
                    </div>

                    <div class="col-12 col-md-7 border-right border-bottom border-top padding-top-10">
                        <p class="titulo_secundario border-bottom margin-bottom-30 text-center">Seleccione las mascotas a afiliar</p>
                        <div class="row">
                            <div class="col-12" id="contenedor-mascotas">
                                <p class="alert alert-info text-center">No existen mascotas para seleccionar</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 margin-top-20">
                    <p class="titulo_principal">Datos de afiliación</p>
                    <div class="row padding-top-20">
                        <div class="col-md-4">

                            <div class="col">
                                <div class="md-form">
                                    <?php echo Form::label('consecutivo','N° Consecutivo'); ?>

                                    <?php echo Form::text('consecutivo',null,['id'=>'consecutivo','class'=>'form-control num-int-positivo']); ?>

                                </div>
                            </div>

                            <div class="col">
                                <div class="md-form">
                                    <?php echo Form::label('fecha_diligenciamiento','Fecha de diligenciamiento (*)',['class'=>'active']); ?>

                                    <?php echo $__env->make('layouts.componentes.datepicker',['id'=>'fecha_diligenciamiento','name'=>'fecha_diligenciamiento'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                            </div>

                            <div class="col">
                                <div class="md-form c-select">
                                    <?php echo Form::label('estado','Estado de pago',['class'=>'active']); ?>

                                    <?php echo Form::select('estado',[''=>'Seleccione un estado','Pendiente de pago'=>'Pendiente de pago','Pagada'=>'Pagada'],null,['id'=>'estado','class'=>'form-control']); ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 border-left">
                            <p class="titulo_secundario border-bottom text-center">Mascotas seleccionadas</p>
                            <p class="alert alert-info">A continuación, ingrese el consecutivo correspondiente a la afiliación de cada mascota, este consecutivo lo puede encontrar en la parte superior derecha del formato de afiliación individual de cada mascota.</p>
                            <div class="row justify-content-center" id="content-mascotas-afiliar">

                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right border-top no-padding">
                        <a class="btn btn-success margin-top-20" id="btn-guardar-afiliacion">Guardar afiliación</a>
                    </div>
                </div>
                </div>
            <?php echo Form::close(); ?>


            <a class="btn-toggle-precio margin-left-30 margin-bottom-50 btn btn-info btn-circle btn-lg position-fixed fixed-bottom"><i class="fas fa-dollar-sign font-x-large margin-top-2"></i></a>

            <div class="position-fixed fixed-bottom info-color padding-20 d-none" id="contenedor-precio">
                <a class="btn-toggle-precio margin-left-30 margin-bottom-50 btn btn-white btn-circle btn-lg position-fixed fixed-bottom"><i class="fas fa-dollar-sign font-x-large margin-top-2 blue-text"></i></a>
                <p class="font-x-large text-center white-text no-padding no-margin">Valor de la afiliación</p>
                <p  class="font-xx-large text-center white-text no-padding no-margin" id="valor_afiliacion">$ <?php echo e(number_format($precios->valor_afiliacion,0,',','.')); ?></p>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/afiliacion/nueva.js')); ?>"></script>

    <script>
        $(function () {
            setValorAfiliacion(<?php echo e($precios->valor_afiliacion); ?>);
            setValorMascotaAdicional(<?php echo e($precios->valor_mascota_adicional); ?>);
        })
    </script>

    <?php if(isset($solicitud) && $solicitud->exists): ?>
        <script>
            $(function () {
                $('#usuario').change();
            })
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>