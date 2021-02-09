@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Crear servicio</h3>

            <div class="col-12">
                @include('servicio.form')
            </div>

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/servicio/crear.js')}}"></script>
@stop


