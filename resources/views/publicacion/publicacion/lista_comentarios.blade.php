<?php
    if(!isset($last_comment))$last_comment = 0;
    $last = (object)array('id'=>$last_comment);
?>
@foreach($comentarios as $c)
    <?php
        $last = $c;
    ?>
    <div>
        <p><strong class="teal-text text-lighten-1 font-small">{{$c->usuario->nombres.' '.$c->usuario->apellidos}}</strong>  <span class="grey-text text-darken-2 font-x-small">{{$c->created_at}}</span></p>
        <p class="font-small" style="margin-top: -10px;">{{$c->comentario}}</p>
    </div>
@endforeach
<input type="hidden" class="last_comment" value="{{$last->id}}">