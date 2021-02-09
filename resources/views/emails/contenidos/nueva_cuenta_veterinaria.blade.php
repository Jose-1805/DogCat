<?php
    $administrador = $veterinaria->administrador;
?>
<p>La cuenta para la veterinaria <strong>{{$veterinaria->nombre}}</strong> ha sido registrada en
el sistema web de <a href="{{url('/')}}">DogCat</a>.</p>

@if($create_password)
<p>Para ingresar al sistema ingrese a este <a href="{{url('/create-password/'.$administrador->token.'/'.\Illuminate\Support\Facades\Crypt::encrypt($administrador->id))}}">link</a> y registre su contraseña de ingreso.</p>
@else
<p>Para ingresar al sistema dirijase a <a href="{{url('/login')}}">DogCat</a> e inicie sesión con los siguientes datos.</p>
<p><strong>Usuario: </strong> {{$administrador->email}}</p>
<p><strong>Contraseña: {{$clave}}</strong></p>
@endif

