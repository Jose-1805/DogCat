<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestVeterinaria;
use DogCat\Models\Correo;
use DogCat\Models\Imagen;
use DogCat\Models\Rol;
use DogCat\Models\Ubicacion;
use DogCat\Models\Veterinaria;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Facades\Datatables;

class VeterinariaController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 9;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    public function index()
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return redirect('/');
        return view('veterinaria/index')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function lista(){
        if (Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador)){
            $veterinarias = Veterinaria::select(
                    'veterinarias.*',
                    'ubicaciones.calle','ubicaciones.carrera','ubicaciones.numero','ubicaciones.barrio','ubicaciones.especificaciones',
                    'ciudades.nombre as ciudad','departamentos.nombre as departamento','paises.nombre as pais',
                    DB::raw('CONCAT(users.nombres," ",users.apellidos) as administrador')
                )
                ->join('ubicaciones','veterinarias.ubicacion_id','=','ubicaciones.id')
                ->join('ciudades','ubicaciones.ciudad_id','=','ciudades.id')
                ->join('departamentos','ciudades.departamento_id','=','departamentos.id')
                ->join('paises','departamentos.pais_id','=','paises.id')
                ->join('users','veterinarias.administrador_id','=','users.id')
                ->where('veterinarias.veterinaria','si')
                ->get();

            $table = Datatables::of($veterinarias);

            $table = $table->editColumn('direccion',function ($row){
                $direccion = "";
                if($row->calle)$direccion .= "Calle ".$row->calle;
                if($row->carrera){
                    if($row->calle) $direccion .= ' con';

                    $direccion .= " Carrera ".$row->carrera;
                }
                if($row->numero) $direccion .= " # ".$row->numero;
                $direccion .= " ".$row->barrio;
                return $direccion;
            })->editColumn('ubicacion',function ($row){
                return $row->ciudad.' - '.$row->departamento.' - '.$row->pais;
            })->editColumn('opciones',function ($row){
                $opciones = "";
                if (Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador)) {
                    if($row->estado == 'aprobada'){
                        $opciones .= "<a title='Editar' href='" . url('veterinaria/editar/' . $row->id) . "' class='btn btn-xs margin-2 btn-primary'><i class='fa fa-edit'></i></a>";
                        $opciones .= "<a title='Desactivar' href='#!' class='btn btn-xs margin-2 btn-danger btn-desactivar-veterinaria' data-veterinaria='".$row->id."'><i class='fa fa-chevron-down'></i></a>";
                    }else{
                        $opciones .= "<a title='Activar' href='#!' class='btn btn-xs margin-2 btn-primary btn-activar-veterinaria' data-veterinaria='".$row->id."'><i class='fa fa-chevron-up'></i></a>";
                    }
                }

                return $opciones;
            })->rawColumns(['opciones']);

            $table = $table->make(true);
            return $table;
        }
    }

    public function crear()
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear', $this->privilegio_superadministrador))
            return redirect('/');

        $roles = Rol::where('veterinarias','si')->pluck('nombre','id');
        return view('veterinaria.crear')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('roles',$roles);
    }

    public function guardar(RequestVeterinaria $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear', $this->privilegio_superadministrador))
            return response(['error'=>['La información enviada es incorrecta.']],422);

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

        $veterinaria  = new Veterinaria();
        DB::beginTransaction();

        $ubicacion_veterinaria = new Ubicacion();
        $ubicacion_veterinaria->ciudad_id = $request->input('ciudad_veterinaria');
        $ubicacion_veterinaria->barrio = $request->input('barrio_veterinaria');
        $ubicacion_veterinaria->calle = $request->input('calle_veterinaria');
        $ubicacion_veterinaria->carrera = $request->input('carrera_veterinaria');
        $ubicacion_veterinaria->transversal = $request->input('transversal_veterinaria');
        $ubicacion_veterinaria->numero = $request->input('numero_veterinaria');
        $ubicacion_veterinaria->especificaciones = $request->input('especificaciones_veterinaria');
        $ubicacion_veterinaria->save();

        $veterinaria->nit = $request->input('nit');
        $veterinaria->nombre = $request->input('nombre');
        $veterinaria->correo = $request->input('correo');
        $veterinaria->telefono = $request->input('telefono');
        $veterinaria->web_Site = $request->input('web_Site');
        $veterinaria->ubicacion_id = $ubicacion_veterinaria->id;
        $veterinaria->estado = 'aprobada';
        $veterinaria->token = '';
        $veterinaria->save();

        $ubicacion_administrador = new Ubicacion();
        $ubicacion_administrador->ciudad_id = $request->input('ciudad_administrador');
        $ubicacion_administrador->barrio = $request->input('barrio_administrador');
        $ubicacion_administrador->calle = $request->input('calle_administrador');
        $ubicacion_administrador->carrera = $request->input('carrera_administrador');
        $ubicacion_administrador->transversal = $request->input('transversal_administrador');
        $ubicacion_administrador->numero = $request->input('numero_administrador');
        $ubicacion_administrador->especificaciones = $request->input('especificaciones_administrador');
        $ubicacion_administrador->save();

        $rol = Rol::where('veterinarias','si')->find($request->input('rol'));
        if(!$rol)
            return response(['error'=>['La información enviada es incorrecta']],422);

        $administrador = new User();
        if($request->has('password')) {
            $administrador->password = Hash::make($request->input('password'));
            $create_password = false;
        }else{
            $create_password = true;
        }
        $administrador->ubicacion_id = $ubicacion_administrador->id;
        $administrador->tipo_identificacion = $request->input('tipo_identificacion');
        $administrador->identificacion = $request->input('identificacion');
        $administrador->nombres = $request->input('nombres');
        $administrador->apellidos = $request->input('apellidos');
        $administrador->email = $request->input('email');
        if($request->has('telefono_administrador'))
            $administrador->telefono = $request->input('telefono_administrador');

        $administrador->celular = $request->input('celular_administrador');
        $administrador->genero = $request->input('genero');
        $administrador->fecha_nacimiento = $request->input('fecha_nacimiento');
        $administrador->veterinaria_empleo_id = $veterinaria->id;
        $administrador->rol_id = $rol->id;

        if($create_password)
            $administrador->token = csrf_token();

        $administrador->save();

        $veterinaria->administrador_id = $administrador->id;
        //imagen del administrador
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_img_perfil_usuario').$administrador->id;
            $imagen->move(storage_path('app/'.$ruta), $nombre);

            $imagen_obj = new Imagen();
            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();
            $administrador->imagen_id = $imagen_obj->id;
        }
        $administrador->save();

        //imagen de la veterinaria
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $nombre = $logo->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_img_veterinarias').$veterinaria->id;
            $logo->move(storage_path('app/'.$ruta), $nombre);

            $logo_obj = new Imagen();
            $logo_obj->nombre = $nombre;
            $logo_obj->ubicacion = $ruta;
            $logo_obj->save();
            $veterinaria->imagen_id = $logo_obj->id;
        }
        $veterinaria->save();
        Correo::nuevaCuentaVeterinaria($veterinaria,$create_password,$request->input('password'));
        DB::commit();
        return ['success' => true];
    }

    public function editar($id)
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return redirect('/');

        $veterinaria = Veterinaria::where('veterinaria','si')->find($id);

        if(!$veterinaria || $veterinaria->estado == 'inactiva')
            return redirect('/');

        $roles = Rol::where('veterinarias','si')->pluck('nombre','id');
        return view('veterinaria.editar')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('roles',$roles)
            ->with('veterinaria',$veterinaria);
    }

    public function actualizar(RequestVeterinaria $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador) || !$request->has('veterinaria'))
            return response(['error'=>['La información enviada es incorrecta.']],422);

        $veterinaria  = Veterinaria::where('veterinaria','si')->find($request->input('veterinaria'));
        if (!$veterinaria || $veterinaria->estado == 'inactiva')
            return response(['error'=>['La información enviada es incorrecta.']],422);

        DB::beginTransaction();

        $ubicacion_veterinaria = $veterinaria->ubicacion;
        $ubicacion_veterinaria->ciudad_id = $request->input('ciudad_veterinaria');
        $ubicacion_veterinaria->barrio = $request->input('barrio_veterinaria');
        $ubicacion_veterinaria->calle = $request->input('calle_veterinaria');
        $ubicacion_veterinaria->carrera = $request->input('carrera_veterinaria');
        $ubicacion_veterinaria->transversal = $request->input('transversal_veterinaria');
        $ubicacion_veterinaria->numero = $request->input('numero_veterinaria');
        $ubicacion_veterinaria->especificaciones = $request->input('especificaciones_veterinaria');
        $ubicacion_veterinaria->save();

        $veterinaria->nit = $request->input('nit');
        $veterinaria->nombre = $request->input('nombre');
        $veterinaria->correo = $request->input('correo');
        $veterinaria->telefono = $request->input('telefono');
        $veterinaria->web_Site = $request->input('web_Site');
        $veterinaria->save();

        $administrador = $veterinaria->administrador;

        $ubicacion_administrador = $administrador->ubicacion;
        $ubicacion_administrador->ciudad_id = $request->input('ciudad_administrador');
        $ubicacion_administrador->barrio = $request->input('barrio_administrador');
        $ubicacion_administrador->calle = $request->input('calle_administrador');
        $ubicacion_administrador->carrera = $request->input('carrera_administrador');
        $ubicacion_administrador->transversal = $request->input('transversal_administrador');
        $ubicacion_administrador->numero = $request->input('numero_administrador');
        $ubicacion_administrador->especificaciones = $request->input('especificaciones_administrador');
        $ubicacion_administrador->save();

        $administrador->tipo_identificacion = $request->input('tipo_identificacion');
        $administrador->identificacion = $request->input('identificacion');
        $administrador->nombres = $request->input('nombres');
        $administrador->apellidos = $request->input('apellidos');
        $administrador->email = $request->input('email');
        $administrador->telefono = null;
        if($request->has('telefono_administrador'))
            $administrador->telefono = $request->input('telefono_administrador');
        $administrador->celular = $request->input('celular_administrador');
        $administrador->genero = $request->input('genero');
        $administrador->fecha_nacimiento = $request->input('fecha_nacimiento');
        $administrador->save();


        //imagen del administrador
        if ($request->hasFile('imagen')) {
            //se borra la anterior
            $img_anterior = $administrador->imagenPerfil;
            if($img_anterior){
                @ unlink(storage_path('app/'.$img_anterior->ubicacion.'/'.$img_anterior->nombre));
            }

            $imagen = $request->file('imagen');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_img_perfil_usuario') . $administrador->id;
            $imagen->move(storage_path('app/'.$ruta), $nombre);

            $imagen_obj = new Imagen();
            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();
            $administrador->imagen_id = $imagen_obj->id;
        }
        $administrador->save();

        //imagen de la veterinaria
        if ($request->hasFile('logo')) {

            $img_anterior = $veterinaria->imagen;
            if($img_anterior){
                @ unlink(storage_path('app/'.$img_anterior->ubicacion.'/'.$img_anterior->nombre));
            }
            $logo = $request->file('logo');
            $nombre = $logo->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_img_veterinarias') . $veterinaria->id;
            $logo->move(storage_path('app/'.$ruta), $nombre);

            $logo_obj = new Imagen();
            $logo_obj->nombre = $nombre;
            $logo_obj->ubicacion = $ruta;
            $logo_obj->save();
            $veterinaria->imagen_id = $logo_obj->id;
        }
        $veterinaria->save();
        DB::commit();
        return ['success' => true];
    }

    public function activar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador) || !$request->has('veterinaria'))
            return response(['error'=>['La información enviada es incorrecta.']],422);

        $veterinaria = Veterinaria::where('veterinaria','si')->find($request->input('veterinaria'));
        if($veterinaria){
            $veterinaria->estado = 'aprobada';
            $veterinaria->save();
            return ['success'=>true];
        }

        return response(['error'=>['La información enviada es incorrecta.']],422);
    }

    public function desactivar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador) || !$request->has('veterinaria'))
            return response(['error'=>['La información enviada es incorrecta.']],422);

        $veterinaria = Veterinaria::where('veterinaria','si')->find($request->input('veterinaria'));

        if($veterinaria){
            $veterinaria->estado = 'inactiva';
            $veterinaria->save();
            return ['success'=>true];
        }

        return response(['error'=>['La información enviada es incorrecta.']],422);
    }
}