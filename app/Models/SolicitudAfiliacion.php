<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SolicitudAfiliacion extends Model
{
    protected $table = 'solicitudes_afiliaciones';

    public static function permitidos(){
        if(Auth::user()->esSuperadministrador()) {
            return SolicitudAfiliacion::select('solicitudes_afiliaciones.*')->join('users', 'solicitudes_afiliaciones.user_id', '=', 'users.id');
        }elseif (Auth::user()->getTipoUsuario() == 'personal dogcat'){
            return SolicitudAfiliacion::select('solicitudes_afiliaciones.*')
                ->join('users', 'solicitudes_afiliaciones.user_id', '=', 'users.id')
                ->where('users.asesor_asignado_id',Auth::user()->id);
        }else{
            return SolicitudAfiliacion::select('solicitudes_afiliaciones.*')->join('users','solicitudes_afiliaciones.user_id','=','users.id')
                ->where('solicitudes_afiliaciones.user_id',Auth::user()->id);
        }
    }

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function historialSolicitudAfiliacion(){
        return $this->hasMany(SolicitudAfiliacionHistorial::class,'solicitud_afiliacion_id');
    }
}
