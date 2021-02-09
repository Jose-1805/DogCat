<?php

namespace DogCat\Http\Controllers;


use DogCat\Http\Requests\RequestRecordatorio;
use DogCat\Models\Recordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordatorioController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 17;
    const IDENTIFICADOR_MODULO = 17;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    public function crear(RequestRecordatorio $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $recordatorio = new Recordatorio();
        $recordatorio->mensaje = $request->mensaje;
        $recordatorio->fecha = $request->fecha_recordatorio;
        $recordatorio->hora = $request->hora.':'.$request->minuto;
        if($request->has('url_actual') && $request->url_actual == 'si'){
            $recordatorio->url = $_SERVER['HTTP_REFERER'];
        }else{
            if($request->has('url') && $request->url){
                $recordatorio->url = url('/').$request->url;
            }
        }
        $recordatorio->importancia = $request->importancia;
        $recordatorio->enviar_correo = 'no';
        if($request->has('enviar_correo') && $request->enviar_correo == 'si'){
            $recordatorio->enviar_correo = 'si';
        }

        $recordatorio->user_id = Auth::user()->id;

        $recordatorio->save();

        $recordatorio->users()->save(Auth::user());

        $html = view('recordatorio.lista_items')
            ->with('recordatorios',collect([$recordatorio]))->render();

        return ['success'=>true,'html'=>$html,'id'=>$recordatorio->id];
    }

    public function lista(Request $request){
        $excluidos = [];
        if($request->has('recordatorios_cargados') && is_array($request->recordatorios_cargados))
            $excluidos = $request->recordatorios_cargados;

        $recordatorios = Recordatorio::permitidos()
            ->whereNotIn('recordatorios.id',$excluidos)
            ->orderBy('recordatorios.fecha','DESC')
            ->orderBy('recordatorios.hora','DESC')
            ->limit(5)
            ->get();

        $recordatorios_cargados = array_merge($excluidos,$recordatorios->pluck('id')->toArray());
        $data = [
            'html'=>view('recordatorio.lista_items')
            ->with('recordatorios',$recordatorios)->render(),
            'recordatorios_cargados'=>$recordatorios_cargados,
            'permitir_cargar_mas'=>count($recordatorios)>0?true:false
        ];
        return $data;
    }

}
