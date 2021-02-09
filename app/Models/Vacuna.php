<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vacuna extends Model
{
    protected $table = "vacunas";

    public static function permitidos(){
        if(Auth::user()->getTipoUsuario() == 'afiliado' || Auth::user()->getTipoUsuario() == 'registro'){
            return Vacuna::select('vacunas.*')
                ->join('mascotas','vacunas.mascota_id','=','mascotas.id')
                ->join('users','mascotas.user_id','=','users.id')
                ->where('users.id',Auth::user()->id);
        }else if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            return Vacuna::where('vacunas.id','>','0');
        }
    }

    public function mascota(){
        return $this->belongsTo(Mascota::class,'mascota_id');
    }

    public function archivo(){
        return $this->belongsTo(Imagen::class,'archivo_id');
    }


}
