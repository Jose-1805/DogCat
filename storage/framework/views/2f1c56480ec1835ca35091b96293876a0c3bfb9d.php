<?php
        if(!isset($modulo))$modulo = new \DogCat\Models\Modulo();
?>
<div class="row padding-top-30">
        <div class="col-md-6">
                <div class="md-form">
                    <?php echo Form::label('nombre','Nombre',['class'=>'active']); ?>

                    <?php echo Form::text('nombre',$modulo->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre para identificar el módulo (no editable)']); ?>

                    <?php echo Form::hidden('modulo',$modulo->id,['id'=>'modulo']); ?>

                </div>
        </div>
        <div class="col-md-6">
                <div class="md-form">
                        <?php
                            $disabled = '';
                            if($modulo->exists)
                                $disabled = 'disabled';
                        ?>
                        <?php echo Form::label('identificador','Identificador',['class'=>'active']); ?>

                        <?php echo Form::text('identificador',$modulo->identificador,['id'=>'identificador','class'=>'form-control num-int-positivo','placeholder'=>'Número entero para identificar el módulo (no editable)',$disabled]); ?>

                </div>
        </div>
        <div class="col-md-6">
                <div class="md-form">
                    <?php echo Form::label('etiqueta','Etiqueta',['class'=>'active']); ?>

                    <?php echo Form::text('etiqueta',$modulo->etiqueta,['id'=>'etiqueta','class'=>'form-control','placeholder'=>'Texto para mostrar en la interfaz gráfica']); ?>

                </div>
        </div>

        <div class="col-md-6">
                <div class="md-form input-group pl-0">
                        <?php echo Form::label('url','Url',['class'=>'active']); ?>

                        <div class="input-group-prepend">
                                <span class="input-group-text"><?php echo e(url('/')); ?></span>
                        </div>
                        <?php echo Form::text('url',$modulo->url,['id'=>'url','class'=>'padding-left-10 form-control py-0','placeholder'=>'/ejemplo-url']); ?>

                </div>
        </div>

        <div class="col-md-6">
                <div class="md-form">
                    <?php echo Form::label('orden_menu','Orden en menú',['class'=>'active']); ?>

                    <?php echo Form::text('orden_menu',$modulo->orden_menu,['id'=>'orden_menu','class'=>'form-control num-int-positivo','placeholder'=>'Número de la posición a ocupar en el menú']); ?>

                </div>
        </div>
        <div class="col-md-6">
                <div class="md-form">
                    <?php echo Form::label('agrupacion','Agrupación',['class'=>'active']); ?>

                    <?php echo Form::text('agrupacion',$modulo->agrupacion,['id'=>'agrupacion','class'=>'form-control','placeholder'=>'Agrupación en menú con otros módulos']); ?>

                </div>
        </div>
        <div class="col-md-6">
                <div class="md-form c-select">
                    <?php echo Form::label('estado','Estado',['class'=>'active']); ?>

                    <?php echo Form::select('estado',['Activo'=>'Activo','Inactivo'=>'Inactivo'],$modulo->estado,['id'=>'estado','class'=>'form-control']); ?>

                </div>
        </div>
</div>