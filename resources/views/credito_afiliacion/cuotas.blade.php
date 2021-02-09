@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Crédito de afiliación - {{$afiliacion->consecutivo}}</h3>
            @php

                $disabled = 'disabled';
                $usuario = $afiliacion->userAfiliado;
                $veterinaria = $usuario->veterinariaAfiliado;
                $renovaciones = $afiliacion->renovaciones()->orderBy('id','DESC')->get();
            @endphp

            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-cuotas'])
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
                        <h4 class="titulo_principal margin-bottom-20">Cuotas del crédito</h4>
                        <div class="col-12 no-padding">
                            <table class="dataTable table-hover table-bordered table-responsive-sm">
                                <thead>
                                    <th class="text-center">Nª Cuota</th>
                                    <th class="text-center">Valor</th>
                                    <th class="text-center">Fecha de pago</th>
                                    <th class="text-center">Fecha de pago real</th>
                                    <th class="text-center">Observaciones</th>
                                    <th class="text-center">Estado</th>
                                </thead>
                                <tbody>
                                    @foreach($cuotas as $c)
                                        @php
                                            $class_row = '';
                                            if($c->estado == 'Pagada'){
                                                $class_row = 'green lighten-4';
                                            }else if ($c->estado == 'Pendiente de pago'){
                                                $fecha_pago = strtotime($c->fecha_pago);
                                                if($fecha_pago < strtotime(date('Y-m-d')))
                                                    $class_row = 'red lighten-4';
                                            }
                                        @endphp
                                        <tr class="{{$class_row}}">
                                            <td class="text-center">{{$c->numero}}</td>
                                            <td class="text-center">$ {{number_format($c->valor,0,',','.')}}</td>
                                            <td class="text-center">{{$c->fecha_pago}}</td>
                                            <td class="text-center">{{$c->fecha_real_pago}}</td>
                                            <td>{{$c->observaciones}}</td>
                                            <td class="text-center">{{$c->estado}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
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
