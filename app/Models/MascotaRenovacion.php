<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class MascotaRenovacion extends Model
{
    protected $table = "mascotas_renovaciones";
    public $timestamps = false;

    protected $fillable = [
        'estado',
        'consecutivo',
    ];

    public function mascota(){
        return $this->belongsTo(Mascota::class,'mascota_id');
    }

    public function citas(){
        return $this->hasMany(Cita::class,'mascota_renovacion_id');
    }

    /**
     * Determina el siguiente consecutivo para asignar a una afiliacion
     */
    public static function siguienteConsecutivo(){
        $consecutivo = '100001';
        $ultima_afiliacion = MascotaRenovacion::orderBy('consecutivo','DESC')->first();
        if($ultima_afiliacion){
            $consecutivo = intval($ultima_afiliacion->consecutivo)+1;
        }
        return $consecutivo;

    }
}