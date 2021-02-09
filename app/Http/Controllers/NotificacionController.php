<?php

namespace DogCat\Http\Controllers;


use DogCat\Http\Requests\RequestRecordatorio;
use DogCat\Models\Notificacion;
use DogCat\Models\Recordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function lista(Request $request){
        $excluidos = [];
        if($request->has('notificaciones_cargadas') && is_array($request->notificaciones_cargadas))
            $excluidos = $request->notificaciones_cargadas;

        $notificaciones = Notificacion::permitidos()
            ->whereNotIn('notificaciones.id',$excluidos)
            ->orderBy('notificaciones.created_at','DESC')
            ->limit(5)
            ->get();

        $notificaciones_cargadas = array_merge($excluidos,$notificaciones->pluck('id')->toArray());
        $data = [
            'html'=>view('notificacion.lista_items')
            ->with('notificaciones',$notificaciones)->render(),
            'notificaciones_cargadas'=>$notificaciones_cargadas,
            'permitir_cargar_mas'=>count($notificaciones)>0?true:false
        ];
        return $data;
    }

}
