<?php

namespace DogCat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Agenda extends Model
{
    protected $table = "agendas";
    public $timestamps = false;

    protected $fillable = [
        'hora_inicio',
        'minuto_inicio',
        'hora_fin',
        'minuto_fin',
    ];

    public function disponibilidad(){
        return $this->belongsTo(Disponibilidad::class,'disponibilidad_id');
    }

    public static function porFecha($fecha){
        $agendas = Agenda::select('agendas.*')
            ->join('disponibilidades','agendas.disponibilidad_id','=','disponibilidades.id')
            ->join('citas','agendas.cita_id','=','citas.id')
            ->where('disponibilidades.fecha',$fecha)
            ->where(function ($q){
                $q->where('citas.estado','Agendada')
                    ->orWhere('citas.estado','Facturada');
            });

        if(Auth::user()->getTipoUsuario() == 'afiliado'){
            $agendas = $agendas
                ->join('mascotas_renovaciones','citas.mascota_renovacion_id','=','mascotas_renovaciones.id')
                ->join('mascotas','mascotas_renovaciones.mascota_id','=','mascotas.id')
                ->where('mascotas.user_id',Auth::user()->id);
        }else if(Auth::user()->getTipoUsuario() == 'empleado'){
            $veterinaria = Auth::user()->getVeterinaria();
            $agendas = $agendas
                ->join('users','disponibilidades.user_id','=','users.id')
                ->where('users.veterinaria_empleo_id',$veterinaria->id);
        }else if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            $agendas = $agendas
                ->where('citas.entidad','Dogcat');
        }else {
            return null;
        }
        return $agendas;
    }

    protected function addCero($data){
        if(strlen($data) == 1){
            return '0'.$data;
        }
        return $data;
    }

    public function strHoraInicio(){
        return $this->addCero($this->hora_inicio).':'.$this->addCero($this->minuto_inicio);
    }

    public function strHoraFin(){
        return $this->addCero($this->hora_fin).':'.$this->addCero($this->minuto_fin);
    }

    public function cita(){
        return $this->belongsTo(Cita::class,'cita_id');
    }

    public function duracionMinutos(){
        $fecha_inicio = date('Y-m-d').' '.$this->hora_inicio.':'.$this->minuto_inicio;
        $fecha_fin = date('Y-m-d').' '.$this->hora_fin.':'.$this->minuto_fin;
        return ceil((strtotime($fecha_fin) - strtotime($fecha_inicio)) / 60);
    }
}