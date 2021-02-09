@php
    $cantidad_pagos = [];
    for($i = 1;$i <= config('params.meses_credito');$i++){
        $cantidad_pagos[$i] = $i == 1?$i.' mes':$i.' meses';
    }
@endphp

@php
    $dias_mes = [];
        for ($i = 1;$i <= 31;$i++)$dias_mes[$i] = $i;
@endphp
{!! Form::open(['id'=>'form-marcar-pagada']) !!}
    {!! Form::hidden('afiliacion',$afiliacion->id) !!}
    @if($afiliacion->estado == 'Pendiente de pago')
        @php($renovacion = $afiliacion->ultimaRenovacion())
        <div class="md-form c-select">
            {!! Form::label('cantidad_pagos','Crédito a',['class'=>'active']) !!}
            {!! Form::select('cantidad_pagos',$cantidad_pagos,null,['id'=>'cantidad_pagos','class'=>'form-control','data-valor'=>$renovacion->getValor()]) !!}
        </div>
        <div class="md-form c-select margin-top-50 d-none" id="contenedor-dia-pagar">
            {!! Form::label('dia_pagar','Día para pagar',['class'=>'active']) !!}
            {!! Form::select('dia_pagar',$dias_mes,null,['id'=>'dia_pagar','class'=>'form-control']) !!}
        </div>
        <p>Seleccione un medio de pago e ingrese un código de verificación, si el sistema lo solicita.</p>
        <div class="">
            {!! Form::label('madio_pago','Medio de pago',['class'=>'active']) !!}
            {!! Form::select('medio_pago',['Efectivo'=>'Efectivo','Consignación'=>'Consignación','Transferencia'=>'Transferencia'],null,['id'=>'medio_pago','class'=>'form-control']) !!}
        </div>

        <div class="md-form d-none margin-top-30" id="contenedor-codigo-verificacion">
            {!! Form::label('codigo_verificacion','Código de verificación') !!}
            {!! Form::text('codigo_verificacion',null,['id'=>'codigo_verificacion','class'=>'form-control']) !!}
        </div>

        <p class="col text-center alert alert-info"><span>Valor a pagar</span><br><span class="font-large" id="valor_pagar">$ {{number_format($renovacion->getValor(),0,',','.')}}</span></p>

        <div class="md-form margin-top-30">
            {!! Form::label('numero_factura','Nº factura (*)') !!}
            {!! Form::text('numero_factura',null,['id'=>'numero_factura','class'=>'form-control']) !!}
        </div>
    @elseif($afiliacion->credito_activo == 'si' && ($afiliacion->estado == 'Pagada' || $afiliacion->estado == 'Activa'))
        @php($renovacion = $afiliacion->ultimaRenovacion())
        @php
            $pagos_realizados = $renovacion->ingresos()->count();
            $pagos_restantes = $renovacion->cantidad_pagos - $pagos_realizados;
            $cantidad_pagos = [];
            for($i = 1;$i <= $pagos_restantes;$i++){
                $cantidad_pagos[$i] = $i;
            }
        @endphp
        <div class="">
            {!! Form::label('cantidad_pagos_realizar','Cantidad de pagos a realizar',['class'=>'active']) !!}
            {!! Form::select('cantidad_pagos_realizar',$cantidad_pagos,null,['id'=>'cantidad_pagos_realizar','class'=>'form-control','data-valor'=>$renovacion->valor_pago]) !!}
        </div>
        </div>
        <p>Seleccione un medio de pago e ingrese un código de verificación, si el sistema lo solicita.</p>
        <div class="">
            {!! Form::label('medio_pago','Medio de pago',['class'=>'active']) !!}
            {!! Form::select('medio_pago',['Efectivo'=>'Efectivo','Consignación'=>'Consignación','Transferencia'=>'Transferencia'],null,['id'=>'medio_pago','class'=>'form-control']) !!}
        </div>

        <div class="md-form d-none margin-top-30" id="contenedor-codigo-verificacion">
            {!! Form::label('codigo_verificacion','Código de verificación') !!}
            {!! Form::text('codigo_verificacion',null,['id'=>'codigo_verificacion','class'=>'form-control']) !!}
        </div>

        <p class="col text-center alert alert-info"><span>Valor a pagar</span><br><span class="font-large" id="valor_pagar">$ {{number_format($renovacion->valor_pago,0,',','.')}}</span></p>

        <div class="md-form margin-top-30">
            {!! Form::label('numero_factura','Nº factura (*)') !!}
            {!! Form::text('numero_factura',null,['id'=>'numero_factura','class'=>'form-control']) !!}
        </div>
    @else
        <p class="alert alert-info">La afiliación seleccionada no cuenta con pagos pendientes por realizar</p>
    @endif
{!! Form::close() !!}