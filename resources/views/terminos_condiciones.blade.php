<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dogcat') }} - Términos y condiciones</title>
    <link rel="icon" type="image/ico" href="{{asset('imagenes/sistema/dogcat.ico')}}" />

@section('css')
    <!-- Styles -->
    <!--<link href="{{asset('bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">-->

        <link href="{{asset('MDB-Free/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('MDB-Free/css/mdb.css')}}" rel="stylesheet" type="text/css">

        <link href="{{asset('fuelux/css/fuelux.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('lightbox/lightbox.css')}}" rel="stylesheet" type="text/css">

        <link href="{{asset('tabdrop/css/tabdrop.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('DataTables-1.10.15/media/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/global.css')}}" rel="stylesheet" type="text/css">

        <link href="{{url('kartik_v_bootstrap_fileinput/css/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/helpers.css')}}" rel="stylesheet" type="text/css">
@show

<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="fuelux" id="body">
<div id="app">
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark teal scrolling-navbar">
            <a class="navbar-brand" href="{{url('/')}}">
                <img alt="Brand" src="{{asset('imagenes/sistema/dogcat.png')}}" style="height: 35px;margin-top: -7px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars font-xx-large"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto" style="max-width: 80%;"></ul>
                <ul class="navbar-nav navbar-right" style="max-width: 15%;">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            @if(strlen(Auth::user()->nombres." ".Auth::user()->apellidos) > 15)
                                @if(strlen(Auth::user()->nombres." ".substr(Auth::user()->apellidos,0,1)) > 15)
                                    @if(strlen(Auth::user()->nombres) > 15)
                                        {{ substr(Auth::user()->nombres,0,12)}}... <span class="caret"></span>
                                    @else
                                        {{ Auth::user()->nombres}} <span class="caret"></span>
                                    @endif
                                @else
                                    {{ Auth::user()->nombres." ".substr(Auth::user()->apellidos,0,1)}}. <span class="caret"></span>
                                @endif
                            @else
                                {{ Auth::user()->nombres." ".Auth::user()->apellidos}} <span class="caret"></span>
                            @endif
                        </a>

                        <div id="dropdown-menu-user" class="dropdown-menu hoverable" style="margin-top: 10px;" role="menu">

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Salir
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>

                <a href="#" ><i style="line-height: 48px;" class="fa fa-bell right teal-text text-lighten-3"></i></a>
            </div>
        </nav>

    </header>
    <div style="height: 100px;"></div>
    <div id="contenido-pagina" class="container-fluid margin-bottom-50">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 white">
                <div class="col-12">
                    <h3 class="titulo_principal font-weight-500">TÉRMINOS Y CONDICIONES DOGCAT</h3>
                </div>

                <div class="col-12">
                    <p class="text-justify">
                        Las presentes condiciones son aplicables a todas las personas (dueños de mascotas) que utilizan los servicios de DOGCAT. Estas condiciones incluidas en los Documentos Legales, como más adelante se definen, constituyen las condiciones generales de contratación que rigen la relación que existe entre DOGCAT y las personas (dueños de mascotas).
                        <br>Por favor lea cuidadosamente estas condiciones.
                        <br>Le recordamos que al hacer uso de este servicio, manifiesta que ha leído y entendido los Documentos Legales ahí contenidos, así como el Aviso de Privacidad y que acepta obligarse de conformidad con las declaraciones y cláusulas que los mismos establecen.
                    </p>
                </div>
                <div class="col-12">
                    <p class="font-weight-500">1. AFILIACIÓN</p>
                    <ul>
                        <li class="text-justify">Solamente se afilian mascotas las cuales sus dueños sean  personas de al menos 18 años de edad.</li>
                        <li class="text-justify">El usuario solo podrá afiliarse a una sola veterinaria y podrá cambiarse únicamente al finalizar el periodo de afiliación y realizar uno nuevo.</li>
                        <li class="text-justify">El usuario podrá hacer uso de los servicios 24 horas después de realizar el pago de la afiliación y únicamente dentro del periodo de vigencia de la misma.</li>
                        <li class="text-justify">Se pueden afiliar máximo cinco  mascotas y el valor adicional por cada una lo define DOGCAT.</li>
                        <li class="text-justify">El pago de los servicios debe realizarse en los puntos donde DOGCAT establezca.</li>
                        <li class="text-justify">Los servicios solicitados por el usuario podrán ser cancelados 12 horas antes de la fecha de programación del servicio. Al cancelar dicho servicio después del tiempo indicado o no asistir en la hora, fecha y lugar establecido, el usuario tendrá que pagar una sanción, establecida por DOGCAT, para hacer uso de cualquier servicio nuevamente.</li>
                    </ul>
                </div>
                <div class="col-12">
                    <p class="font-weight-500">2. RESPONSABILIDADES</p>
                    <ul>
                        <li class="text-justify">El usuario se responsabiliza de brindar información veraz y actualizada de la mascota en nuestros sistemas.</li>
                        <li class="text-justify">El usuario se responsabiliza de usar adecuadamente los sistemas informáticos de DOGCAT, dándose por entendido esto en no promocionar ni vender animales, drogas, armas, trata de personas etc. Si no cumple con estos criterios será judicializado según la ley colombiana.</li>
                        <li class="text-justify">DOGCAT es una empresa intermediaria de servicios básicos para el cuidado de mascotas, por lo cual, no  se responsabiliza por  muertes, enfermedades, golpes y/o robos adquiridos en los establecimientos asociados, dichos establecimientos se harán responsables en cada uno de los eventos mencionados.</li>
                        <li class="text-justify">DOGCAT NO se responsabiliza del servicio funerario si el deceso de la mascota es producto de enfermedades adquiridas por la falta de aplicación de vacunas. DOGCAT es libre de realizar el proceso de investigación necesario para identificar las razones del fallecimiento de la mascota.</li>
                        <li class="text-justify">PASEADORES DOGCAT se hace responsable de incumplimientos, daños, perdida, y golpes de la mascota durante la prestación del servicio de paseo.</li>
                    </ul>
                </div>
                <div class="col-12">
                    <p class="font-weight-500">3. DESCUENTOS Y PAGOS</p>
                    <ul>
                        <li class="text-justify">El pago del servicio FUNERARIO por parte de DOGCAT estará entre el 10%  y el 100% del valor total del servicio, el porcentaje de cubrimiento se establecerá según la edad y patologías que presente la mascota en el momento de la afiliación, esto, basándose en el promedio de vida de la mascota según su raza.</li>
                        <li class="text-justify">DOGCAT se responsabiliza en brindar  a sus afiliados descuentos entre el 10% y el  100% del valor total, según el servicio  requerido por la mascota.</li>
                        <li class="text-justify">DOGCAT no tiene preferencias con  los establecimientos, la afiliación del usuario a la veterinaria, centros de SPA o establecimientos comerciales será preferencia del cliente.</li>
                        <li class="text-justify">DOGCAT no se hace responsable de gastos adicionales que requiera la mascota en el momento del servicio ejemplo: baños medicados, suciedad excesiva, alimentos especiales etc. Estas serán cobradas por el establecimiento según sus precios.</li>
                    </ul>
                </div>
                <div class="col-12">
                    <p class="font-weight-500">4. CONFIDENCIALIDAD</p>
                    <ul>
                        <li class="text-justify">DOGCAT  garantiza que la información personal que usted envíe o seda a través de nuestros asesores o plataforma web cuenta con la seguridad necesaria. Los datos ingresados por usuario o en el caso de requerir una validación de los pedidos no serán entregados a terceros, salvo que deba ser revelada en cumplimiento a una orden judicial o requerimientos legales.</li>
                        <li class="text-justify">Todos los contenidos, marcas, logos, dibujos, documentación, programas informáticos o cualquier otro elemento susceptible de protección por la legislación de propiedad intelectual o industrial, que sean accesibles en el portal corresponden exclusivamente a la empresa o a sus legítimos titulares y quedan expresamente reservados todos los derechos sobre los mismos. Queda expresamente prohibida la creación de enlaces de hipertexto (links) a cualquier elemento integrante de las páginas web del Portal sin la autorización de la empresa, siempre que no sean a una página web del Portal que no requiera identificación o autenticación para su acceso, o el mismo esté restringido.</li>
                        <li class="text-justify">La suscripción a boletines de correos electrónicos publicitarios es voluntaria y podría ser seleccionada al momento de registrar sus datos por primera vez.</li>
                    </ul>
                </div>
                <div class="col-12">
                    <p class="font-weight-500">5. LEGALIDAD</p>
                    <ul>
                        <li class="text-justify">Para cualquier reclamación serán competentes los juzgados y tribunales de Colombia. Todas las notificaciones, requerimientos, peticiones y otras comunicaciones que el Usuario desee efectuar a la Empresa titular deberán realizarse por escrito y se entenderá que han sido correctamente realizadas cuando hayan sido recibidas en la siguiente dirección de correo electrónico gerencia@dogcat.co</li>
                        <li class="text-justify">DOGCAT cuenta con su respectivo respaldo legal para el funcionamiento de esta empresa en su cámara de comercio.</li>
                    </ul>
                </div>
                <div class="col-12">
                    <p class="font-weight-500">DOGCAT RESERVA LOS DERECHOS DE CAMBIAR O DE MODIFICAR ESTOS TÉRMINOS CON UN PREVIO AVISO DE 15 DÍAS.</p>
                </div>
                <div class="col-12">
                    <label>
                        <input type="checkbox" name="aprobar_terminos" id="check_aprobar_terminos" value="si"> He leído y acepto los términos y condiciones
                    </label>
                </div>
                <div class="col-12 text-right no-padding">
                    <a class="btn btn-success disabled" id="btn-terminos-condiciones">Acepto</a>
                </div>
            </div>
        </div>
    </div>

    <div id="pie-pagina" class="container-fluid padding-top-50" style="min-height: 150px; margin-top: 158px;">
        @include('layouts.secciones.footer')
    </div>

    <input type="hidden" id="general_url" value="{{url('/')}}">
    <input type="hidden" id="general_token" value="{{csrf_token()}}">
