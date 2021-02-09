@extends('layouts.app')

@section('content')
    <div class="container-fluid white padding-50">
        <div class="row">
            <h3 class="titulo_principal margin-bottom-20">Editar entidad</h3>
            @include('entidad.form')
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/entidad/editar.js')}}"></script>
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
                    maxFileSize : 500,
                    initialPreview: [
                        @if($veterinaria->administrador->imagenPerfil)
                            "<img src='{{url('/almacen/'.str_replace('/','-',$veterinaria->administrador->imagenPerfil->ubicacion).'-'.$veterinaria->administrador->imagenPerfil->nombre)}}' class='col-12'>",
                        @endif
                    ]
                }
            );
            $("#logo").fileinput(
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
                    maxFileSize : 500,
                    initialPreview: [
                        @if($veterinaria->imagen)
                            "<img src='{{url('/almacen/'.str_replace('/','-',$veterinaria->imagen->ubicacion).'-'.$veterinaria->imagen->nombre)}}' class='col-12'>",
                        @endif
                    ]
                }
            );
        })
    </script>
@stop


