<p>Su cuenta de usuario con el rol de <strong>{{$usuario->rol->nombre}}</strong> ha sido creada con éxito en el sistema web de <a href="{{url('/')}}">DogCat</a>.</p>

@if($create_password)
<p>Para ingresar al sistema ingrese a este <a href="{{url('/create-password/'.$usuario->token.'/'.\Illuminate\Support\Facades\Crypt::encrypt($usuario->id))}}">link</a> y registre su contraseña de ingreso.</p>
@else
<p>Para ingresar al sistema dirijase a <a href="{{url('/login')}}">DogCat</a> e inicie sesión con los siguientes datos.</p>
<p><strong>Usuario: </strong> {{$usuario->email}}</p>
<p><strong>Contraseña: {{$clave}}</strong></p>
@endif

