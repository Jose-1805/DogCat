@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Roles</h3>
            <div class="col-12 no-padding">
                @if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador))
                    <a id="btn-modal-nuevo-rol" href="#!"  class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i>Nuevo rol</a>
                @endif
            </div>
            <div class="col-md-7 no-padding" style="min-height: 100px;" id="contenedor-roles">
            </div>

            <div class="col-md-5 padding-right-none" style="min-height: 100px;" id="contenedor-privilegios">
                @include('rol.lista_privilegios')
            </div>
        </div>
    </div>
    @include('rol.modales')
@endsection

@section('js')
    @parent
    <script src="{{asset('js/rol/roles.js')}}"></script>
@stop