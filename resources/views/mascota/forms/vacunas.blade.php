<div class="col-12">
    <div class="col-12 alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Nota!</strong> Todas las vacunas que se encuentran a continuación provienen como referencia de la fecha de nacimiento y el tipo de mascota seleccionado, por lo cual son obligatorias.
        <br>
        <br>
        Seleccione las fechas de las últimas dosis de aplicación por cada vacuna, posteriormente adjunte un archivo en formato <strong>PDF</strong> donde se encuentre el carné o los carnés de vacunas necesarios para comprobar la información suministrada.
    </div>

    @forelse($vacunas as $v)
        <div class="md-form col-md-6 col-lg-4">
            {!! Form::label($v->nombre.'_'.$v->id,$v->nombre) !!}
            @include('layouts.componentes.datepicker',['id'=>$v->nombre.'_'.$v->id,'name'=>'fecha_vacuna_'.$v->id])
        </div>
    @empty
        <p class="text-info">No se han encontrado vacunas para el tipo de mascota selecionado</p>
    @endforelse
    @if(count($vacunas))
        <div class="md-form col-md-6 col-lg-4">
            {!! Form::label('carne_vacunas','Carné de vacunas') !!}
            <input id="carne_vacunas" name="carne_vacunas" type="file" class="form-control">


            @if(isset($mascota))
                <?php
                    $carne_vacunas = \DogCat\Models\Carne::select('carnes.*')
                    ->join('vacunas_mascotas','carnes.id','=','vacunas_mascotas.carne_id')
                    ->join('mascotas','vacunas_mascotas.mascota_id','mascotas.id')
                    ->where('mascotas.id',$mascota->id)->orderBy('carnes.created_at','DESC')->first();
                ?>
                @if($carne_vacunas)
                    <p class="margin-top-10"><strong>Carné: </strong><a href="{{url('/almacen/'.str_replace('/','-',$carne_vacunas->ubicacion).'-'.$carne_vacunas->nombre)}}" target="_blank">{{$carne_vacunas->nombre}}</a></p>
                @endif
            @endif
        </div>
    @endif

    @if(isset($mascota))
        @foreach($vacunas as $v)
            @if($mascota->vacunas()->where('vacunas.id',$v->id)->get()->count())
                <script>
                    $(function(){
                        //alert('{{date('Y/m/d',strtotime($mascota->vacunas()->select('vacunas_mascotas.fecha_aplicacion')->where('vacunas.id',$v->id)->orderBy('vacunas_mascotas.fecha_aplicacion','DESC')->first()->fecha_aplicacion))}}');
                        $('#{{$v->nombre.'_'.$v->id}}').val('{{date('Y/m/d',strtotime($mascota->vacunas()->select('vacunas_mascotas.fecha_aplicacion')->where('vacunas.id',$v->id)->orderBy('vacunas_mascotas.fecha_aplicacion','DESC')->first()->fecha_aplicacion))}}');
                        //alert('{{date('Y-m-d',strtotime('+1days',strtotime($mascota->vacunas()->select('vacunas_mascotas.fecha_aplicacion')->where('vacunas.id',$v->id)->orderBy('vacunas_mascotas.fecha_aplicacion','DESC')->first()->fecha_aplicacion)))}}');
                        $('#{{$v->nombre.'_'.$v->id}}').datepicker('setDate', new Date('{{date('Y/m/d',strtotime('+1days',strtotime($mascota->vacunas()->select('vacunas_mascotas.fecha_aplicacion')->where('vacunas.id',$v->id)->orderBy('vacunas_mascotas.fecha_aplicacion','DESC')->first()->fecha_aplicacion)))}}'));
                    })
                </script>
            @endif
        @endforeach
    @endif
</div>