<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Módulos</div>

    <!-- List group -->
    <div class="list-group">
        @forelse($modulos as $modulo)
            <a class="list-group-item"> {{$modulo->nombre}}
                <span class="badge badge-pill teal white-text left margin-right-10">{{$modulo->identificador}}</span>
                <span class="fa fa-angle-right right btn-funciones-modulo cursor_pointer green-text font-large" data-modulo="{{$modulo->id}}"></span>
                @if(Auth::user()->tieneFuncion($identificador_modulo,'editar',$privilegio_superadministrador))
                    <span class="fa fa-edit right btn-editar-modulo cursor_pointer margin-right-20 blue-text" data-modulo="{{$modulo->id}}"></span>
                @endif
            </a>
        @empty
            <li class="list-group-item">No existen módulos registrados.</li>
        @endforelse
    </div>
</div>