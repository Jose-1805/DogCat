@auth
<div class="modal fade" id="modal-cambiar-contrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Cambio de contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body padding-top-20">
                {!! Form::open(['id'=>'form-cambiar-contrasena']) !!}
                <div class="md-form margin-top-10">
                    {!! Form::label('password_old','Contraseña antigua',['class'=>'active']) !!}
                    {!! Form::password('password_old',null,['id'=>'password_old','class'=>'form-control']) !!}
                </div>
                <div class="md-form">
                    {!! Form::label('password','Contraseña nueva',['class'=>'active']) !!}
                    {!! Form::password('password',null,['id'=>'password','class'=>'form-control']) !!}
                </div>
                <div class="md-form">
                    {!! Form::label('password_confirm','Confirmación de contraseña',['class'=>'active']) !!}
                    {!! Form::password('password_confirm',null,['id'=>'password_confirm','class'=>'form-control']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-submit" id="btn-cambiar-contrasena">Guardar</button>
            </div>
        </div>
    </div>
</div>

@include('notificacion.modales')
@if(Auth::user()->tieneModulo(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO) || Auth::user()->esSuperadministrador())
    @include('recordatorio.modales')
@endif
@endauth