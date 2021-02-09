<?php

namespace DogCat\Models;

use DogCat\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Mascota extends Model
{
    protected $table = "mascotas";

    protected $fillable = [
    ];

    public static function permitidos(){
        if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
            if(Auth::user()->rol->asesor == 'si'){
                return Mascota::select('mascotas.*')->join('users as us','mascotas.user_id','=','us.id')
                    ->where('us.asesor_asignado_id',Auth::user()->id);
            }else {
                return Mascota::select('mascotas.*')->whereNotNull('mascotas.id');
            }
        }else if(Auth::user()->getTipoUsuario() == 'afiliado' || Auth::user()->getTipoUsuario() == 'registro'){
            return Mascota::select('mascotas.*')->where('mascotas.user_id',Auth::user()->id);
        }else if(Auth::user()->getTipoUsuario() == 'empleado'){
            $veterinaria = Auth::user()->veterinaria;

            return Mascota::select('mascotas.*')
                ->join('users as us','mascotas.user_id','=','us.id')
                ->where('us.veterinaria_afiliado_id',$veterinaria->id);
        }
    }

    /**
     * Retorna consulta de mascotas permitidas para asignar una cita
     *
     * @param $user =>' Objeto User del dueño de las mascotas
     */
    public static function permitidosCita($user){
        return $user->mascotas()->select('mascotas.*')
            ->join('mascotas_renovaciones','mascotas.id','=','mascotas_renovaciones.mascota_id')
            ->join('renovaciones','mascotas_renovaciones.renovacion_id','=','renovaciones.id')
            ->join('afiliaciones','renovaciones.afiliacion_id','=','afiliaciones.id')
            ->where('mascotas.fallecida','no')
            ->where('mascotas.validado','si')
            ->where('mascotas_renovaciones.estado','Activo')
            ->where('afiliaciones.estado','Activa');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function vacunas(){
        return $this->hasMany(Vacuna::class,'mascota_id');
    }

    public function raza(){
        return $this->belongsTo(Raza::class);
    }

    public function imagen(){
        return $this->belongsTo(Imagen::class);
    }

    public function dataEdad(){
        $fecha_nacimiento = strtotime($this->fecha_nacimiento);
        $hoy = strtotime(date('Y-m-d'));
        $diferencia_mes = ((($hoy - $fecha_nacimiento)/86400)/30.5);
        if($diferencia_mes > 12){
            if(is_int($diferencia_mes/12))$edad = $diferencia_mes/12;
            else $edad = $diferencia_mes/12;
            return [
                'edad'=> $edad,
                'tipo'=>'Años'
            ];
        }else{
            if(is_int($diferencia_mes))$edad = $diferencia_mes;
            else $edad = $diferencia_mes;
            return [
                'edad'=> $edad,
                'tipo'=>'Meses'
            ];
        }
    }

    public function edad($tipo = 'años'){
        $fecha_nacimiento = strtotime($this->fecha_nacimiento);
        $hoy = strtotime(date('Y-m-d'));
        $edad_meses = ((($hoy - $fecha_nacimiento)/86400)/30.5);
        if($tipo == 'años')
            return $edad_meses/12;

        return $edad_meses;
    }

    public function strDataEdad(){
        $data = $this->dataEdad();
        if($data['tipo'] == 'Meses' || is_int($data['edad'])) {
            if(is_int($data['edad'])) {
                return $data['edad'] . ' ' . $data['tipo'];
            }else{
                $data['edad'] = number_format($data['edad'],1,',','.');
                return $data['edad'] . ' ' . $data['tipo'];
            }
        }else{
            $anios = intval($data['edad']);
            $meses = $data['edad']-$anios;
            $meses = ($meses*100)/12;
            $meses = number_format($meses,'1',',','.');
            return $anios.' Años '.$meses.' Meses';
        }
    }

    public function mascotasRenovaciones(){
        return $this->hasMany(MascotaRenovacion::class,'mascota_id');
    }

    /**
     * Determina si es posible registrar una cita para la mascota
     * segun los parametros enviados
     *
     * @param $datos
     */
    public function citaPosible($fecha,$datos){
        $hora_inicio = $datos['hora_inicio'];
        $minuto_inicio = $datos['minuto_inicio'];
        $hora_fin = $datos['hora_fin'];
        $minuto_fin = $datos['minuto_fin'];
        $agenda = $this->mascotasRenovaciones()
            ->join('citas','mascotas_renovaciones.id','=','citas.mascota_renovacion_id')
            ->join('agendas','citas.id','=','agendas.cita_id')
            ->where('citas.fecha',$fecha)
            ->where(function ($q) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                //agendas que incluyan la hora de inicio seleccionada
                $q->where(function ($q1) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                    $q1->where('agendas.hora_inicio','<',$hora_inicio)
                        ->where('agendas.hora_fin','>',$hora_inicio);
                })
                    //agendas que incluyan la hora de fin seleccionada
                    ->orWhere(function ($q2) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q2->where('agendas.hora_inicio','<',$hora_fin)
                            ->where('agendas.hora_fin','>',$hora_fin);
                    })
                    //agendas cuya hora de inicio este dentro de la disponibilidad seleccionada
                    ->orWhere(function ($q3) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q3->where('agendas.hora_inicio','>',$hora_inicio)
                            ->where('agendas.hora_inicio','<',$hora_fin);
                    })
                    //agendas cuya hora de fin este dentro de la disponibilidad seleccionada
                    ->orWhere(function ($q4) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q4->where('agendas.hora_fin','>',$hora_inicio)
                            ->where('agendas.hora_fin','<',$hora_fin);
                    })
                    //agendas cuya hora de inicio y fin sean iguales a la hora de inicio y fin seleccionadas
                    //incluyendo minutos
                    ->orWhere(function ($q5) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q5->where(function ($q6) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                            $q6->where('agendas.hora_inicio',$hora_inicio)
                                ->where('minuto_inicio',$minuto_inicio);
                        })->orWhere(function ($q7) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                            $q7->where('agendas.hora_fin',$hora_fin)
                                ->where('minuto_fin',$minuto_fin);
                        })->orWhere(function ($q8) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                            $q8->where('agendas.hora_inicio',$hora_fin)
                                ->where('minuto_inicio',$minuto_fin);
                        })->orWhere(function ($q9) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                            $q9->where('agendas.hora_fin',$hora_inicio)
                                ->where('minuto_fin',$minuto_inicio);
                        });
                    });
            })
            ->first();
        if($agenda)return false;
        return true;
    }

    /**
     * Determina si se puede editar toda la información de una mascota
     * dependiendo de las validaciones hechas por DOGCAT
     */
    public function permitirEditarTodo(){
        //si es superadmin siempre puede editar
        if(Auth::user()->esSuperadministrador())
            return true;

        //si ha pasado solo la primera validacion solo pueden hacer ediciones
        //las personas de dogcat
        if($this->validado == 'si' && $this->informacion_validada == 'no' && Auth::user()->getTipoUsuario() == 'personal dogcat')
            return true;

        if($this->validado == 'no')
            return true;

        return false;
    }

    public function revisionesPeriodicas(){
        return $this->hasMany(RevisionPeriodica::class,'mascota_id');
    }
}