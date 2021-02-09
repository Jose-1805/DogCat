<?php
    if(!isset($servicio))$servicio = new \DogCat\Models\Servicio();

    if(Auth::user()->getTipoUsuario() == 'personal dogcat')
        $entidades = [''=>'Seleccione una entidad']+\DogCat\Models\Veterinaria::pluck('nombre','id')->toArray();
    else
        $entidades = [''=>'Seleccione una entidad']+\DogCat\Models\Veterinaria::where('id',Auth::user()->getVeterinaria()->id)->pluck('nombre','id')->toArray();

    $disabled_edicion = '';
    if($servicio->exists){
        if(!Auth::user()->esSuperadministrador())$disabled_edicion = 'disabled';
    }
?>
<?php echo Form::model($servicio,['id'=>'form-servicio','data-toggle'=>'validator']); ?>


    <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-servicio'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo Form::hidden('servicio',$servicio->id,['id'=>'servicio']); ?>

    <div class="row padding-top-20">
        <div class="col col-md-4">
            <div class="md-form">
                <?php echo Form::label('nombre','Nombre (*)'); ?>

                <?php echo Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','maxlength'=>'150']); ?>

                <p class="count-length">150</p>
            </div>
        </div>

        <div class="col col-md-4">
            <div class="md-form c-select">
                <?php echo Form::label('estado','Estado (*)',['class'=>'active']); ?>

                <?php echo Form::select('estado',['Activo'=>'Activo','Inactivo'=>'Inactivo'],null,['id'=>'estado','class'=>'form-control']); ?>

            </div>
        </div>

        <div class="col col-md-4">
            <div class="md-form c-select">
                <?php echo Form::label('entidad','Entidad',['class'=>'active']); ?>

                <?php echo Form::select('entidad',$entidades,$servicio->veterinaria_id,['id'=>'entidad','class'=>'form-control']); ?>

            </div>
        </div>

        <div class="col col-md-4" style="margin-top: -20px;">
            <div class="md-form">
                <label for="aplicable_perros">
                    <?php echo Form::checkbox('aplicable_perros','si',$servicio->aplicable_perros=='si'?true:false,['id'=>'aplicable_perros','class'=>'']); ?>

                    Aplicable a perros
                </label>
            </div>
            <div class="md-form">
                <label for="aplicable_gatos">
                    <?php echo Form::checkbox('aplicable_gatos','si',$servicio->aplicable_gatos=='si'?true:false,['id'=>'aplicable_gatos','class'=>'']); ?>

                    Aplicable a gatos
                </label>
            </div>
        </div>

        <p class="col-12 alert alert-info margin-bottom-40 margin-top-50">Establezca la cantidad de tiempo empleado para prestar el servicio, segùn el peso de la mascota. El tiempo se leerá como minutos.</p>

        <div class="col col-md-4">
            <div class="md-form">
                <?php echo Form::label('duracion_1_10','Entre 0 y 10 KG'); ?>

                <?php echo Form::text('duracion_1_10',null,['id'=>'duracion_1_10','class'=>'form-control num-int-positivo']); ?>

            </div>
        </div>

        <div class="col col-md-4">
            <div class="md-form">
                <?php echo Form::label('duracion_10_25','Entre 10 y 25 KG'); ?>

                <?php echo Form::text('duracion_10_25',null,['id'=>'duracion_10_25','class'=>'form-control num-int-positivo']); ?>

            </div>
        </div>

        <div class="col col-md-4">
            <div class="md-form">
                <?php echo Form::label('duracion_mayor_25','Mayor a 25 KG'); ?>

                <?php echo Form::text('duracion_mayor_25',null,['id'=>'duracion_mayor_25','class'=>'form-control num-int-positivo']); ?>

            </div>
        </div>

        <?php if($servicio->exists && !Auth::user()->esSuperadministrador()): ?>
            <p class="col-12 alert alert-warning margin-bottom-40">Para editar los valores de cobro comuniquese con DogCat.</p>
        <?php else: ?>
            <p class="col-12 alert alert-info margin-bottom-40">Establezca el valor a cobrar por la prestación del servicio y el descuento ofrecido a los clientes de DogCat</p>
        <?php endif; ?>

        <div class="col col-md-5">
            <div class="md-form">
                <?php echo Form::label('valor','Valor'); ?>

                <?php echo Form::text('valor',null,['id'=>'valor','class'=>'form-control num-int-positivo',$disabled_edicion]); ?>

            </div>
        </div>
        <div class="col col-md-7">
            <div class="md-form">
                <?php echo Form::label('descuento','Descuento ofrecido a DogCat (%)'); ?>

                <?php echo Form::text('descuento',null,['id'=>'descuento','class'=>'form-control num-int-positivo',$disabled_edicion]); ?>

            </div>
        </div>

        <div class="col-12 text-right margin-top-30">
            <a href="#!" class="btn btn-success btn-submit" id="btn-guardar-servicio">Guardar</a>
        </div>
    </div>
<?php echo Form::close(); ?>