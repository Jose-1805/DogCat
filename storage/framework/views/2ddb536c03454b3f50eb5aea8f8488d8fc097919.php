<li class="nav-item <?php echo e(Request::is('publicacion/*') ||  Request::is('publicacion')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/')); ?>">Inicio</a></li>
<li class="nav-item"><a class="nav-link" href="<?php echo e(url('/afiliado/crear/true')); ?>">Crear afiliación</a></li>
<li class="nav-item <?php echo e(Request::is('registro/*') ||  Request::is('registro')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/registro')); ?>">Registros</a></li>
<li class="nav-item dropdown
    <?php echo e(Request::is('empleado/*') ||  Request::is('empleado') ||
      Request::is('disponibilidad/*') ||  Request::is('disponibilidad') ||
      Request::is('afiliado/*') ||  Request::is('afiliado')? 'active':''); ?>

        ">
    <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
    <div class="dropdown-menu">
        <a class="dropdown-item <?php echo e(Request::is('afiliado/*') ||  Request::is('afiliado')? 'active':''); ?>" href="<?php echo e(url('/afiliado')); ?>">Afiliados</a>
        <a class="dropdown-item <?php echo e(Request::is('empleado/*') ||  Request::is('empleado')? 'active':''); ?>" href="<?php echo e(url('/empleado')); ?>">Empleados</a>
        <a class="dropdown-item <?php echo e(Request::is('disponibilidad/*') ||  Request::is('disponibilidad')? 'active':''); ?>" href="<?php echo e(url('/disponibilidad')); ?>">Disponibilidades</a>
    </div>
</li>
<li class="nav-item <?php echo e(Request::is('mascota/*') ||  Request::is('mascota')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/mascota')); ?>">Mascotas</a></li>
<li class="nav-item dropdown
    <?php echo e(Request::is('solicitud-afiliacion') || Request::is('solicitud-afiliacion/*')
    ||  Request::is('afiliacion')||  Request::is('afiliacion/*')
    ||  Request::is('simulador-afiliacion')||  Request::is('simulador-afiliacion/*')
    ||  Request::is('credito-afiliacion')||  Request::is('credito-afiliacion/*')? 'active':''); ?>

        ">
    <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Afiliaciones <span class="caret"></span></a>
    <div class="dropdown-menu">
        <a class="dropdown-item <?php echo e(Request::is('afiliacion/*') ||  Request::is('afiliacion')? 'active':''); ?>" href="<?php echo e(url('/afiliacion')); ?>">Afiliaciones</a>
        <a class="dropdown-item <?php echo e(Request::is('solicitud-afiliacion/*') ||  Request::is('solicitud-afiliacion')? 'active':''); ?>" href="<?php echo e(url('/solicitud-afiliacion')); ?>">Solicitudes de afiliación</a>
        <a class="dropdown-item <?php echo e(Request::is('credito-afiliacion/*') ||  Request::is('credito-afiliacion')? 'active':''); ?>" href="<?php echo e(url('/credito-afiliacion')); ?>">Créditos de afiliación</a>
        <a class="dropdown-item <?php echo e(Request::is('simulador-afiliacion/*') ||  Request::is('simulador-afiliacion')? 'active':''); ?>" href="<?php echo e(url('/simulador-afiliacion')); ?>">Simulador de afiliación</a>
    </div>
</li>
<li class="nav-item dropdown
    <?php echo e(Request::is('entidad') || Request::is('entidad/*')
    ||  Request::is('veterinaria')||  Request::is('veterinaria/*')? 'active':''); ?>

        ">
    <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Empresas <span class="caret"></span></a>
    <div class="dropdown-menu">
        <a class="dropdown-item <?php echo e(Request::is('veterinaria/*') ||  Request::is('veterinaria')? 'active':''); ?>" href="<?php echo e(url('/veterinaria')); ?>">Veterinarias</a>
        <a class="dropdown-item <?php echo e(Request::is('entidad/*') ||  Request::is('entidad')? 'active':''); ?>" href="<?php echo e(url('/entidad')); ?>">Entidades</a>
    </div>
</li>
<li class="nav-item <?php echo e(Request::is('servicio/*') ||  Request::is('servicio')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/servicio')); ?>">Servicios</a></li>
<li class="nav-item <?php echo e(Request::is('cita/*') ||  Request::is('cita')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/cita')); ?>">Citas</a></li>
<li class="nav-item dropdown
    <?php echo e(Request::is('modulos-funciones/*') ||  Request::is('modulos-funciones') ||
      Request::is('rol/*') ||  Request::is('rol') ||
      Request::is('api/*') ||  Request::is('api')

     ? 'active':''); ?>

">
    <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sistema <span class="caret"></span></a>
    <div class="dropdown-menu dropdown-primary">
        <a class="dropdown-item <?php echo e(Request::is('modulos-funciones/*') ||  Request::is('modulos-funciones')? 'active':''); ?>" href="<?php echo e(url('/modulos-funciones')); ?>">Modulos y funciones</a>
        <a class="dropdown-item <?php echo e(Request::is('rol/*') ||  Request::is('rol')? 'active':''); ?>" href="<?php echo e(url('/rol')); ?>">Roles</a>
        <a class="dropdown-item <?php echo e(Request::is('api/*') ||  Request::is('api')? 'active':''); ?>" href="<?php echo e(url("/api")); ?>">Api</a>

    </div>
</li>

<li class="nav-item <?php echo e(Request::is('finanzas/*') ||  Request::is('finanzas')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/finanzas')); ?>">Finanzas</a></li>