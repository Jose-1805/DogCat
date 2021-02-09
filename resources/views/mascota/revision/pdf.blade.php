<style>
    .card {
        margin: 0.5rem 0 1rem 0;
        background-color: #fff;
        border-radius: 2px;
        font-weight: 400;
        word-wrap: break-word;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card .card-title {
        font-size: 24px;
        font-weight: 300;
        margin: 0px;
        padding: 0px;
    }

    .card-body {
        padding: 0px 20px;
    }

    .card-header {
        padding: 10px 20px;
        margin-bottom: 0;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .padding-bottom-10 {
        padding-bottom: 10px !important;
    }

    .mayuscula {
        text-transform: uppercase !important;
    }

    .bg-primary {
        background-color: #4285F4 !important;
    }

    .white-text {
        color: #FFFFFF !important;
    }

    .font-small{
        font-size: small;
    }

    .evidencia{
        width: 48%;
        display: inline-block;
        vertical-align: top;
        margin: 1%;
    }

    .page-break {
        page-break-after: always;
    }
</style>
<div class="col-12 padding-right-none">
    @php($items = $revision->items)
    @forelse($items as $item)
        <div class="card page-break">
            <div class="card-header bg-primary">
                <h5 class="card-title mayuscula white-text">{{$item->nombre}}</h5>
            </div>
            <div class="card-body padding-bottom-10">
                <p>{{$item->observaciones}}</p>
                <div class="">
                    <p class="">Evidencias</p>
                    @php($evidencias = $item->evidencias)
                    <div class="" style="margin-top: -10px;">
                        @forelse($evidencias as $e)
                            @if($e->mimeType() != 'pdf')
                                <img class="evidencia" src="{{storage_path('/app/'.$e->ubicacion.'/'.$e->nombre)}}"/>
                            @else
                                <p>Esta evidencia no se puede mostrar porque esta en formato {{$e->mimeType()}}.</p>
                            @endif
                        @empty
                            <p class="font-small">La revisión de {{$item->nombre}} no tiene evidencias</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="alert alert-warning">No se encontraron elementos</p>
    @endforelse
</div>