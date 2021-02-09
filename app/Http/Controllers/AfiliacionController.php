<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestAfiliacion;
use DogCat\Models\Afiliacion;
use DogCat\Models\Correo;
use DogCat\Models\CuotaCredito;
use DogCat\Models\HistorialPrecioAfiliacion;
use DogCat\Models\HistorialPrecioFuneraria;
use DogCat\Models\Ingreso;
use DogCat\Models\Mascota;
use DogCat\Models\MascotaRenovacion;
use DogCat\Models\Notificacion;
use DogCat\Models\Renovacion;
use DogCat\Models\SolicitudAfiliacion;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class AfiliacionController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 13;
    public function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    public function index(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect('/');

        return view('afiliaciones.index')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function nueva($solicitud = null,$usuario = null){
        $solicitud_obj = null;
        $usuario_obj = null;
        if($solicitud && $solicitud != 'ignorar'){
            $solicitud_obj = SolicitudAfiliacion::permitidos()->where('solicitudes_afiliaciones.estado','procesada')
                ->whereNull('afiliacion_id')->find($solicitud);
            if(!$solicitud_obj)return redirect('/');

            $afiliacion_en_proceso = $solicitud_obj->usuario->afiliacionActivaOProceso();
            if($afiliacion_en_proceso) {
                session()->put('msj_danger', 'No es posible crear la afiliación debido a que se ha encontrado una afiliación en estado "' . $afiliacion_en_proceso->estado . '", la cual está relacionada con el usuario de la solicitud seleccionada');
                return redirect()->back();
            }

        }else{
            if($usuario){
                $usuario_obj = User::afiliados()->find($usuario);
                if(!$usuario_obj)return redirect('/');

                $afiliacion_en_proceso = $usuario_obj->afiliacionActivaOProceso();
                if($afiliacion_en_proceso) {
                    session()->put('msj_danger', 'No es posible crear la afiliación debido a que se ha encontrado una afiliación en estado "' . $afiliacion_en_proceso->estado . '", la cual está relacionada con el usuario de la solicitud seleccionada');
                    return redirect()->back();
                }
            }
        }


        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return redirect('/');

        $precios = HistorialPrecioAfiliacion::orderBy('created_at','DESC')->first();
        if(!$precios){
            session()->put('msj_danger','Para crear afiliaciones es necesario registrar en el sistema los precios de afiliación');
            return redirect()->back();
        }

        return view('afiliaciones.nueva')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('solicitud',$solicitud_obj)
            ->with('usuario',$usuario_obj);
    }

    public function listaMascotas(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return response(['errors'=>['Unauthorized.']],422);

        $usuario = User::afiliados()->find($request->input('usuario'));
        if($usuario){
            $mascotas = $usuario->mascotasValidadas();
            if(count($mascotas)) {
                return view('afiliaciones.lista_mascotas')->with('mascotas',$mascotas);
            }
        }
        return '<p class="alert alert-info text-center">No existen mascotas validadas para seleccionar</p>';
    }

    /**
     * Calcula el valor de una afiliaciòn segùn los parametros enviados
     * @return valor de la afiliaciòn
     */
    public function getValor(Request $request){

        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return response(['errors'=>['Unauthorized.']],401);

        return Afiliacion::getValorAfiliacion($request);
    }

    public function guardar(RequestAfiliacion $request){

        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return response(['errors'=>['Unauthorized.']],401);

        //si se va a registrar la afiliacion por medio de una solicitud del usuario
        if($request->has('solicitud')){
            $solicitud = SolicitudAfiliacion::permitidos()->where('solicitudes_afiliaciones.estado','procesada')
                ->whereNull('afiliacion_id')->find($request->input('solicitud'));
            if(!$solicitud)return response(['errors'=>['La información enviada es incorrecta, por favor recargue la página']],422);

            $usuario = $solicitud->usuario;
        }else{
            if(!$request->has('usuario'))return response(['errors'=>['El campo usuario es obligatorio.']]);

            $usuario = User::afiliados()->find($request->input('usuario'));
        }

        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'pagos',$this->privilegio_superadministrador)){
            if($request->estado == 'Pagada')
                return response(['errors'=>['La información enviada es incorrecta, recargue la página e intente nuevamente.']],422);
        }

        //si el usuario ya tiene una afiliacion en proceso
        $afiliacion_en_proceso = $usuario->afiliacionActivaOProceso();
        if($afiliacion_en_proceso)return response(['errors'=>['El usuario seleccionado ya tiene una afiliación activa o en proceso']],422);

        //mascotas del usuario
        $mascotas = $usuario->mascotasValidadas();

        if(!count($mascotas)) return response(['errors'=>['El usuario seleccionado no tiene mascotas registradas']],422);

        //identifica si se seleccionó una mascota
        $mascota_seleccionada = false;

        //guarda los id de la mascotas seleccionadas
        $mascotas_seleccionadas = [];

        //guarda en el kay el id de la mascota seleccionada y en el valor los valores para cada mascota
        $funerarias = [];

        foreach ($mascotas as $mascota){
            //si se ha seleccionado la mascota
            if($request->exists('mascota_'.$mascota->id)){
                $mascota_seleccionada = true;

                $mascotas_seleccionadas[] = $mascota->id;
                $funerarias[$mascota->id] = $request->input('funeraria_mascota_'.$mascota->id);
            }
        }

        if(!$mascota_seleccionada)
            return response(['errors'=>['Selecione por lo menos una mascota']],422);
        $valor_pagado = 0;
        $credito_activo = 'no';
        if($request->estado == 'Pagada') {
            $valor_pagado = Afiliacion::getValorAfiliacion($request);
            if($request->cantidad_pagos > 1)$credito_activo = 'si';
        }

        DB::beginTransaction();
        $afiliacion = new Afiliacion();
        $afiliacion->consecutivo = Afiliacion::siguienteConsecutivo();
        $afiliacion->estado = $request->estado;
        $afiliacion->fecha_diligenciamiento = date('Y-m-d');
        $afiliacion->user_id = $usuario->id;
        $afiliacion->user_creador_id = Auth::user()->id;
        $afiliacion->credito_activo = $credito_activo;
        $afiliacion->save();

        //si la afiliación proviene de una solicitud del usuario
        //se relaciona la solicitud con la afiliación creada
        if(isset($solicitud)){
            $solicitud->afiliacion_id = $afiliacion->id;
            $solicitud->save();
        }else{
            //todas las solicitudes que tenga el usuario en estado
            //'registrada', 'en proceso' o 'procesada', pasan a ser canceladas
            $sql = "UPDATE solicitudes_afiliaciones SET estado = 'cancelada' WHERE (estado = 'registrada' OR estado = 'en proceso' OR estado = 'procesada') AND user_id = ".$usuario->id;
            DB::statement($sql);
        }

        $precio_afiliacion = HistorialPrecioAfiliacion::ultimoHistorial();
        if(!$precio_afiliacion)
            return response(['errors'=>['No se han registrado precios de afiliación en el sistema']],422);

        $precio_funeraria = HistorialPrecioFuneraria::ultimoHistorial();
        if(!$precio_funeraria)
            return response(['errors'=>['No se han registrado precios de afiliación a funeraria en el sistema']],422);


        //se debe registrar como una renovación, aunque no lo sea
        $renovacion = new Renovacion();
        $renovacion->afiliacion_id = $afiliacion->id;
        $renovacion->historial_precio_afiliacion_id = $precio_afiliacion->id;
        $renovacion->historial_precio_funeraria_id = $precio_funeraria->id;
        $renovacion->user_id = Auth::user()->id;

        if($request->estado == 'Pagada') {
            $renovacion->cantidad_pagos = $request->cantidad_pagos;
            $valor_pagado = intval($valor_pagado/$request->cantidad_pagos);
            $renovacion->valor_pago = $valor_pagado;
        }
        $renovacion->save();

        //si es un credito se registran las cuotas
        if($request->estado == 'Pagada' && $renovacion->cantidad_pagos > 1) {
            for($i = 1;$i <= $renovacion->cantidad_pagos;$i++){
                $cuota_credito = new CuotaCredito();
                $cuota_credito->numero = $i;
                $cuota_credito->valor = $valor_pagado;
                $cuota_credito->estado = 'Pendiente de pago';
                if($i == 1){
                    $cuota_credito->estado = 'Pagada';
                    $cuota_credito->fecha_real_pago = date('Y-m-d');
                }
                $cuota_credito->fecha_pago = Renovacion::calcularFechaCuota($i,$request->dia_pagar);
                $cuota_credito->renovacion_id = $renovacion->id;
                $cuota_credito->user_id = Auth::user()->id;
                $cuota_credito->save();
            }
        }

        //relacionamos todas las mascotas con la renovación
        foreach($mascotas_seleccionadas as $id_mascota){
            $mascota_obj = Mascota::find($id_mascota);
            $relacion = new MascotaRenovacion();
            $relacion->consecutivo = MascotaRenovacion::siguienteConsecutivo();
            $relacion->mascota_id = $id_mascota;
            $relacion->renovacion_id = $renovacion->id;
            if($mascota_obj->patologias)
                $relacion->patologias = 'si';

            $anios = $mascota_obj->edad();
            $meses = $anios*12;
            //define si se debe calcular el valor para la funeraria
            $establecer_precio_funeraria = false;

            $tipo_funeraria = $request->input('funeraria_mascota_'.$id_mascota);
            $plan_funeraria = $request->input('plan_funeraria_mascota_'.$id_mascota);

            //si la mascota tiene mas de la edad permitida para previsión
            //o menos de la edad minima permitida para prevision
            //se analiza si se selecciono un tipo de funeraria
            if($anios > config('params.maxima_edad_prevision') || $meses < config('params.minima_edad_prevision')) {
                if($request->has('funeraria_mascota_'.$id_mascota)){
                    if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura'){
                        $establecer_precio_funeraria = true;
                    }
                }
                $plan_fun = 'Ahorrativo';
            }else{
                //si la mascota tiene menos de la edad permitida para previsión
                //se analiza si se selecciono un tipo de plan para funeraria
                if($request->has('plan_funeraria_mascota_'.$id_mascota)){
                    if($plan_funeraria == 'Ahorrativo' || $plan_funeraria == 'Previsión'){
                        if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura') {
                            $establecer_precio_funeraria = true;
                        }
                    }
                }
                $plan_fun = $plan_funeraria;
            }

            //si se debe aplicar funeraria
            if($establecer_precio_funeraria){
                $relacion->valor_funeraria = Afiliacion::valorFuneraria($mascota_obj,$funerarias[$id_mascota],$request->input('pagar_a_'.$id_mascota),$request->input('incluir_transporte_mascota_'.$id_mascota),$request->input('plan_funeraria_mascota_'.$id_mascota));
                $relacion->valor_comision = config('params.comision_asesor_funeraria');
                $relacion->funeraria = 'si';
                $relacion->plan_funeraria = $plan_fun;
                $relacion->transporte_funeraria = $request->input('incluir_transporte_mascota_'.$id_mascota)=='si'?'si':'no';
                $relacion->servicio_funerario = $funerarias[$id_mascota];
                $mascota_obj->cantidad_cuotas_funeraria = $request->input('pagar_a_'.$id_mascota);
                $mascota_obj->save();
            }
            $relacion->save();
        }

        //se registra el ingreso del pago, si se realizó
        if($request->estado == 'Pagada'){
            $ingreso = new Ingreso();
            $ingreso->numero_factura = $request->numero_factura;
            $ingreso->valor = $valor_pagado;
            $ingreso->fecha = date('Y-m-d');
            $ingreso->fuente = 'Afiliación';
            $ingreso->medio_pago = $request->input('medio_pago');
            $ingreso->user_id = Auth::user()->id;
            if($request->has('codigo_verificacion'))
                $ingreso->codigo_verificacion = $request->input('codigo_verificacion');
            $ingreso->save();

            $renovacion->ingresos()->save($ingreso);

            Correo::pagoDeAfiliacionExitoso($afiliacion,$ingreso);
        }


        if(!$usuario->asesor_asignado) {
            $usuario->asesor_asignado_id = Auth::user()->id;
            $usuario->save();
        }

        Notificacion::nuevaAfiliacion($afiliacion,Auth::user());
        DB::commit();

        if($request->input('estado') == 'Pendiente de pago')
            session()->put('msj_success','La afiliación ha sido registrada exitosamente y será activada al día siguiente de registrar el pago.');
        else if($request->input('estado') == 'Pagada')
            session()->put('msj_success','La afiliación ha sido registrada exitosamente y será activada el día de mañana.');
        return ['success'=>true];
    }

    public function lista(Request $request){
        $result = Afiliacion::permitidos()->select(
            'afiliaciones.*',
            'afiliaciones.created_at as fecha',
            DB::raw('CONCAT(users.nombres," ",users.apellidos) as usuario'),
            DB::raw('CONCAT(asesor.nombres," ",asesor.apellidos) as asesor'),
            'renovaciones.fecha_inicio','renovaciones.fecha_fin','ingresos.fecha as fecha_ultimo_pago','ingresos.valor'
        //al valor de la afiliacion de le suma el producto del valor adicional de cada mascota por
        // la cantidad de mascotas afiliadas menos 1 (la primera no se cobra como valor adicional)
        /*DB::raw('(
            valor_afiliacion + (valor_mascota_adicional *
             (
                (select COUNT(mascotas_renovaciones.id) from mascotas_renovaciones where mascotas_renovaciones.renovacion_id = renovaciones.id) - 1)
             )
        ) as valor
        ')*/
        )
            ->join('renovaciones','afiliaciones.id','=','renovaciones.afiliacion_id')
            ->leftJoin('pagos_renovaciones','renovaciones.id','=','pagos_renovaciones.renovacion_id')
            ->leftJoin('ingresos','pagos_renovaciones.ingreso_id','=','ingresos.id')
            ->join('users','afiliaciones.user_id','=','users.id')
            ->leftJoin('users as asesor','users.asesor_asignado_id','=','asesor.id')
            ->where(function($q){
                $q->whereRaw('renovaciones.id IN (select max(r.id) from renovaciones as r where r.afiliacion_id = afiliaciones.id)')
                    ->whereRaw('pagos_renovaciones.id IN (select max(p_r.id) from pagos_renovaciones as p_r where p_r.renovacion_id = pagos_renovaciones.renovacion_id)')
                    ->orWhereNull('pagos_renovaciones.id');
            })
            /*->whereRaw('renovaciones.id IN (select max(r.id) from renovaciones as r where r.afiliacion_id = afiliaciones.id)')
            ->whereRaw('pagos_renovaciones.id IN (select max(p_r.id) from pagos_renovaciones as p_r where p_r.renovacion_id = pagos_renovaciones.renovacion_id)')
            ->orWhereNull('pagos_renovaciones.id')*/
            ->get();

        $table = Datatables::of($result);

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador)) {
                if (($r->estado == 'Pendiente de pago' || $r->credito_activo == 'si') && Auth::user()->tieneFuncion($this->identificador_modulo,'pagos',$this->privilegio_superadministrador)) {
                    $opc .= '<a href="#!" class="btn btn-xs btn-success margin-2 btn-marcar-pagada" data-afiliacion="' . $r->id . '"  data-toggle="tooltip" data-placement="bottom" title="Registrar pago"><i class="white-text fas fa-dollar-sign fa-2x"></i></a>';
                }
                if ($r->estado == 'Activa') {
                    $opc .= '<a href="#!" class="btn btn-xs btn-danger margin-2 btn-cancelar-afiliacion" data-usuario="' . $r->id . '" data-toggle="tooltip" data-placement="bottom" title="Cancelar afiliación"><i class="white-text fas fa-times-circle"></i></a>';
                }

            }
            $opc .= '<a href="' . url('/afiliacion/ver') . '/' . $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Ver completo"><i class="white-text fa fa-chevron-right"></i></a>';

            return $opc;

        })
            ->editColumn('valor',function ($r){
                return '$ '.number_format($r->ultimaRenovacion()->getValor(),0,',','.');
            })
            ->editColumn('estado',function ($r){
                $estado = $r->estado;
                if($r->credito_activo == 'si'){
                    $estado .= ' con credito activo';
                }
                return $estado;
            })
            ->rawColumns(['opciones','estado']);

        if(!Auth::user()->tieneFunciones($this->identificador_modulo,['editar','pagos','ver'],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function formMarcarPagada(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'pagos',$this->privilegio_superadministrador))
            return response(['errors'=>['Unauthorized.']],401);

        $afiliacion = Afiliacion::pendientesDePago()->find($request->afiliacion);

        if($afiliacion){
            return view('afiliaciones.form_pagar')
                ->with('afiliacion',$afiliacion);
        }
    }

    public function marcarPagada(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'pagos',$this->privilegio_superadministrador))
            return response(['errors'=>['Unauthorized.']],401);

        $afiliacion = Afiliacion::pendientesDePago()->find($request->afiliacion);

        if(!$afiliacion)
            return response(['errors'=>['La información enviada es incorrecta.']],422);

        $renovacion = $afiliacion->ultimaRenovacion();

        $pagos_realizados = 0;
        $pagos_restantes = 0;
        $cuotas_pagadas = 1;

        if($afiliacion->estado == 'Pendiente de pago') {
            $meses = '';
            for($i = 1;$i <= config('params.meses_credito');$i++)$meses .= $i.',';
            $meses = trim($meses,',');

            $rules = [
                'cantidad_pagos' => 'required|in:'.$meses,
                'medio_pago' => 'required|in:Efectivo,Consignación,Transferencia',
                'codigo_verificacion' => 'required_if:medio_pago,Consignación,Transferencia',
                'numero_factura' => 'required',
                'dia_pagar'=>'in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31'
            ];
        }elseif($afiliacion->credito_activo == 'si' && ($afiliacion->estado == 'Pagada' || $afiliacion->estado == 'Activa')){
            $pagos_realizados = $renovacion->ingresos()->count();
            $pagos_restantes = $renovacion->cantidad_pagos - $pagos_realizados;
            $cantidad_pagos = [];
            for($i = 1;$i <= $pagos_restantes;$i++){
                $cantidad_pagos[] = $i;
            }
            $rules = [
                'cantidad_pagos_realizar' => 'required|in:'.implode(',',$cantidad_pagos),
                'medio_pago' => 'required|in:Efectivo,Consignación,Transferencia',
                'codigo_verificacion' => 'required_if:medio_pago,Consignación,Transferencia',
                'numero_factura' => 'required',
            ];
        }

        $messages = [
            'cantidad_pagos.required'=>'El campo crédito a es requerido.',
            'cantidad_pagos.in'=>'La información enviada es incorrecta.',
            'medio_pago.required'=>'El campo medio de pago es requerido.',
            'medio_pago.in'=>'EL campo medio de pago debe contener uno de estos valores (Efectivo,Consignación,Transferencia).',
            'codigo_verificacion.required_if'=>'El campo còdigo de verificación es requerido.',
            'numero_factura.required'=>'EL campo nº de factura es requerido.',
            'dia_pagar.in'=>'La información enviada es incorrecta.'
        ];

        Validator::make($request->all(),$rules,$messages)->validate();

        if($renovacion) {
            DB::beginTransaction();
            //mas de un pago es credito
            $estado_previo = $afiliacion->estado;
            if($estado_previo == 'Pendiente de pago' && $request->cantidad_pagos > 1)
                $afiliacion->credito_Activo = 'si';

            if($estado_previo != 'Activa')
                $afiliacion->estado = 'Pagada';

            $valor_pagado = 0;
            if($estado_previo == 'Pendiente de pago') {
                $renovacion->cantidad_pagos = $request->cantidad_pagos;
                $valor_pagado = $renovacion->getValor()/$request->cantidad_pagos;
                $renovacion->valor_pago = $valor_pagado;

                //si es un credito se registra el calendario de pado de las cuotas
                if($request->cantidad_pagos > 1){
                    for($i = 1;$i <= $request->cantidad_pagos;$i++){
                        $cuota_credito = new CuotaCredito();
                        $cuota_credito->numero = $i;
                        $cuota_credito->valor = $valor_pagado;
                        $cuota_credito->estado = 'Pendiente de pago';
                        //la primera cuota ya se a pagado
                        if($i == 1){
                            $cuota_credito->estado = 'Pagada';
                            $cuota_credito->fecha_real_pago = date('Y-m-d');
                        }
                        $cuota_credito->fecha_pago = Renovacion::calcularFechaCuota($i,$request->dia_pagar);
                        $cuota_credito->renovacion_id = $renovacion->id;
                        $cuota_credito->user_id = Auth::user()->id;
                        $cuota_credito->save();
                    }
                }

            }elseif ($afiliacion->credito_activo == 'si' && ($estado_previo == 'Pagada' || $estado_previo == 'Activa')){
                $valor_pagado = $renovacion->valor_pago*$request->cantidad_pagos_realizar;
                $cuotas_pagadas = $request->cantidad_pagos_realizar;
                //se pagan todas las cuotas
                if($pagos_restantes == $request->cantidad_pagos_realizar){
                    $afiliacion->credito_activo = 'no';
                }
                $cuotas = $renovacion->cuotasCreditos()
                    ->where('estado','Pendiente de pago')
                    ->orderBy('id','ASC')->limit($cuotas_pagadas)->get();

                foreach ($cuotas as $c_){
                    $c_->estado = 'Pagada';
                    $c_->fecha_real_pago = date('Y-m-d');
                    $c_->save();
                }
            }

            $ingreso = new Ingreso();
            $ingreso->numero_factura = $request->numero_factura;
            $ingreso->valor = $valor_pagado;
            $ingreso->fecha = date('Y-m-d');
            $ingreso->fuente = 'Afiliación';
            $ingreso->medio_pago = $request->input('medio_pago');
            $ingreso->user_id = Auth::user()->id;

            if($request->has('codigo_verificacion'))
                $ingreso->codigo_verificacion = $request->input('codigo_verificacion');

            $ingreso->save();
            $afiliacion->save();
            $renovacion->save();

            $renovacion->ingresos()->save($ingreso,['cuotas_pagadas'=>$cuotas_pagadas]);
            Correo::pagoDeAfiliacionExitoso($afiliacion,$ingreso);

            Notificacion::pagoAfiliacion($afiliacion,Auth::user());

            DB::commit();
            return ['success' => true];
        }

        return response(['errors'=>['La información enviada es incorrecta']],422);
    }

    public function ver($afiliacion){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect()->back();

        $afiliacion = Afiliacion::permitidos()->find($afiliacion);
        if(!$afiliacion)return redirect()->back();

        return view('afiliaciones.ver')->with('afiliacion',$afiliacion);
    }
}