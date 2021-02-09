<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroHistorial extends Model
{
    protected $table = "registros_historial";

    protected $fillable = [
        'estado_anterior',
        'estado_nuevo',
        'observaciones',
        'registro_id',
        'user_id',
    ];
}
