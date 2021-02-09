
<a href="#!" class="
<?php if(isset($except) && in_array('datos_basicos_veterinaria',$except)): ?>
    teal-text text-lighten-2
<?php endif; ?>
btn-navegacion-toggle-render margin-right-10" data-element="datos_basicos_veterinaria"><i class="fa fa-list-alt margin-right-5"></i>Datos básicos veterinaria</a>

<a href="#!" class="
<?php if(isset($except) && in_array('ubicacion_veterinaria',$except)): ?>
    teal-text text-lighten-2
<?php endif; ?>
btn-navegacion-toggle-render margin-right-10" data-element="ubicacion_veterinaria"><i class="fa fa-map-marker margin-right-5"></i>Ubicación veterinaria</a>

<a href="#!" class="
<?php if(isset($except) && in_array('datos_personales_administrador',$except)): ?>
    teal-text text-lighten-2
<?php endif; ?>
btn-navegacion-toggle-render margin-right-10" data-element="datos_personales_administrador"><i class="fa fa-list-alt margin-right-5"></i>Datos personales administrador</a>

<a href="#!" class="
<?php if(isset($except) && in_array('datos_ubicacion_administrador',$except)): ?>
    teal-text text-lighten-2
<?php endif; ?>
btn-navegacion-toggle-render margin-right-10" data-element="datos_ubicacion_administrador"><i class="fa fa-map-marker margin-right-5"></i>Ubicación administrador</a>

<?php if(!$administrador->exists): ?>
<a href="#!" class="
<?php if(isset($except) && in_array('seguridad_administrador',$except)): ?>
    teal-text text-lighten-2
<?php endif; ?>
btn-navegacion-toggle-render margin-right-10" data-element="seguridad_administrador"><i class="fa fa-key margin-right-5"></i>Seguridad administrador</a>
<?php endif; ?>