<p>Cordial saludo,</p>
<p>Dogcat le informa que el pago de su afiliación con consecutivo <strong><?php echo e($afiliacion->consecutivo); ?></strong> ha sido registrado con éxito en nuestro sistema</p>
<p><strong>Factura Nº: </strong><?php echo e($ingreso->numero_factura); ?></p>
<p><strong>Valor pagado: </strong>$ <?php echo e(number_format($ingreso->valor,0,',','.')); ?></p>
<p>Para ver en detalle la información de lo que ha pagado con el valor anterior, ingrese a
<a href="<?php echo e(url('/')); ?>"> nuestro sistema </a> y dirijase a afiliaciones y seleccione la opción ver en la afiliaciòn
con consecutivo <strong><?php echo e($afiliacion->consecutivo); ?></strong>.</p>
<br>
<p style="text-align: center;">Muchas gracias por confiar en nosotros.</p>