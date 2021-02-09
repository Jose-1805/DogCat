<?php 
use DogCat\Models\TareasSistema;
use DogCat\Models\Servicio;

    $dias = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];

    $cita->dia = $dias[date('w',strtotime($cita->fecha))];
    $cita->fecha = date('Y-m-d',strtotime($cita->fecha));
    $cita->hora = TareasSistema::addCero($cita->hora_inicio).':'.TareasSistema::addCero($cita->minuto_inicio);

    $servicio = Servicio::find($cita->servicio_id);
    $data_precios = $servicio->dataPreciosMascota($cita->getMascota());

    $cita->valor = $data_precios['valor'];
    $cita->descuento =  $data_precios['descuento'];

    $cita->valor_str = '$ '.number_format(($data_precios['valor']),0,',','.');
    $cita->descuento_str = $data_precios['descuento'].'%';
    $cita->total_str = '$ '.number_format(($data_precios['valor'] - (($data_precios['valor']*$data_precios['descuento'])/100)),0,',','.');
 ?>

<p class="padding-10 alert bg-info white-text text-center">
    <span class="margin-2 font-weight-700"><?php echo e($cita->dia); ?></span>
    <span class="margin-2 font-weight-700"><?php echo e($cita->fecha); ?></span>
    <span class="margin-2 font-weight-700"><?php echo e($cita->hora); ?></span>
</p>
<p>
    <span class="font-weight-500">Mascota:</span><span class="margin-left-5">
        <?php echo e($cita->mascota); ?>

        <?php if($cita->peso_mascota): ?>
            (<?php echo e($cita->peso_mascota.' KG'); ?>)
        <?php else: ?>
            (<?php echo e($cita->mascota_peso_mascotas.' KG'); ?>)
        <?php endif; ?>
    </span>
</p>
<p><span class="font-weight-500">Servicio:</span><span class="margin-left-5"><?php echo e($cita->servicio); ?></span></p>
<p><span class="font-weight-500">Encargado:</span><span class="margin-left-5"><?php echo e($cita->encargado); ?></span></p>
<?php if($cita->observaciones): ?>
    <p><span class="font-weight-500">Observaciones:</span><span class="margin-left-5"><?php echo e($cita->observaciones); ?></span></p>
<?php endif; ?>

<?php if($cita->valor): ?>
    <p><span class="font-weight-500">Valor: </span><span class="margin-left-5"><?php echo e($cita->valor_str); ?></span></p>
    <p><span class="font-weight-500">Descuento: </span><span class="margin-left-5"><?php echo e($cita->descuento_str); ?></span></p>
    <?php ($total = $cita->valor - (($cita->valor*$cita->descuento)/100)); ?>
    <?php if(is_numeric($cita->valor_adicional)): ?>
        <p><span class="font-weight-500">Subtotal: </span><span class="margin-left-5">$ <?php echo e(number_format($total,0,',','.')); ?></span></p>
        <p><span class="font-weight-500">Valor adicional: </span><span class="margin-left-5">$ <?php echo e(number_format($cita->valor_adicional,0,',','.')); ?></span></p>
        <?php ($total += $cita->valor_adicional); ?>
        <p><span class="font-weight-500">Descripción valor adicional: </span><span class="margin-left-5"><?php echo e($cita->descripcion_valor_adicional); ?></span></p>
    <?php endif; ?>

    <p class="alert alert-info margin-top-30 text-center">TOTAL<br><span class="font-xx-large font-weight-500" id="valor_pagar">$ <?php echo e(number_format($total,0,',','.')); ?></span></p>
<?php else: ?>
    <p class="alert alert-warning font-small row"><span class="font-weight-600">Nota: </span>este servicio no cuenta con un precio fijo, por esta razón, no es posible visualizar el valor a cancelar y solamente se podrá saber
        cuando su mascota vaya a ser atendida</p>
    <p class="alert alert-info margin-top-30 text-center">El descuento para este servicio es de<br><span class="font-xx-large font-weight-500" id="valor_pagar"><?php echo e($cita->descuento); ?> %</span></p>
<?php endif; ?>