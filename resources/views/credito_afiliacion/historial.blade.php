@extends('layouts.app')
<?php
    $estados = [];
    if($solicitud->estado == 'registrada'){
        $estados = [
            'registrada'=>'registrada',
            'en proceso'=>'en proceso',
            'procesada'=>'procesada',
            'descartada'=>'descartada'
        ];
    }else{
        $estados = [
            'en proceso'=>'en proceso',
            'procesada'=>'procesada',
            'descartada'=>'descartada'
        ];
    }
?>
@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="col-12 titulo_principal margin-bottom-20">Historial de solicitud de afiliación</h3>

            <div class="col-12 grey lighten-5 margin-bottom-10 padding-10">
                <div class="row">
                    <p class="col-12 titulo_secundario margin-bottom-20">Datos de la solicitud</p>
                    <div class="col-12 col-sm-6 col-lg-3">
                        {!! Form::label('identificacion','Identificación') !!}
                        <p>{{$user->tipo_identificacion.' '.$user->identificacion}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        {!! Form::label('usuario','Usuario') !!}
                        <p>{{$user->nombres.' '.$user->apellidos}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        {!! Form::label('fecha','Fecha') !!}
                        <p>{{$solicitud->created_at}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        {!! Form::label('estado','Estado') !!}
                        <p>{{$solicitud->estado}}</p>
                    </div>
                </div>
            </div>
            @if(Auth::user()->getTipoUsuario() == "personal dogcat")
                @if($solicitud->estado != 'procesada' && $solicitud->estado != 'cancelada')
                    {!! Form::open(['id'=>'form-historial-solicitud-afiliacion','class'=>'col-12 grey lighten-5 padding-10']) !!}
                        <div class="row">
                            <p class="col-12 titulo_secundario margin-bottom-20">Nuevo historal</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.alertas',['id_contenedor'=>'alertas-nuevo-historial-solicitud-afiliacion'])
                            </div>
                            {!! Form::hidden('solicitud',$solicitud->id) !!}
                            <div class="col-12 col-md-7">
                                <div class="form-group">
                                    {!! Form::label('observaciones','Observaciones') !!}

                                    {!! Form::textarea('observaciones',null,['id'=>'observaciones','class'=>'form-control','rows'=>'1','maxlength'=>1000]) !!}
                                    <p class="count-length">1000</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    {!! Form::label('estado','Estado') !!}

                                    {!! Form::select('estado',$estados,$solicitud->estado,['id'=>'estado','class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-2 text-center" style="margin-top: 15px !important;">
                                <a href="#!" class="btn btn-success btn-block" id="btn-nuevo-historial-solicitud-afiliacion">Guardar</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                @else
                    <div role="alert" class="alert alert-info col-12">.
                        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        La solicitud se encuentra en estado {{$solicitud->estado}}, por lo tanto no será posible registrar más historiales
                    </div>
                @endif
            @endif


            <div class="col-12 no-padding">
                <p class="col-12 margin-top-30 titulo_secundario">Historiales registrados</p>
                <div class="col-12" id="contenedor-lista-historial" style="min-height: 50px;">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent
    <script src="{{asset('js/solicitud_afiliacion/historial.js')}}"></script>
    <script>
        $(function () {
            registro = {{$solicitud->id}};
            cargarHistorialSolicitudAfiliacion();
        })
    </script>
@endsection
