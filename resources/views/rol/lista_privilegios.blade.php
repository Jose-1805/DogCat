<div class="card">
    <!-- Default panel contents -->
    <div class="card-header">Privilegios  {{isset($rol) ? ' - '.$rol->nombre:''}}</div>

    <!-- List group -->
    <div class="list-group">
        @if(isset($rol))
            @if($rol->privilegios)
                @foreach($rol->dataPrivilegios() as $pr)
                    <?php
                        $funciones = '';
                        for($i = 0; $i < count($pr['funciones']);$i++){
                            $funciones .= $pr['funciones'][$i].', ';
                        }
                        $funciones = trim($funciones);
                        $funciones = trim($funciones,',');
                    ?>
                    <li class="list-group-item">{{$pr['nombre'].' ('.$funciones.')'}}</li>
                @endforeach
            @else
                <li class="list-group-item">Rol sin privilegios asociados</li>
            @endif
        @else
            <li class="list-group-item">Lista de privilegios asociados a un rol</li>
        @endif
    </div>
</div>