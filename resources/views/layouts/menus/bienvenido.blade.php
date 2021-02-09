<header>

    <!--<nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
        <a class="navbar-brand" href="{{url('/')}}">
            <img alt="Brand" src="{{asset('imagenes/sistema/dogcat.png')}}" style="height: 35px;margin-top: -7px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars font-xx-large"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="#precios">Precios</a></li>
                <li class="nav-item"><a class="nav-link" href="#quienes_somos">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link" href="#asociaciones">Asociaciones</a></li>
            </ul>
        </div>
    </nav>-->

    <div class="view intro">
        <div class="full-bg-img flex-center" style="background-color: rgba(0,0,0,.3);">
            <div class="container text-center white-text animated fadeInUp">
                <div class="row padding-top-50">
                    <div class="col-10 offset-1 padding-top-50">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4">
                                <img class="img-fluid" src="{{asset('imagenes/sistema/dogcat.png')}}">
                            </div>

                            <div class="col-12 col-md-8">
                                <h1 class="white-text text-left margin-bottom-5 font-weight-600" style="font-size: 50px;">Porque tus mascotas nos importan mucho</h1>
                                <h3 class="white-text text-left">Salud, recreación y cuidado para ellas</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="">
                    <div class="col-10 offset-1 padding-top-50 padding-bottom-50">
                            <a class="btn btn-success" data-toggle="modal" data-target="#modal-registro"><i class="fab fa-wpforms margin-right-10"></i>Registrate</a>
                            <a href="{{url('/simulador-afiliacion')}}" class="btn btn-primary"><i class="fas fa-paw margin-right-10"></i>Simula tu afiliación</a>
                            <a class="btn btn-success" data-toggle="modal" data-target="#modal-login"><i class="fas fa-sign-in-alt margin-right-10"></i>Ingresa</a>
                    </div>
                </div>
                <div class="row" style="">
                    <h4 class="col-12 text-center white-text mayuscula">Click para continuar</h4>
                    <p class="text-center col-12 margin-bottom-50">
                        <a href="#!" id="btn-continuar-contenido"><i class="fas fa-arrow-circle-down white-text fa-3x animated pulse infinite"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</header>