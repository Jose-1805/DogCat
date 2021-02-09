<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = "ciudades";

    protected $fillable = [
    ];

    public function departamento(){
        return $this->belongsTo(Departamento::class,'departamento_id');
    }
}