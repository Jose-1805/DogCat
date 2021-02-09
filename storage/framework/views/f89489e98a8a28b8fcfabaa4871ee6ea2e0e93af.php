<?php
    $administrador = new \DogCat\User();
    $ubicacion_veterinaria = new \DogCat\Models\Ubicacion();
    $ubicacion_administrador = new \DogCat\Models\Ubicacion();
    if($veterinaria->exists){
        $administrador = $veterinaria->administrador;
        $ubicacion_veterinaria = $veterinaria->ubicacion;
        $ubicacion_administrador = $administrador->ubicacion;
    }
?>
<?php echo Form::model($veterinaria,['id'=>'form-veterinaria']); ?>

<?php if($veterinaria->exists): ?>
    <?php echo Form::hidden('veterinaria',$veterinaria->id); ?>

<?php endif; ?>
<?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-veterinaria'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="contenedor-toggle-render" id="datos_basicos_veterinaria">
    <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos básicos - veterinaria</p>
    <div class="col-12 padding-bottom-30">
        <?php echo $__env->make('veterinaria.forms.navegacion',['except'=>['datos_basicos_veterinaria']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php echo $__env->make('veterinaria.forms.datos_basicos_veterinaria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
    </div>
</div>

<div class="contenedor-toggle-render d-none" id="ubicacion_veterinaria">
    <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - veterinaria</p>
    <div class="col-12 padding-bottom-30">
        <?php echo $__env->make('veterinaria.forms.navegacion',['except'=>['ubicacion_veterinaria']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php echo $__env->make('veterinaria.forms.datos_ubicacion_veterinaria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_basicos_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
    </div>
</div>

<div class="contenedor-toggle-render d-none" id="datos_personales_administrador">
    <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Datos personales - administrador</p>
    <div class="col-12 padding-bottom-30">
        <?php echo $__env->make('veterinaria.forms.navegacion',['except'=>['datos_personales_administrador']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php echo $__env->make('veterinaria.forms.datos_personales_administrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="ubicacion_veterinaria"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
    </div>
</div>

<div class="contenedor-toggle-render d-none" id="datos_ubicacion_administrador">
    <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Ubicación - administrador</p>
    <div class="col-12 padding-bottom-30">
        <?php echo $__env->make('veterinaria.forms.navegacion',['except'=>['datos_ubicacion_administrador']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php echo $__env->make('veterinaria.forms.datos_ubicacion_administrador', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="col-12 text-right margin-top-30 no-padding">
        <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_personales_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
        <?php if(!$administrador->exists): ?>
            <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="seguridad_administrador">Siguiente <i class="fa fa-caret-right margin-left-5"></i></a>
        <?php else: ?>
            <a href="#!" class="btn btn-success btn-submit" id="guardar-veterinaria">Guardar</a>
        <?php endif; ?>
    </div>
</div>

<?php if(!$administrador->exists): ?>
    <div class="contenedor-toggle-render d-none" id="seguridad_administrador">
        <div class="row">
                <p class="titulo_principal margin-bottom-20 margin-top-20 col-12">Seguridad - administrador</p>
                <div class="col-12 padding-bottom-30">
                    <?php echo $__env->make('veterinaria.forms.navegacion',['except'=>['seguridad_administrador']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>

                <div class="col-12 col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('password','Contraseña',['class'=>'control-label']); ?>

                        <input type="password" name="password" id="password" class="form-control" data-minlength="6" autocomplete="off">
                        <div class="help-block">Mínimo 6 caracteres</div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('password_confirm','Confirmación de contraseña',['class'=>'control-label']); ?>

                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" data-minlength="6" data-match="#password" data-minlength-error="Mínimo 6 caracteres" data-match-error="La confirmación no coincide" autocomplete="off">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-12 text-right margin-top-30 no-padding">
                    <a href="#!" class="btn btn-primary btn-navegacion-toggle-render" data-element="datos_ubicacion_administrador"><i class="fa fa-caret-left margin-right-5"></i> Anterior</a>
                    <a href="#!" class="btn btn-success btn-submit" id="guardar-veterinaria">Guardar</a>
                </div>
        </div>
    </div>
<?php endif; ?>
<?php echo Form::close(); ?>