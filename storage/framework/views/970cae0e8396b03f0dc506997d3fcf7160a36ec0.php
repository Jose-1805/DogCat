<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">Nueva afiliación</p>
            <?php 
                $disabled = '';
                $veterinarias = [''=>'Seleccione una veterinaria']+\DogCat\Models\Veterinaria::where('estado','aprobada')->where('veterinaria','si')->pluck('nombre','id')->toArray();
                $veterinaria_select = null;
                $usuarios = [''=>'Seleccione un usuario'];
                $user_select = null;

                if(isset($solicitud) && $solicitud->exists){
                    $disabled = 'disabled';
                    $veterinaria = $solicitud->usuario->veterinariaAfiliado;
                    $usuario = $solicitud->usuario;
                    $veterinarias = [$veterinaria->id=>$veterinaria->nombre];
                    $veterinaria_select = $veterinaria->id;
                    $usuarios = [$usuario->id=>$usuario->nombres.' '.$usuario->apellidos];
                    $user_select = $usuario->id;
                }
             ?>

            <div class="col-12 col-md-5 border padding-top-10">
                <p class="titulo_secundario border-bottom margin-bottom-30">Busque el usuario a afiliar</p>
                <div class="row">
                    <div class="col-12">
                        <div class="md-form c-select">
                            <?php echo Form::label('veterinaria','Veterinaria',['class'=>'active']); ?>

                            <?php echo Form::select('veterinaria',$veterinarias,$veterinaria_select,['id'=>'veterinaria','class'=>'form-control',$disabled]); ?>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="md-form c-select">
                            <?php echo Form::label('usuario','Usuario (*)',['class'=>'active']); ?>

                            <div id="contenedor-select-afiliados">
                                <?php echo Form::select('usuario',$usuarios,$user_select,['id'=>'usuario','class'=>'form-control',$disabled]); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-7 border-right border-bottom border-top padding-top-10">
                <p class="titulo_secundario border-bottom margin-bottom-30 text-center">Seleccione las mascotas a afiliar</p>
                <div class="row">
                    <div class="col-12" id="contenedor-mascotas">
                        <p class="alert alert-info text-center">No existen mascotas para seleccionar</p>
                    </div>
                </div>
            </div>



        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/afiliacion/nueva.js')); ?>"></script>
    <?php if(isset($solicitud) && $solicitud->exists): ?>
        <script>
            $(function () {
                $('#usuario').change();
            })
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>