<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = "ingresos";

    protected $fillable = [
        'valor',
        'fecha',
        'fuente',
        'subfuente',
        'medio_pago',
        'user_id',
    ];

    public function servicio(){
        return $this->belongsTo(Servicio::class,'servicio_id');
    }

    public function evidencia(){
        return $this->belongsTo(Imagen::class,'imagen_id');
    }
}