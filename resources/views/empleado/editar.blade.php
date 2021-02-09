@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Editar empleado</h3>

            <div class="col-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-editar-usuario'])
            </div>
            <div class="col-12">
                {!! Form::model($usuario,['id'=>'form-usuario']) !!}
                    {!! Form::hidden('usuario',$usuario->id,['id'=>'usuario']) !!}
                    @include('empleado.form')
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/empleado/editar.js')}}"></script>
    <script>
        $(function () {
            $("#imagen").fileinput(
                {
                    previewSettings: {
                        image:{width:"auto", height:"160px"},
                    },
                    allowedFileTypes:['image'],
                    AllowedFileExtensions:['jpg','jpeg','png'],
                    removeFromPreviewOnError:true,
                    showCaption: false,
                    showUpload: false,
                    showClose:false,
                    maxFileSize : {{config('params.maximo_peso_archivos')}},
                    initialPreview: [
                        @if($usuario->imagenPerfil)
                            "<img src='{{url('/almacen/'.str_replace('/','-',$usuario->imagenPerfil->ubicacion).'-'.$usuario->imagenPerfil->nombre)}}' class='col-12'>",
                        @endif
                    ]
                }
            );

            $('#fecha_nacimiento').val('{{$usuario->fecha_nacimiento}}')
        })
    </script>
@stop
