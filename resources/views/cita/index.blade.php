@extends('layouts.app')
@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">{{Auth::user()->getTipoUsuario() == 'afiliado'?'Mis citas':'Citas'}}</h3>
            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-citas'])
            </div>

            <div class="col-12 no-padding">
                @if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador))
                    <a href="#!"  class="btn btn-primary right margin-right-none" id="btn-modal-nueva-cita"><i class="fa fa-plus-circle margin-right-10"></i>Nueva cita</a>
                @endif
            </div>

            <div class="col-12 no-padding">
                @include('cita.lista')
            </div>

            @include('cita.modals')
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('params.google_maps_api_key')}}&callback=initMap"></script>
    <script src="{{asset('/js/cita/index.js')}}"></script>
    <script src="{{asset('/js/cita/gestion.js')}}"></script>
@endsection