<?php 
    $cantidad_pagos = [];
    for($i = 1;$i <= config('params.meses_credito');$i++){
        $cantidad_pagos[$i] = $i == 1?$i.' mes':$i.' meses';
    }
 ?>

<?php 
    $dias_mes = [];
        for ($i = 1;$i <= 31;$i++)$dias_mes[$i] = $i;
 ?>
<?php echo Form::open(['id'=>'form-marcar-pagada']); ?>

    <?php echo Form::hidden('afiliacion',$afiliacion->id); ?>

    <?php if($afiliacion->estado == 'Pendiente de pago'): ?>
        <?php ($renovacion = $afiliacion->ultimaRenovacion()); ?>
        <div class="md-form c-select">
            <?php echo Form::label('cantidad_pagos','Crédito a',['class'=>'active']); ?>

            <?php echo Form::select('cantidad_pagos',$cantidad_pagos,null,['id'=>'cantidad_pagos','class'=>'form-control','data-valor'=>$renovacion->getValor()]); ?>

        </div>
        <div class="md-form c-select margin-top-50 d-none" id="contenedor-dia-pagar">
            <?php echo Form::label('dia_pagar','Día para pagar',['class'=>'active']); ?>

            <?php echo Form::select('dia_pagar',$dias_mes,null,['id'=>'dia_pagar','class'=>'form-control']); ?>

        </div>
        <p>Seleccione un medio de pago e ingrese un código de verificación, si el sistema lo solicita.</p>
        <div class="">
            <?php echo Form::label('madio_pago','Medio de pago',['class'=>'active']); ?>

            <?php echo Form::select('medio_pago',['Efectivo'=>'Efectivo','Consignación'=>'Consignación','Transferencia'=>'Transferencia'],null,['id'=>'medio_pago','class'=>'form-control']); ?>

        </div>

        <div class="md-form d-none margin-top-30" id="contenedor-codigo-verificacion">
            <?php echo Form::label('codigo_verificacion','Código de verificación'); ?>

            <?php echo Form::text('codigo_verificacion',null,['id'=>'codigo_verificacion','class'=>'form-control']); ?>

        </div>

        <p class="col text-center alert alert-info"><span>Valor a pagar</span><br><span class="font-large" id="valor_pagar">$ <?php echo e(number_format($renovacion->getValor(),0,',','.')); ?></span></p>

        <div class="md-form margin-top-30">
            <?php echo Form::label('numero_factura','Nº factura (*)'); ?>

            <?php echo Form::text('numero_factura',null,['id'=>'numero_factura','class'=>'form-control']); ?>

        </div>
    <?php elseif($afiliacion->credito_activo == 'si' && ($afiliacion->estado == 'Pagada' || $afiliacion->estado == 'Activa')): ?>
        <?php ($renovacion = $afiliacion->ultimaRenovacion()); ?>
        <?php 
            $pagos_realizados = $renovacion->ingresos()->count();
            $pagos_restantes = $renovacion->cantidad_pagos - $pagos_realizados;
            $cantidad_pagos = [];
            for($i = 1;$i <= $pagos_restantes;$i++){
                $cantidad_pagos[$i] = $i;
            }
         ?>
        <div class="">
            <?php echo Form::label('cantidad_pagos_realizar','Cantidad de pagos a realizar',['class'=>'active']); ?>

            <?php echo Form::select('cantidad_pagos_realizar',$cantidad_pagos,null,['id'=>'cantidad_pagos_realizar','class'=>'form-control','data-valor'=>$renovacion->valor_pago]); ?>

        </div>
        </div>
        <p>Seleccione un medio de pago e ingrese un código de verificación, si el sistema lo solicita.</p>
        <div class="">
            <?php echo Form::label('medio_pago','Medio de pago',['class'=>'active']); ?>

            <?php echo Form::select('medio_pago',['Efectivo'=>'Efectivo','Consignación'=>'Consignación','Transferencia'=>'Transferencia'],null,['id'=>'medio_pago','class'=>'form-control']); ?>

        </div>

        <div class="md-form d-none margin-top-30" id="contenedor-codigo-verificacion">
            <?php echo Form::label('codigo_verificacion','Código de verificación'); ?>

            <?php echo Form::text('codigo_verificacion',null,['id'=>'codigo_verificacion','class'=>'form-control']); ?>

        </div>

        <p class="col text-center alert alert-info"><span>Valor a pagar</span><br><span class="font-large" id="valor_pagar">$ <?php echo e(number_format($renovacion->valor_pago,0,',','.')); ?></span></p>

        <div class="md-form margin-top-30">
            <?php echo Form::label('numero_factura','Nº factura (*)'); ?>

            <?php echo Form::text('numero_factura',null,['id'=>'numero_factura','class'=>'form-control']); ?>

        </div>
    <?php else: ?>
        <p class="alert alert-info">La afiliación seleccionada no cuenta con pagos pendientes por realizar</p>
    <?php endif; ?>
<?php echo Form::close(); ?>