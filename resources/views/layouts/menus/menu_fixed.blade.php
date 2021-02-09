<div id="contenedor-menu-fixed" style="
        background-image: url('{{url('/imagenes/sistema/background_menu.jpg')}}');
        background-size: auto 100%;
        background-repeat: no-repeat;
        background-position: center;
        ">
    <div id="menu-fixed" class="z-depth-3">
        <a class="btn btn-white btn-esconter-menu-fixed right">
            <i class="fas fa-bars"></i>
        </a>
        <div class="menu-fixed-header padding-top-10">
            @guest
                @include('layouts.menus.menu_fixed.header_guest')
            @endguest

            @auth
                @include('layouts.menus.menu_fixed.header_auth')
            @endauth
        </div>

        <ul class="navbar-nav col-12 no-padding margin-top-10">
            @auth
                @include('layouts.menus.menu_fixed.opciones_auth')
            @endauth
            @guest
                @include('layouts.menus.menu_fixed.opciones_guest')
            @endguest
        </ul>

            <div style="position:fixed;bottom: 0px;" id="contenedor-botones-estaticos-menu-fixed">
            @auth
                <a id="btn-notificaciones" class="btn btn-primary btn-block"><i class="fas fa-bell margin-right-10"></i>Notificaciones</a>
                @if(Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'ver',true) ||
                    Auth::user()->tieneFuncion(\DogCat\Http\Controllers\RecordatorioController::IDENTIFICADOR_MODULO,'crear',true))
                    <a id="btn-recordatorios" class="btn btn-success btn-block no-margin"><i class="fas fa-clock margin-right-10"></i>Recordatorios</a>
                @endif
                <a href="{{ route('logout') }}" class="btn btn-white btn-block no-margin border-right" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt margin-right-10"></i>Salir</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endauth

            @guest
                @if(
                    !Request::is('password') && !Request::is('password/*') && !Request::is('simulador-afiliacion')
                    && !Request::is('login')
                )
                    <a class="btn btn-success btn-block no-margin" data-toggle="modal" data-target="#modal-registro"><i class="fab fa-wpforms margin-right-10"></i>Registrarse</a>
                    <a class="btn btn-primary btn-block no-margin" data-toggle="modal" data-target="#modal-login"><i class="fas fa-sign-in-alt margin-right-10"></i>Ingresar</a>
                @endif
            @endguest
        </div>
    </div>
</div>