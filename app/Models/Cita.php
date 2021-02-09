<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cita extends Model
{
    protected $table = "citas";

    protected $fillable = [
        'estado',
        'fecha',
        'valor',
        'descuento',
        'entidad',
        'motivo_cancelacion'
    ];

    public static function permitidos(){
        $citas = Cita::select(
            'citas.*'
        )
            ->join('agendas','citas.id','=','agendas.cita_id')
            ->join('disponibilidades','agendas.disponibilidad_id','=','disponibilidades.id')
            ->join('servicios','citas.servicio_id','=','servicios.id')
            ->join('mascotas_renovaciones','citas.mascota_renovacion_id','=','mascotas_renovaciones.id')
            ->join('mascotas','mascotas_renovaciones.mascota_id','=','mascotas.id')
            ->join('users as propietario','mascotas.user_id','=','propietario.id')
            ->join('users as encargado','disponibilidades.user_id','=','encargado.id');


        if(Auth::user()->getTipoUsuario() == 'afiliado'){
            $citas = $citas
                ->where('propietario.id',Auth::user()->id);
        }else if(Auth::user()->getTipoUsuario() == 'empleado'){
            $veterinaria = Auth::user()->getVeterinaria();
            $citas = $citas
                ->where('encargado.veterinaria_empleo_id',$veterinaria->id);
        }else if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            $citas = $citas
                ->where('citas.entidad','Dogcat');
        }

        return $citas;
    }

    public function strFecha(){
        return date('Y-m-d',strtotime($this->fecha));
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class,'servicio_id');
    }

    public function mascotaRenovacion(){
        return $this->belongsTo(MascotaRenovacion::class,'mascota_renovacion_id');
    }

    public function getMascota(){
        return $this->mascotaRenovacion->mascota;
    }

    public function agenda(){
        return $this->hasOne(Agenda::class,'cita_id');
    }

    public function permitirCancelarCita(){
        $permitir = false;
        if($this->estado == 'Agendada'){
            $agenda = $this->agenda;
            $hora_cita = date('Y-m-d',strtotime($this->fecha)).' '.$agenda->strHoraInicio();
            $hora_actual = date('Y-m-d H:i');
            $hora_limite = date('Y-m-d H:i',strtotime('-'.config('params.horas_cancelacion_cita').' hours',strtotime($hora_cita)));
            if(strtotime($hora_actual) <= strtotime($hora_limite)){
               $permitir = true;
            }
        }
        return $permitir;
    }
}