<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestAfiliado;
use DogCat\Models\Ciudad;
use DogCat\Models\Correo;
use DogCat\Models\Imagen;
use DogCat\Models\RevisionPeriodica;
use DogCat\Models\Rol;
use DogCat\Models\Ubicacion;
use DogCat\Models\Veterinaria;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Facades\Datatables;

class AfiliadoController extends Controller
{

    public $privilegio_superadministrador = true;
    protected $identificador_modulo = 10;

    function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador,['except'=>['validarCuenta','validarCuentaSend','passwordEmpresario','passwordEmpresarioSend']]);
    }

    public function index(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect('/');

        return view('afiliado/index')
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('identificador_modulo',$this->identificador_modulo);
    }

    public function crear($assisted = false){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return redirect('/');

        return view('afiliado/crear')
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('asistido',$assisted == 'true'?true:false);
    }

    public function guardar(RequestAfiliado $request){
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

        $rol = Rol::where('afiliados','si')->find($request->input('rol'));

        if(!$rol)
            return response(['error'=>['La información enviada es incorrecta']],422);

        //si es superadministrador se busca la veterinaria seleccionada
        if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            $veterinaria = Veterinaria::where('veterinaria','si')->find($request->input('veterinaria'));
        }else{
            //si es un usuario de una veterinaria se busca la veterinaria a la cual pertenece
            $veterinaria = Auth::user()->veterinaria;
        }

        if(!$veterinaria)
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

        if($request->has('ref_fam_nombre') && $request->has('ref_fam_celular') && $request->has('ref_fam_direccion')){
            $usuario->ref_fam_nombre = $request->input('ref_fam_nombre');
            $usuario->ref_fam_celular = $request->input('ref_fam_celular');
            $usuario->ref_fam_direccion = $request->input('ref_fam_direccion');
        }

        if($request->has('ref_per_nombre') && $request->has('ref_per_celular') && $request->has('ref_per_direccion')){
            $usuario->ref_per_nombre = $request->input('ref_per_nombre');
            $usuario->ref_per_celular = $request->input('ref_per_celular');
            $usuario->ref_per_direccion = $request->input('ref_per_direccion');
        }

        $usuario->rol_id = $rol->id;
        $usuario->veterinaria_afiliado_id = $veterinaria->id;
        $usuario->asesor_asignado_id = Auth::user()->id;

       //se genera token que va en la url para el registro de contraseña
        if($create_password)
            $usuario->token = csrf_token();

        $usuario->save();

        //imagen del usuario
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_img_perfil_usuario').$usuario->id;
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

        //si es asistido se lanza mensaje por session
        //para que se muestre al redireccionar a la creación de mascotas
        if($request->has('asistido') && $request->asistido == '1')
            session()->put('msj_success','Usuario creado con éxito, a continuación agregue las mascotas del usuario.');
        return ['success' => true,'usuario'=>$usuario->id];
    }

    public function editar($id){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador))
            return redirect('/');

        $usuario = User::afiliados()->select('users.*','ubicaciones.calle','ubicaciones.carrera','ubicaciones.transversal','ubicaciones.numero','ubicaciones.barrio','ubicaciones.especificaciones','ciudades.id as ciudad')
            ->join('ubicaciones','users.ubicacion_id','=','ubicaciones.id')
            ->join('ciudades','ubicaciones.ciudad_id','=','ciudades.id')
            ->find($id);
        if(!$usuario || $usuario->estado == 'inactivo') return redirect('/');

        $ciudad = Ciudad::find($usuario->ciudad);
        $departamento = $ciudad->departamento;

        return view('afiliado/editar')
            ->with('usuario',$usuario)
            ->with('ciudad',$ciudad)
            ->with('departamento',$departamento)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function actualizar(RequestAfiliado $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        DB::beginTransaction();
        $user = User::afiliados()->find($request->input('usuario'));
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

        $user->ref_fam_nombre = null;
        $user->ref_fam_celular = null;
        $user->ref_fam_direccion = null;

        if($request->has('ref_fam_nombre') && $request->has('ref_fam_celular') && $request->has('ref_fam_direccion')){
            $user->ref_fam_nombre = $request->input('ref_fam_nombre');
            $user->ref_fam_celular = $request->input('ref_fam_celular');
            $user->ref_fam_direccion = $request->input('ref_fam_direccion');
        }

        $user->ref_per_nombre = null;
        $user->ref_per_celular = null;
        $user->ref_per_direccion = null;
        if($request->has('ref_per_nombre') && $request->has('ref_per_celular') && $request->has('ref_per_direccion')){
            $user->ref_per_nombre = $request->input('ref_per_nombre');
            $user->ref_per_celular = $request->input('ref_per_celular');
            $user->ref_per_direccion = $request->input('ref_per_direccion');
        }

        $rol = Rol::where('afiliados','si')->find($request->input('rol'));

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

        if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            $afiliados = User::afiliados()->select('users.id',DB::raw('CONCAT(users.tipo_identificacion , " " ,users.identificacion) as identificacion'),DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'),'users.email','users.celular as telefono','roles.nombre as rol','users.fecha_nacimiento','users.genero','users.estado','roles.id as rol_id','veterinarias.nombre as veterinaria',
                DB::raw('CONCAT(user_asignado.nombres," ",user_asignado.apellidos) as asesor'))
                ->join('roles','users.rol_id','=','roles.id')
                ->join('veterinarias','users.veterinaria_afiliado_id','=','veterinarias.id')
                ->join('users as user_asignado','users.asesor_asignado_id','=','user_asignado.id')
                ->get();
        }else {
            $afiliados = User::afiliados()->select('users.id', DB::raw('CONCAT(users.tipo_identificacion , " " ,users.identificacion) as identificacion'), DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'), 'users.email', 'users.celular as telefono', 'roles.nombre as rol','users.fecha_nacimiento','users.genero', 'users.estado', 'roles.id as rol_id')
                ->join('roles', 'users.rol_id', '=', 'roles.id')
                ->get();
        }

        $table = Datatables::of($afiliados);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
                $opc = '';
                if(Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador)) {
                    //$rol = Rol::find($r->rol_id);
                    if ($r->estado == 'activo') {
                        $opc .= '<a href="' . url('/afiliado/editar') . '/' . $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fas fa-edit"></i></a>';
                        if(Auth::user()->tieneFuncion(MascotaController::$identificador_modulo_static,'crear',MascotaController::$privilegio_superadministrador_static)){
                            $opc .= '<a href="' . url('/mascota/nueva') . '/' . $r->id . '" class="btn btn-xs btn-success margin-2" data-toggle="tooltip" data-placement="bottom" title="Crear mascota"><i class="white-text fas fa-paw"></i></a>';
                        }
                        $opc .= '<a href="#!" class="btn btn-xs btn-danger margin-2 btn-desactivar-usuario" data-usuario="' . $r->id . '"  data-toggle="tooltip" data-placement="bottom" title="Inactivar"><i class="white-text fa fa-chevron-down"></i></a>';
                    }
                    if ($r->estado == 'inactivo')
                        $opc .= '<a href="#!" class="btn btn-xs btn-primary margin-2 btn-activar-usuario" data-usuario="' . $r->id . '" data-toggle="tooltip" data-placement="bottom" title="Activar"><i class="white-text fa fa-chevron-up"></i></a>';

                }

                return $opc;

            })->editColumn('afiliacion_activa',function ($row){
                if($row->afiliaciones()->where('estado','Activa')->first())
                    return 'Si';
                return 'No';
            })->editColumn('ultima_visita_periodica',function ($row){
                $ultima_revision = RevisionPeriodica::select('revisiones_periodicas.created_at')
                    ->join('mascotas','revisiones_periodicas.mascota_id','=','mascotas.id')
                    ->join('users','mascotas.user_id','=','users.id')
                    ->where('users.id',$row->id)
                    ->orderBy('revisiones_periodicas.created_at','DESC')
                    ->first();

                return $ultima_revision?date('Y-m-d',strtotime($ultima_revision->created_at)):'Sin visitas';
            })->rawColumns(['opciones','afiliacion_activa']);

        if(!Auth::user()->tieneFunciones($this->identificador_modulo,['editar'],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function activar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return response(['error'=>['La información enviada es incorrecta.']],422);

        $usuario = User::afiliados()->find($request->input('usuario'));
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

        $usuario = User::afiliados()->find($request->input('usuario'));

        if($usuario){
            $usuario->estado = 'inactivo';
            $usuario->save();
            return ['success'=>true];
        }

        return response(['error'=>['La información enviada es incorrecta.']],422);
    }
}
