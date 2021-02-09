<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;

class LikePublicacion extends Model
{
    protected $table = "likes_publicaciones";

    protected $fillable = [
        'publicacion_id',
        'user_id'
    ];
}