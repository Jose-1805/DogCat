@php($indice = count($revisiones))
@forelse($revisiones as $revision)
    <div class="col-12">
        <div class="card padding-10 btn_cargar_revision cursor_pointer" data-revision="{{$revision->id}}">
            <div class="card-title border-bottom border-info">
                <p class="text-info no-padding no-margin">
                    Revision #{{$indice--}}
                </p>

                <a class="right" href="{{url('/mascota/revision-pdf/'.$revision->mascota_id.'/'.$revision->id)}}" target="_blank" style="margin-top: -35px;" data-toggle="tooltip" data-placement="right" title="Expotar a pdf">
                    <i class="fas fa-file-pdf"></i>
                </a>
            </div>
            <div class="card-body no-padding">
                <p class="no-margin">Fecha: {{date('Y-m-d',strtotime($revision->created_at))}}</p>
                <p class="no-margin padding-bottom-20">Por: {{$revision->usuario->fullName()}}</p>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <p class="col-12 alert alert-info">
            No se han registrado revisiones para <strong>{{$mascota->nombre}}</strong>.
        </p>
    </div>
@endforelse
