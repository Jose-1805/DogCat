<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Servicios</div>

    <!-- List group -->
    <div class="list-group">
        @forelse($servicios as $servicio)
            <a class="list-group-item"> {{$servicio->nombre}}
                <span class="fa fa-angle-right right btn-usuarios-servicio cursor_pointer green-text font-large" data-servicio="{{$servicio->id}}"></span>
            </a>
        @empty
            <li class="list-group-item">No existen servicios registrados.</li>
        @endforelse
    </div>
</div>