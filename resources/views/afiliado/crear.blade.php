@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Crear afiliado</h3>

            <div class="col-12 no-padding">
                @include('afiliado.form')
            </div>

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/afiliado/crear.js')}}"></script>

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
                }
            );
        })
    </script>
@stop