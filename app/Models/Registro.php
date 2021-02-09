<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Registro extends Model
{
    protected $table = "registros";

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'barrio',
        'direccion',
        'permiso_notificaciones',
        'veterinaria'
    ];

    public static function permitidos(){
        if(Auth::user()->esSuperadministrador()){
            return Registro::whereNotNull('registros.id');
        }else{
            return Registro::where('registros.user_asignado_id',Auth::user()->id);
        }
    }

    public function historial(){
        return $this->hasMany(RegistroHistorial::class);
    }

    public function asesor(){
        return $this->belongsTo(User::class,'user_asignado_id');
    }
}
