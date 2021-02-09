@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Bienvenido a DogCat!</h3>

            <div class="col-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-create-password'])
            </div>
            <div class="col-12">
                <p class="col-12 margin-bottom-20 no-padding">Señor(a) {{$user->fullName()}}, para ingresar al sistema ingrese una contraseña de acceso y la verificación de la misma.</p>
                {!! Form::open(['id'=>'form-create-password']) !!}
                    <div class="row">
                        <div class="col-md-6 col-lg-5">
                            <div class="md-form">
                                {!! Form::label('password','Contraseña (*)') !!}
                                {!! Form::password('password',['id'=>'password','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-5">
                            <div class="md-form">
                                {!! Form::label('password_confirm','Confirmación de contraseña (*)') !!}
                                {!! Form::password('password_confirm',['id'=>'password_confirm','class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 md-form">
                            <a href="#!" class="col-12 cursor_pointer btn-submit btn btn-success right margin-top-5" id="btn-create-password">Guardar</a>
                        </div>
                        {!! Form::hidden('id',$user->id) !!}
                    </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/usuario/create_password.js')}}"></script>
@stop


