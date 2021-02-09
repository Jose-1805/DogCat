@php
    $horas_inicio = ['06:00'=>'06:00','06:30'=>'06:30','07:00'=>'07:00','07:30'=>'07:30','08:00'=>'08:00','08:30'=>'08:30','09:00'=>'09:00','09:30'=>'09:30','10:00'=>'10:00','10:30'=>'10:30','11:00'=>'11:00','11:30'=>'11:30','12:00'=>'12:00','12:30'=>'12:30','13:00'=>'13:00','13:30'=>'13:30','14:00'=>'14:00','14:30'=>'14:30','15:00'=>'15:00','15:30'=>'15:30','16:00'=>'16:00','16:30'=>'16:30','17:00'=>'17:00','17:30'=>'17:30','18:00'=>'18:00','18:30'=>'18:30','19:00'=>'19:00','19:30'=>'19:30','20:00'=>'20:00','20:30'=>'20:30','21:00'=>'21:00','21:30'=>'21:30'];
    $horas_fin = ['06:30'=>'06:30','07:00'=>'07:00','07:30'=>'07:30','08:00'=>'08:00','08:30'=>'08:30','09:00'=>'09:00','09:30'=>'09:30','10:00'=>'10:00','10:30'=>'10:30','11:00'=>'11:00','11:30'=>'11:30','12:00'=>'12:00','12:30'=>'12:30','13:00'=>'13:00','13:30'=>'13:30','14:00'=>'14:00','14:30'=>'14:30','15:00'=>'15:00','15:30'=>'15:30','16:00'=>'16:00','16:30'=>'16:30','17:00'=>'17:00','17:30'=>'17:30','18:00'=>'18:00','18:30'=>'18:30','19:00'=>'19:00','19:30'=>'19:30','20:00'=>'20:00','20:30'=>'20:30','21:00'=>'21:00','21:30'=>'21:30','22:00'=>'22:00'];
@endphp
<div class="row">
    <p class="titulo_secundario border-bottom col-12 text-left no-padding">Disponibilidad para <span class="teal-text">{{$usuario->fullName()}}</span></p>
    {!! Form::open(['id'=>'form-disponibilidades','class'=>'col-12 no-padding']) !!}
        @foreach($disponibilidades as $fecha => $disponibilidad)
            <div class="col-12 border margin-top-2">
                <div class="row no-padding">
                    <div class="col-12 col-md-3 padding-10 bq-success green lighten-4">
                        @if(strtotime($fecha) > $hoy)
                            <input type="checkbox" name="fechas[]" value="{{$fecha}}" class="margin-right-10 check-fecha">
                        @endif

                        {{$fecha}}
                    </div>
                    <div class="col-12 col-md-9 padding-10 ">
                        <div class="row">
                            @foreach($disponibilidad as $obj)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <p class="alert-info padding-10 truncate">{{$obj->toString()}}
                                        @if(strtotime($fecha) > $hoy && $obj->permitirEliminar())
                                            <i class="fa fa-times-circle cursor_pointer margin-left-20 btn-borrar-disponibilidad" data-disponibilidad="{{$obj->id}}"></i>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="modal fade" id="modal-registro-disponibilidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Registrar disponibilidades</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body padding-top-20">
                        <div class="row padding-top-20">
                            <div class="col-12 col-md-6">
                                <div class="md-form c-select">
                                    {!! Form::label('hora_inicio','Hora de inicio',['class'=>'active']) !!}
                                    {!! Form::select('hora_inicio',$horas_inicio,null,['id'=>'hora_inicio','class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="md-form c-select">
                                    {!! Form::label('hora_fin','Hora de fin',['class'=>'active']) !!}
                                    {!! Form::select('hora_fin',$horas_fin,null,['id'=>'hora_fin','class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-submit" id="btn-guardar-disponibilidad">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::hidden('usuario',$usuario->id) !!}
    {!! Form::close() !!}
</div>