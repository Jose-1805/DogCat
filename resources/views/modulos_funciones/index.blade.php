@extends('layouts.app')

@section('content')
        <div class="container-fluid white padding-50">
            <div class="row">
                <h3 class="titulo_principal margin-bottom-20">Módulos y Funciones</h3>

                <div class="col-12 no-padding">
                <div class="alert alert-warning" role="alert">.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Alerta! </strong>esta funcionalidad es de vital importancía para el correcto funcionamiento del sistema, debe ser manipulada con el respectivo cuidado y responsabilidad.
                </div>
                </div>
                <div class="col-md-6 no-padding" id="contenedor-modulos" style="min-height: 50px;">

                </div>

                <div class="col-md-4">
                    <div class="row" >
                        <div class="col-12 ">
                            <div class="col-12 no-padding" id="contenedor-funciones" style="min-height: 50px;">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 padding-right-none padding-left-none">
                    <?php $disabled = ''; ?>
                    @if(!Auth::user()->tieneFuncion($identificador_modulo,'crear',$privilegio_superadministrador))
                            <?php $disabled = 'disabled'; ?>
                    @endif
                    <a class="btn btn-block btn-success" data-toggle="modal" @if($disabled == '') data-target="#modal-nuevo-modulo" @endif{{$disabled}}>Nuevo Módulo</a>
                    <a class="btn btn-block btn-success" data-toggle="modal" @if($disabled == '') data-target="#modal-nueva-funcion" @endif{{$disabled}}>Nueva Función</a>
                </div>
            </div>
        </div>

        @include('modulos_funciones.modales')
@endsection

@section('js')
    @parent
    <script src="{{asset('js/modulos_funciones/modulos_funciones.js')}}"></script>
@stop