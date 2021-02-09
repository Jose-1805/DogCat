<div class="row">
    <div class="col-12 col-md-4 col-lg-3">
        <div class="card no-padding no-margin">
            <div class="card-header bg-primary">
                <p class="card-title white-text">Agenda para hoy</p>
                <p class="font-small white-text right"><span class="fa fa-calendar"></span> <?php echo e(date('Y-m-d')); ?></p>
            </div>
            <div class="card-body no-padding" id="contenedor-agenda-hoy">

            </div>
        </div>
    </div>

    <div class="col-12 col-md-8 col-lg-9">
        <table id="tabla-citas" class="table dataTable">
            <thead>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Servicio</th>
            <th>Estado</th>
            <th>Mascota</th>
            <th>Propietario</th>
            <th>Dirección</th>
            <th>Opciones</th>
            </thead>
        </table>
    </div>
</div>