@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">Créditos de afiliación</h3>
            <div class="col-12 no-padding">
                @include('layouts.alertas',['id_contenedor'=>'alertas-credito-afiliacion'])
            </div>

            <div class="col-12 no-padding text-right">
                @include('layouts.componentes.btn_filter_table',['tabla'=>'tabla-creditos-afiliacion'])
            </div>
            <div class="col-12 no-padding">
                <table id="tabla-creditos-afiliacion" class="table-hover DataTable tabla-filter-colums-table">
                    <thead>
                        <th class="text-center">Afiliación</th>
                        <th>Estado de afiliación</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th class="text-center">Valor crédito</th>
                        <th class="text-center">Valor cuota</th>
                        <th class="text-center">Cantidad cuotas</th>
                        <th class="text-center">Opciones</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/credito_afiliacion/credito_afiliacion.js')}}"></script>
@stop