</div>

<script src="{{ asset('js/app.js') }}"></script>
@section('js')
    <script src="{{asset('MDB-Free/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('MDB-Free/js/popper.min.js')}}"></script>
    <script src="{{asset('MDB-Free/js/bootstrap.js')}}"></script>
    <script src="{{asset('MDB-Free/js/mdb.js')}}"></script>
    <script src="{{asset('fuelux/js/fuelux.js')}}"></script>
    <script src="{{asset('lightbox/lightbox.js')}}"></script>
    <script src="{{asset('DataTables-1.10.15/media/js/jquery.dataTables.js')}}"></script>
    <!--<script src="https://use.fontawesome.com/a8d29b5cc4.js"></script>-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"></script>
    <script src="{{asset('js/numeric.js')}}"></script>
    <script src="{{asset('tabdrop/js/bootstrap-tabdrop.js')}}"></script>

    <script src="{{asset('js/blockUi.js')}}"></script>
    <script src="{{asset('js/global.js')}}"></script>
    <script src="{{asset('js/params.js')}}"></script>
    <script src="{{asset('js/jquery.number.min.js')}}"></script>

    <script>
        $(function () {
            $('.nav-pills, .nav-tabs').tabdrop();
        })
    </script>

    <script src="{{url('kartik_v_bootstrap_fileinput/js/plugins/piexif.min.js')}}" type="text/javascript"></script>
    <script src="{{url('kartik_v_bootstrap_fileinput/js/plugins/sortable.min.js')}}" type="text/javascript"></script>
    <script src="{{url('kartik_v_bootstrap_fileinput/js/plugins/purify.min.js')}}" type="text/javascript"></script>
    <script src="{{url('kartik_v_bootstrap_fileinput/js/fileinput.js')}}"></script>
    <script src="{{url('kartik_v_bootstrap_fileinput/js/locales/es.js')}}"></script>
    <script src="{{url('js/jquery.autocomplete.js')}}"></script>
    <script src="{{url('bootstrap-validator-master/dist/validator.min.js')}}"></script>
    <script src="{{url('js/terminos_condiciones.js')}}"></script>
@show
</body>
</html>
