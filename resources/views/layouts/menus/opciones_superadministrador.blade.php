<ul class="navbar-nav mr-auto" style="max-width: 80%;">
    <li class="nav-item {{Request::is('registro/*') ||  Request::is('registro')? 'active':''}}"><a class="nav-link" href="{{url('/registro')}}">Registros</a></li>
    <li class="nav-item {{Request::is('veterinaria/*') ||  Request::is('veterinaria')? 'active':''}}"><a class="nav-link" href="{{url('/veterinaria')}}">Veterinarias</a></li>
    <li class="nav-item {{Request::is('entidad/*') ||  Request::is('entidad')? 'active':''}}"><a class="nav-link" href="{{url('/entidad')}}">Entidades</a></li>
    <li class="nav-item {{Request::is('mascota/*') ||  Request::is('mascota')? 'active':''}}"><a class="nav-link" href="{{url('/mascota')}}">Mascotas</a></li>
    <li class="nav-item {{Request::is('servicio/*') ||  Request::is('servicio')? 'active':''}}"><a class="nav-link" href="{{url('/servicio')}}">Servicios</a></li>
    <li class="nav-item {{Request::is('cita/*') ||  Request::is('cita')? 'active':''}}"><a class="nav-link" href="{{url('/cita')}}">Citas</a></li>

    <li class="nav-item dropdown
        {{Request::is('solicitud-afiliacion/*') ||  Request::is('afiliacion') ? 'active':''}}
            ">
        <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliaciones <span class="caret"></span></a>
        <div class="dropdown-menu">
            <a class="dropdown-item {{Request::is('solicitud-afiliacion/*') ||  Request::is('solicitud-afiliacion')? 'active':''}}" href="{{url('/solicitud-afiliacion')}}">Solicitudes de afiliación</a>
            <a class="dropdown-item {{Request::is('afiliacion/*') ||  Request::is('afiliacion')? 'active':''}}" href="{{url('/afiliacion')}}">Afiliaciones</a>
            <a class="dropdown-item {{Request::is('credito-afiliacion/*') ||  Request::is('credito-afiliacion')? 'active':''}}" href="{{url('/credito-afiliacion')}}">Créditos de afiliación</a>
        </div>
    </li>

    <li class="nav-item dropdown
        {{Request::is('empleado/*') ||  Request::is('empleado') ||
          Request::is('afiliado/*') ||  Request::is('afiliado')? 'active':''}}
            ">
        <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
        <div class="dropdown-menu">
            <a class="dropdown-item {{Request::is('empleado/*') ||  Request::is('empleado')? 'active':''}}" href="{{url('/empleado')}}">Empleados</a>
            <a class="dropdown-item {{Request::is('afiliado/*') ||  Request::is('afiliado')? 'active':''}}" href="{{url('/afiliado')}}">Afiliados</a>
            <a class="dropdown-item {{Request::is('disponibilidad/*') ||  Request::is('disponibilidad')? 'active':''}}" href="{{url('/disponibilidad')}}">Disponibilidades</a>
        </div>
    </li>

    <li class="nav-item dropdown
        {{Request::is('modulos-funciones/*') ||  Request::is('modulos-funciones') ||
          Request::is('rol/*') ||  Request::is('rol') ||
          Request::is('api/*') ||  Request::is('api')

         ? 'active':''}}
    ">
        <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sistema <span class="caret"></span></a>
        <div class="dropdown-menu dropdown-primary">
            <a class="dropdown-item {{Request::is('rol/*') ||  Request::is('rol')? 'active':''}}" href="{{url('/rol')}}">Roles</a>
            <a class="dropdown-item {{Request::is('modulos-funciones/*') ||  Request::is('modulos-funciones')? 'active':''}}" href="{{url('/modulos-funciones')}}">Modulos y funciones</a>
            <a class="dropdown-item {{Request::is('api/*') ||  Request::is('api')? 'active':''}}" href="{{url("/api")}}">Api</a>

        </div>
    </li>

    <li class="nav-item {{Request::is('finanzas/*') ||  Request::is('finanzas')? 'active':''}}"><a class="nav-link" href="{{url('/finanzas')}}">Finanzas</a></li>
</ul>