<p>Cordial saludo,</p>
<p>Dogcat le informa que el pago de su afiliación con consecutivo <strong>{{$afiliacion->consecutivo}}</strong> ha sido registrado con éxito en nuestro sistema</p>
<p><strong>Factura Nº: </strong>{{$ingreso->numero_factura}}</p>
<p><strong>Valor pagado: </strong>$ {{number_format($ingreso->valor,0,',','.')}}</p>
<p>Para ver en detalle la información de lo que ha pagado con el valor anterior, ingrese a
<a href="{{url('/')}}"> nuestro sistema </a> y dirijase a afiliaciones y seleccione la opción ver en la afiliaciòn
con consecutivo <strong>{{$afiliacion->consecutivo}}</strong>.</p>
<br>
<p style="text-align: center;">Muchas gracias por confiar en nosotros.</p>