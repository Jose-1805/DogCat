@forelse($notificaciones as $n)
    @php($url = $n->link?$n->link:'#!')
    <a href="{{$url}}" class="margin-top-5 list-group-item list-group-item-action flex-column align-items-start notificacion_importancia_{{$n->importancia}}">
        <div class="row">
            <div class="col-auto">
                @if($n->tipo == 'recordatorio')
                    <img src="/imagenes/sistema/reloj_alarma.png" style="max-width: 60px;">
                @else
                    <img src="{{$n->icon}}" style="max-width: 60px;">
                @endif
            </div>
            <div class="col">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{$n->titulo}}</h5>
                </div>
                <p class="mb-1">{!! $n->mensaje !!}</p>
                <small class="text-muted">{{date('Y-m-d H:i',strtotime($n->created_at))}}</small>
            </div>
        </div>
    </a>
@empty
    <p class="alert alert-info margin-top-20">No existen más notificaciones para mostrar</p>
@endforelse