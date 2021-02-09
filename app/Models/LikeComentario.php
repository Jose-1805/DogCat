<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class LikeComentario extends Model
{
    protected $table = "likes_comentarios";

    protected $fillable = [
        'comentario_id',
        'user_id'
    ];
}