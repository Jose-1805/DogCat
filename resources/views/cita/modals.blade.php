<div class="modal fade" id="modal-nueva-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Nueva cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                {!! Form::open(['id'=>'form-veterinarias']) !!}
                <div class="md-form c-select @if(Auth::user()->getTipoUsuario() != 'personal dogcat') d-none @endif">
                    {!! Form::label('veterinaria','Veterinaria',['class'=>'active']) !!}
                    {!! Form::select('veterinaria',$veterinarias,null,['id'=>'veterinaria','class'=>'form-control']) !!}
                </div>
                <div class="md-form c-select margin-top-40 @if(Auth::user()->getTipoUsuario() != 'personal dogcat' && Auth::user()->getTipoUsuario() != 'empleado') d-none @endif">
                    {!! Form::label('usuario','Usuario',['class'=>'active']) !!}
                    <div id="contenedor-usuarios">
                        {!! Form::select('usuario',[''=>'Seleccione un usuario'],null,['id'=>'usuario','class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="md-form c-select margin-top-40">
                    {!! Form::label('mascota','Mascota',['class'=>'active']) !!}
                    <div id="contenedor-mascotas">
                        {!! Form::select('mascota',[''=>'Seleccione una mascota'],null,['id'=>'mascota','class'=>'form-control']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success btn-submit" id="btn-gestionar-cita">Si</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-gestion-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-fluid padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Nueva cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                <div id="contenedor-gestion-cita"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn-submit" disabled id="btn-guardar-cita">Guardar Cita</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirmar-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Confirmar cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                <p class="padding-10 alert bg-info white-text text-center" id="fecha_cita">
                    <span class="margin-2">Martes</span>
                    <span class="margin-2">10-05-2017</span>
                    <span class="margin-2">11:00</span>
                </p>
                <p id="mascota_cita"><span class=>Mascota:</span><span class="margin-left-5"></span></p>
                <p id="servicio_cita"><span class=>Servicio:</span><span class="margin-left-5"></span></p>
                <p id="encargado_cita"><span class=>Encargado:</span><span class="margin-left-5"></span></p>


                <div id="contenedor_con_precio_fijo">
                    <p id="valor"><span class=>Valor: </span><span class="margin-left-5"></span></p>
                    <p id="descuento"><span class=>Descuento: </span><span class="margin-left-5"></span></p>
                    <p class="alert alert-info margin-top-30 text-center">TOTAL<br><span class="font-xx-large" id="total">$ 0</span></p>
                </div>

                <div id="contenedor_sin_precio_fijo">
                    <p class="alert alert-warning font-small row"><span class=>Nota: </span>este servicio no cuenta con un precio fijo, por esta razón, no es posible visualizar el valor a cancelar y solamente se podrá saber
                        cuando su mascota vaya a ser atendida</p>
                    <p class="alert alert-info margin-top-30 text-center">El descuento para este servicio es de<br><span class="font-xx-large" id="valor_descuento">0 %</span></p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cancelar-confirmacion-cita">Cancelar</button>
                <button type="button" class="btn btn-primary btn-submit" id="btn-confirmar-cita">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-datos-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Información de cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-cancelar-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Cancelar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                {!! Form::label('motivo_cancelacion','Motivo de cancelación') !!}
                {!! Form::textarea('motivo_cancelacion',null,['id'=>'motivo_cancelacion','class'=>'md-textarea form-control','rows'=>'1']) !!}
                <p>¿Está seguro de cancelar la cita seleccionada?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="btn-cancelar-cita-ok">Si</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-registrar-pago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Registrar pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                @include('layouts.alertas',['id_contenedor'=>'alertas-pago'])
                {!! Form::open(['id'=>'form-registrar-pago','class'=>'']) !!}
                    <div id="contenedor-info-pago"></div>

                    <input type="checkbox" name="valor_adicional_check" id="valor_adicional_check" class="item-precio"> Valor adicional
                    <div id="contenedor-valor-adicional" class="d-none margin-top-30">
                        <div class="md-form">
                            {!! Form::label('valor_adicional','Valor adicional') !!}
                            {!! Form::text('valor_adicional',null,['id'=>'valor_adicional','class'=>'item-precio form-control num-int-positivo']) !!}
                        </div>

                        <div class="md-form">
                            {!! Form::label('descripcion_valor_adicional','Descripción del valor adicional') !!}
                            {!! Form::textarea('descripcion_valor_adicional',null,['id'=>'descripcion_valor_adicional','class'=>'form-control md-textarea','maxlength'=>'250']) !!}
                        </div>
                    </div>
                    <div class="margin-top-10">
                        {!! Form::label('madio_pago','Medio de pago',['class'=>'active']) !!}
                        {!! Form::select('medio_pago',['Efectivo'=>'Efectivo','Consignación'=>'Consignación','Transferencia'=>'Transferencia'],null,['id'=>'medio_pago','class'=>'form-control']) !!}
                    </div>

                    <div class="md-form d-none margin-top-30" id="contenedor-codigo-verificacion">
                        {!! Form::label('codigo_verificacion','Código de verificación') !!}
                        {!! Form::text('codigo_verificacion',null,['id'=>'codigo_verificacion','class'=>'form-control']) !!}
                    </div>
                    <p class="alert alert-info margin-top-30 text-center">TOTAL A PAGAR<br><span class="font-xx-large" id="valor_cita">$ 0</span></p>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btn-registrar-pago-ok">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-validar-registrar-pago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Registrar pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de registrar el pago del servicio con los parametros seleccionados?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success" id="btn-validar-registrar-pago-ok">Si</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirmar-cancelar-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Confirmar cancelación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                <p>Faltan menos de {{config('params.horas_cancelacion_cita')}} horas para dar inicio a la cita.</p>
                <p>¿Está seguro de cancelar la cita seleccionada?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="btn-confirmar-cancelar-cita-ok">Si</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-finalizar-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog padding-left-30 padding-right-30" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Finalizar cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @include('layouts.alertas',['id_contenedor'=>'alertas-finalizar-cita'])
            <p class="alert alert-info"><strong>Nota; </strong>finalizar una cita indicará al sistema que la cita fue atendida correctamente.</p>
            <div class="modal-body padding-top-20">
                {!! Form::label('observaciones_cita','Observaciones') !!}
                {!! Form::textarea('observaciones_cita',null,['id'=>'observaciones_cita','class'=>'md-textarea form-control','placeholder'=>'Ingrese las observaciones o resultados obtenidos durante la cita.']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btn-finalizar-cita-ok">Finalizar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-ubicacion-cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Establecer ubicación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="col-12 padding-5">
                <p class="font-small">Seleccione e ingrese los datos de la dirección donde se prestará el servicio.
                    Para mayor exactitud, escriba 'Norte' en lugar de 'N' o 'n' y deje un espacio en blanco en lugar de utilizar el guion en el número de la casa. </p>
                <div class="row">
                    <div class="col-6 col-md-4 col-lg">
                        <div class="md-form mt-0">
                            <select id="tipo_direccion" class="form-control">
                                <option value="Cl.">Cl.</option>
                                <option value="Cra.">Cra.</option>
                                <option value="Tv.">Tv.</option>
                                <option value="Dg.">Dg.</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg">
                        <div class="md-form form-sm mt-0">
                            <input type="text" name="numero_tipo_direccion" id="numero_tipo_direccion" placeholder="7" class="form-control text-center">
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="md-form form-sm mt-0 input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><strong>N</strong></div>
                            </div>
                            <input type="text" name="numero_direccion" id="numero_direccion" placeholder="11-36" class="form-control text-center">
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="md-form form-sm mt-0 input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><strong>B/</strong></div>
                            </div>
                            <input type="text" name="barrio_direccion" id="barrio_direccion" placeholder="Barrio" class="form-control text-center">
                        </div>
                    </div>

                    <div class="col col-md-4 col-lg">
                        <div class="md-form mt-0 input-group" style="padding-top: 4px !important;">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Popayán</div>
                            </div>
                        </div>
                    </div>

                    <div class="col col-md-4 col-lg-1">
                        <a id="btn-init-map" class="btn btn-sm btn-outline-primary right col-12" style=""><i class="fas fa-search"></i></a>
                    </div>
                </div>
            </div>
            <p class="alert alert-warning font-small" style="margin-top: -15px;"><span class="fas fa-exclamation-triangle margin-right-5"></span> Si la dirección no es localizada con exactitud en el mapa, arrastre el marcador rojo (<span class="fas fa-map-marker-alt red-text text-darken-2"></span>) al lugar exacto donde se prestará el servicio.</p>
            <div class="modal-body" id="mapa_cita" style="min-height: 400px;margin-top: -10px !important;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn-submit" id="btn-ubicacion-cita-ok">Aceptar</button>
            </div>
        </div>
    </div>
</div>