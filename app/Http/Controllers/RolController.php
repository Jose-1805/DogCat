<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestRegistro;
use DogCat\Http\Requests\RequestRol;
use DogCat\Models\Registro;
use DogCat\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

class RolController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 6;

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
        return view('rol/index')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }


    public function vistaRoles(Request $request)
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador)){
            if($request->ajax())return response(['error' => ['Unauthorized.']], 401);
            else return redirect('/');
        }
        return view('rol.lista_roles')
            ->with('roles', Rol::permitidos()->orderBy("nombre")->where('superadministrador','no')->get())
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador', $this->privilegio_superadministrador);
    }

    public function vistaPrivilegios(Request $request)
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador)){
            if($request->ajax())return response(['error' => ['Unauthorized.']], 401);
            else return redirect('/');
        }
        $rol = null;
        if ($request->has('rol'))
            $rol = Rol::permitidos()->where('superadministrador','no')->find($request->input('rol'));

        if(!$rol)return response(['error'=>['La información enviada es incorrecta']],422);

        return view('rol.lista_privilegios')
            ->with('rol', $rol)
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador', $this->privilegio_superadministrador);
    }

    public function crear(RequestRol $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $rol = new Rol();
        $rol->nombre = $request->nombre;
        if(Auth::user()->getTipoUsuario() == 'personal dogcat') {
            if ($request->has('registros'))
                $rol->registros = 'si';
            else if ($request->has('veterinarias'))
                $rol->veterinarias = 'si';
            else if ($request->has('entidades'))
                $rol->entidades = 'si';
            else if ($request->has('afiliados'))
                $rol->afiliados = 'si';
        }else{
            $veterinaria = Auth::user()->getVeterinaria();

            if(!$veterinaria)
                return response(['error'=>['No se encontró ninguna veterinaria para relacionar el nuevo rol.']],422);
            $rol->veterinaria_id = $veterinaria->id;
        }



        $rol->user_id = Auth::user()->id;
        $privilegios = '';
        if($request->has('privilegios')){
            if(is_array($request->input('privilegios'))){
                for ($i = 0;$i < count($request->input('privilegios')); $i++){
                    //se separa cada dato por la coma que debe traer para identificar el módulo y la funcion ej: 2,1
                    $data = explode(',',$request->input('privilegios')[$i]);

                    if(count($data) == 2){
                        if(Auth::user()->tieneFuncion($data[0],array_flip(config('params')['funciones'])[$data[1]],$this->privilegio_superadministrador)){
                            $privilegios .= '('.$request->input('privilegios')[$i].')_';
                        }
                    }else{
                        return response(['error' => ['La información enviada es incorrecta']], 422);
                    }
                }
                //se quita el ultimo '_' para que la cadena quede tipo -> (1,2)_(1,3) y no -> (1,2)_(1,3)_
                $privilegios = trim($privilegios,'_');
            }else{
                return response(['error' => ['La información enviada es incorrecta']], 422);
            }
        }
        if($privilegios != '')
            $rol->privilegios = $privilegios;

        $rol->save();
        return ['success'=>true];
    }

    public function form(Request $request){
        $rol = new Rol();
        if($request->has('rol')){
            $rol = Rol::permitidos()->find($request->input('rol'));

            if(!$rol)return response(['error'=>['La información enviada es incorrecta']],422);
        }


        return view('rol/form')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('rol',$rol)->render();
    }

    public function editar(RequestRol $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        if(!$request->has('rol'))return response(['error'=>['La información envida es incorrecta']],422);

        $rol = Rol::permitidos()->find($request->input('rol'));

        if(!$rol)return response(['error'=>['La información envida es incorrecta']],422);

        $rol->nombre = $request->nombre;
        $rol->privilegios = '';
        $privilegios = '';
        if($request->has('privilegios')){
            if(is_array($request->input('privilegios'))){
                for ($i = 0;$i < count($request->input('privilegios')); $i++){
                    //se separa cada dato por la coma que debe traer para identificar el módulo y la funcion ej: 2,1
                    $data = explode(',',$request->input('privilegios')[$i]);

                    if(count($data) == 2){
                        if(Auth::user()->tieneFuncion($data[0],array_flip(config('params')['funciones'])[$data[1]],$this->privilegio_superadministrador)){
                            $privilegios .= '('.$request->input('privilegios')[$i].')_';
                        }
                    }else{
                        return response(['error' => ['La información enviada es incorrecta']], 422);
                    }
                }
                //se quita el ultimo '_' para que la cadena quede tipo -> (1,2)_(1,3) y no -> (1,2)_(1,3)_
                $privilegios = trim($privilegios,'_');
            }else{
                return response(['error' => ['La información enviada es incorrecta']], 422);
            }
        }
        if($privilegios != '')
            $rol->privilegios = $privilegios;

        $rol->save();
        return ['success'=>true];
    }
}