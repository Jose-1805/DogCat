<div class="col-12 col-md-10 offset-md-1 padding-top-20">
    <div class="row justify-content-md-center_">
        <h2 class="col-12 teal-text text-center titulo_principal padding-bottom-5 no-border">Nuestros Servicios</h2>

        <div class="col-12 col-sm-6 col-md-4 wow zoomIn">
            @include('bienvenido.servicios.aplicativo')
        </div>

        <div class="col-12 col-sm-6 col-md-4 wow zoomIn">
            @include('bienvenido.servicios.descuentos')
        </div>

        <div class="col-12 col-sm-6 col-md-4 wow zoomIn">
            @include('bienvenido.servicios.funeraria')
        </div>

        <div class="col-12 col-sm-6 col-md-4 wow zoomIn">
            @include('bienvenido.servicios.paseadores')
        </div>

        <div class="col-12 col-sm-6 col-md-4 wow zoomIn">
            @include('bienvenido.servicios.cumpleanios')
        </div>
    </div>
</div>

<div class="modal fade" id="modal-servicios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @include('bienvenido.servicios.contenido_modal')
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>