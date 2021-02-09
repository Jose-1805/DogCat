@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 margin-top-30">
            <div class="card">
                <div class="card-header teal-text">REESTABLECER CONTRASEÑA</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="md-form {{ $errors->has('email') ? ' has-error' : '' }} margin-top-20">
                            <label for="email" class="control-label">Correo electrónico</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="md-form">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    Solicitar reestablecimiento
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
