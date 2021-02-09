@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Afiliación - {{$afiliacion->consecutivo}}</h3>
            @php

                $disabled = 'disabled';
                $usuario = $afiliacion->userAfiliado;
                $veterinaria = $usuario->veterinariaAfiliado;
                $renovaciones = $afiliacion->renovaciones()->orderBy('id','DESC')->get();
            @endphp

            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-afiliacion'])
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-5 border padding-top-10">
                            <p class="col-12 titulo_secundario border-bottom margin-bottom-30">Usuario</p>
                            <div class="col-12 no-padding">
                                <div class="col">
                                    <div class="md-form">
                                        {!! Form::label('veterinaria','Veterinaria') !!}
                                        {!! Form::text('veterinaria',$veterinaria->nombre,['id'=>'veterinaria','class'=>'form-control num-int-positivo',$disabled]) !!}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="md-form">
                                        {!! Form::label('usuario','Usuario') !!}
                                        {!! Form::text('usuario',$usuario->nombres.' '.$usuario->apellidos,['id'=>'usuario','class'=>'form-control num-int-positivo',$disabled]) !!}
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-12 col-md-7 border padding-top-10">
                    <p class="col-12 titulo_secundario border-bottom margin-bottom-30">Datos de la afiliación</p>
                    <div class="col-12 no-padding">
                        <div class="col">
                            <div class="md-form">
                                {!! Form::label('consecutivo','N° Consecutivo') !!}
                                {!! Form::text('consecutivo',$afiliacion->consecutivo,['id'=>'consecutivo','class'=>'form-control num-int-positivo',$disabled]) !!}
                            </div>
                        </div>

                        <div class="col">
                            <div class="md-form">
                                {!! Form::label('fecha_diligenciemiento','Fecha de diligenciemoento') !!}
                                {!! Form::text('fecha_diligenciemiento',$afiliacion->fecha_diligenciamiento,['id'=>'fecha_diligenciemiento','class'=>'form-control num-int-positivo',$disabled]) !!}
                            </div>
                        </div>

                        <div class="col">
                            <div class="md-form">
                                {!! Form::label('estado','Estado') !!}
                                {!! Form::text('estado',$afiliacion->estado,['id'=>'estado','class'=>'form-control num-int-positivo',$disabled]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-12 margin-top-20">
                        <h4 class="titulo_principal margin-bottom-20">Renovaciones de la afiliacion</h4>
                        <div class="col-12 no-padding">
                                @if(count($renovaciones))
                                    @php($count = count($renovaciones))
                                    @foreach($renovaciones as $renovacion)
                                        <div class="card">
                                            <p class="card-header">Renovación #{{$count}}</p>
                                            <div class="card-body">
                                                <div class="row right padding-10">
                                                    <div class="display-inline padding-20 border-right border-left">
                                                        <strong>Valor</strong>
                                                        <p>$ {{number_format($renovacion->getValor(),0,',','.')}}</p>
                                                    </div>
                                                    <div class="display-inline padding-20 border-right border-left">
                                                        <strong>Valor pagado</strong>
                                                        <p>$ {{number_format($renovacion->getValorPagado(),0,',','.')}}</p>
                                                    </div>
                                                    <div class="display-inline padding-20 border-right">
                                                        <strong>Fecha inicio</strong>
                                                        <p>{{$renovacion->fecha_inicio?$renovacion->fecha_inicio:'No establecido'}}</p>
                                                    </div>
                                                    <div class="display-inline padding-20 border-right">
                                                        <strong>Fecha fin</strong>
                                                        <p>{{$renovacion->fecha_fin?$renovacion->fecha_fin:'No establecido'}}</p>
                                                    </div>
                                                </div>

                                                @php
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
                                                @endphp
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
                                                            @php($total = 0)
                                                            @php($total_pagado = 0)
                                                            @foreach($mascotas as $m)
                                                                <tr>
                                                                    <td class="text-center">{{$m->consecutivo}}</td>
                                                                    <td class="text-center">{{$m->nombre}}</td>
                                                                    <td class="text-center">{{$m->sexo}}</td>
                                                                    <td>{{$m->raza}}</td>
                                                                    <td class="text-center">{{$m->estado}}</td>
                                                                    <td class="text-center">{{$m->funeraria}}</td>
                                                                    <td class="text-center">{{$m->funeraria == 'si'?$m->plan_funeraria:''}}</td>
                                                                    <td class="text-center">{{$m->funeraria == 'si'?$m->servicio_funerario:''}}</td>
                                                                    <td class="text-center">{{$m->funeraria == 'si'?$m->transporte_funeraria:''}}</td>
                                                                    <td class="text-center">
                                                                        @if($m->funeraria == 'si')
                                                                            @if(is_numeric($m->cantidad_cuotas_funeraria))
                                                                                {{$m->cantidad_cuotas_funeraria}} años
                                                                            @else
                                                                                @if($m->funeraria == 'si')
                                                                                    1 año
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    @php($total += ($m->valor_funeraria+$m->valor_comision))
                                                                    <td class="text-center">$ {{number_format($m->valor_funeraria+$m->valor_comision,0,',','.')}}</td>
                                                                    @php
                                                                        $valor_pagado = 0;
                                                                        if($m->funeraria == 'si' && $renovacion->cantidad_pagos > 0)
                                                                            $valor_pagado = (($m->valor_funeraria+$m->valor_comision)/$renovacion->cantidad_pagos)*$renovacion->numeroPagosRealizados();

                                                                        $total_pagado += $valor_pagado;
                                                                    @endphp
                                                                    <td class="text-center">$ {{number_format($valor_pagado,0,',','.')}}</td>
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <th colspan="10" class="text-center"><strong class="teal-text">TOTALES FUNERARIA</strong></th>
                                                                <th class="text-center teal-text"><strong>$ {{number_format($total,0,',','.')}}</strong></th>
                                                                <th class="text-center teal-text"><strong>$ {{number_format($total_pagado,0,',','.')}}</strong></th>
                                                            </tr>
                                                            @php
                                                                $valor_afiliacion = $m->valor_afiliacion;
                                                                if(count($mascotas) > 3) $valor_afiliacion += (count($mascotas)-3)*$m->mascota_adicional;
                                                            @endphp
                                                            @php($total += $valor_afiliacion)
                                                            @php
                                                                $valor_pagado = 0;
                                                                if($renovacion->cantidad_pagos > 0)
                                                                    $valor_pagado = (($valor_afiliacion)/$renovacion->cantidad_pagos)*$renovacion->numeroPagosRealizados();

                                                                $total_pagado += $valor_pagado;
                                                            @endphp
                                                            <tr>
                                                                <th colspan="10" class="text-center"><strong>VALORES DE AFILIACIÓN</strong></th>
                                                                <td class="text-center">$ {{number_format($valor_afiliacion,0,',','.')}}</td>
                                                                <td class="text-center">$ {{number_format($valor_pagado,0,',','.')}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th colspan="10" class="text-center"><strong class="teal-text">TOTALES</strong></th>
                                                                <th class="text-center teal-text"><strong>$ {{number_format($total,0,',','.')}}</strong></th>
                                                                <th class="text-center teal-text"><strong>$ {{number_format($total_pagado,0,',','.')}}</strong></th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="alert alert-info col-12">No se han registrado renovaciones en la afiliacón seleccionada.</p>
                                @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    @parent
@stop
