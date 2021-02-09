<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;

class UserNotificacion extends Model
{
    protected $table = "users_notificaciones";

    protected $fillable = [
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function notificacion(){
        return $this->belongsTo(Notificacion::class,'notificacion_id');
    }
}