<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialPrecioServicio extends Model
{
    protected $table = "historial_precios_servicios";

    protected $fillable = [
        'valor',
        'descuento',
    ];
}
