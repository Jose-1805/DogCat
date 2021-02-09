<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = "departamentos";

    protected $fillable = [
    ];

    public function pais(){
        return $this->belongsTo(Pais::class,'pais_id');
    }
}