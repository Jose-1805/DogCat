@php
use DogCat\Models\TareasSistema;
use DogCat\Models\Servicio;

    $dias = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];

    $cita->dia = $dias[date('w',strtotime($cita->fecha))];
    $cita->fecha = date('Y-m-d',strtotime($cita->fecha));
    $cita->hora = TareasSistema::addCero($cita->hora_inicio).':'.TareasSistema::addCero($cita->minuto_inicio);

    $servicio = Servicio::find($cita->servicio_id);
    $data_precios = $servicio->dataPreciosMascota($cita->getMascota());

    $cita->valor = $data_precios['valor'];
    $cita->descuento =  $data_precios['descuento'];

    $cita->valor_str = '$ '.number_format(($data_precios['valor']),0,',','.');
    $cita->descuento_str = $data_precios['descuento'].'%';
    $cita->total_str = '$ '.number_format(($data_precios['valor'] - (($data_precios['valor']*$data_precios['descuento'])/100)),0,',','.');
@endphp

<p class="padding-10 alert bg-info white-text text-center">
    <span class="margin-2 ">{{$cita->dia}}</span>
    <span class="margin-2 ">{{$cita->fecha}}</span>
    <span class="margin-2 ">{{$cita->hora}}</span>
</p>
<p>
    <span class="">Mascota:</span><span class="margin-left-5">
        {{$cita->mascota}}
        @if($cita->peso_mascota)
            ({{$cita->peso_mascota.' KG'}})
        @else
            ({{$cita->mascota_peso_mascotas.' KG'}})
        @endif
    </span>
</p>
<p><span class="">Servicio:</span><span class="margin-left-5">{{$cita->servicio}}</span></p>
<p><span class="">Encargado:</span><span class="margin-left-5">{{$cita->encargado}}</span></p>
@if($cita->observaciones)
    <p><span class="">Observaciones:</span><span class="margin-left-5">{{$cita->observaciones}}</span></p>
@endif

@if($cita->valor)
    <p><span class="">Valor: </span><span class="margin-left-5">{{$cita->valor_str}}</span></p>
    <p><span class="">Descuento: </span><span class="margin-left-5">{{$cita->descuento_str}}</span></p>
    @php($total = $cita->valor - (($cita->valor*$cita->descuento)/100))
    @if(is_numeric($cita->valor_adicional))
        <p><span class="">Subtotal: </span><span class="margin-left-5">$ {{number_format($total,0,',','.')}}</span></p>
        <p><span class="">Valor adicional: </span><span class="margin-left-5">$ {{number_format($cita->valor_adicional,0,',','.')}}</span></p>
        @php($total += $cita->valor_adicional)
        <p><span class="">Descripción valor adicional: </span><span class="margin-left-5">{{$cita->descripcion_valor_adicional}}</span></p>
    @endif

    <p class="alert alert-info margin-top-30 text-center">TOTAL<br><span class="font-xx-large " id="valor_pagar">$ {{number_format($total,0,',','.')}}</span></p>
@else
    <p class="alert alert-warning font-small row"><span class="">Nota: </span>este servicio no cuenta con un precio fijo, por esta razón, no es posible visualizar el valor a cancelar y solamente se podrá saber
        cuando su mascota vaya a ser atendida</p>
    <p class="alert alert-info margin-top-30 text-center">El descuento para este servicio es de<br><span class="font-xx-large " id="valor_pagar">{{$cita->descuento}} %</span></p>
@endif