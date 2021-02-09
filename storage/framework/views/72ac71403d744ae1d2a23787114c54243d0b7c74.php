

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Afiliación - <?php echo e($afiliacion->consecutivo); ?></h3>
            <?php 

                $disabled = 'disabled';
                $usuario = $afiliacion->userAfiliado;
                $veterinaria = $usuario->veterinariaAfiliado;
                $renovaciones = $afiliacion->renovaciones()->orderBy('id','DESC')->get();
             ?>

            <div class="col-12 no-padding">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-afiliacion'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-5 border padding-top-10">
                            <p class="col-12 titulo_secundario border-bottom margin-bottom-30">Usuario</p>
                            <div class="col-12 no-padding">
                                <div class="col">
                                    <div class="md-form">
                                        <?php echo Form::label('veterinaria','Veterinaria'); ?>

                                        <?php echo Form::text('veterinaria',$veterinaria->nombre,['id'=>'veterinaria','class'=>'form-control num-int-positivo',$disabled]); ?>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="md-form">
                                        <?php echo Form::label('usuario','Usuario'); ?>

                                        <?php echo Form::text('usuario',$usuario->nombres.' '.$usuario->apellidos,['id'=>'usuario','class'=>'form-control num-int-positivo',$disabled]); ?>

                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-12 col-md-7 border padding-top-10">
                    <p class="col-12 titulo_secundario border-bottom margin-bottom-30">Datos de la afiliación</p>
                    <div class="col-12 no-padding">
                        <div class="col">
                            <div class="md-form">
                                <?php echo Form::label('consecutivo','N° Consecutivo'); ?>

                                <?php echo Form::text('consecutivo',$afiliacion->consecutivo,['id'=>'consecutivo','class'=>'form-control num-int-positivo',$disabled]); ?>

                            </div>
                        </div>

                        <div class="col">
                            <div class="md-form">
                                <?php echo Form::label('fecha_diligenciemiento','Fecha de diligenciemoento'); ?>

                                <?php echo Form::text('fecha_diligenciemiento',$afiliacion->fecha_diligenciamiento,['id'=>'fecha_diligenciemiento','class'=>'form-control num-int-positivo',$disabled]); ?>

                            </div>
                        </div>

                        <div class="col">
                            <div class="md-form">
                                <?php echo Form::label('estado','Estado'); ?>

                                <?php echo Form::text('estado',$afiliacion->estado,['id'=>'estado','class'=>'form-control num-int-positivo',$disabled]); ?>

                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-12 margin-top-20">
                        <h4 class="titulo_principal margin-bottom-20">Renovaciones de la afiliacion</h4>
                        <div class="col-12 no-padding">
                                <?php if(count($renovaciones)): ?>
                                    <?php ($count = count($renovaciones)); ?>
                                    <?php $__currentLoopData = $renovaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $renovacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card">
                                            <p class="card-header">Renovación #<?php echo e($count); ?></p>
                                            <div class="card-body">
                                                <div class="row right padding-10">
                                                    <div class="display-inline padding-20 border-right border-left">
                                                        <strong>Valor</strong>
                                                        <p>$ <?php echo e(number_format($renovacion->getValor(),0,',','.')); ?></p>
                                                    </div>
                                                    <div class="display-inline padding-20 border-right border-left">
                                                        <strong>Valor pagado</strong>
                                                        <p>$ <?php echo e(number_format($renovacion->getValorPagado(),0,',','.')); ?></p>
                                                    </div>
                                                    <div class="display-inline padding-20 border-right">
                                                        <strong>Fecha inicio</strong>
                                                        <p><?php echo e($renovacion->fecha_inicio?$renovacion->fecha_inicio:'No establecido'); ?></p>
                                                    </div>
                                                    <div class="display-inline padding-20 border-right">
                                                        <strong>Fecha fin</strong>
                                                        <p><?php echo e($renovacion->fecha_fin?$renovacion->fecha_fin:'No establecido'); ?></p>
                                                    </div>
                                                </div>

                                                <?php 
                                                    $mascotas = $renovacion->mascotas()
                                                            ->select(
                                                                'mascotas_renovaciones.*',
                                                                'razas.nombre as raza',
                                                                'mascotas.nombre',
                                                                'mascotas.sexo',
                                                                'mascotas.cantidad_cuotas_funeraria',
                                                                'historial_precios_afiliacion.valor_afiliacion',
                                                                'historial_precios_afiliacion.mascota_adicional'
                                                                )
                                                            ->join('razas','mascotas.raza_id','=','razas.id')
                                                            ->join('renovaciones','mascotas_renovaciones.renovacion_id','=','renovaciones.id')
                                                            ->join('historial_precios_afiliacion','renovaciones.historial_precio_afiliacion_id','=','historial_precios_afiliacion.id')
                                                            ->get();
                                                 ?>
                                                <div class="col-12" style="overflow-x: auto;">
                                                    <table class="dataTable table-hover table-bordered table-responsive-sm">
                                                        <thead>
                                                            <th class="text-center">Consecutivo</th>
                                                            <th class="text-center">Nombre</th>
                                                            <th class="text-center">Sexo</th>
                                                            <th class="text-center">Raza</th>
                                                            <th class="text-center">Estado afiliación</th>
                                                            <th class="text-center">Funeraria</th>
                                                            <th class="text-center">Plan funerario</th>
                                                            <th class="text-center">Servicio funerario</th>
                                                            <th class="text-center">Incluir transporte</th>
                                                            <th class="text-center">Pago de funeraria a</th>
                                                            <th class="text-center">Valor funeraria</th>
                                                            <th class="text-center">Valor pagado</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php ($total = 0); ?>
                                                            <?php ($total_pagado = 0); ?>
                                                            <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo e($m->consecutivo); ?></td>
                                                                    <td class="text-center"><?php echo e($m->nombre); ?></td>
                                                                    <td class="text-center"><?php echo e($m->sexo); ?></td>
                                                                    <td><?php echo e($m->raza); ?></td>
                                                                    <td class="text-center"><?php echo e($m->estado); ?></td>
                                                                    <td class="text-center"><?php echo e($m->funeraria); ?></td>
                                                                    <td class="text-center"><?php echo e($m->funeraria == 'si'?$m->plan_funeraria:''); ?></td>
                                                                    <td class="text-center"><?php echo e($m->funeraria == 'si'?$m->servicio_funerario:''); ?></td>
                                                                    <td class="text-center"><?php echo e($m->funeraria == 'si'?$m->transporte_funeraria:''); ?></td>
                                                                    <td class="text-center">
                                                                        <?php if($m->funeraria == 'si'): ?>
                                                                            <?php if(is_numeric($m->cantidad_cuotas_funeraria)): ?>
                                                                                <?php echo e($m->cantidad_cuotas_funeraria); ?> años
                                                                            <?php else: ?>
                                                                                <?php if($m->funeraria == 'si'): ?>
                                                                                    1 año
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <?php ($total += ($m->valor_funeraria+$m->valor_comision)); ?>
                                                                    <td class="text-center">$ <?php echo e(number_format($m->valor_funeraria+$m->valor_comision,0,',','.')); ?></td>
                                                                    <?php 
                                                                        $valor_pagado = 0;
                                                                        if($m->funeraria == 'si' && $renovacion->cantidad_pagos > 0)
                                                                            $valor_pagado = (($m->valor_funeraria+$m->valor_comision)/$renovacion->cantidad_pagos)*$renovacion->numeroPagosRealizados();

                                                                        $total_pagado += $valor_pagado;
                                                                     ?>
                                                                    <td class="text-center">$ <?php echo e(number_format($valor_pagado,0,',','.')); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <tr>
                                                                <th colspan="10" class="text-center"><strong class="teal-text">TOTALES FUNERARIA</strong></th>
                                                                <th class="text-center teal-text"><strong>$ <?php echo e(number_format($total,0,',','.')); ?></strong></th>
                                                                <th class="text-center teal-text"><strong>$ <?php echo e(number_format($total_pagado,0,',','.')); ?></strong></th>
                                                            </tr>
                                                            <?php 
                                                                $valor_afiliacion = $m->valor_afiliacion;
                                                                if(count($mascotas) > 3) $valor_afiliacion += (count($mascotas)-3)*$m->mascota_adicional;
                                                             ?>
                                                            <?php ($total += $valor_afiliacion); ?>
                                                            <?php 
                                                                $valor_pagado = 0;
                                                                if($renovacion->cantidad_pagos > 0)
                                                                    $valor_pagado = (($valor_afiliacion)/$renovacion->cantidad_pagos)*$renovacion->numeroPagosRealizados();

                                                                $total_pagado += $valor_pagado;
                                                             ?>
                                                            <tr>
                                                                <th colspan="10" class="text-center"><strong>VALORES DE AFILIACIÓN</strong></th>
                                                                <td class="text-center">$ <?php echo e(number_format($valor_afiliacion,0,',','.')); ?></td>
                                                                <td class="text-center">$ <?php echo e(number_format($valor_pagado,0,',','.')); ?></td>
                                                            </tr>

                                                            <tr>
                                                                <th colspan="10" class="text-center"><strong class="teal-text">TOTALES</strong></th>
                                                                <th class="text-center teal-text"><strong>$ <?php echo e(number_format($total,0,',','.')); ?></strong></th>
                                                                <th class="text-center teal-text"><strong>$ <?php echo e(number_format($total_pagado,0,',','.')); ?></strong></th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <p class="alert alert-info col-12">No se han registrado renovaciones en la afiliacón seleccionada.</p>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>