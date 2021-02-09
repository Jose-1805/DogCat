<div class="row">
    <div class="col-12" style="overflow-x: auto;">
        <table class="dataTable table-hover table-bordered table-responsive-sm">
            <thead>
                <th class="text-center">Nombre</th>
                <th class="text-center">Raza</th>
                <th class="text-center">Edad</th>
                <th class="text-center">Funeraria</th>
                <th class="text-center">Plan funerario</th>
                <th class="text-center">Servicio funerario</th>
                <th class="text-center">Incluir transporte</th>
                <th class="text-center">Pago de funeraria a</th>
                <th class="text-center">Valor funeraria</th>
            </thead>
            <tbody>
                @php($total = 0)
                @foreach($detalle['mascotas'] as $m)
                    <tr>
                        <td class="text-center">{{$m['nombre']}}</td>
                        <td>{{$m['raza']}}</td>
                        <td>{{$m['edad']}}</td>
                        <td class="text-center">{{$m['funeraria']}}</td>
                        <td class="text-center">{{$m['plan_funerario']}}</td>
                        <td class="text-center">{{$m['servicio_funerario']}}</td>
                        <td class="text-center">{{$m['incluir_transporte_funeraria']}}</td>
                        <td class="text-center">{{$m['pago_funeraria_a']}}</td>
                        <td class="text-center">$ {{number_format($m['valor_funeraria'],0,',','.')}}</td>
                        @php($total += $m['valor_funeraria'])
                    </tr>
                @endforeach

                <tr>
                    <th colspan="8" class="text-center"><strong class="teal-text">TOTALES FUNERARIA</strong></th>
                    <th class="text-center teal-text"><strong>$ {{number_format($total,0,',','.')}}</strong></th>
                </tr>
                @php($total += $detalle['valor_afiliacion'])
                <tr>
                    <th colspan="8" class="text-center"><strong>VALOR DE AFILIACIÓN</strong></th>
                    <td class="text-center">$ {{number_format($detalle['valor_afiliacion'],0,',','.')}}</td>
                </tr>

                <tr>
                    <th colspan="8" class="text-center"><strong class="teal-text">TOTAL</strong></th>
                    <th class="text-center teal-text"><strong>$ {{number_format($total,0,',','.')}}</strong></th>
                </tr>
            </tbody>
        </table>
    </div>
</div>