@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Editar servicio</h3>

            <div class="col-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-editar-usuario'])
            </div>

            <div class="col-12">
                @include('servicio.form')
            </div>

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/servicio/editar.js')}}"></script>
@stop