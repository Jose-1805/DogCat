<p style="font-size: large;">
    Hola, veterinaria {{$veterinaria->nombre}}
</p>

<p>Se ha verificado la información suministrada por ustedes en DogCat.
    A continuación, podrá hacer click en <a href="{{url('/nueva-cuenta-veterinaria/'.$veterinaria->token.'/'.\Illuminate\Support\Facades\Crypt::encrypt($veterinaria->id))}}">este link</a> para activarse en el sistema y crear su usuario ({{$rol->nombre}}).
</p>
<p>Gracias por confiar en nosotros.</p>