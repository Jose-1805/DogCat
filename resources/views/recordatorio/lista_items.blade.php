@forelse($recordatorios as $r)
    @php($url = $r->url?$r->url:'#!')
    <a href="{{$url}}" class="margin-top-5 list-group-item list-group-item-action flex-column align-items-start notificacion_importancia_{{$r->importancia}}">
        <p class="mb-1">{!! $r->mensaje !!}</p>
        <small class="text-muted">{{$r->fecha.' '.$r->hora}}</small>
    </a>
@empty
    <p class="alert alert-info margin-top-20">No existen más recordatorios para mostrar</p>
@endforelse