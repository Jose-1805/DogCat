<?php
$comentarios = $publicacion->comentarios;
?>
<div class="col-12 no-padding info-comentarios">
    <div class="col-12 no-padding">
        <p class="cursor_pointer grey-text text-right contador-comentarios" style="border-bottom: 1px solid #b9b9b9;"><span class="grey-text text-lighten-1"><?php echo e(count($comentarios)); ?></span> Comentarios</p>
    </div>
    <div class="col-12 no-padding d-none comentarios">
        <div class="lista-comentarios">
            <?php if(count($comentarios)): ?>
                <div class="col-12 grey lighten-5 padding-10 contenedor-comentarios">
                    <?php echo $__env->make('publicacion.publicacion.lista_comentarios',['comentarios'=>$comentarios], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            <?php else: ?>
                <div class="col-12 grey lighten-5 padding-10 contenedor-comentarios">
                    <input type="hidden" class="last_comment" value="0">
                </div>
            <?php endif; ?>
        </div>

        <?php if(Auth::user()->tieneFuncion($identificador_modulo,'comentar',$privilegio_superadministrador)): ?>
            <div class="col-12 no-padding">
                <div class="input-group" >
                    <?php echo Form::text('comentario',null,['id'=>'','class'=>'form-control focus-border comentario','placeholder'=>'Comentar','data-publicacion'=>$publicacion->id]); ?>

                    <span class="input-group-btn margin-top-10">
                        <button class="btn btn-sm btn-success teal lighten-1 enviar-comentario" type="button"><i class="fa fa-paper-plane fa-2x white-text"></i></button>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>