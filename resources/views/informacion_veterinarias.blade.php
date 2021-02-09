@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">Información de veterinarias</h3>

            @if(count($veterinarias))
                @foreach($veterinarias as $v)
                    <div class="col-12 col-md-4">
                        <div class="card">
                            @if($v->imagen)
                                <div class="col-12 text-center">
                                    <img class="img-responsive" style="height: 130px !important;" src="{{url('/almacen/'.str_replace('/','-',$v->imagen->ubicacion).'-'.$v->imagen->nombre)}}" alt="Nombre">
                                </div>
                            @endif
                            <!--Card content-->
                            <div class="card-body">
                                <!--Title-->
                                <h4 class="card-title border-bottom text-center">{{$v->nombre}}</h4>
                                <!--Text-->
                                <p class="card-text text-center"><strong>Correo: </strong>{{$v->correo}}</p>
                                <p class="card-text text-center"><strong>Teléfono: </strong>{{$v->telefono}}</p>
                                <p class="card-text text-center"><strong>Dirección: </strong>{{$v->ubicacion->stringDireccion()}}</p>
                                @if($v->web_site)
                                    <a href="{{$v->web_site}}" class="btn btn-info" target="_blank">WebSite</a>
                                @endif
                            </div>
                        </div>
                    </div>

                @endforeach
            @else
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <strong><i class="fa fa-info-circle"></i></strong> No existen veterinarias registradas en el sistema
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/mascota/mascota.js')}}"></script>
@stop


