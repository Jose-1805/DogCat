<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialPrecioFuneraria extends Model
{
    protected $table = "historial_precios_funeraria";

    protected $fillable = [
        'cremacion_gigantes',
        'cremacion_grandes',
        'cremacion_medianos',
        'cremacion_pequenios_gatos',
        'sepultura_gigantes',
        'sepultura_grandes',
        'sepultura_medianos',
        'sepultura_pequenios_gatos',
    ];

    public static function ultimoHistorial(){
        return HistorialPrecioFuneraria::orderBy('created_at','DESC')->first();
    }
}