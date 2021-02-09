<?php
        if(!isset($rol))$rol = new \DogCat\Models\Rol();
?>
<div class="row">
        <div class="col-12">
                <div class="md-form">
                    {!! Form::label('nombre','Nombre',['class'=>'active']) !!}
                    {!! Form::text('nombre',$rol->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre del rol']) !!}
                    {!! Form::hidden('rol',$rol->id,['id'=>'rol']) !!}
                </div>
        </div>

        @if(Auth::user()->getTipoUsuario() == 'personal dogcat')
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="entidades" value="si" @if($rol->entidades == 'si') checked="checked"@endif @if($rol->exists) disabled="disabled" @endif>
                                Rol aplicable para la creación de usuarios administradores de una entidad
                        </label>
                        </div>
                </div>
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="veterinarias" value="si" @if($rol->veterinarias == 'si') checked="checked"@endif @if($rol->exists) disabled="disabled" @endif>
                                Rol aplicable para la creación de usuarios administradores de una veterinaria
                        </label>
                        </div>
                </div>
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="registros" value="si" @if($rol->registros == 'si') checked="checked" @endif @if($rol->exists) disabled="disabled" @endif>
                                Rol aplicable para la creación de usuarios a partir de un registro (posibles usuarios afiliados a veterinarias)
                        </label>
                        </div>
                </div>
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="afiliados" value="si" @if($rol->afiliados == 'si') checked="checked" @endif @if($rol->exists) disabled="disabled" @endif>
                                Rol aplicable para la asignación de usuarios afiliados a veterinarias
                        </label>
                        </div>
                </div>
        @endif
        <div class="col-12 margin-top-40">
                <p>Selecciones los privilegios permitidos para el rol</p>
                <table class="table table-responsive">
                        <thead>
                                <th >Módulos</th>
                                @foreach(\DogCat\Models\Funcion::get() as $f)
                                        <th class="text-center">{{$f->nombre}}</th>
                                @endforeach
                        </thead>
                        <tbody>
                                <?php
                                     $modulos = \DogCat\Models\Modulo::permitidos()->orderBy('nombre')->get();
                                     $funciones = \DogCat\Models\Funcion::get();
                                ?>
                                @foreach($modulos as $m)
                                        @if($m->funciones()->count() && $m->estado == 'Activo')
                                        <tr>
                                                <td>{{$m->etiqueta}}</td>
                                                @foreach($funciones as $f)
                                                        <th class="text-center">
                                                                @if($m->tieneFuncion($f->id) && $m->usuarioTieneFuncion($f->identificador))
                                                                        <input type="checkbox" name="privilegios[]" value="{{$m->identificador.','.$f->identificador}}" @if($rol->exists && $rol->tieneFuncion($m->identificador,$f->identificador)) checked="checked" @endif>
                                                                @endif
                                                        </th>
                                                @endforeach

                                        </tr>
                                        @endif
                                @endforeach
                        </tbody>
                </table>
        </div>
</div>