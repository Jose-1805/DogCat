<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Renovacion extends Model
{
    protected $table = "renovaciones";

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
    ];

    public function mascotasRenovaciones(){
        return $this->hasMany(MascotaRenovacion::class,'renovacion_id');
    }

    public function historialPrecioAfiliacion(){
        return $this->belongsTo(HistorialPrecioAfiliacion::class,'historial_precio_afiliacion_id');
    }

    public function afiliacion(){
        return $this->belongsTo(Afiliacion::class,'afiliacion_id');
    }

    public function historialPrecioFuneraria(){
        return $this->belongsTo(HistorialPrecioFuneraria::class,'historial_precio_funeraria_id');
    }

    public function getValor(){
        $historial_precio_afiliacion = $this->historialPrecioAfiliacion;
        $mascotas = $this->mascotasRenovaciones;
        $valor = $historial_precio_afiliacion->valor_afiliacion;

        //valor de mascotas adicionales
        if(count($mascotas) > $historial_precio_afiliacion->cantidad_mascotas_afiliacion){
            $valor += (count($mascotas) - $historial_precio_afiliacion->cantidad_mascotas_afiliacion) * $historial_precio_afiliacion->mascota_afiliacion;
        }

        foreach ($mascotas as $m){
            $valor += $m->valor_funeraria;
            $valor += $m->valor_comision;
        }

        return $valor;
    }

    public function mascotas(){
        return $this->belongsToMany(Mascota::class,'mascotas_renovaciones','renovacion_id','mascota_id');
    }

    public function ingresos(){
        return $this->belongsToMany(Ingreso::class,'pagos_renovaciones','renovacion_id','ingreso_id');
    }

    public function getValorPagado(){
        return $this->valor_pago*$this->numeroPagosRealizados();
    }

    public function numeroPagosRealizados(){
        $ingresos = $this->ingresos()->select('cuotas_pagadas')->get();
        $cantidad = 0;
        foreach($ingresos as $ingreso){
            $cantidad +=  $ingreso->cuotas_pagadas;
        }
        return $cantidad;
    }

    public function cuotasCreditos(){
        return $this->hasMany(CuotaCredito::class,'renovacion_id');
    }

    public static function calcularFechaCuota($numero_cuota,$dia_pagar){
        $fecha_segunda_cuota = self::calcularFechaSegundaCuota($dia_pagar);
        if($numero_cuota == 1)return date('Y-m-d');
        if($numero_cuota == 2)return $fecha_segunda_cuota;

        $fecha_aux = date('Y-m',strtotime($fecha_segunda_cuota)).'-01';
        $fecha_aux = strtotime('+'.($numero_cuota-2).' month',strtotime($fecha_aux));
        $anio = date('Y',$fecha_aux);
        $mes = date('m',$fecha_aux);

        $continuar = true;

        $fecha_cuota = '';

        //asigna el dia en el mes
        while ($continuar){
            if(checkdate($mes,$dia_pagar,$anio)){
                $fecha_cuota = $anio.'-'.$mes.'-'.$dia_pagar;
                $continuar = false;
            }else{
                $dia_pagar--;
            }
        }

        return $fecha_cuota;
    }

    public static function calcularFechaSegundaCuota($dia_pagar){

        $anio = date('Y');
        $mes = date('m');

        $fecha_cuota = '';
        $fecha_segunda_cuota_calculada = false;
        while (!$fecha_segunda_cuota_calculada){

            $continuar = true;
            $dia_pagar_aux = $dia_pagar;

            //asigna el dia en el mes
            while ($continuar){
                if(checkdate($mes,$dia_pagar_aux,$anio)){
                    $fecha_cuota = $anio.'-'.$mes.'-'.$dia_pagar_aux;
                    $continuar = false;
                }else{
                    $dia_pagar_aux--;
                }
            }

            $date_fecha_min = strtotime('+20 days',strtotime(date('Y-m-d')));
            $date_fecha_cuota = strtotime($fecha_cuota);

            //si la cuota queda para dentro de menos de 20 días
            //no sirve la fecha y se busca una en otro mes
            if($date_fecha_min > $date_fecha_cuota){
                $fecha_auxiliar = $anio.'-'.$mes.'-01';
                //calculamos los datos del siguiente mes
                $fecha_auxiliar = strtotime('+1 month',strtotime($fecha_auxiliar));
                $anio = date('Y',$fecha_auxiliar);
                $mes = date('m',$fecha_auxiliar);
            }else{
                $fecha_segunda_cuota_calculada = true;
            }
        }

        return $fecha_cuota;
    }
}