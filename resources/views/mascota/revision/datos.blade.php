<div class="col-12 padding-right-none">
    @php($items = $revision->items)
    @forelse($items as $item)
        <div class="card card-primary">
            <div class="card-header bg-primary white-text">
                <h5 class="card-title mayuscula white-text">{{$item->nombre}}</h5>
            </div>
            <div class="card-body padding-bottom-10">
                <p>{{$item->observaciones}}</p>
                <div class="row text-right">
                    <p class="col-12 border-bottom border-primary">Evidencias</p>
                    @php($evidencias = $item->evidencias)
                    <div class="col-12 no-padding" style="margin-top: -10px;">
                        @forelse($evidencias as $e)
                            <a href="{{url('/mascota/evidencia-revision/'.$mascota->id.'/'.$e->id)}}" target="_blank" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="bottom" title="{{$e->nombre}}"><i class="fas fa-paperclip"></i></a>
                        @empty
                            <p class="col-12 font-small">La revisión de {{$item->nombre}} no tiene evidencias</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="alert alert-warning">No se encontraron elementos</p>
    @endforelse
</div>