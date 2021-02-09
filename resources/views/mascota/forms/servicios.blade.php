<div class="col-12 alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Nota!</strong> Para calcular correctamente el valor aproximado de la afiliación, asegurese de diligenciar toda la información anterior y a continuación seleccione el tipo de afiliación y cada uno de los servicios que desea en su plan.
</div>
<div class="col-12 col-sm-8">
    {!! Form::label('tipo_afiliacion','Tipo de afiliación (*)') !!}
    {!! Form::select('tipo_afiliacion',['Mensual'=>'Mensual','Semestral'=>'Semestral','Anual'=>'Anual'],null,['id'=>'tipo_afiliacion','class'=>'form-control consulta-datos-afiliacion','placeholder'=>'Selecione el tipo de afiliación']) !!}
    <div class="md-form margin-top-30">
        <?php
            $servicios = \DogCat\Models\Servicio::all();
        ?>
        @forelse($servicios as $s)
            <div class="col-6 col-sm-6 col-md-3 contenedor-check-imagen">
                <label class="">
                    <img src="{{url($s->logo)}}" alt="..." class="img-check checked hide">
                    <img src="{{url($s->logo_bn)}}" alt="..." class="img-check unchecked">
                    <input type="checkbox" name="servicios[]" id="servicio_{{$s->id}}" value="{{$s->id}}" class="hidden consulta-datos-afiliacion check-servicios" autocomplete="off">
                    <p class="font-small truncate">{{$s->nombre}}</p>
                </label>
            </div>
        @empty
            <div class="col-12 alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> No existen servicios registrados en el sistema
            </div>
        @endforelse

    </div>
</div>
<div class="col-12 col-sm-4 text-center no-padding">
    <div class="panel panel-info margin-top-30">
        <div class="card-header">Datos aproximados de afiliación</div>
        <div class="card-body" id="datos-aproximados-afiliacion">
            <strong class="font-xx-large teal-text text-lighten-1">$ <span class="teal-text text-lighten-1" id="valor_afiliacion">0</span></strong>
            <p class="text-info teal-text text-lighten-1">Cubrimiento funeraria: <span id="porcentaje_funeraria">0</span>%</p>
            <p class="text-info alert-danger hide" id="error_datos_afiliacion"></p>
        </div>
    </div>
</div>