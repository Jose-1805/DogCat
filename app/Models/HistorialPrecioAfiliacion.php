<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialPrecioAfiliacion extends Model
{
    protected $table = "historial_precios_afiliacion";

    protected $fillable = [
        'valor_afiliacion',
        'valor_mascota_adicional',
    ];

    public static function ultimoHistorial(){
        return HistorialPrecioAfiliacion::orderBy('created_at','DESC')->first();
    }
}