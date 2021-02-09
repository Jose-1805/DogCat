<div style="width: 80% !important; background-color: #f5f5f5 !important; padding: 20px 40px !important;">
    <div style="background-color: #FFFFFF !important; padding: 20px !important;">
        <div style="width: 100% !important; margin-bottom: 50px !important; border-bottom: 1px solid #4db6ac !important; padding-bottom: 20px !important;">
            <p style="display: inline; font-size: x-large !important;color: #4db6ac !important; vertical-align: middle;">
                <img src="{{url('/imagenes/sistema/dogcat.png')}}" style="display: inline !important; height: 35px !important; vertical-align: middle !important;float: right !important; margin-right: 10px !important;">
                <span style="display: inline !important; vertical-align: middle !important;">{!! $titulo !!}</span>
            </p>
        </div>

        <div style="width: 100% !important; margin-bottom: 30px !important;">
            {!! $contenido !!}
        </div>

    </div>

    <p style="font-size: small !important;">
        Este email ha sido generado automáticamente. Por favor, no conteste a este email. Si tiene alguna pregunta, incondormidad o necesita ayuda, por favor haga click <a href="{{url('/contacto')}}">aquí</a> y contactese con nosotros, pronto atenderemos su solicitud.
    </p>
</div>