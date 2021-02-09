<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestServicio;
use DogCat\Models\Ciudad;
use DogCat\Models\Correo;
use DogCat\Models\HistorialPrecioServicio;
use DogCat\Models\Imagen;
use DogCat\Models\Rol;
use DogCat\Models\Servicio;
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

class ServicioController extends Controller
{

    public $privilegio_superadministrador = true;
    protected $identificador_modulo = 14;

    function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    public function index(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect('/');

        return view('servicio/index')
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('identificador_modulo',$this->identificador_modulo);
    }

    public function crear(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return redirect('/');

        return view('servicio/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function guardar(RequestServicio $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        DB::beginTransaction();

        $servicio = new Servicio($request->all());
        if($request->has('entidad'))$servicio->veterinaria_id = $request->entidad;
        $servicio->user_id = Auth::user()->id;
        $servicio->aplicable_perros = 'no';
        $servicio->aplicable_gatos = 'no';
        if($request->has('aplicable_perros'))$servicio->aplicable_perros = 'si';
        if($request->has('aplicable_gatos'))$servicio->aplicable_gatos = 'si';
        $servicio->save();

        $histrorial_precio = new HistorialPrecioServicio($request->all());
        $histrorial_precio->servicio_id = $servicio->id;
        $histrorial_precio->user_id = Auth::user()->id;
        $histrorial_precio->save();


        DB::commit();
        return ['success' => true];
    }

    public function editar($id){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador))
            return redirect('/');

        $sub_sql = '(select historial_precios_servicios.id from historial_precios_servicios where historial_precios_servicios.servicio_id = '.$id.' order by id desc limit 1)';

        $servicio = Servicio::permitidos()->select(
            'servicios.*',
            'historial_precios_servicios.valor',
            'historial_precios_servicios.descuento'
        )
            ->leftJoin('historial_precios_servicios','servicios.id','=','historial_precios_servicios.servicio_id')
            ->where('servicios.id',$id)
            ->where(function ($q) use ($sub_sql){
                $q->where('historial_precios_servicios.id',DB::raw($sub_sql))
                    ->orWhereNull('historial_precios_servicios.id');
            })
            //->where('historial_precios_servicios.id',DB::raw($sub_sql))
            ->first();

        //dd($servicio);
        if(!$servicio)return redirect()->back();

        return view('servicio/editar')
            ->with('servicio',$servicio)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function actualizar(RequestServicio $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        $servicio = Servicio::find($request->servicio);
        if(!$servicio)return response(['error'=>['La información enviada es incorrecta']],422);

        $servicio->fill($request->all());
        $servicio->aplicable_perros = 'no';
        $servicio->aplicable_gatos = 'no';
        if($request->has('aplicable_perros'))$servicio->aplicable_perros = 'si';
        if($request->has('aplicable_gatos'))$servicio->aplicable_gatos = 'si';
        $servicio->save();

        //si es un superadmin puede editar precios
        if(Auth::user()->esSuperadministrador()){
            $ultimo_historial = $servicio->ultimoHistorialPrecioServicio();

            if(
                !$ultimo_historial ||
                ($ultimo_historial && ($ultimo_historial->largo_1_10 != $request->largo_1_10 ||
                $ultimo_historial->largo_10_25 != $request->largo_10_25 ||
                $ultimo_historial->largo_mayor_25 != $request->largo_mayor_25 ||
                $ultimo_historial->corto_1_10 != $request->corto_1_10 ||
                $ultimo_historial->corto_10_25 != $request->corto_10_25 ||
                $ultimo_historial->corto_mayor_25 != $request->corto_mayor_25 ||
                $ultimo_historial->descuento != $request->descuento))
            ){
                $historial = new HistorialPrecioServicio($request->all());
                $historial->servicio_id = $servicio->id;
                $historial->user_id = Auth::user()->id;
                $historial->save();
            }
        }

        DB::beginTransaction();
        DB::commit();
        return ['success'=>true];
    }

    public function lista(){

        $servicios = Servicio::permitidos()->select('servicios.*','veterinarias.nombre as entidad')
            ->leftJoin('veterinarias','servicios.veterinaria_id','=','veterinarias.id')->get();

        $table = Datatables::of($servicios);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador)) {
                if ($r->estado == 'Activo') {
                    $opc .= '<a href="' . url('/servicio/editar') . '/' . $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fas fa-edit"></i></a>';
                    $opc .= '<a href="#!" class="btn btn-xs btn-danger margin-2 btn-desactivar-servicio" data-servicio="' . $r->id . '"  data-toggle="tooltip" data-placement="bottom" title="Inactivar"><i class="white-text fa fa-chevron-down"></i></a>';
                }
                if ($r->estado == 'Inactivo')
                    $opc .= '<a href="#!" class="btn btn-xs btn-primary margin-2 btn-activar-servicio" data-servicio="' . $r->id . '" data-toggle="tooltip" data-placement="bottom" title="Activar"><i class="white-text fa fa-chevron-up"></i></a>';
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

        $servicio = Servicio::permitidos()->find($request->input('servicio'));
        if($servicio){
            $servicio->estado = 'Activo';
            $servicio->save();
            return ['success'=>true];
        }

        return response(['error'=>['La información enviada es incorrecta.']],422);
    }

    public function desactivar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return response(['error'=>['La información enviada es incorrecta.']],422);

        $servicio = Servicio::permitidos()->find($request->input('servicio'));

        if($servicio){
            $servicio->estado = 'Inactivo';
            $servicio->save();
            return ['success'=>true];
        }

        return response(['error'=>['La información enviada es incorrecta.']],422);
    }

    public function asignar(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'Asignar',$this->privilegio_superadministrador))
            return redirect('/');

        return view('servicio.asignar')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function vistaServicios(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'asignar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],422);

        $servicios = Servicio::propios()->orderBy('servicios.nombre')->get();

        return view('servicio.lista_servicios')->with('servicios',$servicios);
    }

    public function vistaUsuarios(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'asignar', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $servicio = null;
        if ($request->has('servicio'))
            $servicio = Servicio::propios()->find($request->input('servicio'));

        return view('servicio.lista_usuarios')
            ->with('usuarios', User::permitidos()->orderBy("nombres")->get())
            ->with('servicio', $servicio)
            ->with('identificador_modlo',$this->identificador_modulo)
            ->with('privilegio_superadministrador', $this->privilegio_superadministrador);
    }

    /**
     * Actualiza la relacion entre un servicio y un usuario seleccionada.
     */
    public function actualizarRelacion(Request $request)
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'asignar', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        if ($request->has('accion') && $request->has('usuario')) {
            $servicio = Servicio::propios()->find($request->input('servicio'));
            $usuario = User::permitidos()->find($request->input('usuario'));
            if ($servicio && $usuario) {
                if ($request->input('accion') == 'agregar') {
                    if (!$servicio->tieneUsuario($request->input('usuario'))) {
                        $servicio->usuarios()->save($usuario);
                    }
                    return ['success' => true];
                } else if ($request->input('accion') == 'eliminar') {
                    if ($servicio->tieneUsuario($request->input('usuario'))) {
                        $servicio->usuarios()->detach($usuario);
                    }
                    return ['success' => true];
                }
            }
        }
        return response(['error' => ['La información enviada es incorrecta']], 422);
    }
}
