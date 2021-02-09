<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = "egresos";

    protected $fillable = [
        'id',
        'tipo',
        'descripcion',
        'numero_factura',
        'valor',
        'fecha',
    ];

    public function evidencia(){
        return $this->belongsTo(Imagen::class,'imagen_id');
    }
}