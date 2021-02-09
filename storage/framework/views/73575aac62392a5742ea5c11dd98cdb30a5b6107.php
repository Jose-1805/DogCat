<?php 
    $estados = ['Pendiente de pago'=>'Pendiente de pago'];
    if(Auth::user()->tieneFuncion($identificador_modulo,'pagos',$privilegio_superadministrador))
        $estados['Pagada'] = 'Pagada';

    $cantidad_pagos = [];
    for($i = 1;$i <= config('params.meses_credito');$i++){
        $cantidad_pagos[$i] = $i == 1?$i.' mes':$i.' meses';

    }

    $dias_mes = [];
    for ($i = 1;$i <= 31;$i++)$dias_mes[$i] = $i;
 ?>



<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Nueva afiliación</h3>
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
                }else{
                   if(isset($usuario) && $usuario->exists){
                        //$disabled = 'disabled';
                        $veterinaria = $usuario->veterinariaAfiliado;

                        $veterinarias = [$veterinaria->id=>$veterinaria->nombre];
                        $veterinaria_select = $veterinaria->id;
                        $usuarios = [$usuario->id=>$usuario->nombres.' '.$usuario->apellidos];
                        $user_select = $usuario->id;
                    }
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

                    <div class="col-12 margin-top-20 no-padding">
                    <h4 class="titulo_principal">Datos de afiliación</h4>
                    <div class="row padding-top-20">
                        <div class="col-md-4 no-padding">
                            <div class="col">
                                <div class="md-form c-select">
                                    <?php echo Form::label('estado','Estado de pago',['class'=>'active']); ?>

                                    <?php echo Form::select('estado',$estados,null,['id'=>'estado','class'=>'form-control']); ?>

                                </div>
                            </div>

                            <div id="datos_pago" class="d-none">
                                <div class="col">
                                    <div class="md-form c-select margin-top-50">
                                        <?php echo Form::label('cantidad_pagos','Crédito a',['class'=>'active']); ?>

                                        <?php echo Form::select('cantidad_pagos',$cantidad_pagos,null,['id'=>'cantidad_pagos','class'=>'form-control']); ?>

                                    </div>
                                </div>

                                <div class="col d-none" id="contenedor-dia-pagar">
                                    <div class="md-form c-select margin-top-50">
                                        <?php echo Form::label('dia_pagar','Día para pagar',['class'=>'active']); ?>

                                        <?php echo Form::select('dia_pagar',$dias_mes,null,['id'=>'dia_pagar','class'=>'form-control']); ?>

                                    </div>
                                </div>

                                <div class="col">
                                    <div class="md-form c-select margin-top-50">
                                        <?php echo Form::label('medio_pago','Medio de pago',['class'=>'active']); ?>

                                        <?php echo Form::select('medio_pago',['Efectivo'=>'Efectivo','Consignación'=>'Consignación','Transferencia'=>'Transferencia'],null,['id'=>'medio_pago','class'=>'form-control']); ?>

                                    </div>
                                </div>

                                <div class="col d-none" id="contenedor-codigo-verificacion">
                                    <div class="md-form margin-top-10">
                                        <?php echo Form::label('codigo_verificacion','Código de verificación'); ?>

                                        <?php echo Form::text('codigo_verificacion',null,['id'=>'codigo_verificacion','class'=>'form-control']); ?>

                                    </div>
                                </div>

                                <p class="col text-center alert alert-info"><span>Valor a pagar</span><br><span class="font-large" id="valor_pagar">$ 0</span></p>

                                <div class="col">
                                    <div class="md-form c-select margin-top-50">
                                        <?php echo Form::label('numero_factura','Nº factura',['class'=>'active']); ?>

                                        <?php echo Form::text('numero_factura',null,['id'=>'numero_factura','class'=>'form-control']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 border-left padding-bottom-50">
                            <p class="titulo_secundario border-bottom text-center">Mascotas seleccionadas</p>
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

            <div class="position-fixed fixed-bottom info-color padding-20" id="contenedor-precio">
                <a class="btn-toggle-precio margin-left-30 margin-bottom-50 btn btn-white btn-circle btn-lg position-fixed fixed-bottom"><i class="fas fa-dollar-sign font-x-large margin-top-2 blue-text"></i></a>
                <p class="font-x-large text-center white-text no-padding no-margin">Valor de la afiliación</p>
                <p  class="font-xx-large text-center white-text no-padding no-margin" id="valor_afiliacion">$ 0</p>
            </div>

            <div class="modal fade" id="modal-confirmar-guardar-afiliacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog padding-left-30 padding-right-30" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Confirmar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body padding-top-20">
                            <p>¿Está seguro de guardar la afiliación con la información diligenciada?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="cancelar-confirmacion-cita">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-submit" id="btn-confirmar-guardar-afiliacion">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/afiliacion/nueva.js')); ?>"></script>
    <script>
        maxima_edad_prevision = <?php echo e(config('params.maxima_edad_prevision')); ?>;
        minima_edad_prevision = <?php echo e(config('params.minima_edad_prevision')); ?>;
    </script>

    <?php if((isset($solicitud) && $solicitud->exists) || (isset($usuario) && $usuario->exists)): ?>
        <script>
            $(function () {
                $('#usuario').change();
            })
        </script>
    <?php endif; ?>
    <script>
        $(function () {
            valorAfiliacion();

            $('#medio_pago').change(function () {
                if($(this).val() == 'Efectivo'){
                    $('#contenedor-codigo-verificacion').addClass('d-none');
                    $('#codigo_verificacion').val('');
                }else{
                    $('#contenedor-codigo-verificacion').removeClass('d-none');
                }
            })

            $('#estado').change(function () {
                if($(this).val() == 'Pagada'){
                    $('#datos_pago').removeClass('d-none');
                }else{
                    $('#datos_pago').addClass('d-none');
                }
            })
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>