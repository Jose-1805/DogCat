@if(Request::is('password') || Request::is('password/*') || Request::is('simulador-afiliacion'))
    <li class="nav-item">
        <a id="btn-inicio" class="nav-link" href="{{url('/')}}">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-home margin-right-10"></i></div>
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{url('/login')}}">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-sign-in-alt margin-right-10"></i></div>
            Ingresar
        </a>
    </li>
@elseif(Request::is('login'))
    <li class="nav-item">
        <a id="btn-inicio" class="nav-link" href="{{url('/')}}">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-home margin-right-10"></i></div>
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{url('/password/reset')}}">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-redo-alt margin-right-10"></i></div>
            Recuperar contraseña
        </a>
    </li>
@else
    <li class="nav-item">
        <a id="btn-inicio" class="nav-link" href="#">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-home margin-right-10"></i></div>
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#servicios">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-clipboard-list margin-right-10"></i></div>
            Servicios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#precios">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-dollar-sign margin-right-10"></i></div>
            Precios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#quienes_somos">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-paw margin-right-10"></i></div>
            Nosotros
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#asociaciones">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-handshake margin-right-10"></i></div>
            Asociaciones
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{url('/simulador-afiliacion')}}">
            <div class="d-inline-flex justify-content-center" style="width: 25px;"><i class="fas fa-paw margin-right-10"></i></div>
            Simulador de afiliación
        </a>
    </li>
@endif