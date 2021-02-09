<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestSolicitudAfiliacionHistorial;
use DogCat\Models\Notificacion;
use DogCat\Models\SolicitudAfiliacion;
use DogCat\Models\SolicitudAfiliacionHistorial;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class SolicitudAfiliacionController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 12;

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
        $solicitud_activa = Auth::user()->solicitudAfiliacionActiva();

        return view('solicitud_afiliacion/index')
            ->with('solicitud_activa',$solicitud_activa)
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function lista(){
        $solicitudes = SolicitudAfiliacion::permitidos()
            ->select('solicitudes_afiliaciones.*',
                DB::raw('CONCAT(users.nombres," ",users.apellidos) as usuario'),
                DB::raw('CONCAT(asesor.nombres," ",asesor.apellidos) as asesor_asignado')
            )
            ->leftJoin('users as asesor','users.asesor_asignado_id','=','asesor.id')
            ->get();

        $table = Datatables::of($solicitudes);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';

            if(Auth::user()->tieneFuncion($this->identificador_modulo,'asignar',$this->privilegio_superadministrador) && ($r->estado == 'registrada' || $r->estado == 'en proceso')){
                $opc .= '<a data-solicitud="'.$r->id.'" class="btn btn-xs btn-success margin-2 btn-asignar-solicitud" data-toggle="tooltip" data-placement="bottom" title="Asignar"><i class="white-text fa fa-user"></i></a>';
            }

            if(Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/solicitud-afiliacion/historial') . '/' . $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Historial"><i class="white-text fa fa-history"></i></a>';
            }

            if($r->estado == 'procesada' && !$r->afiliacion_id && Auth::user()->getTipoUsuario() == 'personal dogcat'){
                $opc .= '<a href="' . url('/afiliacion/nueva') . '/' . $r->id . '" class="btn btn-xs btn-success margin-2" data-toggle="tooltip" data-placement="bottom" title="Crear afiliación"><i class="white-text fa-3x fa fa-clipboard-list"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        $table = $table->setRowClass(function ($r) {
            if($r->estado == 'procesada') return 'green lighten-5';
            if($r->estado == 'descartada') return 'red lighten-5';
        });
        if(!Auth::user()->tieneFunciones($this->identificador_modulo,['ver'],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function enviar(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear', $this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $solicitud_activa = Auth::user()->solicitudAfiliacionActiva();
        if(!$solicitud_activa && !Auth::user()->afiliacionActivaOProceso() && (Auth::user()->getTipoUsuario() == "afiliado" || Auth::user()->getTipoUsuario() == "registro")){
            $solicitud = new SolicitudAfiliacion();
            $solicitud->user_id = Auth::user()->id;
            $solicitud->save();

            Notificacion::solicitudAfiliacion($solicitud);
        }
        return ['success'=>true];
    }

    public function historial($id){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return redirect()->back();
        $solicitud = SolicitudAfiliacion::permitidos()->find($id);
        if($solicitud){
            $user = $solicitud->usuario;

            return view('solicitud_afiliacion/historial')
                ->with('solicitud',$solicitud)
                ->with('user',$user)
                ->with('identificador_modulo',$this->identificador_modulo)
                ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
        }
        return redirect()->back();
    }

    public function listaHistorial(Request $request)
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $solicitud = SolicitudAfiliacion::permitidos()->find($request->input('id'));
        if ($solicitud) {
            $historial = $solicitud->historialSolicitudAfiliacion()->orderBy('created_at', 'DESC')->get();
            return view('solicitud_afiliacion.lista_historial')->with('historial',$historial);
        }

    }

    public function storeHistorial(RequestSolicitudAfiliacionHistorial $request){
        if(Auth::user()->tieneFuncion($this->identificador_modulo,'historial',$this->privilegio_superadministrador)) {

            if($request->has('solicitud')) {
                $solicitud = SolicitudAfiliacion::permitidos()->find($request->input('solicitud'));
                if($solicitud && $solicitud->estado != 'procesada'&& $solicitud->estado != 'cancelada') {
                    //despues de cambiado el estado a registrado no es posible marcarlo como registrado nuevamente
                    if($solicitud->estado != 'registrada' && $request->input('estado') == 'registrada')
                        return response(['error'=>['La información enviada es incorrecta']],422);

                    $historial = new SolicitudAfiliacionHistorial();
                    $historial->estado_nuevo = $request->input('estado');
                    $historial->estado_anterior = $solicitud->estado;
                    $historial->observaciones = $request->input('observaciones');
                    $historial->solicitud_afiliacion_id = $solicitud->id;
                    $historial->user_id = Auth::user()->id;
                    $historial->save();
                    $solicitud->estado = $historial->estado_nuevo;
                    $solicitud->save();
                    return ['success' => true];

                }
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }


    public function asignar(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'asignar', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $usuario = User::permitidos()->where('users.estado','activo')->find($request->usuario);
        $solicitud = SolicitudAfiliacion::permitidos()
            ->where(function ($q){
                $q->where('solicitudes_afiliaciones.estado','registrada')
                    ->orWhere('solicitudes_afiliaciones.estado','en proceso');
            })
            ->find($request->solicitud);

        if($usuario && $solicitud){
            $user = $solicitud->usuario;
            $user->asesor_asignado_id = $usuario->id;
            $user->save();
            return ['success'=>true];
        }
        return response(['errors'=>['La información enviada es incorrecta']],422);
    }
}
