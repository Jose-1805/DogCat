<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dogcat') }}</title>

@section('css')
    <!-- Styles -->
        <link href="{{asset('css/helpers.css')}}" rel="stylesheet" type="text/css">

        <link href="{{asset('MDB-Free/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('MDB-Free/css/mdb.css')}}" rel="stylesheet" type="text/css">

        <link href="{{asset('css/global.css')}}" rel="stylesheet" type="text/css">
@show

<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="fuelux" id="body">
<div id="app">
    @if(\Illuminate\Support\Facades\Auth::guest())
        @include('layouts.menus.no_autenticado')
    @else
        @include('layouts.menus.autenticado')
    @endif
    <div style="height: 60px;"></div>
    <div id="contenido-pagina" class="container-fluid margin-bottom-50">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1 margin-top-50 text-center" style="min-height: 355px;">
                <a href="{{url('/')}}"><img src="{{url('imagenes/sistema/dogcat.png')}}" style="height: 250px;display: inline-block;margin-bottom: 30px;"></a>
                <div style="display: inline-block; padding-left: 50px;" class="text-left">
                    <strong class="font-xx-large">Lo sentimos!!</strong>
                    <p class="font-xx-large">{{$mensaje}}</p>
                </div>
            </div>
        </div>
    </div>

    <div id="pie-pagina" class="container-fluid padding-top-50" style="min-height: 150px;">

        @include('layouts.secciones.footer')

    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
@section('js')
    <script src="{{asset('MDB-Free/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('MDB-Free/js/popper.min.js')}}"></script>
    <script src="{{asset('MDB-Free/js/bootstrap.js')}}"></script>
    <script src="{{asset('MDB-Free/js/mdb.js')}}"></script>
    <script src="https://use.fontawesome.com/a8d29b5cc4.js"></script>


@show
</body>
</html>
