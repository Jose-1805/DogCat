<?php
    if(!isset($mascota))$mascota = new \DogCat\Models\Mascota();
    $cols_form = '';
?>

<div class="row">
    <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat' || Auth::user()->getTipoUsuario() == 'empleado'): ?>
        <p class="titulo_principal col-12">Propietario de la mascota</p>
        <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
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
                }
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('veterinaria','Veterinaria',['class'=>'active']); ?>

                    <?php echo Form::select('veterinaria',$veterinarias,$veterinaria,['id'=>'veterinaria','class'=>'form-control',$disabled]); ?>

                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('usuario','Usuario (*)',['class'=>'active']); ?>

                    <div id="contenedor-select-afiliados">
                        <?php echo Form::select('usuario',$usuarios,$user_select,['id'=>'usuario','class'=>'form-control',$disabled]); ?>

                    </div>
                </div>
            </div>
        <?php elseif(Auth::user()->getTipoUsuario() == 'empleado'): ?>
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
                    <?php echo Form::label($name,'Usuario (*)',['class'=>'active']); ?>

                    <?php echo Form::select($name,$usuarios,$mascota->user_id,['id'=>$name,'class'=>'form-control',$disabled]); ?>

                </div>
            </div>
        <?php endif; ?>

        <p class="titulo_principal col-12">Datos de la mascota</p>
    <?php endif; ?>

    <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'uploads', $privilegio_superadministrador)): ?>
        <div class="col-12 col-md-4 col-lg-3">
            <p class="titulo_secundario">Imagen (foto)</p>
            <input id="imagen" name="imagen" type="file" class="file-loading">
        </div>
        <?php
            $cols_form = 'col-md-8 col-lg-9';
        ?>
    <?php endif; ?>
    <div class="col-12 <?php echo e($cols_form); ?> no-padding">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('nombre','Nombre (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('nombre',$mascota->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre de la mascota','maxlength'=>100,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                    <div class="help-block with-errors"></div>
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
                    <?php echo Form::label('sexo','Sexo (*)',['class'=>'active']); ?>

                    <?php echo Form::select('sexo',['Macho'=>'Macho','Hembra'=>'Hembra'],$mascota->sexo,['id'=>'sexo','class'=>'form-control','placeholder'=>'Sexo de la mascota']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('peso','Peso (Kg) (*)'); ?>

                    <?php echo Form::text('peso',$mascota->peso,['id'=>'peso','class'=>'form-control num-float-positivo','placeholder'=>'Peso de la mascota']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <?php echo Form::label('color','Color (*)',['class'=>'control-label']); ?>

                    <?php echo Form::text('color',$mascota->color,['id'=>'color','class'=>'form-control','placeholder'=>'Color de la mascota','maxlength'=>100,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese únicamente letras']); ?>

                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form c-select">
                    <?php echo Form::label('tipo_mascota','Tipo de mascota (*)',['class'=>'active']); ?>

                    <?php echo Form::select('tipo_mascota',\DogCat\Models\TipoMascota::pluck('nombre','id'),$mascota->exists?$mascota->raza->tipoMascota->id:'',['id'=>'tipo_mascota','class'=>'form-control consulta-datos-afiliacion','placeholder'=>'Selecione el tipo de mascota']); ?>

                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="md-form">
                    <label for="raza_">Raza (*) <span class="text-success" id="raza_seleccionada" style="color: #5ab8c1 !important; font-weight: 600 !important;"><?php echo e($mascota->exists?'('.$mascota->raza->nombre.')':''); ?></span></label>
                    <?php
                        $disabled = 'disabled="disabled"';
                        $class_change = '';
                        if($mascota->exists){
                            $disabled = '';
                            $class_change = 'cargar-mascotas';
                        }
                    ?>
                    <?php echo Form::text('raza_',$mascota->exists?$mascota->raza->nombre:'',['id'=>'raza_','class'=>'form-control '.$class_change,'placeholder'=>'Seleccione una raza',$disabled]); ?>

                    <?php echo Form::hidden('raza',$mascota->exists?$mascota->raza->id:'',['id'=>'raza']); ?>

                </div>
            </div>


            <div class="col-md-6 col-lg-8 content-textarea">
                    <?php echo Form::label('patologias','Patologías ',['class'=>'control-label']); ?>

                    <?php echo Form::textarea('patologias',$mascota->patologias,['id'=>'patologias','class'=>'form-control','placeholder'=>'Ingrese la descrición de todas las patologías conocidas o halladas en la mascota','rows'=>'3']); ?>

            </div>

            <div class="col-12">
                <p class="titulo_principal">Características</p>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('pelaje','Pelaje (*)'); ?>

                            <?php echo Form::text('pelaje',null,['id'=>'pelaje','class'=>'form-control']); ?>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('cola','Cola (*)'); ?>

                            <?php echo Form::text('cola',null,['id'=>'cola','class'=>'form-control']); ?>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('patas','Patas (*)'); ?>

                            <?php echo Form::text('patas',null,['id'=>'patas','class'=>'form-control']); ?>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('orejas','Orejas (*)'); ?>

                            <?php echo Form::text('orejas',null,['id'=>'orejas','class'=>'form-control']); ?>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('ojos','Ojos (*)'); ?>

                            <?php echo Form::text('ojos',null,['id'=>'ojos','class'=>'form-control']); ?>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form">
                            <?php echo Form::label('manchas','Manchas'); ?>

                            <?php echo Form::text('manchas',null,['id'=>'manchas','class'=>'form-control']); ?>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="md-form c-select">
                            <?php echo Form::label('esterilizado','Esterilizado (*)',['class'=>'active']); ?>

                            <?php echo Form::select('esterilizado',['no'=>'no','si'=>'si'],null,['id'=>'esterilizado','class'=>'form-control']); ?>

                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8 form-group content-textarea" style="margin-top: -18px !important;">
                            <?php echo Form::label('otras_caracteristicas','Otras características'); ?>

                            <?php echo Form::textarea('otras_caracteristicas',null,['id'=>'otras_caracteristicas','class'=>'form-control','rows'=>'3']); ?>

                        </div>
                    </div>
                </div>

            <div class="col-12">
                <p class="titulo_principal">Vacunas</p>
                <div class="row">
                    <div class="col-12">
                        <p class="alert alert-info">
                            A continuación puede seleccionar un archivo (.pdf) con el último carné de vacunas de la mascota y al final ingresar el nombre de las vacunas aplicadas según el carné.
                            <?php if($mascota->exists): ?>
                                <br><br>Los carnés registrados anteriormente no se eliminarán y quedarán almacenados en el sistema a modo de historial
                            <?php endif; ?>
                        </p>
                        <?php if($mascota->exists): ?>
                            <?php 
                                $vacunas = $mascota->vacunas;
                             ?>

                            <?php if(count($vacunas)): ?>
                                <div class="col-12 padding-top-10 padding-bottom-20 green lighten-4 margin-bottom-10">
                                    <p><strong class="">Vacunas registradas anteriormente</strong></p>
                                    <ul class="no-padding margin-left-20">
                                    <?php $__currentLoopData = $vacunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(url('/mascota/vacuna/'.$v->id)); ?>" target="_blank"><?php echo e($v->vacunas.' - '.$v->created_at); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="md-form">
                            <?php echo Form::file('vacunas_file',null,['id'=>'vacunas_file','class'=>'form-control']); ?>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 content-textarea">
                        <?php echo Form::label('vacunas','Vacunas'); ?>

                        <?php echo Form::textarea('vacunas','',['id'=>'vacunas','class'=>'form-control']); ?>

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
            <?php if($mascota->exists): ?>
                $('.datepicker').datepicker('setDate', new Date('<?php echo e(date('Y-m-d',strtotime('+1days',strtotime($mascota->fecha_nacimiento)))); ?>'));

                $('.cargar-mascotas').focus(function () {
                    $('#tipo_mascota').change();
                    $(this).removeClass('cargar-mascotas');
                })

            <?php endif; ?>
        })
    </script>
<?php $__env->stopSection(); ?>