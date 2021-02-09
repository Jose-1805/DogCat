<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Afiliacion extends Model
{
    protected $table = "afiliaciones";

    protected $fillable = [
    ];

    public static function permitidos(){
        if(Auth::user()->esSuperadministrador()){
            return Afiliacion::whereNotNull('afiliaciones.id');
        }else if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            return Afiliacion::select('afiliaciones.*')
                ->join('users as afiliado','afiliaciones.user_id','=','afiliado.id')
                ->where('afiliado.asesor_asignado_id',Auth::user()->id);
        }else{
            return Afiliacion::where('afiliaciones.user_id',Auth::user()->id);
        }
    }

    function userAfiliado(){
        return $this->belongsTo(User::class,'user_id');
    }


    /**
     * Función encargada de calcular el costo de afiliaciòn de una mascota al servicio de funerarìa
     *
     * @param $mascota => Objeto de la mascota a calcular
     * @param $tipo => Define el tipo de servicio (cremación o sepultura)
     * @param $cubrimiento_total => Define si se debe obligar a hacer un calculo para la afiliación total
     * o se debe calcular el porcentaje de cubrimiento de acuerdo a los parametros de la mascota
     */
    public static function valorFuneraria ($mascota,$tipo,$anios_de_pago,$incluir_transporte,$plan){
        $precios_funeraria = HistorialPrecioFuneraria::ultimoHistorial();
        $raza = $mascota->raza;
        $tipo_mascota = $raza->tipoMascota;
        $valor_global = 0;

        $anios = $mascota->edad();
        $meses = $anios * 12;

        if($anios > config('params.maxima_edad_prevision') || $meses < config('params.minima_edad_prevision')) {
            //se determina el valor global segun el tamaño, tipo de mascota y tipo de servicio
            if ($tipo_mascota->nombre == 'Gato') {
                //los gatos tienen siempre el valor de la mascota pequeña
                if ($tipo == 'cremación') {
                    //se determina el valor de acuerdo si se solicita o no el transport
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                    else
                        $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                } elseif ($tipo == 'sepultura') {
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                    else
                        $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                }
            } elseif ($tipo_mascota->nombre == 'Perro') {
                if ($tipo == 'cremación') {
                    switch ($raza->tamanio) {
                        case 'Pequeño':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                            else
                                $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                            break;
                        case 'Mediano':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_medianos;
                            else
                                $valor_global = $precios_funeraria->cremacion_medianos_sin_transporte;
                            break;
                        case 'Grande':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_grandes;
                            else
                                $valor_global = $precios_funeraria->cremacion_grandes_sin_transporte;
                            break;
                        case 'Gigante':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_gigantes;
                            else
                                $valor_global = $precios_funeraria->cremacion_gigantes_sin_transporte;
                            break;
                    }
                } elseif ($tipo == 'sepultura') {

                    switch ($raza->tamanio) {
                        case 'Pequeño':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                            else
                                $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                            break;
                        case 'Mediano':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_medianos;
                            else
                                $valor_global = $precios_funeraria->sepultura_medianos_sin_transporte;
                            break;
                        case 'Grande':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_grandes;
                            else
                                $valor_global = $precios_funeraria->sepultura_grandes_sin_transporte;
                            break;
                        case 'Gigante':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_gigantes;
                            else
                                $valor_global = $precios_funeraria->sepultura_gigantes_sin_transporte;
                            break;
                    }
                }
            }
        }else{
            if($plan == 'Previsión') {
                if ($tipo == 'cremación') {
                    //se determina el valor de acuerdo si se solicita o no el transport
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->prevision;
                    else
                        $valor_global = $precios_funeraria->prevision_sin_transporte;
                } elseif ($tipo == 'sepultura') {
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->prevision_sepultura;
                    else
                        $valor_global = $precios_funeraria->prevision_sepultura_sin_transporte;
                }
            }elseif ($plan == 'Ahorrativo'){
                if ($tipo_mascota->nombre == 'Gato') {
                    //los gatos tienen siempre el valor de la mascota pequeña
                    if ($tipo == 'cremación') {
                        //se determina el valor de acuerdo si se solicita o no el transport
                        if ($incluir_transporte == 'si')
                            $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                        else
                            $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                    } elseif ($tipo == 'sepultura') {
                        if ($incluir_transporte == 'si')
                            $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                        else
                            $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                    }
                } elseif ($tipo_mascota->nombre == 'Perro') {
                    if ($tipo == 'cremación') {
                        switch ($raza->tamanio) {
                            case 'Pequeño':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                                else
                                    $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                                break;
                            case 'Mediano':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_medianos;
                                else
                                    $valor_global = $precios_funeraria->cremacion_medianos_sin_transporte;
                                break;
                            case 'Grande':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_grandes;
                                else
                                    $valor_global = $precios_funeraria->cremacion_grandes_sin_transporte;
                                break;
                            case 'Gigante':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_gigantes;
                                else
                                    $valor_global = $precios_funeraria->cremacion_gigantes_sin_transporte;
                                break;
                        }
                    } elseif ($tipo == 'sepultura') {

                        switch ($raza->tamanio) {
                            case 'Pequeño':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                                else
                                    $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                                break;
                            case 'Mediano':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_medianos;
                                else
                                    $valor_global = $precios_funeraria->sepultura_medianos_sin_transporte;
                                break;
                            case 'Grande':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_grandes;
                                else
                                    $valor_global = $precios_funeraria->sepultura_grandes_sin_transporte;
                                break;
                            case 'Gigante':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_gigantes;
                                else
                                    $valor_global = $precios_funeraria->sepultura_gigantes_sin_transporte;
                                break;
                        }
                    }
                }
            }
        }


        $valor_pago = $valor_global;
        //si se paga a mas de un año se cobran los intereses establecdos en la DB
        if($anios_de_pago > 1) {
            $valor_pago = round(($valor_global / $anios_de_pago));
            $valor_pago = round($valor_pago + (($valor_pago * $precios_funeraria->interes) / 100));
        }
        return $valor_pago;
    }

    public static function pendientesDePago(){
        return Afiliacion::where('estado','Pendiente de pago')
            ->orWhere('afiliaciones.credito_activo','si');
    }

    public function renovaciones(){
        return $this->hasMany(Renovacion::class,'afiliacion_id');
    }

    public function ultimaRenovacion(){
        return $this->renovaciones()->orderBy('created_at','DESC')->first();
    }

    public static function getValorAfiliacion(Request $request){
        //define si se debe consultar las mascotas seleccionadas para calcular el valor de afiliaciòn
        $consultar_mascotas = false;

        //si se va a registrar la afiliacion por medio de una solicitud del usuario
        if($request->has('solicitud')){
            $solicitud = SolicitudAfiliacion::where('estado','procesada')
                ->whereNull('afiliacion_id')->find($request->input('solicitud'));
            if(!$solicitud)return response(['errors'=>['La información enviada es incorrecta, por favor recargue la página']],422);

            $usuario = $solicitud->usuario;
            $consultar_mascotas = true;
        }else{
            if($request->has('usuario')) {
                $usuario = User::afiliados()->find($request->input('usuario'));
                $consultar_mascotas = true;
            }
        }

        $precio_afiliacion = HistorialPrecioAfiliacion::ultimoHistorial();
        if(!$precio_afiliacion)
            return response(['errors'=>['No se han registrado precios de afiliación en el sistema']],422);

        $valor_afiliacion = $precio_afiliacion->valor_afiliacion;

        if($consultar_mascotas){
            //mascotas del usuario
            $mascotas = $usuario->mascotasValidadas();
            $mascotas_seleccionadas = [];
            $mascotas_seleccionadas_obj = [];
            if(count($mascotas)){
                foreach ($mascotas as $mascota){
                    if($request->exists('mascota_'.$mascota->id)){
                        if(!array_key_exists($mascota->id,$mascotas_seleccionadas)){
                            $mascotas_seleccionadas[$mascota->id] = $mascota->id;
                            $mascotas_seleccionadas_obj[$mascota->id] = $mascota;
                        }
                    }
                }
            }

            //se agrega el valor adicional por mascota seleccionada
            if(count($mascotas_seleccionadas) > $precio_afiliacion->cantidad_mascotas_afiliacion){
                $valor_afiliacion += (count($mascotas_seleccionadas) - $precio_afiliacion->cantidad_mascotas_afiliacion) * $precio_afiliacion->mascota_adicional;
            }

            foreach($mascotas_seleccionadas as $key => $value){
                $mascota_obj = $mascotas_seleccionadas_obj[$key];

                $anios = $mascota_obj->edad();
                $meses = $anios*12;
                //define si se debe calcular el valor para la funeraria
                $establecer_precio_funeraria = false;

                $tipo_funeraria = $request->input('funeraria_mascota_'.$key);
                $plan_funeraria = $request->input('plan_funeraria_mascota_'.$key);

                //si la mascota tiene mas de la edad permitida para previsión
                //o menos de la edad minima permitida para prevision
                //se analiza si se selecciono un tipo de funeraria
                if($anios > config('params.maxima_edad_prevision') || $meses < config('params.minima_edad_prevision')) {
                    if($request->has('funeraria_mascota_'.$key)){
                        if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura'){
                            $establecer_precio_funeraria = true;
                        }
                    }
                }else{
                    //si la mascota tiene menos de la edad permitida para previsión
                    //se analiza si se selecciono un tipo de plan para funeraria
                    if($request->has('plan_funeraria_mascota_'.$key)){
                        if($plan_funeraria == 'Ahorrativo' || $plan_funeraria == 'Previsión'){
                            if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura') {
                                $establecer_precio_funeraria = true;
                            }
                        }
                    }
                }

                if($establecer_precio_funeraria) {
                    $anios_pagar = 1;
                    if ($request->input('pagar_a_' . $key)) $anios_pagar = $request->input('pagar_a_' . $key);

                    $valor_afiliacion += self::valorFuneraria($mascotas->find($key), $tipo_funeraria, $anios_pagar, $request->input('incluir_transporte_mascota_' . $key), $plan_funeraria);

                    //si se debe pagar impuesto para pago a asesor
                    if ($usuario->impuestoAsesor()) {
                        $valor_afiliacion += config('params.comision_asesor_funeraria');
                    }
                }
            }
        }

        if($request->has('format'))
            return number_format($valor_afiliacion,'0',',','.');
        return $valor_afiliacion;
    }

    /**
     * Determina el siguiente consecutivo para asignar a una afiliacion
     */
    public static function siguienteConsecutivo(){
        $consecutivo = '100001';
        $ultima_afiliacion = Afiliacion::orderBy('consecutivo','DESC')->first();
        if($ultima_afiliacion){
            $consecutivo = intval($ultima_afiliacion->consecutivo)+1;
        }
        return $consecutivo;

    }

    /**
     * Calcula el valor de una afiliación con los datos enviados desde el simulador
     *
     * @param Request $request
     * @return float|int|mixed
     */
    public static function getValorAfiliacionSimulador(Request $request){
        $precio_afiliacion = HistorialPrecioAfiliacion::ultimoHistorial();
        if(!$precio_afiliacion)
            return response(['errors'=>['No se han registrado precios de afiliación en el sistema']],422);

        $valor_afiliacion = $precio_afiliacion->valor_afiliacion;

        $mascotas_seleccionadas = [];

        $indice_mascota = 1;
        $continuar = true;

        while ($continuar){
            if($request->has('fecha_nacimiento_mascota_'.$indice_mascota)){
                $mascotas_seleccionadas[] = [
                  'raza'=>$request->input('raza_mascota_'.$indice_mascota),
                  'fecha_nacimiento'=>$request->input('fecha_nacimiento_mascota_'.$indice_mascota),
                  'plan_funeraria'=>$request->input('plan_funeraria_mascota_'.$indice_mascota),
                  'funeraria'=>$request->input('funeraria_mascota_'.$indice_mascota),
                  'incluir_transporte'=>$request->input('incluir_transporte_mascota_'.$indice_mascota),
                  'pagar_a'=>$request->input('pagar_a_'.$indice_mascota),
                ];
                $indice_mascota++;
            }else{
                $continuar = false;
            }
        }

        //se agrega el valor adicional por mascota seleccionada
        if(count($mascotas_seleccionadas) > $precio_afiliacion->cantidad_mascotas_afiliacion){
            $valor_afiliacion += (count($mascotas_seleccionadas) - $precio_afiliacion->cantidad_mascotas_afiliacion) * $precio_afiliacion->mascota_adicional;
        }

        foreach($mascotas_seleccionadas as $key => $mascota){
            $fecha_nacimiento = strtotime($mascota['fecha_nacimiento']);
            $hoy = strtotime(date('Y-m-d'));
            $meses = ((($hoy - $fecha_nacimiento)/86400)/30.5);

            $anios = $meses/12;

            //define si se debe calcular el valor para la funeraria
            $establecer_precio_funeraria = false;

            $tipo_funeraria = $mascota['funeraria'];
            $plan_funeraria = $mascota['plan_funeraria'];

            //si la mascota tiene mas de la edad permitida para previsión
            //o menos de la edad minima permitida para prevision
            //se analiza si se selecciono un tipo de funeraria
            if($anios > config('params.maxima_edad_prevision') || $meses < config('params.minima_edad_prevision')) {
                if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura'){
                    $establecer_precio_funeraria = true;
                }
            }else{
                //si la mascota tiene menos de la edad permitida para previsión
                //se analiza si se selecciono un tipo de plan para funeraria
                if($plan_funeraria == 'Ahorrativo' || $plan_funeraria == 'Previsión'){
                    if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura') {
                        $establecer_precio_funeraria = true;
                    }
                }
            }

            if($establecer_precio_funeraria) {
                $anios_pagar = 1;
                if ($mascota['pagar_a']) $anios_pagar = $mascota['pagar_a'];

                $valor_afiliacion += self::valorFunerariaSimulador($mascota['raza'], $tipo_funeraria, $anios_pagar, $mascota['incluir_transporte'], $plan_funeraria,$mascota['fecha_nacimiento']);

                //Impuesto para pago a asesor
                $valor_afiliacion += config('params.comision_asesor_funeraria');
            }
        }

        if($request->has('format'))
            return number_format($valor_afiliacion,'0',',','.');

        return $valor_afiliacion;
    }

    public static function getDetalleAfiliacionSimulador(Request $request){
        $precio_afiliacion = HistorialPrecioAfiliacion::ultimoHistorial();
        if(!$precio_afiliacion)
            return response(['errors'=>['No se han registrado precios de afiliación en el sistema']],422);

        $valor_afiliacion = $precio_afiliacion->valor_afiliacion;

        $mascotas_seleccionadas = [];
        $detalle_afiliacion = [];

        $indice_mascota = 1;
        $continuar = true;

        while ($continuar){
            if($request->has('fecha_nacimiento_mascota_'.$indice_mascota)){
                $mascotas_seleccionadas[] = [
                    'nombre'=>$request->input('nombre_'.$indice_mascota),
                    'raza'=>$request->input('raza_mascota_'.$indice_mascota),
                    'fecha_nacimiento'=>$request->input('fecha_nacimiento_mascota_'.$indice_mascota),
                    'plan_funeraria'=>$request->input('plan_funeraria_mascota_'.$indice_mascota),
                    'funeraria'=>$request->input('funeraria_mascota_'.$indice_mascota),
                    'incluir_transporte'=>$request->input('incluir_transporte_mascota_'.$indice_mascota),
                    'pagar_a'=>$request->input('pagar_a_'.$indice_mascota),
                ];
                $indice_mascota++;
            }else{
                $continuar = false;
            }
        }

        //se agrega el valor adicional por mascota seleccionada
        if(count($mascotas_seleccionadas) > $precio_afiliacion->cantidad_mascotas_afiliacion){
            $valor_afiliacion += (count($mascotas_seleccionadas) - $precio_afiliacion->cantidad_mascotas_afiliacion) * $precio_afiliacion->mascota_adicional;
        }

        $detalle_afiliacion['valor_afiliacion'] = $valor_afiliacion;
        $detalle_mascotas = [];
        foreach($mascotas_seleccionadas as $key => $mascota){
            $fecha_nacimiento = strtotime($mascota['fecha_nacimiento']);
            $hoy = strtotime(date('Y-m-d'));
            $meses = ((($hoy - $fecha_nacimiento)/86400)/30.5);

            $anios = $meses/12;
            //define si se debe calcular el valor para la funeraria
            $establecer_precio_funeraria = false;

            $tipo_funeraria = $mascota['funeraria'];
            $plan_funeraria = $mascota['plan_funeraria'];

            //si la mascota tiene mas de la edad permitida para previsión
            //o menos de la edad minima permitida para prevision
            //se analiza si se selecciono un tipo de funeraria
            if($anios > config('params.maxima_edad_prevision') || $meses < config('params.minima_edad_prevision')) {
                if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura'){
                    $establecer_precio_funeraria = true;
                }
            }else{
                //si la mascota tiene menos de la edad permitida para previsión
                //se analiza si se selecciono un tipo de plan para funeraria
                if($plan_funeraria == 'Ahorrativo' || $plan_funeraria == 'Previsión'){
                    if($tipo_funeraria == 'cremación' || $tipo_funeraria == 'sepultura') {
                        $establecer_precio_funeraria = true;
                    }
                }
            }

            $valor_funeraria = 0;
            if($establecer_precio_funeraria) {
                $anios_pagar = 1;
                if ($mascota['pagar_a']) $anios_pagar = $mascota['pagar_a'];

                $valor_funeraria += self::valorFunerariaSimulador($mascota['raza'], $tipo_funeraria, $anios_pagar, $mascota['incluir_transporte'], $plan_funeraria,$mascota['fecha_nacimiento']);

                //Impuesto para pago a asesor
                $valor_funeraria += config('params.comision_asesor_funeraria');
            }

            $raza = Raza::find($mascota['raza']);

            $meses = $anios-intval($anios);
            $meses = $meses * 12;
            $dias = $meses - intval($meses);
            $dias = ($dias * 30.5);
            $edad = intval($anios)?(intval($anios)==1?intval($anios).' año ':intval($anios).' años '):'';
            $edad .= intval($meses)?(intval($meses)==1?intval($meses).' mes ':intval($meses).' meses '):'';
            $edad .= intval($dias)?(intval($dias)==1?intval($dias).' día ':intval($dias).' días '):'';
            $edad = trim($edad);

            $detalle_mascotas[] = [
                'nombre'=>$mascota['nombre'],
                'raza'=>'('.$raza->tipoMascota->nombre.') '.$raza->nombre,
                'edad'=>$edad,
                'valor_funeraria'=>$valor_funeraria,
                'funeraria'=>$establecer_precio_funeraria?'si':'no',
                'plan_funerario'=>$establecer_precio_funeraria?($plan_funeraria?$plan_funeraria:'Ahorrativo'):'',
                'servicio_funerario'=>$establecer_precio_funeraria?$tipo_funeraria:'',
                'incluir_transporte_funeraria'=>$establecer_precio_funeraria?($mascota['incluir_transporte']?$mascota['incluir_transporte']:'no'):'',
                'pago_funeraria_a'=>$establecer_precio_funeraria?($mascota['pagar_a']?$mascota['pagar_a'].' año(s)':''):''
            ];
        }

        $detalle_afiliacion['mascotas'] = $detalle_mascotas;

        return $detalle_afiliacion;
    }

    /**
     * Función encargada de calcular el costo de afiliaciòn de una mascota al servicio de funerarìa
     * con datos enviados por el simulador de afiliaciones
     *
     * @param $raza => Objeto de la raza de la mascota a calcular
     * @param $tipo => Define el tipo de servicio (cremación o sepultura)
     * @param $cubrimiento_total => Define si se debe obligar a hacer un calculo para la afiliación total
     * o se debe calcular el porcentaje de cubrimiento de acuerdo a los parametros de la mascota
     */
    public static function valorFunerariaSimulador ($raza,$tipo,$anios_de_pago,$incluir_transporte,$plan,$fecha_nacimiento){
        $precios_funeraria = HistorialPrecioFuneraria::ultimoHistorial();
        $raza = Raza::find($raza);
        $tipo_mascota = $raza->tipoMascota;
        $valor_global = 0;

        $fecha_nacimiento = strtotime($fecha_nacimiento);
        $hoy = strtotime(date('Y-m-d'));
        $meses = ((($hoy - $fecha_nacimiento)/86400)/30.5);

        $anios = $meses/12;

        if($anios > config('params.maxima_edad_prevision') || $meses < config('params.minima_edad_prevision')) {
            //se determina el valor global segun el tamaño, tipo de mascota y tipo de servicio
            if ($tipo_mascota->nombre == 'Gato') {
                //los gatos tienen siempre el valor de la mascota pequeña
                if ($tipo == 'cremación') {
                    //se determina el valor de acuerdo si se solicita o no el transport
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                    else
                        $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                } elseif ($tipo == 'sepultura') {
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                    else
                        $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                }
            } elseif ($tipo_mascota->nombre == 'Perro') {
                if ($tipo == 'cremación') {
                    switch ($raza->tamanio) {
                        case 'Pequeño':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                            else
                                $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                            break;
                        case 'Mediano':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_medianos;
                            else
                                $valor_global = $precios_funeraria->cremacion_medianos_sin_transporte;
                            break;
                        case 'Grande':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_grandes;
                            else
                                $valor_global = $precios_funeraria->cremacion_grandes_sin_transporte;
                            break;
                        case 'Gigante':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->cremacion_gigantes;
                            else
                                $valor_global = $precios_funeraria->cremacion_gigantes_sin_transporte;
                            break;
                    }
                } elseif ($tipo == 'sepultura') {

                    switch ($raza->tamanio) {
                        case 'Pequeño':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                            else
                                $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                            break;
                        case 'Mediano':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_medianos;
                            else
                                $valor_global = $precios_funeraria->sepultura_medianos_sin_transporte;
                            break;
                        case 'Grande':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_grandes;
                            else
                                $valor_global = $precios_funeraria->sepultura_grandes_sin_transporte;
                            break;
                        case 'Gigante':
                            if ($incluir_transporte == 'si')
                                $valor_global = $precios_funeraria->sepultura_gigantes;
                            else
                                $valor_global = $precios_funeraria->sepultura_gigantes_sin_transporte;
                            break;
                    }
                }
            }
        }else{
            if($plan == 'Previsión') {
                if ($tipo == 'cremación') {
                    //se determina el valor de acuerdo si se solicita o no el transport
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->prevision;
                    else
                        $valor_global = $precios_funeraria->prevision_sin_transporte;
                } elseif ($tipo == 'sepultura') {
                    if ($incluir_transporte == 'si')
                        $valor_global = $precios_funeraria->prevision_sepultura;
                    else
                        $valor_global = $precios_funeraria->prevision_sepultura_sin_transporte;
                }
            }elseif ($plan == 'Ahorrativo'){
                if ($tipo_mascota->nombre == 'Gato') {
                    //los gatos tienen siempre el valor de la mascota pequeña
                    if ($tipo == 'cremación') {
                        //se determina el valor de acuerdo si se solicita o no el transport
                        if ($incluir_transporte == 'si')
                            $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                        else
                            $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                    } elseif ($tipo == 'sepultura') {
                        if ($incluir_transporte == 'si')
                            $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                        else
                            $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                    }
                } elseif ($tipo_mascota->nombre == 'Perro') {
                    if ($tipo == 'cremación') {
                        switch ($raza->tamanio) {
                            case 'Pequeño':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_pequenios_gatos;
                                else
                                    $valor_global = $precios_funeraria->cremacion_pequenios_gatos_sin_transporte;
                                break;
                            case 'Mediano':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_medianos;
                                else
                                    $valor_global = $precios_funeraria->cremacion_medianos_sin_transporte;
                                break;
                            case 'Grande':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_grandes;
                                else
                                    $valor_global = $precios_funeraria->cremacion_grandes_sin_transporte;
                                break;
                            case 'Gigante':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->cremacion_gigantes;
                                else
                                    $valor_global = $precios_funeraria->cremacion_gigantes_sin_transporte;
                                break;
                        }
                    } elseif ($tipo == 'sepultura') {

                        switch ($raza->tamanio) {
                            case 'Pequeño':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_pequenios_gatos;
                                else
                                    $valor_global = $precios_funeraria->sepultura_pequenios_gatos_sin_transporte;
                                break;
                            case 'Mediano':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_medianos;
                                else
                                    $valor_global = $precios_funeraria->sepultura_medianos_sin_transporte;
                                break;
                            case 'Grande':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_grandes;
                                else
                                    $valor_global = $precios_funeraria->sepultura_grandes_sin_transporte;
                                break;
                            case 'Gigante':
                                if ($incluir_transporte == 'si')
                                    $valor_global = $precios_funeraria->sepultura_gigantes;
                                else
                                    $valor_global = $precios_funeraria->sepultura_gigantes_sin_transporte;
                                break;
                        }
                    }
                }
            }
        }


        $valor_pago = $valor_global;
        //si se paga a mas de un año se cobran los intereses establecdos en la DB
        if($anios_de_pago > 1) {
            $valor_pago = round(($valor_global / $anios_de_pago));
            $valor_pago = round($valor_pago + (($valor_pago * $precios_funeraria->interes) / 100));
        }
        return $valor_pago;
    }
}
