<?php
    $index = count($historial);
?>
@forelse($historial as $item)
    <div class="card">
        <div class="card-header">Registro #{{$index--}} - {{$item->created_at}}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    {!! Form::label('observaciones','Observaciones') !!}
                    <p>{{$item->observaciones}}</p>
                </div>
                <div class="col-12 col-md-3">
                    {!! Form::label('estado_anterior','Estado anterior',['class'=>'grey-text text-lighten-1']) !!}
                    <p class="grey-text text-lighten-1">{{$item->estado_anterior}}</p>
                </div>
                <div class="col-12 col-md-3">
                    {!! Form::label('estado_nuevo','Estado nuevo') !!}
                    <p>{{$item->estado_nuevo}}</p>
                </div>
            </div>
        </div>
    </div>
@empty
    <div role="alert" class="alert alert-info">.
        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        No existen datos de historial para esta solicitud
    </div>
@endforelse