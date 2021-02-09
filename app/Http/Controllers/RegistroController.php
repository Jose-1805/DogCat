<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestRegistro;
use DogCat\Http\Requests\RequestRegistroHistorial;
use DogCat\Models\Correo;
use DogCat\Models\Notificacion;
use DogCat\Models\Registro;
use DogCat\Models\RegistroHistorial;
use DogCat\Models\Rol;
use DogCat\Models\Veterinaria;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Facades\Datatables;

class RegistroController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 2;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    /**s
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return redirect('/');
        return view('registro/index')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function historial($id)
    {
        if(Auth::user()->tieneFuncion($this->identificador_modulo,'historial',$this->privilegio_superadministrador)) {
            $registro = Registro::permitidos()->find($id);
            if ($registro) {
                return view('registro/historial')
                    ->with('registro', $registro)
                    ->with('identificador_modulo',$this->identificador_modulo)
                    ->with('privilegio_superadministrador', $this->privilegio_superadministrador);
            }
        }
        return redirect('/');
    }

    public function listaHistorial(Request $request){
        if(Auth::user()->tieneFuncion($this->identificador_modulo,'historial',$this->privilegio_superadministrador)) {
            if ($request->has('registro')) {

                $registro = Registro::permitidos()->find($request->input('registro'));
                if ($registro) {
                    return view('registro/lista_historial')
                        ->with('historial', $registro->historial()->orderBy('created_at', 'DESC')->get())
                        ->with('identificador_modulo',$this->identificador_modulo)
                        ->with('privilegio_superadministrador', $this->privilegio_superadministrador);
                }
            }
            return response(['error' => ['La información enviada es incorrecta']], 422);
        }else{
            return response(['error' => ['Unauthorized.']], 401);
        }
    }

    public function storeHistorial(RequestRegistroHistorial $request){
        if(Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador)) {

            if($request->has('registro')) {
                $registro = Registro::permitidos()->find($request->input('registro'));
                if($registro && $registro->estado != 'completo') {
                    //despues de cambiado el estado a registrado no es posible marcarlo como registrado nuevamente
                    if($registro->estado != 'registrado' && $request->input('estado') == 'registrado')
                        return response(['error'=>['La información enviada es incorrecta']],422);

                    DB::beginTransaction();
                    $historial = new RegistroHistorial();
                    $historial->estado_nuevo = $request->input('estado');
                    $historial->estado_anterior = $registro->estado;
                    $historial->observaciones = $request->input('observaciones');
                    $historial->registro_id = $registro->id;
                    $historial->user_id = Auth::user()->id;
                    $historial->save();
                    $registro->estado = $historial->estado_nuevo;
                    $registro->save();

                    //si se esta seleccionando el estado completo
                    //se debe crear la cuenta de usuario con la información del registro
                    if($registro->estado == 'completo'){
                        $rol = Rol::find($request->input('rol'));

                        if($rol && ($registro->veterinaria == 'no' && $rol->registros == 'si') || ($registro->veterinaria == 'si' && $rol->veterinarias == 'si')){

                            //si se esta haciendo el registro de un usuario normal
                            if($registro->veterinaria == 'no') {
                                $usuario_email = User::where("email", $registro->email)->first();
                                if ($usuario_email)
                                    return response(['error' => ['Ya existe una cuenta de usuario con el con el email del registro seleccionado.']], 422);
                                //se crea una cuenta de usuario
                                $usuario = new User();
                                $usuario->email = $registro->email;
                                $usuario->celular = $registro->telefono;
                                $usuario->permiso_notificaciones = $registro->permiso_notificaciones;
                                $usuario->rol_id = $rol->id;
                                $usuario->token = csrf_token();
                                if($registro->user_asignado_id){
                                    $usuario->asesor_asignado_id = $registro->user_asignado_id;
                                }
                                $usuario->save();
                                $usuario->nombres = $registro->nombre;
                                $registro->user_id = $usuario->id;
                                $registro->save();

                                Correo::nuevaCuentaUsuarioRegistro($usuario);

                                //se realiza el registro de una veterinaria
                            }else if($registro->veterinaria == 'si'){
                                $veterinaria_email = Veterinaria::where("correo", $registro->email)->first();
                                if ($veterinaria_email)
                                    return response(['error' => ['Ya existe una cuenta de veterinaria con el con el email del registro seleccionado.']], 422);
                                //se crea una cuenta de veterinaria
                                $veterinaria = new Veterinaria();
                                $veterinaria->nombre = $registro->nombre;
                                $veterinaria->correo = $registro->email;
                                $veterinaria->telefono = $registro->telefono;
                                $veterinaria->permiso_notificaciones = $registro->permiso_notificaciones;
                                $veterinaria->token = csrf_token();
                                $veterinaria->user_id = Auth::user()->id;
                                $veterinaria->save();
                                $registro->veterinaria_id = $veterinaria->id;
                                $registro->save();

                                $administrador = new User();
                                $administrador->rol_id = $rol->id;
                                $administrador->veterinaria_empleo_id = $veterinaria->id;
                                $administrador->save();

                                $veterinaria->administrador_id = $administrador->id;
                                $veterinaria->save();

                                Correo::nuevaCuentaVeterinariaRegistro($veterinaria,$rol);
                            }

                        }else{
                            return response(['error'=>['La información enviada es incorrecta']],422);
                        }
                    }
                    DB::commit();
                    return ['success' => true];

                }
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function datos(Request $request)
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador)){
            if($request->ajax())return response(['error' => ['Unauthorized.']], 401);
            else return redirect('/');
        }

        $registros = Registro::permitidos()->select(
    "registros.id",
            "registros.created_at as fecha",
            "registros.nombre",
            "registros.email",
            "registros.telefono",
            "registros.direccion",
            "registros.barrio",
            "registros.estado",
            "registros.veterinaria",
            DB::raw('CONCAT(users.nombres," ",users.apellidos," (",roles.nombre,")") as usuario_asignado')
        )
            ->leftJoin('users','registros.user_asignado_id','=','users.id')
            ->leftJoin('roles','users.rol_id','=','roles.id')
            ->get();

        $table = Datatables::of($registros)
            ->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion($this->identificador_modulo,'asignar',$this->privilegio_superadministrador) && $r->estado != 'completo' && $r->estado != 'descartado' && $r->veterinaria == 'no') {
                $opc .= '<a class="btn btn-xs btn-success margin-2 btn-asignar-registro" data-registro="'.$r->id.'" data-toggle="tooltip" data-placement="bottom" title="Asignar"><i class="white-text fa fa-user"></i></a>';
            }

            if(Auth::user()->tieneFuncion($this->identificador_modulo,'historial',$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/registro/historial') .'/'. $r->id . '" class="btn btn-xs btn-info margin-2" data-toggle="tooltip" data-placement="bottom" title="Historial"><i class="white-text fa fa-list-alt"></i></a>';
            }

            return $opc;

        })
        ->setRowClass(function ($r) {
            if($r->estado == 'completo') return 'green lighten-4';
            if($r->estado == 'descartado') return 'red lighten-4';
        })
        ->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones($this->identificador_modulo,['editar','historial'],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function asignar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'asignar', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $usuario = User::permitidos()->where('users.estado','activo')->find($request->usuario);
        $registro = Registro::permitidos()->where('estado','<>','completo')
            ->where('estado','<>','descartado')->find($request->registro);

        if($usuario && $registro){
            $registro->user_asignado_id = $usuario->id;
            $registro->save();
            Notificacion::registroAsignado($registro,$usuario);
            return ['success'=>true];
        }
        return response(['errors'=>['La información enviada es incorrecta']],422);
    }
}