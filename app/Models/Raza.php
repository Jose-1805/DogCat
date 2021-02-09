<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    protected $table = "razas";

    protected $fillable = [
        'nombre',
        'promedio_vida_menor',
        'promedio_vida_mayor',
        'tipo_mascota_id',
        'tamanio',
    ];

    public static function json_autocomplete($tipo_mascota){
        $razas = Raza::select('razas.nombre as value','razas.id as data')
            ->join('tipos_mascotas','razas.tipo_mascota_id','=','tipos_mascotas.id')
            ->where('tipos_mascotas.nombre',$tipo_mascota)
            ->get();
        return json_encode($razas);
    }


    public function tipoMascota(){
        return $this->belongsTo(TipoMascota::class,'tipo_mascota_id');
    }
}