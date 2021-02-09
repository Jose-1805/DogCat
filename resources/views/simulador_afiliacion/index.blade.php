@php

    $cantidad_pagos = [1=>'1 mes'];
    /*for($i = 1;$i <= config('params.meses_credito');$i++){
        $cantidad_pagos[$i] = $i == 1?$i.' mes':$i.' meses';

    }*/
@endphp

@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Bienvenido al simulador de afiliación DogCat</h3>

            <div class="alert alert-info alert-dismissible col-12">
                Para calcular el valor de una afiliación agregue las mascotas que desee afiliar
                e interactue con las opciones que el sistema le brinda por cada mascota, a medida
                que agregue o cambie las opciones de las mascotas el sistema calculará de forma automática
                el valor para la afiliación. <strong>Dogcat</strong> también le permite realizar el pago de su afiliación a crédito y
                sin cobro adicional de intereses, para esto, puede utilizar la lista desplegable que aparece en el panel
                de <strong>"Datos de pago"</strong>, el sistema calculará la cantidad máxima de cuotas de acuerdo al valor total de la afiliación.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-simulador-afiliacion'])
            </div>
            {!! Form::open(['id'=>'form-simulador-afiliacion','class'=>'col-12']) !!}
                <div class="row">

                    <div class="col-12 margin-top-20 no-padding">
                        <div class="row padding-top-20">
                            <div class="col-md-4 no-padding">
                                <p class="titulo_secundario border-bottom text-center">Datos de pago</p>
                                <div id="datos_pago" class="">
                                    <div class="col">
                                        <div class="md-form c-select margin-top-50">
                                            {!! Form::label('cantidad_pagos','Crédito a',['class'=>'active']) !!}
                                            {!! Form::select('cantidad_pagos',$cantidad_pagos,null,['id'=>'cantidad_pagos','class'=>'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <p class="col-12 text-center alert alert-warning"><span>Valor a pagar</span><br><span class="font-large" id="valor_pagar">$ 0</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 border-left padding-bottom-50">
                                <p class="titulo_secundario border-bottom text-center">Mascotas agregadas</p>
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="row d-flex justify-content-center" id="contenedor-mascotas-simulador">
                                            <p class="col-12 text-center" id="msj_sin_mascota">Ninguna mascota agregada</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-right border-top no-padding">
                            <a class="btn btn-primary margin-top-20" id="btn-agregar-mascota"><i class="fas fa-plus-circle margin-right-10"></i>Agregar mascota</a>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}

            <a class="btn-toggle-precio margin-left-30 margin-bottom-50 btn btn-info btn-circle btn-lg position-fixed fixed-bottom"><i class="fas fa-dollar-sign font-x-large margin-top-2"></i></a>

            <div class="position-fixed fixed-bottom info-color padding-20" id="contenedor-precio">
                <a class="btn-toggle-precio margin-left-30 margin-bottom-50 btn btn-white btn-circle btn-lg position-fixed fixed-bottom"><i class="fas fa-dollar-sign font-x-large margin-top-2 blue-text"></i></a>
                <p class="font-x-large text-center white-text no-padding no-margin">Valor de la afiliación</p>
                <p  class="font-xx-large text-center white-text no-padding no-margin" id="valor_afiliacion">$ 0</p>
                <a class="btn-detalle-afiliacion btn btn-white btn-circle btn-lg position-fixed" style="right: 30px !important;bottom: 45px;" data-toggle="tooltip" data-placement="right" title="Detalle de la afiliación"><i class="fas fa-clipboard-list font-x-large margin-top-2 blue-text"></i></a>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal-agregar-mascota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Agregar mascota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
                </div>
                <div class="modal-body">
                    @include('layouts.alertas',["id_contenedor"=>"alertas-agregar-mascota"])
                    {!! Form::open(['id'=>'form-agregar-mascota']) !!}
                    <div class="md-form">
                        {!! Form::label("nombre","Nombre") !!}
                        {!! Form::text("nombre",null,["id"=>"nombre","class"=>"form-control","placeholder"=>"Ingrese el nombre de la mascota"]) !!}
                    </div>
                    <div class="md-form">
                        {!! Form::label("tipo_mascota","Tipo de mascota",['class'=>'active']) !!}
                        {!! Form::select("tipo_mascota",[''=>'Seleccione','Perro'=>'Perro','Gato'=>'Gato'],null,["id"=>"tipo_mascota","class"=>"form-control"]) !!}
                    </div>
                    <div class="md-form">
                        {!! Form::label("raza","Raza") !!}
                        {!! Form::text("raza",null,["id"=>"raza","class"=>"form-control","disabled"=>"disabled","placeholder"=>"Seleccione una raza"]) !!}
                        {!! Form::hidden("raza_id",null,["id"=>"raza_id"]) !!}
                    </div>
                    <div class="md-form">
                        {!! Form::label("fecha_nacimiento","Fecha de nacimiento",['class'=>'active']) !!}
                        {!! Form::date("fecha_nacimiento",null,["id"=>"fecha_nacimiento","class"=>"form-control","max"=>date('Y-m-d')]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btn-submit" id="btn-agregar-mascota-ok">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-detalle-afiliacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detalle de afiliación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
                </div>
                <div class="modal-body" id="contenedor-detalle-afiliacion">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/simulador_afiliacion/simulador_afiliacion.js')}}"></script>
    <script>
        $(function () {
            maxima_edad_prevision = {{config('params.maxima_edad_prevision')}};
            minima_edad_prevision = {{config('params.minima_edad_prevision')}};
            razas_perros = JSON.parse('{{$razas_perros}}'.replace(/(&quot\;)/g,"\""));
            razas_gatos = JSON.parse('{{$razas_gatos}}'.replace(/(&quot\;)/g,"\""));
            maxima_cantidad_meses_credito = {{config('params.meses_credito')}};
            valor_minimo_cuota_credito = {{config('params.valor_minimo_cuota_credito')}};
        })
    </script>
@stop