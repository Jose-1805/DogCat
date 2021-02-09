<?php echo Form::label('tipo_ingr_egre_util','Tipo'); ?>

<?php echo Form::select('tipo_ingr_egre_util',['anual'=>'Anual','mensual'=>'Mensual'],null,['id'=>'tipo_ingr_egre_util','class'=>'form-control']); ?>

<div class="row" id="anios-ingr-egre-util">
    <div class="col-12 col-md-6">
        <?php echo Form::label('inicio_anio_ingr_egre_util','Inicio'); ?>

        <?php echo Form::select('inicio_anio_ingr_egre_util',$anios,null,['id'=>'inicio_anio_ingr_egre_util','class'=>'form-control']); ?>

    </div>

    <div class="col-12 col-md-6">
        <?php echo Form::label('fin_anio_ingr_egre_util','Fin'); ?>

        <?php echo Form::select('fin_anio_ingr_egre_util',$anios,null,['id'=>'fin_anio_ingr_egre_util','class'=>'form-control']); ?>

    </div>
</div>

<div class="row d-none" id="meses-ingr-egre-util">
    <div class="col-12 col-md-6">
        <?php echo Form::label('inicio_mes_ingr_egre_util','Inicio'); ?>

        <?php echo Form::select('inicio_mes_ingr_egre_util',$meses,null,['id'=>'inicio_mes_ingr_egre_util','class'=>'form-control']); ?>

    </div>

    <div class="col-12 col-md-6">
        <?php echo Form::label('fin_mes_ingr_egre_util','Fin'); ?>

        <?php echo Form::select('fin_mes_ingr_egre_util',$meses,null,['id'=>'fin_mes_ingr_egre_util','class'=>'form-control']); ?>

    </div>
</div>