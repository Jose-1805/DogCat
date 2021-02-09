@if(count($agendas))
    <ul class="list-group list-group-flush">
@endif
    @forelse($agendas as $agenda)
        @php($cita = $agenda->cita)
        @php($mascota = $cita->getMascota())
        <li class="list-group-item hoverable">
            <p class="font-small no-padding no-margin">{{$cita->servicio->nombre}}</p>
            <p class="font-small no-padding no-margin teal-text text-lighten-2">
                @if(Auth::user()->tieneFuncion(\DogCat\Http\Controllers\MascotaController::$identificador_modulo_static, 'editar', \DogCat\Http\Controllers\MascotaController::$privilegio_superadministrador_static))
                    <a target="_blank" class="teal-text text-lighten-2" href="{{url('/mascota/editar/'.$mascota->id)}}">
                        {{$mascota->nombre.' ('.$mascota->raza->tipoMascota->nombre.') - '}} <i class="fas fa-pen-square"> </i>
                    </a>
                @else
                    {{$mascota->nombre.' ('.$mascota->raza->tipoMascota->nombre.') - '}}
                @endif
                <i>{{$mascota->user->fullName()}}</i>
            </p>
            <p class="font-small no-padding no-margin"><u>{{$mascota->peso.' KG'}}</u></p>
            <p class="font-small no-padding no-margin">De {{$agenda->strHoraInicio()}} a {{$agenda->strHoraFin()}}</p>
            <div class="right">
                <span data-cita="{{$cita->id}}" class="btn-ver-cita cursor_pointer teal-text text-lighten-1 fas fa-eye margin-5" data-toggle="tooltip" data-placement="bottom" title="Ver completo"></span>
                @if(Auth::user()->tieneFuncion($identificador_modulo, 'cancelar', $privilegio_superadministrador) && $cita->estado == 'Agendada')
                    <span data-cita="{{$cita->id}}" class="btn-cancelar-cita cursor_pointer teal-text text-lighten-1 fas fa-minus-square margin-5" data-toggle="tooltip" data-placement="bottom" title="Cancelar cita"></span>
                @endif

                @if(Auth::user()->tieneFuncion($identificador_modulo, 'pagos', $privilegio_superadministrador) && $cita->estado == 'Agendada')
                    <span data-cita="{{$cita->id}}" class="btn-pagar-cita cursor_pointer teal-text text-lighten-1 fas fa-hand-holding-usd margin-5" data-toggle="tooltip" data-placement="bottom" title="Facturar cita"></span>
                @endif

                @if(Auth::user()->tieneFuncion($identificador_modulo, 'editar', $privilegio_superadministrador) && $cita->estado == 'Facturada')
                    <span data-cita="{{$cita->id}}" class="btn-finalizar-cita cursor_pointer teal-text text-lighten-1 fas fa-handshake margin-5" data-toggle="tooltip" data-placement="bottom" title="Atender cita (finalizar)"></span>
                @endif
            </div>
        </li>
    @empty
        <p class="alert alert-info">No hay citas registradas para la fecha.</p>
    @endforelse
@if(count($agendas))
    </ul>
@endif