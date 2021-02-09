
<?php 
    $horas = [];
    for ($i=0;$i<24;$i++){
        if($i < 10)$horas['0'.$i] = '0'.$i;
        else $horas[$i] = $i;
    }
    $minutos = [];
    for ($i=0;$i<60;$i++){
        if($i < 10)$minutos['0'.$i] = '0'.$i;
        else $minutos[$i] = $i;
    }

    $importancias = [
        'media'=>'media',
        'alta'=>'alta',
        'baja'=>'baja',
    ];
 ?>
<div class="modal fade" id="modal-recordatorio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Seleccione una opción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <?php if(Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'ver',true)): ?>
                                <div class="col col-md-6 text-center">
                                    <a href="#!" id="btn-ver-recordatorios" class="btn btn-default">Ver recordatorios</a>
                                </div>
                            <?php endif; ?>

                            <?php if(Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'crear',true)): ?>
                                <div class="col col-md-6 text-center">
                                    <a href="#!" id="btn-crear-recordatorio" class="btn btn-primary">Crear recordatorio</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-crear-recordatorio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Nuevo recordatorio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-10">
                <?php echo $__env->make('layouts.alertas',['id_contenedor'=>'alertas-recordatorios'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo Form::open(['id'=>'form-nuevo-recordatorio','class'=>'row']); ?>

                <div class="col-12">
                    <div class="md-form margin-top-10">
                        <?php echo Form::label('mensaje','Mensaje (*)',['class'=>'active']); ?>

                        <?php echo Form::text('mensaje',null,['id'=>'mensaje','class'=>'form-control','placeholder'=>'Mensaje de recordatorio']); ?>

                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="md-form">
                        <?php echo Form::label('fecha_recordatorio','Fecha (*)',['class'=>'active']); ?>

                        <?php echo Form::date('fecha_recordatorio',date('Y-m-d'),['id'=>'fecha_recordatorio','class'=>'form-control']); ?>

                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="md-form c-select">
                        <?php echo Form::label('hora','Hora (*)',['class'=>'active']); ?>

                        <?php echo Form::select('hora',$horas,null,['id'=>'hora','class'=>'form-control']); ?>

                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="md-form c-select">
                        <?php echo Form::label('minuto','Minuto (*)',['class'=>'active']); ?>

                        <?php echo Form::select('minuto',$minutos,null,['id'=>'minuto','class'=>'form-control col']); ?>

                    </div>
                </div>


                <div class="col-12">
                    <div class="md-form c-select">
                        <?php echo Form::label('importancia','Importancia (*)',['class'=>'active']); ?>

                        <?php echo Form::select('importancia',$importancias,null,['id'=>'importancia','class'=>'form-control']); ?>

                    </div>
                </div>

                <div class="col-12">
                    <label>
                        <input type="checkbox" name="url_actual" id="url_actual" value="si"> Abrir la página actual con el recordatorio
                    </label>
                </div>

                <div class="col-12 margin-top-20">
                    <div class="md-form input-group pl-0">
                        <?php echo Form::label('url','Url',['class'=>'active']); ?>


                        <div class="input-group-prepend" style="margin-top: 10px;">
                            <span class="input-group-text"><?php echo e(url('/')); ?></span>
                        </div>
                        <?php echo Form::text('url',null,['id'=>'url','class'=>'padding-left-10 form-control py-0','placeholder'=>'/ejemplo-url','style'=>'margin-top:15px;']); ?>

                    </div>
                </div>


                <div class="col-12">
                    <label>
                        <input type="checkbox" name="enviar_correo" id="enviar_correo" value="si" checked> Recordar vía correo electrónico
                    </label>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-submit" id="btn-guardar-recordatrio">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lista-recordatorios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><i class="fas fa-clock margin-right-10"></i>Recordatorios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-10 list-group" id="lista-recordatorios">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-cargar-mas">Cargar más</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>