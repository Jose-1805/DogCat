<?php
        if(!isset($rol))$rol = new \DogCat\Models\Rol();
?>
<div class="row">
        <div class="col-12">
                <div class="md-form">
                    <?php echo Form::label('nombre','Nombre',['class'=>'active']); ?>

                    <?php echo Form::text('nombre',$rol->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre del rol']); ?>

                    <?php echo Form::hidden('rol',$rol->id,['id'=>'rol']); ?>

                </div>
        </div>

        <?php if(Auth::user()->getTipoUsuario() == 'personal dogcat'): ?>
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="entidades" value="si" <?php if($rol->entidades == 'si'): ?> checked="checked"<?php endif; ?> <?php if($rol->exists): ?> disabled="disabled" <?php endif; ?>>
                                Rol aplicable para la creación de usuarios administradores de una entidad
                        </label>
                        </div>
                </div>
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="veterinarias" value="si" <?php if($rol->veterinarias == 'si'): ?> checked="checked"<?php endif; ?> <?php if($rol->exists): ?> disabled="disabled" <?php endif; ?>>
                                Rol aplicable para la creación de usuarios administradores de una veterinaria
                        </label>
                        </div>
                </div>
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="registros" value="si" <?php if($rol->registros == 'si'): ?> checked="checked" <?php endif; ?> <?php if($rol->exists): ?> disabled="disabled" <?php endif; ?>>
                                Rol aplicable para la creación de usuarios a partir de un registro (posibles usuarios afiliados a veterinarias)
                        </label>
                        </div>
                </div>
                <div class="col-12">
                        <div class="">
                        <label>
                                <input class="check_tipo_plan" type="checkbox" name="afiliados" value="si" <?php if($rol->afiliados == 'si'): ?> checked="checked" <?php endif; ?> <?php if($rol->exists): ?> disabled="disabled" <?php endif; ?>>
                                Rol aplicable para la asignación de usuarios afiliados a veterinarias
                        </label>
                        </div>
                </div>
        <?php endif; ?>
        <div class="col-12 margin-top-40">
                <p>Selecciones los privilegios permitidos para el rol</p>
                <table class="table table-responsive">
                        <thead>
                                <th >Módulos</th>
                                <?php $__currentLoopData = \DogCat\Models\Funcion::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th class="text-center"><?php echo e($f->nombre); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </thead>
                        <tbody>
                                <?php
                                     $modulos = \DogCat\Models\Modulo::permitidos()->orderBy('nombre')->get();
                                     $funciones = \DogCat\Models\Funcion::get();
                                ?>
                                <?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($m->funciones()->count() && $m->estado == 'Activo'): ?>
                                        <tr>
                                                <td><?php echo e($m->etiqueta); ?></td>
                                                <?php $__currentLoopData = $funciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <th class="text-center">
                                                                <?php if($m->tieneFuncion($f->id) && $m->usuarioTieneFuncion($f->identificador)): ?>
                                                                        <input type="checkbox" name="privilegios[]" value="<?php echo e($m->identificador.','.$f->identificador); ?>" <?php if($rol->exists && $rol->tieneFuncion($m->identificador,$f->identificador)): ?> checked="checked" <?php endif; ?>>
                                                                <?php endif; ?>
                                                        </th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </tr>
                                        <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                </table>
        </div>
</div>