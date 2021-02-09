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

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('fecha_nacimiento','Fecha de nacimiento (*)',['class'=>'active']); ?>

                    <?php echo $__env->make('layouts.componentes.datepicker',['id'=>'fecha_nacimiento','name'=>'fecha_nacimiento'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('rol','Rol (*)',['class'=>'active']); ?>

                    <?php echo Form::select('rol',\DogCat\Models\Rol::where('afiliados','si')->pluck('nombre','id'),$usuario->rol_id,['id'=>'rol','class'=>'form-control']); ?>

                </div>
            </div>

            <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
                <?php
                    $disabled = '';
                    $name = 'veterinaria';
                    if($usuario->exists){
                        $disabled = 'disabled="disabled"';
                        $name = '';
                    }
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="md-form c-select">
                        <?php echo Form::label($name,'Veterinaria (*)',['class'=>'active']); ?>

                        <?php echo Form::select($name,\DogCat\Models\Veterinaria::where('estado','aprobada')->where('veterinaria','si')->pluck('nombre','id'),$usuario->veterinaria_afiliado_id,['id'=>$name,'class'=>'form-control','placeholder'=>'Seleccione una veterinaria',$disabled]); ?>

                        <a href="<?php echo e(url('/informacion-veterinarias')); ?>" target="_blank" class="btn btn-info btn-block">Ver información de veterinarias</a>
                    </div>
                </div>
            <?php endif; ?>


            <p class="titulo_principal margin-bottom-20 col-12">Referencia familiar</p>
            <div class="col-12 no-padding">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('ref_fam_nombre','Nombre (*)',['class'=>'control-label']); ?>

                            <?php echo Form::text('ref_fam_nombre',null,['id'=>'ref_fam_nombre','class'=>'form-control','maxlength'=>250,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                            <p class="count-length">250</p>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('ref_fam_celular','N° Celular (*)'); ?>

                            <?php echo Form::text('ref_fam_celular',null,['id'=>'ref_fam_celular','class'=>'form-control num-int-positivo','maxlength'=>'15']); ?>

                            <p class="count-length">15</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                    <div class="md-form">
                        <?php echo Form::label('ref_fam_direccion','Dirección (*)',['class'=>'control-label']); ?>

                        <?php echo Form::text('ref_fam_direccion',null,['id'=>'ref_fam_direccion','class'=>'form-control','maxlength'=>250,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                        <p class="count-length">250</p>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                </div>
            </div>

            <p class="titulo_principal margin-bottom-20 col-12">Referencia personal</p>
            <div class="col-12 no-padding">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('ref_per_nombre','Nombre (*)',['class'=>'control-label']); ?>

                            <?php echo Form::text('ref_per_nombre',null,['id'=>'ref_per_nombre','class'=>'form-control','maxlength'=>250,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                            <p class="count-length">250</p>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('ref_per_celular','N° Celular (*)'); ?>

                            <?php echo Form::text('ref_per_celular',null,['id'=>'ref_per_celular','class'=>'form-control num-int-positivo','maxlength'=>'15']); ?>

                            <p class="count-length">15</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                    <div class="md-form">
                        <?php echo Form::label('ref_per_direccion','Dirección (*)',['class'=>'control-label']); ?>

                        <?php echo Form::text('ref_per_direccion',null,['id'=>'ref_per_direccion','class'=>'form-control','maxlength'=>250,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                        <p class="count-length">250</p>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script>
        $(function () {
            agregarDivisionesDivs('datos_personales_usuario',1,1,2,3);
        })
    </script>
<?php $__env->stopSection(); ?>