<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestSolicitudAfiliacionHistorial;
use DogCat\Models\Afiliacion;
use DogCat\Models\CuotaCredito;
use DogCat\Models\Notificacion;
use DogCat\Models\Renovacion;
use DogCat\Models\SolicitudAfiliacion;
use DogCat\Models\SolicitudAfiliacionHistorial;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class CreditoAfiliacionController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 18;

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

        return view('credito_afiliacion/index')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function lista(){
        $creditos = Afiliacion::permitidos()
            ->select(
                'renovaciones.id as id',
                'afiliaciones.consecutivo as afiliacion',
                'afiliaciones.credito_activo',
                'afiliaciones.estado as estado_afiliacion',
                DB::raw('CONCAT(users.nombres," ",users.apellidos) as cliente'),
                'users.celular as telefono',
                DB::raw('renovaciones.valor_pago*renovaciones.cantidad_pagos as valor_credito'),
                'renovaciones.valor_pago as valor_cuota',
                'renovaciones.cantidad_pagos as cantidad_cuotas'
            )
            ->join('users','afiliaciones.user_id','=','users.id')
            ->join('renovaciones','afiliaciones.id','=','renovaciones.afiliacion_id')
            ->where('renovaciones.cantidad_pagos','>','1')
            ->get();

        $table = Datatables::of($creditos);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '<a href="' . url('/credito-afiliacion/cuotas') . '/' . $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Calendario de pagos"><i class="white-text fas fa-calendar-alt"></i></a>';

            return $opc;

        })->editColumn('estado_afiliacion',function ($r){
            $estado = $r->estado_afiliacion;
            if($r->credito_activo == 'si'){
                $estado .= ' con credito activo';
            }
            return $estado;
        })->editColumn('valor_credito',function ($r){
            return '$ '.number_format($r->valor_credito,0,',','.');
        })->editColumn('valor_cuota',function ($r){
            return '$ '.number_format($r->valor_cuota,0,',','.');
        })->rawColumns(['opciones']);

        $table = $table->setRowClass(function ($r) {
            if($r->credito_activo == 'no') return 'green lighten-4';
            if($r->credito_activo == 'si'){
                $cuotas = CuotaCredito::select('cuotas_creditos.id')
                    ->where('renovacion_id',$r->id)
                    ->where('fecha_pago','<',date('Y-m-d'))
                    ->where('estado','Pendiente de pago')
                    ->count();
                if($cuotas)
                    return 'red lighten-4';
            }
        });

        if(!Auth::user()->tieneFunciones($this->identificador_modulo,['ver'],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function cuotas($id){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return redirect('/');

        $afiliacion = Afiliacion::permitidos()
            ->select('afiliaciones.*')
            ->join('renovaciones','afiliaciones.id','=','renovaciones.afiliacion_id')
            ->where('renovaciones.id',$id)
            ->first();

        if($afiliacion){
            $cuotas = CuotaCredito::where('renovacion_id',$id)->get();

            return view('credito_afiliacion/cuotas')
                ->with('afiliacion',$afiliacion)
                ->with('cuotas',$cuotas);
        }
        return redirect('/');
    }
}
