<?php
if(!isset($mascota))$mascota = new \DogCat\Models\Mascota();
$cols_form = '';
$disabled_edicion = '';
if($mascota->exists && !$mascota->permitirEditarTodo()){
    $disabled_edicion = 'disabled';
}
$clasificaciones = ['Mesocéfalo'=>'Mesocéfalo (osico mediano)','Braquicéfalo'=>'Braquicéfalo (osico ñato)','Dolicéfalo'=>'Dolicéfalo (osico largo)'];
?>

<div class="row">
    @if(Auth::user()->getTipoUsuario() == 'personal dogcat' || Auth::user()->getTipoUsuario() == 'empleado')
        <h4 class="titulo_principal col-12 margin-bottom-20">Propietario de la mascota</h4>
        @if(Auth::user()->getTipoUsuario() == 'personal dogcat')
            <?php
            $disabled = '';
            if($mascota->exists){
                $user = $mascota->user;
                $veterinarias = \DogCat\Models\Veterinaria::where('id',$user->veterinaria_afiliado_id)->pluck('nombre','id')->toArray();
                $usuarios = [''=>$user->nombres.' '.$user->apellidos.' - '.$user->tipo_identificacion.' '.$user->identificacion];
                $user_select = null;
                $disabled = 'disabled="disabled"';
                $veterinaria = $user->veterinaria_afiliado_id;
            }else{
                $veterinaria = null;
                $veterinarias = [''=>'Seleccione una veterinaria']+\DogCat\Models\Veterinaria::where('estado','aprobada')->where('veterinaria','si')->pluck('nombre','id')->toArray();
                $usuarios = [''=>'Seleccione un usuario'];
                $user_select = null;
                if($usuario_seleccionado){
                    $veterinaria = $usuario_seleccionado->veterinaria_afiliado_id;
                    $usuarios = [''=>'Seleccione un usuario']+\DogCat\User::afiliados()->where('estado','activo')->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(nombres," ",apellidos," - ",tipo_identificacion," ",identificacion) as afiliado'))->where('veterinaria_afiliado_id',$usuario_seleccionado->veterinaria_afiliado_id)->pluck('afiliado','id')->toArray();
                    $user_select = $usuario_seleccionado->id;
                }
            }
            ?>
            <div class="col-12 no-padding">
                <div class="row">

                    <div class="col-md-6 col-lg-4">
                        <div class="md-form c-select">
                            {!! Form::label('veterinaria','Veterinaria',['class'=>'active']) !!}
                            {!! Form::select('veterinaria',$veterinarias,$veterinaria,['id'=>'veterinaria','class'=>'form-control',$disabled]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form c-select">
                            {!! Form::label('usuario','Usuario (*)',['class'=>'active']) !!}
                            <div id="contenedor-select-afiliados">
                                {!! Form::select('usuario',$usuarios,$user_select,['id'=>'usuario','class'=>'form-control',$disabled]) !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @elseif(Auth::user()->getTipoUsuario() == 'empleado')
            <?php
            $usuarios = [''=>'Seleccione un usuario']+\DogCat\User::afiliados()->where('estado','activo')->select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(nombres," ",apellidos," - ",tipo_identificacion," ",identificacion) as afiliado'))->pluck('afiliado','id')->toArray();
            $name = 'usuario';
            $disabled = '';
            if($mascota->exists){
                $name = '';
                $disabled = 'disabled="disabled"';
            }
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label($name,'Usuario (*)',['class'=>'active']) !!}
                    {!! Form::select($name,$usuarios,$mascota->user_id,['id'=>$name,'class'=>'form-control',$disabled]) !!}
                </div>
            </div>
        @endif

        <h4 class="titulo_principal col-12 margin-bottom-20">Datos de la mascota</h4>
    @endif

    @if(Auth::user()->tieneFuncion($identificador_modulo, 'uploads', $privilegio_superadministrador))
        <div class="col-12 col-md-4 col-lg-3">
            <p class="titulo_secundario">Imagen (foto)</p>
            <input id="imagen" name="imagen" type="file" class="file-loading">
        </div>
        <?php
        $cols_form = 'col-md-8 col-lg-9';
        ?>
    @endif
    <div class="col-12 {{$cols_form}} no-padding">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('nombre','Nombre (*)',['class'=>'control-label']) !!}
                    {!! Form::text('nombre',$mascota->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre de la mascota','maxlength'=>100,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras',$disabled_edicion]) !!}
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('fecha_nacimiento','Fecha de nacimiento (*)',['class'=>'active']) !!}
                    @if($disabled_edicion == 'disabled')
                        {!! Form::date('fecha_nacimiento',$mascota->fecha_nacimiento,['id'=>'fecha_nacimiento','class'=>'form-control',$disabled_edicion]) !!}
                    @else
                        @include('layouts.componentes.datepicker',['id'=>'fecha_nacimiento','name'=>'fecha_nacimiento'])
                    @endif
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('sexo','Sexo (*)',['class'=>'active']) !!}
                    {!! Form::select('sexo',['Macho'=>'Macho','Hembra'=>'Hembra'],$mascota->sexo,['id'=>'sexo','class'=>'form-control','placeholder'=>'Sexo de la mascota',$disabled_edicion]) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('peso','Peso (Kg) (*)') !!}
                    {!! Form::text('peso',$mascota->peso,['id'=>'peso','class'=>'form-control num-float-positivo','placeholder'=>'Peso de la mascota']) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    {!! Form::label('color','Color (*)',['class'=>'control-label']) !!}
                    {!! Form::text('color',$mascota->color,['id'=>'color','class'=>'form-control','placeholder'=>'Color de la mascota','maxlength'=>100,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras',$disabled_edicion]) !!}
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    {!! Form::label('tipo_mascota','Tipo de mascota (*)',['class'=>'active']) !!}
                    {!! Form::select('tipo_mascota',\DogCat\Models\TipoMascota::pluck('nombre','id'),$mascota->exists?$mascota->raza->tipoMascota->id:'',['id'=>'tipo_mascota','class'=>'form-control consulta-datos-afiliacion','placeholder'=>'Selecione el tipo de mascota',$disabled_edicion]) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <label for="raza_">Raza (*) <span class="text-success" id="raza_seleccionada" style="color: #5ab8c1 !important; font-weight: 600 !important;">{{$mascota->exists?'('.$mascota->raza->nombre.')':''}}</span></label>
                    <?php
                        $disabled = 'disabled="disabled"';
                        $class_change = '';
                        if($mascota->exists){
                            $disabled = '';
                            $class_change = 'cargar-mascotas';
                        }
                    ?>
                    {!! Form::text('raza_',$mascota->exists?$mascota->raza->nombre:'',['id'=>'raza_','class'=>'form-control '.$class_change,'placeholder'=>'Seleccione una raza',$disabled,$disabled_edicion]) !!}
                    {!! Form::hidden('raza',$mascota->exists?$mascota->raza->id:'',['id'=>'raza']) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-8">
                <div class="md-form c-select">
                    {!! Form::label('clasificacion','Clasificación (solo aplica para perros)',['class'=>'active']) !!}
                    {!! Form::select('clasificacion',$clasificaciones,$mascota->clasificacion,['id'=>'clasificacion','class'=>'form-control','placeholder'=>'Selecione la clasificacion de la mascota',$disabled_edicion]) !!}
                </div>
            </div>

            <div class="col-md-6 col-lg-12 content-textarea">
                {!! Form::label('patologias','Patologías ',['class'=>'control-label']) !!}
                {!! Form::textarea('patologias','',['id'=>'patologias','class'=>'form-control','placeholder'=>'Ingrese la descrición de todas las patologías conocidas o halladas en la mascota','rows'=>'3']) !!}
            </div>
            @if($mascota->patologias)
                <div class="col-12 alert alert-info">
                    <p><strong>Patologías registradas: </strong>{{$mascota->patologias}}</p>
                </div>
            @endif


            <div class="col-12">
                <h4 class="titulo_principal margin-bottom-20">Características</h4>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            {!! Form::label('pelaje','Pelaje (*)') !!}
                            {!! Form::text('pelaje',null,['id'=>'pelaje','class'=>'form-control',$disabled_edicion]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form c-select">
                            {!! Form::label('cola','Cola (*)',['class'=>'active']) !!}
                            {!! Form::select('cola',[''=>'Seleccione el tipo de cola','Larga'=>'Larga','Corta'=>'Corta','Cortada'=>'Cortada'],null,['id'=>'cola','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            {!! Form::label('patas','Patas (*)') !!}
                            {!! Form::text('patas',null,['id'=>'patas','class'=>'form-control',$disabled_edicion]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form c-select">
                            {!! Form::label('orejas','Orejas (*)',['class'=>'active']) !!}
                            {!! Form::select('orejas',[''=>'Seleccione el tipo de orejas','Larga'=>'Larga','Corta'=>'Corta','Cortada'=>'Cortada'],null,['id'=>'orejas','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            {!! Form::label('ojos','Ojos (*)') !!}
                            {!! Form::text('ojos',null,['id'=>'ojos','class'=>'form-control',$disabled_edicion]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            {!! Form::label('manchas','Manchas') !!}
                            {!! Form::text('manchas',null,['id'=>'manchas','class'=>'form-control',$disabled_edicion]) !!}
                        </div>
                    </div>

                    @php($disabled_esterilizado = '')
                    @if($mascota->exists && $mascota->esterilizado == 'si' && $disabled_edicion == 'disabled')
                        @php($disabled_esterilizado = 'disabled')
                    @endif
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form c-select">
                            {!! Form::label('esterilizado','Esterilizado (*)',['class'=>'active']) !!}
                            {!! Form::select('esterilizado',['no'=>'no','si'=>'si'],null,['id'=>'esterilizado','class'=>'form-control',$disabled_esterilizado]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8 form-group content-textarea" style="margin-top: -18px !important;">
                        {!! Form::label('otras_caracteristicas','Otras características') !!}
                        {!! Form::textarea('otras_caracteristicas','',['id'=>'otras_caracteristicas','class'=>'form-control','rows'=>'3']) !!}
                    </div>
                    @if($mascota->otras_caracteristicas)
                        <div class="col-12 alert alert-info">
                            <p><strong>Otras caracteristicas registradas: </strong>{{$mascota->otras_caracteristicas}}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12">
                <h4 class="titulo_principal">Vacunas</h4>
                <div class="row">
                    <div class="col-12">
                        <p class="alert alert-info">
                            A continuación debe seleccionar un archivo (.pdf, .jpg, .jpeg, .png) con el último carné de vacunas de la mascota y al final ingresar el nombre de las vacunas aplicadas según el carné.
                            @if($mascota->exists)
                                <br><br>Los carnés registrados anteriormente no se eliminarán y quedarán almacenados en el sistema a modo de historial
                            @endif
                        </p>
                        @if($mascota->exists)
                            @php
                                $vacunas = $mascota->vacunas;
                            @endphp

                            @if(count($vacunas))
                                <div class="col-12 padding-top-10 padding-bottom-20 green lighten-4 margin-bottom-10">
                                    <p><strong class="">Vacunas registradas anteriormente</strong></p>
                                    <ul class="no-padding margin-left-20">
                                        @foreach($vacunas as $v)
                                            <li><a href="{{url('/mascota/vacuna/'.$v->id)}}" target="_blank">{{$v->vacunas.' - '.$v->created_at}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                        <div class="md-form">
                            {!! Form::file('vacunas_file',null,['id'=>'vacunas_file','class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 content-textarea">
                        {!! Form::label('vacunas','Vacunas') !!}
                        {!! Form::textarea('vacunas','',['id'=>'vacunas','class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent
    <script>
        $(function () {
            @if($mascota->exists)
                @if($disabled_edicion != 'disabled')
                    $('.datepicker').datepicker('setDate', new Date('{{date('Y-m-d',strtotime('+1days',strtotime($mascota->fecha_nacimiento)))}}'));
                @endif

                $('.cargar-mascotas').focus(function () {
                    $('#tipo_mascota').change();
                    $(this).removeClass('cargar-mascotas');
                })

            @endif
        })
    </script>
@endsection