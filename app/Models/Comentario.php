<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = "comentarios";

    protected $fillable = [
        'comentario',
        'user_id',
        'publicacion_id',
    ];

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }
}