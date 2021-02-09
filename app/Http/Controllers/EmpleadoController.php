<?php

namespace DogCat\Http\Controllers;

use DogCat\Models\Ciudad;
use DogCat\Models\Correo;
use DogCat\Models\Imagen;
use DogCat\Models\Rol;
use DogCat\Models\Ubicacion;
use DogCat\Models\Veterinaria;
use DogCat\User;
use DogCat\Http\Requests\RequestEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Facades\Datatables;

class EmpleadoController extends Controller
{

    public $privilegio_superadministrador = true;
    protected $identificador_modulo = 3;

    function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador,['except'=>['validarCuenta','validarCuentaSend','passwordEmpresario','passwordEmpresarioSend']]);
    }

    public function index(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect('/');

        return view('empleado/index')
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('identificador_modulo',$this->identificador_modulo);
    }

    public function crear(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return redirect('/');

        return view('empleado/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function guardar(RequestEmpleado $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        DB::beginTransaction();

        //validacion de password
        if($request->has('password') && $request->input('password') != ''){
            if($request->has('password_confirm')){
                if(strlen($request->input('password'))<6)
                    return response(['error'=>['La contraseña debe tener 6 caracteres como mínimo.']],422);

                if($request->input('password') != $request->input('password_confirm'))
                    return response(['error'=>['La contraseña y la verificación no coinciden..']],422);
            }else{
                return response(['error'=>['Debe ingresar la confirmación de la contraseña.']],422);
            }
        }


        $ubicacion = new Ubicacion();
        $ubicacion->ciudad_id = $request->input('ciudad');
        $ubicacion->barrio = $request->input('barrio');
        $ubicacion->calle = $request->input('calle');
        $ubicacion->carrera = $request->input('carrera');
        $ubicacion->transversal = $request->input('transversal');
        $ubicacion->numero = $request->input('numero');
        $ubicacion->especificaciones = $request->input('especificaciones');
        $ubicacion->save();

        //si es superadministrador se busca el rol de acuerdo a la los roles permitidos para personal dogcat
        if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            $rol = Rol::where('afiliados','no')
                ->where('veterinarias','no')
                ->where('registros','no')
                ->find($request->input('rol'));
        }else{
            //si es un usuario de una veterinaria se busca el rol de acuerdo a los roles relacionados con la veterinaria a la cual pertenece
            $rol = Rol::permitidos()->find($request->input('rol'));
        }

        if(!$rol)
            return response(['error'=>['La información enviada es incorrecta']],422);

        $usuario = new User();
        //si se ingreso un paswwod o se sebe enviar un link para crearlo
        if($request->has('password')) {
            $usuario->password = Hash::make($request->input('password'));
            $create_password = false;
        }else{
            $create_password = true;
        }

        $usuario->ubicacion_id = $ubicacion->id;
        $usuario->tipo_identificacion = $request->input('tipo_identificacion');
        $usuario->identificacion = $request->input('identificacion');
        $usuario->nombres = $request->input('nombres');
        $usuario->apellidos = $request->input('apellidos');
        $usuario->email = $request->input('email');
        if($request->has('telefono'))
            $usuario->telefono = $request->input('telefono');

        $usuario->celular = $request->input('celular');
        $usuario->genero = $request->input('genero');
        $usuario->estado_civil = $request->input('estado_civil');
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
        $usuario->rol_id = $rol->id;

        if(Auth::user()->getTipoUsuario() == 'empleado') {
            //si es un usuario de una veterinaria se buca la veterinaria relacionada para
            //relacioanrla igualmente copn el nuevo usuario
            $veterinaria = Auth::user()->veterinaria;
            if (!$veterinaria)
                return response(['error' => ['La información enviada es incorrecta']], 422);

            $usuario->veterinaria_empleo_id = $veterinaria->id;
        }

        //se genera token que va en la url para el registro de contraseña
        if($create_password)
            $usuario->token = csrf_token();

        $usuario->save();

        //imagen del usuario
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_img_perfil_usuario') . $usuario->id;
            $imagen->move(storage_path('app/'.$ruta), $nombre);

            $imagen_obj = new Imagen();
            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();
            $usuario->imagen_id = $imagen_obj->id;
            $usuario->save();
        }

        Correo::nuevaCuentaUsuario($usuario,$create_password,$request->input('password'));
        DB::commit();
        return ['success' => true];
    }

    public function editar($id){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador))
            return redirect('/');

        $usuario = User::permitidos()->select('users.*','ubicaciones.calle','ubicaciones.carrera','ubicaciones.transversal','ubicaciones.numero','ubicaciones.barrio','ubicaciones.especificaciones','ciudades.id as ciudad')
            ->join('ubicaciones','users.ubicacion_id','=','ubicaciones.id')
            ->join('ciudades','ubicaciones.ciudad_id','=','ciudades.id')
            ->find($id);
        if(!$usuario || $usuario->estado == 'inactivo') return redirect('/');

        $ciudad = Ciudad::find($usuario->ciudad);
        $departamento = $ciudad->departamento;

        return view('empleado/editar')
            ->with('usuario',$usuario)
            ->with('ciudad',$ciudad)
            ->with('departamento',$departamento)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function actualizar(RequestEmpleado $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        DB::beginTransaction();
        $user = User::permitidos()->find($request->input('usuario'));
        if(!$user || $user->estado == 'inactivo')
            return response(['error' => ['La información enviada es incorrecta']], 422);

        $user->tipo_identificacion = $request->input('tipo_identificacion');
        $user->identificacion = $request->input('identificacion');
        $user->nombres = $request->input('nombres');
        $user->apellidos = $request->input('apellidos');
        $user->telefono = null;
        if($request->has('telefono'))
            $user->telefono = $request->input('telefono');
        $user->celular = $request->input('celular');
        $user->fecha_nacimiento = $request->input('fecha_nacimiento');
        $user->email = $request->input('email');
        $user->genero = $request->input('genero');
        $user->estado_civil = $request->input('estado_civil');

        if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
                $rol = Rol::where('afiliados','no')
                    ->where('veterinarias','no')
                    ->where('registros','no')
                    ->find($request->input('rol'));
        }else{
            //si es un usuario de una veterinaria se busca el rol de acuerdo a los roles relacionados con la veterinaria a la cual pertenece
            $rol = Rol::permitidos()->find($request->input('rol'));
        }

        if(!$rol)
            return response(['error' => ['La información enviada es incorrecta']], 422);

        $user->rol_id = $rol->id;
        $user->save();

        $ubicacion = $user->ubicacion;

        $ubicacion->ciudad_id = $request->input('ciudad');
        $ubicacion->barrio = $request->input('barrio');
        $ubicacion->calle = $request->input('calle');
        $ubicacion->carrera = $request->input('carrera');
        $ubicacion->transversal = $request->input('transversal');
        $ubicacion->numero = $request->input('numero');
        $ubicacion->especificaciones = $request->input('especificaciones');
        $ubicacion->save();

        if($request->hasFile('imagen')){

            //si la persona tiene imagen se elimina
            $imagen_obj = $user->imagenPerfil;
            if($imagen_obj){
                $file = storage_path('app/'.$imagen_obj->ubicacion.'/'.$imagen_obj->nombre);
                @unlink($file);
            }

            $ruta = config('params.storage_img_perfil_usuario').$user->id;

            $imagen = $request->file('imagen');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $imagen->move(storage_path('app/'.$ruta),$nombre);

            if(!$imagen_obj)
                $imagen_obj = new Imagen();

            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();

            $user->imagen_id = $imagen_obj->id;
            $user->save();
        }
        DB::commit();
        return ['success'=>true];
    }

    public function lista(){
        $usuarios = User::permitidos()->select('users.id',DB::raw('CONCAT(users.tipo_identificacion , " " ,users.identificacion) as identificacion'),DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'),'users.email','users.telefono','users.fecha_nacimiento','users.genero','roles.nombre as rol','users.estado','roles.id as rol_id')
            ->join('roles','users.rol_id','=','roles.id')
            ->where('users.id','<>',Auth::user()->id)
            ->where('roles.registros','no')
            ->where('roles.veterinarias','no')
            ->where('roles.afiliados','no')
            ->where('roles.entidades','no')
            ->get();

        $table = Datatables::of($usuarios);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador)) {
                $rol = Rol::find($r->rol_id);
                if($rol && $rol->registros == 'no') {
                    if ($r->estado == 'activo') {
                        $opc .= '<a href="' . url('/empleado/editar') . '/' . $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-edit"></i></a>';
                        $opc .= '<a href="#!" class="btn btn-xs btn-danger margin-2 btn-desactivar-usuario" data-usuario="' . $r->id . '"  data-toggle="tooltip" data-placement="bottom" title="Inactivar"><i class="white-text fa fa-chevron-down"></i></a>';
                    }
                    if ($r->estado == 'inactivo')
                        $opc .= '<a href="#!" class="btn btn-xs btn-primary margin-2 btn-activar-usuario" data-usuario="' . $r->id . '" data-toggle="tooltip" data-placement="bottom" title="Activar"><i class="white-text fa fa-chevron-up"></i></a>';
                }
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones($this->identificador_modulo,['editar'],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function activar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return response(['error'=>['La información enviada es incorrecta.']],422);

        $usuario = User::permitidos()->find($request->input('usuario'));
        if($usuario){
            $usuario->estado = 'activo';
            $usuario->save();
            return ['success'=>true];
        }

        return response(['error'=>['La información enviada es incorrecta.']],422);
    }

    public function desactivar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return response(['error'=>['La información enviada es incorrecta.']],422);

        $usuario = User::permitidos()->find($request->input('usuario'));

        if($usuario){
            $usuario->estado = 'inactivo';
            $usuario->save();
            return ['success'=>true];
        }

        return response(['error'=>['La información enviada es incorrecta.']],422);
    }
}
