<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Veterinaria extends Model
{
    protected $table = "veterinarias";

    protected $fillable = [
        'nit',
        'nombre',
        'correo',
        'telefono',
        'web_site',
        'imagen_id',
        'token',
        'user_id',
        'administrador_id',
        'ubicacion_id',
    ];

    public static function permitidos(){
        if(Auth::user()->esSuperadministrador() || Auth::user()->getTipoUsuario() == 'personal dogcat'){
            return Veterinaria::whereNotNull('id');
        }else if(Auth::user()->getTipoUsuario() == 'empleado'){
            return Veterinaria::where('veterinarias.id',Auth::user()->veterinaria_empleo_id);
        }else{
            return Veterinaria::where('veterinarias.id',Auth::user()->veterinaria_afiliado_id);
        }
    }

    public function administrador(){
        return $this->belongsTo(User::class,'administrador_id');
    }

    public function imagen(){
        return $this->belongsTo(Imagen::class,'imagen_id');
    }

    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class,'ubicacion_id');
    }

    public function roles(){
        return $this->hasMany(Rol::class,'veterinaria_id');
    }

}