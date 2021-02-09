<div class="col-12" style="margin-top: -10px;">
    @if(!$publicacion->userLike(Auth::user()->id))

        <?php
            if(Auth::user()->tieneFuncion($identificador_modulo,'like',$privilegio_superadministrador)){
                $class = 'enviar-like';
            }else{
                $class = 'grey-text';
            }
            $numero = $publicacion->likes()->get()->count();
        ?>
        <p class="col-12 no-padding"><i class="fa fa-paw teal-text text-lighten-1 cursor_pointer {{$class}}" data-publicacion="{{$publicacion->id}}" data-numero="{{$numero}}"></i> <span class="numero_likes">{{$numero}}</span></p>
    @else
        <p class="col-12 no-padding"><i class="fa fa-paw white-text teal lighten-1" style="padding: 3px;border-radius: 30px;"></i> <span class="numero_likes">{{$publicacion->likes()->count()}}</span></p>
    @endif
</div>