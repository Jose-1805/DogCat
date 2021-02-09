<div class="row">
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card">
            <div class="card-header bg-info">
                <p class="card-title white-text">Agenda para hoy</p>
                <p class="font-small white-text right font-weight-500"><span class="fa fa-calendar"></span> <?php echo e(date('Y-m-d')); ?></p>
            </div>
            <div class="card-body">
                <p class="alert alert-info">No hay citas registradas para el dìa de hoy</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-7 col-lg-8">
        <table class="table dataTable">
            <thead>
                <th>Fecha</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Mascota</th>
                <th>Personal</th>
                <th>Opciones</th>
            </thead>
        </table>
    </div>
</div>