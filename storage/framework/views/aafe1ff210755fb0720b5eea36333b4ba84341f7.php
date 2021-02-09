<ul class="navbar-nav mr-auto" style="max-width: 80%;">
    <li class="nav-item <?php echo e(Request::is('registro/*') ||  Request::is('registro')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/registro')); ?>">Registros</a></li>
    <li class="nav-item <?php echo e(Request::is('veterinaria/*') ||  Request::is('veterinaria')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/veterinaria')); ?>">Veterinarias</a></li>
    <li class="nav-item <?php echo e(Request::is('entidad/*') ||  Request::is('entidad')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/entidad')); ?>">Entidades</a></li>
    <li class="nav-item <?php echo e(Request::is('mascota/*') ||  Request::is('mascota')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/mascota')); ?>">Mascotas</a></li>
    <li class="nav-item <?php echo e(Request::is('solicitud-afiliacion/*') ||  Request::is('solicitud-afiliacion')? 'active':''); ?>"><a class="nav-link" href="<?php echo e(url('/solicitud-afiliacion')); ?>">Solicitudes de afiliación</a></li>

    <li class="nav-item dropdown
        <?php echo e(Request::is('empleado/*') ||  Request::is('empleado') ||
          Request::is('afiliado/*') ||  Request::is('afiliado')? 'active':''); ?>

            ">
        <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
        <div class="dropdown-menu">
            <a class="dropdown-item <?php echo e(Request::is('empleado/*') ||  Request::is('empleado')? 'active':''); ?>" href="<?php echo e(url('/empleado')); ?>">Empleados</a>
            <a class="dropdown-item <?php echo e(Request::is('afiliado/*') ||  Request::is('afiliado')? 'active':''); ?>" href="<?php echo e(url('/afiliado')); ?>">Afiliados</a>
        </div>
    </li>

    <li class="nav-item dropdown
        <?php echo e(Request::is('modulos-funciones/*') ||  Request::is('modulos-funciones') ||
          Request::is('rol/*') ||  Request::is('rol') ||
          Request::is('api/*') ||  Request::is('api')

         ? 'active':''); ?>

    ">
        <a href="#!" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sistema <span class="caret"></span></a>
        <div class="dropdown-menu dropdown-primary">
            <a class="dropdown-item <?php echo e(Request::is('rol/*') ||  Request::is('rol')? 'active':''); ?>" href="<?php echo e(url('/rol')); ?>">Roles</a>
            <a class="dropdown-item <?php echo e(Request::is('modulos-funciones/*') ||  Request::is('modulos-funciones')? 'active':''); ?>" href="<?php echo e(url('/modulos-funciones')); ?>">Modulos y funciones</a>
            <a class="dropdown-item <?php echo e(Request::is('api/*') ||  Request::is('api')? 'active':''); ?>" href="<?php echo e(url("/api")); ?>">Api</a>

        </div>
    </li>
</ul>