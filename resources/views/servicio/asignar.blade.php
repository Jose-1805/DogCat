@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Asignar Servicios</h3>

            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-asignar-servicios'])
            </div>

            <div class="col-12 no-padding">
                <div class="row">
                    <div class="col-md-5" id="contenedor-servicios" style="min-height: 50px;">

                    </div>

                    <div class="col-md-7">
                        <div class="row" >
                            <div class="col-12 ">
                                <div class="col-12 no-padding" id="contenedor-usuarios" style="min-height: 50px;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/servicio/asignar.js')}}"></script>

@stop


