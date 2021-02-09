<p>Se ha verificado la información suministrada por ustedes en DogCat.
    A continuación, podrá hacer click en <a href="<?php echo e(url('/nueva-cuenta-veterinaria/'.$veterinaria->token.'/'.\Illuminate\Support\Facades\Crypt::encrypt($veterinaria->id))); ?>">este link</a> para activarse en el sistema y crear su usuario (<?php echo e($rol->nombre); ?>).
</p>
<p>Gracias por confiar en nosotros.</p>