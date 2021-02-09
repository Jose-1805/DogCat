<?php
        if(!isset($funcion))$funcion = new \DogCat\Models\Funcion();
?>
<div class="row padding-top-30">
        <div class="col-12">
                <div class="md-form">
                    {!! Form::label('nombre','Nombre',['class'=>'active']) !!}
                    {!! Form::text('nombre',$funcion->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre de la función']) !!}
                    {!! Form::hidden('funcion',$funcion->id,['id'=>'funcion']) !!}
                </div>
        </div>
        <div class="col-12">
                <div class="md-form">
                    <?php
                            $disabled = '';
                            if($funcion->exists)
                                $disabled = 'disabled';
                    ?>
                    {!! Form::label('identificador','Identificador',['class'=>'active']) !!}
                    {!! Form::text('identificador',$funcion->identificador,['id'=>'identificador','class'=>'form-control num-int-positivo','placeholder'=>'Número entero para identificar la función (no editable)',$disabled]) !!}
                </div>
        </div>
</div>