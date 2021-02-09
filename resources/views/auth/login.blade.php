@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-4 offset-md-3 offset-lg-4">
            <div class="card margin-top-50">
                <div class="card-header teal-text">INICIO DE SESION DOGCAT</div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="md-form">
                            <label for="email" class="control-label">Correo</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="md-form">
                            <label for="password" class="control-label">Contraseña</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>

                        <label class="">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                        </label>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success">
                                Ingresar
                            </button>
                        </div>
                        <div class="col-12 text-center">
                            <a class="col-12" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
