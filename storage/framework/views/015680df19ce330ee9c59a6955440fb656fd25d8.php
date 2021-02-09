

<?php $__env->startSection('content'); ?>
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal">Mascotas</h3>
            <div class="col-12 no-padding">
                <div class="col-12 no-padding">
                    <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-mascotas'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div class="col-12 no-padding">

                    <?php if(!(Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro")): ?>
                        <div class="right margin-left-10" style="padding-top: 6px;">
                            <?php echo $__env->make('layouts.componentes.btn_filter_table',['tabla'=>'tabla-mascotas'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(Auth::user()->tieneFuncion($identificador_modulo, 'crear', $privilegio_superadministrador)): ?>
                        <a href="<?php echo e(url('/mascota/nueva')); ?>" class="btn btn-primary right margin-right-none"><i class="fa fa-plus-circle margin-right-10"></i> Nueva mascota</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro"): ?>
                <div class="col-12 no-padding" style="min-height: 100px;" id="contenedor-mascotas">
                    <?php if(count($mascotas)): ?>
                        <div class="row">
                            <div class="col-md-7 col-lg-8">
                                <ul class="list-group lista-mascotas">
                                    <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li href="#!" data-m="<?php echo e($m->id); ?>" class="list-group-item cursor_pointer <?php if(($mascotas[0] == $m && !$mascota) || ($mascota && $mascota->id == $m->id)): ?> list-group-item-info <?php endif; ?>">
                                            <?php echo e($m->nombre.' ('.$m->raza->nombre.')'); ?>

                                            <span class="fa fa-angle-right right green-text font-large"></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>

                            <div class="col-md-5 col-lg-4">
                            <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="card <?php if(!(($mascotas[0] == $m && !$mascota) || ($mascota && $mascota->id == $m->id))): ?> d-none <?php endif; ?> info-mascota" id="m-<?php echo e($m->id); ?>">
                                    <?php if($m->imagen): ?>
                                        <img class="img-fluid" src="<?php echo e(url('/almacen/'.str_replace('/','-',$m->imagen->ubicacion).'-'.$m->imagen->nombre)); ?>" alt="Nombre">
                                    <?php endif; ?>
                                    <!--Card content-->
                                    <div class="card-body">
                                        <!--Title-->
                                        <h4 class="card-title border-bottom"><?php echo e($m->nombre); ?></h4>
                                        <!--Text-->
                                        <div class="collapse <?php if(($mascotas[0] == $m && !$mascota) || ($mascota && $mascota->id == $m->id)): ?> in show <?php endif; ?>" id="datos-<?php echo e($m->id); ?>">
                                            <p class="card-text"><strong>Tipo: </strong><?php echo e($m->raza->tipoMascota->nombre); ?></p>
                                            <p class="card-text"><strong>Raza: </strong><?php echo e($m->raza->nombre); ?></p>
                                            <p class="card-text"><strong>Edad: </strong><?php echo e($m->strDataEdad()); ?></p>
                                            <p class="card-text"><strong>Sexo: </strong><?php echo e($m->sexo); ?></p>
                                            <p class="card-text"><strong>Peso: </strong><?php echo e($m->peso.' Kg'); ?></p>
                                            <p class="card-text"><strong>Color: </strong><?php echo e($m->color); ?></p>
                                        </div>
                                        <div class="row right">
                                            <a class="btn btn-info" data-toggle="collapse" href="#datos-<?php echo e($m->id); ?>" aria-expanded="false" aria-controls="collapseExample">
                                                Info
                                            </a>
                                            <a href="<?php echo e(url('/mascota/editar/'.$m->id)); ?>" class="btn btn-primary">Editar</a>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php if(Auth::user()->tieneFuncion($identificador_modulo,'crear',$privilegio_superadministrador)): ?>
                                <i class="fa fa-info-circle"></i>  No existen mascotas registradas. Para registrar una mascota en <strong>DogCat</strong> haga <strong><a href="<?php echo e(url('/mascota/nueva')); ?>">click aquí</a></strong> o en el botón <i class="fa fa-plus"></i>.
                            <?php else: ?>
                                <i class="fa fa-info-circle"></i> No existen mascotas registradas.
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="col-12 no-padding">
                    <table id="tabla-mascotas" class="table-hover DataTable">
                        <thead>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Peso</th>
                        <th>Color</th>
                        <th>Propietario</th>
                        <th>Identificación propietario</th>
                        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar'],false,$privilegio_superadministrador)): ?>
                            <th class="text-center">Opciones</th>
                        <?php endif; ?>
                        </thead>
                    </table>
                </div>

                <div class="modal fade" id="modal-validar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Validar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Validar la mascota habilitará la asociación de la mascota a una afiliación e inhabilitará
                                alguna información de la mascota en su edición (para personal diferente a DOGCAT).</p>
                                <p>¿Está seguro de validar esta mascota?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-primary btn-submit" id="btn-validar-ok">Si</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-validar-informacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Validar información</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Validar la información de la mascota inhabilitará
                                la edición de algunos datos para todos los usuarios.</p>
                                <p>¿Está seguro de validar la información de esta mascota?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-primary btn-submit" id="btn-validar-informacion-ok">Si</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(asset('js/mascota/mascota.js')); ?>"></script>

    <?php if(!(Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro")): ?>
        <script>
        var tiene_opciones = false;

        <?php if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones($identificador_modulo,['editar','eliminar'],false,$privilegio_superadministrador)): ?>
            tiene_opciones = true;
        <?php endif; ?>

        $(function () {
            if(tiene_opciones){
                var cols = [
                    {data: 'imagen', name: 'imagen'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'raza', name: 'raza'},
                    {data: 'edad', name: 'edad'},
                    {data: 'sexo', name: 'sexo'},
                    {data: 'peso', name: 'peso'},
                    {data: 'color', name: 'color'},
                    {data: 'propietario', name: 'propietario'},
                    {data: 'identificacion_propietario', name: 'identificacion_propietario',"className": "text-center"},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'imagen', name: 'imagen'},
                    {data: 'nombre', name: 'nombre'},
                    {data: 'raza', name: 'raza'},
                    {data: 'edad', name: 'edad'},
                    {data: 'sexo', name: 'sexo'},
                    {data: 'peso', name: 'peso'},
                    {data: 'color', name: 'color'},
                    {data: 'propietario', name: 'propietario'},
                    {data: 'identificacion_propietario', name: 'identificacion_propietario',"className": "text-center"},
                ]
            }

            setCols(cols);
            cargarTablaMascotas();
        })
    </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>