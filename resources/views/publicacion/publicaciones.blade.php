@foreach($publicaciones as $p)
    @include('publicacion.publicacion.index',['publicacion'=>$p])
@endforeach