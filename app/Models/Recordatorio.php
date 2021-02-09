<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Recordatorio extends Model
{
    protected $table = "recordatorios";

    protected $fillable = [
    ];

    public static function permitidos(){
        return Recordatorio::select('recordatorios.*')
            ->join('users_recordatorios','recordatorios.id','=','users_recordatorios.recordatorio_id')
            ->where(function ($q){
                $q->where('recordatorios.user_id',Auth::user()->id)
                    ->orWhere('users_recordatorios.user_id',Auth::user()->id);
            });
    }

    public function users(){
        return $this->belongsToMany(User::class,'users_recordatorios','recordatorio_id','user_id');
    }
}