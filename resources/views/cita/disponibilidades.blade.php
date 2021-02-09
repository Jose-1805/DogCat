<div class="row">
    <div class="col-12">
        <!--<div class="btn-group col-12" data-toggle="buttons">-->
        <div class="row">
            @if(count($disponibilidades))
                <p class="col-12 padding-left-2 margin-bottom-5">A continuación seleccione la fecha para asignar a la cita</p>
            @endif
            @forelse($disponibilidades as $disponibilidad)
                <div class="col-6 col-sm-4 col-lg-2 padding-5">
                    <label class="col-12 btn btn-outline-info waves-effect padding-left-2 padding-right-2 padding-top-10 padding-bottom-10 no-margin">
                        <input class="disponibilidad" data-fecha="{{$disponibilidad->fecha}}" type="radio" name="options" autocomplete="off"> <span class="">{{$disponibilidad->strDiaFecha()}}</span><br>{{$disponibilidad->fecha}}
                    </label>
                </div>
            @empty
                <p class="col-12 alert alert-warning">Lo sentimos, no se han encontrado disponibilidades cercanas con el encargado seleccionado</p>
            @endforelse
        </div>
    </div>
</div>