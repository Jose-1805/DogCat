<div class="col-12 no-padding no-margin margin-top-40 encabezado-publicacion">
    <div class="avatar">
        <img style="width: 50px; height: 50px;" src="https://www.jamf.com/jamf-nation/img/default-avatars/generic-user-purple.png">
    </div>
    <div class="padding-left-5 data">
        <p class="teal-text text-lighten-1 font-medium"><strong><?php echo e($publicacion->usuario->nombres.' '.$publicacion->usuario->apellidos); ?></strong> </p>
        <p class="font-small" style="margin-top: -20px;"><?php echo e($publicacion->formatoFecha()); ?></p>
    </div>
</div>