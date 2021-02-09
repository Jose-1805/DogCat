@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Control de disponibilidades</h3>

            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-disponibilidad'])
            </div>

            <div class="col-12 margin-top-10">
                <div class="row">
                    <div class="col-12 col-lg-4 padding-left-none padding-top-20">
                        {!! Form::open(['id'=>'form-disponibilidad']) !!}
                            <div class="md-form">
                                {!! Form::label('usuario','Usuario',['class'=>'active']) !!}
                                {!! Form::select('usuario',$usuarios,null,['id'=>'usuario','class'=>'form-control']) !!}
                            </div>

                            <div class="md-form" id="contenedor-fecha-inicio">
                                {!! Form::label('fecha_inicio','Fecha de inicio',['class'=>'active']) !!}
                                @include('layouts.componentes.datepicker',['id'=>'fecha_inicio','name'=>'fecha_inicio'])
                            </div>

                            <div class="md-form" id="contenedor-fecha-fin">
                                {!! Form::label('fecha_fin','Fecha fin',['class'=>'active']) !!}
                                @include('layouts.componentes.datepicker',['id'=>'fecha_fin','name'=>'fecha_fin'])
                            </div>

                            <div class="md-form margin-bottom-none">
                                <a class="btn btn-success btn-block" id="btn-buscar-disponibilidad">Buscar</a>
                            </div>


                            <div class="md-form">
                                @if(Auth::user()->tieneFuncion($identificador_modulo, 'asignar', $privilegio_superadministrador))
                                    <a href="#!"  class="btn btn-primary btn-block" id="btn-asignar"><i class="fa fa-plus-circle margin-right-10"></i>Nueva disponibilidad</a>
                                @endif
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-12 col-lg-8 padding-top-20 padding-bottom-20 border-left teal lighten-5">
                        <div id="contenedor-disponibilidad" class="col-12 text-center">
                            <img style="max-height: 250px;opacity: .7;" src="{{asset('/imagenes/sistema/paseador.png')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-eliminar-disponibilidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Eliminar disponibilidades</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar la disponibilidad seleccionada?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-submit" id="btn-borrar-disponibilidad-ok">Si</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent
    <script src="{{asset('js/disponibilidad/index.js')}}"></script>
@stop