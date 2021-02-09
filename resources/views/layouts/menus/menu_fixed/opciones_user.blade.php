
<?php
    $privilegios = collect(Auth::user()->rol->dataPrivilegios())->where('estado','Activo')->sortBy('orden_menu')->groupBy('agrupacion');

    //identificadores de modulos que no se deben mostrar en el menu
    $excluir = [
        17=>true
    ];

    $privilegios->each(function ($item, $key) use ($privilegios,$excluir){
    $dropdowns = [];
?>
        <?php foreach($item as $i){?>
            @if (!array_key_exists($i['identificador'],$excluir) && Auth::user()->tieneFuncion($i['identificador'], 'ver', false))
                @if($key != '')
                    @if(!array_key_exists($key,$dropdowns))
                        <?php $dropdowns[$key] = true; ?>
                        <li class="nav-item dropdown

                            <?php
                                foreach ($privilegios[$key] as $elemento){
                                    if(Request::is(trim($elemento['url'],'/').'/*') ||  Request::is(trim($elemento['url'],'/'))){
                                        echo ' active';
                                        break;
                                    }
                                }
                            ?>
                                ">
                            <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$key}} <span class="caret"></span></a>
                            <div class="dropdown-menu">
                                <?php foreach ($privilegios[$key] as $elemento) { ?>
                                    <a class="dropdown-item {{Request::is(trim($elemento['url'],'/').'/*') ||  Request::is(trim($elemento['url'],'/'))? 'active':''}}" href="{{url($elemento['url'])}}">{{$elemento['etiqueta']}}</a>
                                <?php } ?>
                            </div>
                        </li>
                    @endif
                @else
                    <li class="nav-item {{Request::is(trim($i['url'],'/').'/*') ||  Request::is(trim($i['url'],'/'))? 'active':''}}"><a class="nav-link" href="{{url($i['url'])}}">{{$i['etiqueta']}}</a></li>
                @endif
            @endif
        <?php } ?>
<?php
    });

?>