<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestNuevoEgreso;
use DogCat\Http\Requests\RequestNuevoIngreso;
use DogCat\Models\Afiliacion;
use DogCat\Models\Egreso;
use DogCat\Models\Imagen;
use DogCat\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\Facades\Datatables;

class FinanzasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('authSuperadmin');
    }

    /**s
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('finanzas.index');
    }

    public function listaIngresos(Request $request){
        $ingresos = Ingreso::select(
            'ingresos.*',
            DB::raw('CONCAT(users.nombres," ",users.apellidos) as usuario')
        );

        if($request->has('desde') && $request->desde){
            $ingresos = $ingresos->where('fecha','>=',$request->desde);
        }

        if($request->has('hasta') && $request->hasta){
            $ingresos = $ingresos->where('fecha','<=',$request->hasta);
        }

        if($request->has('fuente') && $request->fuente != 'todas'){
            $ingresos = $ingresos->where('fuente', $request->fuente);
        }

        if($request->has('medio_pago') && $request->medio_pago != 'todos'){
            $ingresos = $ingresos->where('medio_pago', $request->medio_pago);
        }

        $ingresos = $ingresos->join('users','ingresos.user_id','=','users.id')->get();

        $table = Datatables::of($ingresos);

        $table = $table->editColumn('evidencia',function ($row){
            if($row->imagen_id){
                return '<a href="'.url('/finanzas/evidencia-ingreso/'.$row->id).'" target="_blank" class="btn btn-circle btn-info"><i class="fas fa-file"></i></a>';
            }else{
                return 'Ingreso sin evidencia';
            }
            return '';
        })
            ->editColumn('detalle_fuente',function ($row){
            if($row->descripcion){
                return $row->descripcion;
            }else {
                if ($row->fuente == 'Afiliación') {
                    $afiliacion = Afiliacion::select('afiliaciones.consecutivo')
                        ->join('renovaciones', 'afiliaciones.id', '=', 'renovaciones.afiliacion_id')
                        ->join('pagos_renovaciones', 'renovaciones.id', '=', 'pagos_renovaciones.renovacion_id')
                        ->join('ingresos', 'pagos_renovaciones.ingreso_id', '=', 'ingresos.id')
                        ->where('ingresos.id', $row->id)->first();

                    return $afiliacion ? $afiliacion->consecutivo : '';
                } elseif ($row->fuente == 'Servicio') {
                    return $row->servicio->nombre;
                }
            }
        })->editColumn('valor',function ($row){
            return '$ '.number_format($row->valor,'0',',','.');
        })->rawColumns(['evidencia','detalle_fuente','valor']);

        $table = $table->make(true);
        return $table;
    }

    public function listaEgresos(Request $request){
        $egresos = Egreso::select(
            'egresos.*',
            DB::raw('CONCAT(users.nombres," ",users.apellidos) as usuario')
        );

        if($request->has('desde') && $request->desde){
            $egresos = $egresos->where('fecha','>=',$request->desde);
        }

        if($request->has('hasta') && $request->hasta){
            $egresos = $egresos->where('fecha','<=',$request->hasta);
        }

        if($request->has('tipo') && $request->tipo != 'todos'){
            $egresos = $egresos->where('tipo', $request->tipo);
        }

        $egresos = $egresos->join('users','egresos.user_id','=','users.id')->get();

        $table = Datatables::of($egresos);

        $table = $table->editColumn('evidencia',function ($row){
            if($row->imagen_id){
                return '<a href="'.url('/finanzas/evidencia-egreso/'.$row->id).'" target="_blank" class="btn btn-circle btn-info"><i class="fas fa-file"></i></a>';
            }else{
                return 'Egreso sin evidencia';
            }
           return '';
        })->editColumn('valor',function ($row){
            return '$ '.number_format($row->valor,'0',',','.');
        })->rawColumns(['evidencia','valor']);

        $table = $table->make(true);
        return $table;
    }

    public function nuevoEgreso(RequestNuevoEgreso $requestNuevoEgreso){
        $egreso = new Egreso();
        $egreso->fill($requestNuevoEgreso->all());
        $egreso->fecha = date('Y-m-d');
        $egreso->user_id = Auth::user()->id;
        $egreso->save();

        if($requestNuevoEgreso->hasFile('evidencia')){
            $evidencia = $requestNuevoEgreso->file('evidencia');
            $nombre = $evidencia->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_evidencias_egresos') . $egreso->id;
            $evidencia->move(storage_path('app/'.$ruta), $nombre);

            $evidencia_obj = new Imagen();
            $evidencia_obj->nombre = $nombre;
            $evidencia_obj->ubicacion = $ruta;
            $evidencia_obj->save();
            $egreso->imagen_id = $evidencia_obj->id;
            $egreso->save();
        }
    }

    public function evidenciaEgreso($id){
        $egreso = Egreso::find($id);

        if($egreso){
            $evidencia = $egreso->evidencia;
            if($evidencia){
                $path = storage_path('app/'.config('params.storage_evidencias_egresos'). $egreso->id);

                $path .= '/' . $evidencia->nombre;
                if (!File::exists($path)) abort(404);

                $file = File::get($path);
                $type = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            }
        }
        return redirect('/');
    }

    public function nuevoIngreso(RequestNuevoIngreso $request){
        $ingreso = new Ingreso();
        $ingreso->numero_factura = $request->numero_factura_ingreso;
        $ingreso->valor = $request->valor_ingreso;
        $ingreso->fuente = $request->fuente_ingreso;
        $ingreso->descripcion = $request->descripcion_ingreso;
        $ingreso->medio_pago = $request->medio_pago_ingreso;
        $ingreso->codigo_verificacion = $request->codigo_verificacion_ingreso;
        $ingreso->fecha = date('Y-m-d');
        $ingreso->user_id = Auth::user()->id;
        $ingreso->save();

        if($request->hasFile('evidencia_ingreso')){
            $evidencia = $request->file('evidencia_ingreso');
            $nombre = $evidencia->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $ruta = config('params.storage_evidencias_ingresos') . $ingreso->id;
            $evidencia->move(storage_path('app/'.$ruta), $nombre);

            $evidencia_obj = new Imagen();
            $evidencia_obj->nombre = $nombre;
            $evidencia_obj->ubicacion = $ruta;
            $evidencia_obj->save();
            $ingreso->imagen_id = $evidencia_obj->id;
            $ingreso->save();
        }
    }

    public function evidenciaIngreso($id){
        $ingreso = Ingreso::find($id);

        if($ingreso){
            $evidencia = $ingreso->evidencia;
            if($evidencia){
                $path = storage_path('app/'.config('params.storage_evidencias_ingresos'). $ingreso->id);

                $path .= '/' . $evidencia->nombre;
                if (!File::exists($path)) abort(404);

                $file = File::get($path);
                $type = File::mimeType($path);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            }
        }
        return redirect('/');
    }

    public function datosGraficaIngresosEgresosUtilidades(Request $request){
        $ingresos = [];
        $egresos = [];
        $tipo = 'Mes';
        $datos_grafica = [];
        //datos por año
        if($request->tipo_ingr_egre_util == 'anual'){
            $tipo = 'Año';
            $inicio = $request->inicio_anio_ingr_egre_util;
            $fin = $request->fin_anio_ingr_egre_util;
            if($inicio > $fin){
                return [
                    'success'=>false,
                    'mensaje'=>'Información incorrecta, el dato de inicio no puede ser mayor al dato de fin'
                ];
            }else{
                //calcula los datos año por año
                for($i = $inicio;$i <= $fin;$i++) {
                    $ingresos = Ingreso::select('ingresos.*')
                        ->where('ingresos.fecha', '>=', $i . '-01-01')
                        ->where('ingresos.fecha', '<=', $i . '-12-31')->get();

                    $egresos = Egreso::select('egresos.*')
                        ->where('egresos.fecha', '>=', $i . '-01-01')
                        ->where('egresos.fecha', '<=', $i . '-12-31')->get();

                    $valor_ingresos = 0;
                    if(count($ingresos)){
                        $valor_ingresos = $ingresos->sum('valor');
                    }

                    $valor_egresos = 0;
                    if(count($egresos)){
                        $valor_egresos = $egresos->sum('valor');
                    }

                    $datos_grafica[] = [
                        'fecha'=>$i,
                        'ingreso'=>$valor_ingresos,
                        'egreso'=>$valor_egresos,
                        'utilidad'=>$valor_ingresos-$valor_egresos
                    ];
                }
            }
        }else{
            $inicio = $request->inicio_mes_ingr_egre_util;
            $fin = $request->fin_mes_ingr_egre_util;
            $data_inicio = explode('-',$inicio);
            $data_fin = explode('-',$fin);
            $inicio_aux = intval($data_inicio[1].$data_inicio[0]);
            $fin_aux = intval($data_fin[1].$data_fin[0]);
            if($inicio_aux > $fin_aux){
                return [
                    'success'=>false,
                    'mensaje'=>'Información incorrecta, el dato de inicio no puede ser mayor al dato de fin'
                ];
            }else{
                $fecha_inicio = $data_inicio[1].'-'.$data_inicio[0].'-01';
                $fecha_fin = $data_fin[1].'-'.$data_fin[0].'-01';

                $continuar = true;
                while ($continuar){
                    //calcula el ultimo día del mes actual
                    $nueva_fecha_inicio = strtotime('+1 month',strtotime($fecha_inicio));
                    $ultimo_dia = strtotime('-1 day',$nueva_fecha_inicio);
                    $fecha_fin_aux = date('Y-m-d',$ultimo_dia);

                    $ingresos = Ingreso::select('ingresos.*')
                        ->where('ingresos.fecha', '>=', $fecha_inicio)
                        ->where('ingresos.fecha', '<=', $fecha_fin_aux)->get();

                    $egresos = Egreso::select('egresos.*')
                        ->where('egresos.fecha', '>=', $fecha_inicio)
                        ->where('egresos.fecha', '<=', $fecha_fin_aux)->get();

                    $valor_ingresos = 0;
                    if(count($ingresos)){
                        $valor_ingresos = $ingresos->sum('valor');
                    }

                    $valor_egresos = 0;
                    if(count($egresos)){
                        $valor_egresos = $egresos->sum('valor');
                    }

                    $datos_grafica[] = [
                        'fecha'=>date('m',strtotime($fecha_inicio)).' - '.date('Y',strtotime($fecha_inicio)),
                        'ingreso'=>$valor_ingresos,
                        'egreso'=>$valor_egresos,
                        'utilidad'=>$valor_ingresos-$valor_egresos
                    ];

                    if(date('Y-m-d',strtotime($fecha_inicio)) == date('Y-m-d',strtotime($fecha_fin))){
                        $continuar = false;
                    }else{
                        $fecha_inicio = date('Y-m-d',$nueva_fecha_inicio);
                    }
                }
            }
        }

        $datos_retorno = [
            'success'=>true,
            'tipo'=>$tipo,
            'datos_grafica'=>$datos_grafica
        ];

        return $datos_retorno;
    }
}