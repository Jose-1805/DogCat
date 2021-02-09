<!-- MODAL DE INICIO DE SESION -->

<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Inicio Sesion DogCat</h4>-->

                <h5 class="modal-title" id="myModalLabel">Inicio Sesion DogCat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('layouts.alertas',["id_contenedor"=>"alertas-login"])

                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="md-form">
                        <label for="email" class="control-label">Correo</label>

                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block text-danger">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="md-form">
                        <label for="password" class="control-label">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>

                    <div class="">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                        </label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            Ingresar
                        </button>
                    </div>

                    <div class="text-center">
                        <a class="" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE REGISTRO -->
<div class="modal fade" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Registro DogCat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>
            </div>
            {!! Form::open(["id"=>"form-registro"]) !!}
            <div class="modal-body">
                @include('layouts.alertas',["id_contenedor"=>"alertas-registro"])
                <div class="md-form">
                    {!! Form::label("nombre","Nombre") !!}
                    {!! Form::text("nombre",null,["id"=>"nombre","class"=>"form-control"]) !!}
                </div>
                <div class="md-form">
                    {!! Form::label("email","Correo") !!}
                    {!! Form::text("email",null,["id"=>"email","class"=>"form-control"]) !!}
                </div>
                <div class="md-form">
                    {!! Form::label("telefono","Celular") !!}
                    {!! Form::text("telefono",null,["id"=>"telefono","class"=>"form-control"]) !!}
                </div>
                <div class="md-form">
                    {!! Form::label("direccion","Dirección") !!}
                    {!! Form::text("direccion",null,["id"=>"direccion","class"=>"form-control"]) !!}
                </div>
                <div class="md-form">
                    {!! Form::label("barrio","Barrio") !!}
                    {!! Form::text("barrio",null,["id"=>"barrio","class"=>"form-control"]) !!}
                </div>
                <div class="md-form">
                    <input type="checkbox" name="veterinaria" id="veterinaria" value="si">
                    <label for="veterinaria">Veterinaria (Seleccione si desea registrarse como veterinaria)</label>
                </div>
                <div class="md-form">
                    <input type="checkbox" name="permiso_notificaciones" id="permiso_notificaciones" value="si" checked>
                    <label for="permiso_notificaciones">Permitir notificaciones de información vía correo electrónico.</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success btn-submit" id="enviar_registro">Enviar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
