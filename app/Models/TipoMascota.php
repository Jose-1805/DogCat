<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMascota extends Model
{
    protected $table = "tipos_mascotas";

    protected $fillable = [
    ];

    public function vacunas(){
        return $this->hasMany(Vacuna::class,'tipo_mascota_id');
    }
}