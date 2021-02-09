<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Usuarios
        @if($servicio)
            - {{$servicio->nombre}} <span class="fa fa-times-circle margin-left-10 cursor_pointer cerrar-usuarios"></span>
        @endif
    </div>

    <!-- List group -->
    <ul class="list-group">
        @forelse($usuarios as $usuario)
            <li class="list-group-item">
                @if($servicio)
                    @if($servicio->tieneUsuario($usuario->id))
                        <div class="no-margin">
                            <label class="font-medium">
                                <input type="checkbox" class="check-usuario" checked data-usuario="{{$usuario->id}}"> {{$usuario->fullName().' ('.$usuario->rol->nombre.')'}}
                            </label>
                        </div>
                    @else
                        <div class="no-margin">
                            <label class="font-medium">
                                <input type="checkbox" class="check-usuario" data-usuario="{{$usuario->id}}"> {{$usuario->fullName().' ('.$usuario->rol->nombre.')'}}
                            </label>
                        </div>
                    @endif
                @else
                    {{$usuario->fullName().' ('.$usuario->rol->nombre.')'}}
                @endif
            </li>
        @empty
            <li class="list-group-item">No existen usuarios registradas.</li>
        @endforelse
    </ul>
</div>