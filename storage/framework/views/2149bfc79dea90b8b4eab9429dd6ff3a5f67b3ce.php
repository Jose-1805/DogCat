<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <p class="titulo_secundario">Imagen (foto)</p>
        <input id="imagen" name="imagen" type="file" class="file-loading">
    </div>

    <div class="col-12 col-md-8 col-lg-9 no-padding" id="datos_personales_usuario">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('tipo_identificacion','Tipo de identificación (*)',['class'=>'active']); ?>

                    <?php echo Form::select('tipo_identificacion',['C.C'=>'C.C','NIT'=>'NIT'],null,['id'=>'tipo_identificacion','class'=>'form-control']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('identificacion','No. de identificación (*)'); ?>

                    <?php echo Form::text('identificacion',null,['id'=>'identificacion','class'=>'form-control num-int-positivo','maxlength'=>'15']); ?>

                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('nombres','Nombres (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('nombres',null,['id'=>'nombres','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('apellidos','Apellidos (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('apellidos',null,['id'=>'apellidos','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('email','Correo (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('email',null,['id'=>'email','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z0-9@.-]{1,}$','data-error'=>'Caracteres no válidos']); ?>

                    <p class="count-length">150</p>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('celular','N° Celular (*)'); ?>

                    <?php echo Form::text('celular',null,['id'=>'celular','class'=>'form-control num-int-positivo','maxlength'=>'15']); ?>

                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('telefono','N° Teléfono fijo'); ?>

                    <?php echo Form::text('telefono',null,['id'=>'telefono','class'=>'form-control num-int-positivo','maxlength'=>'15']); ?>

                    <p class="count-length">15</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('genero','Gènero (*)',['class'=>'active']); ?>

                    <?php echo Form::select('genero',['masculino'=>'Masculino','femenino'=>'Femenino'],null,['id'=>'genero','class'=>'form-control']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('estado_civil','Estado civil (*)',['class'=>'active']); ?>

                    <?php echo Form::select('estado_civil',['Casado(a)'=>'Casado(a)', 'Soltero(a)'=>'Soltero(a)', 'Unión marital de hecho'=>'Unión marital de hecho'],null,['id'=>'estado_civil','class'=>'form-control']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4 m">
                <div class="md-form">
                    <?php echo Form::label('fecha_nacimiento','Fecha de nacimiento (*)',['class'=>'active']); ?>

                    <?php echo $__env->make('layouts.componentes.datepicker',['id'=>'fecha_nacimiento','name'=>'fecha_nacimiento'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>

            <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="md-form c-select">
                        <?php echo Form::label('rol','Rol (*)',['class'=>'active']); ?>

                        <?php echo Form::select('rol',\DogCat\Models\Rol::permitidos()->where('afiliados','no')->where('veterinarias','no')->where('entidades','no')->where('registros','no')->pluck('nombre','id'),$usuario->rol_id,['id'=>'rol','class'=>'form-control']); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-6 col-lg-4">
                    <div class="md-form c-select">
                        <?php echo Form::label('rol','Rol (*)',['class'=>'active']); ?>

                        <?php echo Form::select('rol',\DogCat\Models\Rol::permitidos()->pluck('nombre','id'),$usuario->rol_id,['id'=>'rol','class'=>'form-control']); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>