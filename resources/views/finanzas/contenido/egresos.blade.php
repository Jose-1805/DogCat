<h4 class="grey-text mayuscula margin-bottom-40">Listado de egresos</h4>
<a id="btn-nuevo-egreso" class="btn btn-primary right" style="margin-top: -80px;"><i class="fas fa-plus-circle margin-right-10"></i>Nuevo egreso</a>

@php(
    $tipos = [
        'Pago de funeraria'=>'Pago de funeraria',
        'Pago de servicios'=>'Pago de servicios',
        'Pago de salarios'=>'Pago de salarios',
        'Pago de arriendos'=>'Pago de arriendos',
        'Pago de impuestos'=>'Pago de impuestos',
        'Pago de aportes'=>'Pago de aportes',
        'Compra de insumos'=>'Compra de insumos',
        'Pago de viáticos'=>'Pago de viáticos',
        'Otro'=>'Otro'
    ]
)
<div class="row">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('egresos_desde','Desde',['class'=>'active']) !!}
            {!! Form::date('egresos_desde',date('Y-m-d',strtotime('-1 month')),['id'=>'egresos_desde','class'=>'form-control filtro-egresos']) !!}
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="md-form">
            {!! Form::label('egresos_hasta','Hasta',['class'=>'active']) !!}
            {!! Form::date('egresos_hasta',date('Y-m-d'),['id'=>'egresos_hasta','class'=>'form-control filtro-egresos']) !!}
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="md-form c-select">
            {!! Form::label('egresos_tipo','Tipo',['class'=>'active']) !!}
            {!! Form::select('egresos_tipo',['todos'=>'Todos']+$tipos,null,['id'=>'egresos_tipo','class'=>'form-control filtro-egresos']) !!}
        </div>
    </div>
</div>

<table class="dataTable" id="tabla-egresos">
    <thead>
        <th class="text-center" width="100">Fecha</th>
        <th class="text-center">Tipo</th>
        <th class="text-center">Descripción</th>
        <th class="text-center" width="100">Valor</th>
        <th class="text-center">Nª Factura</th>
        <th class="text-center">Evidencia</th>
        <th class="text-center">Usuario</th>
    </thead>
</table>

<div class="modal fade" id="modal-nuevo-egreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Nuevo egreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @include('layouts.alertas',['id_contenedor'=>'alertas-nuevo-egreso'])
                {!! Form::open(['id'=>'form-nuevo-egreso','class'=>'row']) !!}
                    <div class="col-12 margin-top-10">
                        <div class="md-form c-select">
                            {!! Form::label('tipo','Tipo (*)',['class'=>'active']) !!}
                            {!! Form::select('tipo',$tipos,null,['id'=>'tipo','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="md-form">
                            {!! Form::label('descripcion','Descripción',['class'=>'active']) !!}
                            {!! Form::textarea('descripcion',null,['id'=>'descripcion','class'=>'form-control md-textarea']) !!}
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="md-form">
                            {!! Form::label('numero_factura','Nª Factura',['class'=>'active']) !!}
                            {!! Form::text('numero_factura',null,['id'=>'numero_factura','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="md-form">
                            {!! Form::label('valor','Valor (*)',['class'=>'active']) !!}
                            {!! Form::text('valor',null,['id'=>'valor','class'=>'form-control num-int-positivo']) !!}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            {!! Form::label('evidencia','Evidencia',['class'=>'active col-12']) !!}
                            <div class="col-12">
                                {!! Form::file('evidencia',null,['id'=>'evidencia','class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-submit" id="btn-guardar-egreso">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirmacion-egreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Confirmar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Este paso no se puede deshacer, continue si está seguro de guardar la información que ingresó.</p>
                <p>¿Está seguro guardar el nuevo egreso?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn-guardar-egreso-no">No</button>
                <button type="button" class="btn btn-primary" id="btn-guardar-egreso-ok">Si</button>
            </div>
        </div>
    </div>
</div>
@section('js')
    @parent
    <script src="{{asset('/js/finanzas/egresos.js')}}"></script>
@endsection

<!--
'Pago de funeraria','Pago de servicios','Pago de salarios','Pago de arriendos','Pago de impuestos','Pago de aportes','Compra de insumos','Pago de viáticos','Otro'
-->