<?php echo Form::label('tipo_obj_ventas','Tipo'); ?>

<?php echo Form::select('tipo_obj_ventas',['anual'=>'Anual','mensual'=>'Mensual'],null,['id'=>'tipo_obj_ventas','class'=>'form-control']); ?>


<div class="row" id="anios-obj-ventas">
    <div class="col-12 col-md-6">
        <?php echo Form::label('inicio_anio_obj_ventas','Inicio'); ?>

        <?php echo Form::select('inicio_anio_obj_ventas',$anios,null,['id'=>'inicio_anio_obj_ventas','class'=>'form-control']); ?>

    </div>

    <div class="col-12 col-md-6">
        <?php echo Form::label('fin_anio_obj_ventas','Fin'); ?>

        <?php echo Form::select('fin_anio_obj_ventas',$anios,null,['id'=>'fin_anio_obj_ventas','class'=>'form-control']); ?>

    </div>
</div>

<div class="row d-none" id="meses-obj-ventas">
    <div class="col-12 col-md-6">
        <?php echo Form::label('inicio_mes_obj_ventas','Inicio'); ?>

        <?php echo Form::select('inicio_mes_obj_ventas',$meses,null,['id'=>'inicio_mes_obj_ventas','class'=>'form-control']); ?>

    </div>

    <div class="col-12 col-md-6">
        <?php echo Form::label('fin_mes_obj_ventas','Fin'); ?>

        <?php echo Form::select('fin_mes_obj_ventas',$meses,null,['id'=>'fin_mes_obj_ventas','class'=>'form-control']); ?>

    </div>
</div>