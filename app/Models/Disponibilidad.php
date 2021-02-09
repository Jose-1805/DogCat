<?php

namespace DogCat\Models;

use DogCat\User;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    protected $table = "disponibilidades";

    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin',
    ];

    public static function permitidos(){
        $users = User::permitidos()->select('id')->get()->toArray();
        return Disponibilidad::whereIn('user_id',$users);
    }

    public function toString(){
        return $this->addCero($this->hora_inicio).':'.$this->addCero($this->minuto_inicio).' - '.$this->addCero($this->hora_fin).':'.$this->addCero($this->minuto_fin);
    }

    protected function addCero($data){
        if(strlen($data) == 1){
            return '0'.$data;
        }
        return $data;
    }

    public function permitirEliminar(){
        if($this->agendas()->count())return false;
        $hoy = strtotime(date('Y-m-d'));
        $fecha = strtotime($this->fecha);
        if($hoy >= $fecha)return false;

        return true;
    }

    public function agendas(){
        return $this->hasMany(Agenda::class,'disponibilidad_id');
    }

    /**
     * Determina si en la agenda existe un espacio libre de la cantidad de minutos
     * pasada como parametro
     *
     * @param $minutos
     */
    public function existeEspacioLibre($minutos){
        if(count($this->espaciosLibres($minutos)))return true;
        return false;
    }

    public function espaciosLibres($minutos){
        //identificamos cuantas horas y minutos de tiempo necesita libre
        $horas_duracion = intval($minutos/60);
        $minutos_duracion = $minutos % 60;

        //hora y minuto de inicio segun disponibilidad
        //estos datos se deben actualizar a medida de las agendas encontradas (en el while)
        $hora_inicio = $this->hora_inicio;
        $minuto_inicio = $this->minuto_inicio;

        //hora y minuto limite segun disponibilidad
        $hora_limite = $this->hora_fin;
        $minuto_limite = $this->minuto_fin;

        $parar = false;
        $espacios_libres = [];
        while (!$parar){
            //determinamos hora y minuto de finalización
            if(($minuto_inicio + $minutos_duracion) >= 60){
                $hora_fin = ($hora_inicio + $horas_duracion) + 1;
                $minuto_fin = ($minuto_inicio + $minutos_duracion) - 60;
            }else{
                $hora_fin = $hora_inicio + $horas_duracion;
                $minuto_fin = $minuto_inicio + $minutos_duracion;
            }

            //no debe pasar los limites de la disponibilidad
            if($hora_fin > $hora_limite){
                $parar = true;
                break;
            }

            if($hora_fin == $hora_limite){
                if($minuto_fin > $minuto_limite){
                    $parar = true;
                    break;
                }
            }

            if(!$parar) {
                //se busca una agenda que esté relacionada con la disponibilidad actual
                //y que esté de alguna forma entre los horarios de inicio y fin establecidos
                $agenda = $this->agendaCruzada($hora_inicio, $minuto_inicio, $hora_fin, $minuto_fin);
                //si no se encuentra, ese espacio está libre y se agrega la info al array
                if (!$agenda) {

                    $espacios_libres[] = [
                        'hora_inicio'=>$this->addCero($hora_inicio),
                        'minuto_inicio'=>$this->addCero($minuto_inicio),
                        'hora_fin'=>$this->addCero($hora_fin),
                        'minuto_fin'=>$this->addCero($minuto_fin)
                    ];

                    //determinamos nueva hora y minuto de inicio
                    if (($minuto_fin + 1) == 60) {
                        $hora_inicio = $hora_fin + 1;
                        $minuto_inicio = 0;
                    } else {
                        $hora_inicio = $hora_fin;
                        $minuto_inicio = $minuto_fin + 1;
                    }
                } else {
                    //determinamos nueva hora y minuto de inicio
                    if (($agenda->minuto_fin + 1) == 60) {
                        $hora_inicio = $agenda->hora_fin + 1;
                        $minuto_inicio = 0;
                    } else {
                        $hora_inicio = $agenda->hora_fin;
                        $minuto_inicio = $agenda->minuto_fin + 1;
                    }
                }
            }
        }

        return $espacios_libres;
    }

    public function agendaCruzada($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
        return $this->agendas()->select('agendas.*')
            ->join('citas','agendas.cita_id','=','citas.id')
            ->where(function ($q){
                $q->where('citas.estado','Agendada')
                    ->orWhere('citas.estado','Facturada');
            })
            ->where(function ($q) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                //agendas que incluyan la hora de inicio seleccionada
                $q->where(function ($q1) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                    $q1->where('hora_inicio','<',$hora_inicio)
                        ->where('hora_fin','>',$hora_inicio);
                })
                //agendas que incluyan la hora de fin seleccionada
                ->orWhere(function ($q2) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                    $q2->where('hora_inicio','<',$hora_fin)
                        ->where('hora_fin','>',$hora_fin);
                })
                //agendas cuya hora de inicio este dentro de la disponibilidad seleccionada
                ->orWhere(function ($q3) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                    $q3->where('hora_inicio','>',$hora_inicio)
                        ->where('hora_inicio','<',$hora_fin);
                })
                //agendas cuya hora de fin este dentro de la disponibilidad seleccionada
                ->orWhere(function ($q4) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                    $q4->where('hora_fin','>',$hora_inicio)
                        ->where('hora_fin','<',$hora_fin);
                })
                //agendas cuya hora de inicio y fin sean iguales a la hora de inicio y fin seleccionadas
                //incluyendo minutos
                ->orWhere(function ($q5) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                    $q5->where(function ($q6) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q6->where('hora_inicio',$hora_inicio)
                            ->where('minuto_inicio',$minuto_inicio);
                    })->orWhere(function ($q7) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q7->where('hora_fin',$hora_fin)
                            ->where('minuto_fin',$minuto_fin);
                    })->orWhere(function ($q8) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q8->where('hora_inicio',$hora_fin)
                            ->where('minuto_inicio',$minuto_fin);
                    })->orWhere(function ($q9) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        $q9->where('hora_fin',$hora_inicio)
                            ->where('minuto_fin',$minuto_inicio);
                    });
                });
            })->first();
    }

    /**
     * Determina los espacios en los que existe una cita pero dispone de cupos libres para agendar otra
     * de las mismas caracteristicas
     *
     * @param Servicio $servicio
     */
    public function espaciosOcupadosConCupoLibre(Servicio $servicio, Mascota $mascota,$longitud = null,$latitud = null){
        ///determinamos la duración del servicio según el peso de la mascota
        if($mascota->peso <= 10)
            $duracion = $servicio->duracion_1_10;
        if($mascota->peso > 10 && $mascota->peso <= 25)
            $duracion = $servicio->duracion_10_25;
        if($mascota->peso > 25)
            $duracion = $servicio->duracion_mayor_25;

        //se consultan las agendas relacionadas con el mismo servicio
        $agendas = $this->agendas()->select('agendas.*')
            ->join('citas','agendas.cita_id','=','citas.id')
            ->where('citas.servicio_id',$servicio->id)->get();

        $espacios = [];
        foreach ($agendas as $agenda){
            //la agenda tiene la misma duraciòn del servicio
            if($agenda->duracionMinutos() == $duracion){
                //agendas con el mismo horario y el mismo servicio
                $agendas_iguales = $this->agendas()->select('agendas.*','mascotas.id as mascota_id')
                    ->join('citas','agendas.cita_id','=','citas.id')
                    ->join('mascotas_renovaciones','citas.mascota_renovacion_id','=','mascotas_renovaciones.id')
                    ->join('mascotas','mascotas_renovaciones.mascota_id','=','mascotas.id')
                    ->where('citas.servicio_id',$servicio->id)
                    ->where('agendas.hora_inicio',$agenda->hora_inicio)
                    ->where('agendas.minuto_inicio',$agenda->minuto_inicio)
                    ->where('agendas.hora_fin',$agenda->hora_fin)
                    ->where('agendas.minuto_fin',$agenda->minuto_fin)
                    ->where(function ($q){
                        $q->where('citas.estado','Agendada')
                            ->orWhere('citas.estado','Facturada');
                    })
                    ->get();

                //no se ha llenado el cupo del servicio
                if(count($agendas_iguales) < $servicio->cupos){
                    //se determina si la mascota ya esta relacionada con una de las agendas
                    //si es asì no se agrega la agenda (no es posible)
                    $continuar = true;
                    foreach ($agendas_iguales as $ag){
                        if($ag->mascota_id == $mascota->id){
                            $continuar = false;
                        }else{
                            //si el servicio es de paseo, validamos
                            //que solo se pueda agrupar por la clasificacion de la mascota
                            //y la ubicacion
                            if($servicio->paseador == 'si') {
                                $mascota_agenda = Mascota::find($ag->mascota_id);
                                if($mascota_agenda->clasificacion != $mascota->clasificacion){
                                    $continuar = false;
                                }

                                if($continuar) {
                                    //validamos la ubicacion
                                    $cita = $ag->cita;

                                    $cliente = new Client();
                                    $origen = "$cita->latitud,$cita->longitud";
                                    $destino = "$latitud,$longitud";
                                    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$origen&destinations=$destino&mode=walking&key=" . config('params.google_maps_api_key');
                                    $res = $cliente->request('GET', $url);
                                    if ($res->getStatusCode() != 200) {
                                        $continuar = false;
                                    } else {
                                        $body = $res->getBody();
                                        $data = \GuzzleHttp\json_decode($body->read($body->getSize()));
                                        $duracion_segundos = $data->rows[0]->elements[0]->duration->value;
                                        $duracion_minutos = $duracion_segundos/60;

                                        if($duracion_minutos > config('params.maximo_minutos_distancia_paseador')){
                                            $continuar = false;
                                        }
                                    }
                                }
                            }

                        }
                    }

                    if($continuar) {
                        $datos = [
                            'hora_inicio' => $this->addCero($agenda->hora_inicio),
                            'minuto_inicio' => $this->addCero($agenda->minuto_inicio),
                            'hora_fin' => $this->addCero($agenda->hora_fin),
                            'minuto_fin' => $this->addCero($agenda->minuto_fin)
                        ];
                        if (!in_array($datos, $espacios)) {
                            $espacios[] = $datos;
                        }
                    }
                }
            }
        }
        return $espacios;
    }

    /**
     * Determina las disponibilidades en las cuales se pude agendar una cita
     * para determinada mascota y determinado servicio
     *
     * @param Mascota $mascota
     * @param Servicio $servicio
     * @param $encargado // empleado sel cual se revisa la disponibilidad
     * @param $fecha_inicio_time
     * @param $fecha_fin_time
     */
    public static function porServicioMascota(Mascota $mascota, Servicio $servicio,$encargado,$fecha_inicio_time,$fecha_fin_time){
        //posibles disponibilidades en las que se pueda agendar la cita
        $posibles_disponibildades = $encargado->disponibilidades()
            ->where('fecha','>',date('Y-m-d',$fecha_inicio_time))
            ->where('fecha','<=',date('Y-m-d',$fecha_fin_time))->get();

        //determinamos la duración del servicio según el peso de la mascota
        if($mascota->peso <= 10)
            $duracion = $servicio->duracion_1_10;
        if($mascota->peso > 10 && $mascota->peso <= 25)
            $duracion = $servicio->duracion_10_25;
        if($mascota->peso > 25)
            $duracion = $servicio->duracion_mayor_25;

        $disponibilidades = [];
        $agregadas = [];

        foreach ($posibles_disponibildades as $disponibilidad){
            if(!array_key_exists($disponibilidad->fecha,$agregadas)) {
                if ($disponibilidad->existeEspacioLibre($duracion)) {
                    $disponibilidades[] = $disponibilidad;
                    $agregadas[$disponibilidad->fecha] = true;
                }
            }
        }

        return $disponibilidades;
    }

    /**
     * Determina las disponibilidades en las cuales se pude agendar una cita
     * para determinada mascota y determinado servicio en determinada fecha
     *
     * @param Mascota $mascota
     * @param Servicio $servicio
     * @param $encargado // empleado sel cual se revisa la disponibilidad
     * @param $fecha
     */
    public static function porServicioMascotaFecha(Mascota $mascota, Servicio $servicio,$encargado,$fecha){
        //posibles disponibilidades en las que se pueda agendar la cita
        $posibles_disponibildades = $encargado->disponibilidades()
            ->where('fecha',$fecha)->get();

        //determinamos la duración del servicio según el peso de la mascota
        if($mascota->peso <= 10)
            $duracion = $servicio->duracion_1_10;
        if($mascota->peso > 10 && $mascota->peso <= 25)
            $duracion = $servicio->duracion_10_25;
        if($mascota->peso > 25)
            $duracion = $servicio->duracion_mayor_25;

        $disponibilidades = [];
        $agregadas = [];

        foreach ($posibles_disponibildades as $disponibilidad){
            if(!array_key_exists($disponibilidad->id,$agregadas)) {
                if ($disponibilidad->existeEspacioLibre($duracion)) {
                    $disponibilidades[] = $disponibilidad;
                    $agregadas[$disponibilidad->id] = true;
                }
            }
        }

        return $disponibilidades;
    }

    /**
     * Determina las posibles agendas que se pueden registrar en el objeto de disponibilidad actual
     * dependiendo del servicio y la mascota recibidas como parametro
     *
     * @param Mascota $mascota
     * @param Servicio $servicio
     */
    public function posiblesAgendas(Servicio $servicio,Mascota $mascota,$longitud = null,$latitud = null){

        //determinamos la duración del servicio según el peso de la mascota
        if($mascota->peso <= 10)
            $duracion = $servicio->duracion_1_10;
        if($mascota->peso > 10 && $mascota->peso <= 25)
            $duracion = $servicio->duracion_10_25;
        if($mascota->peso > 25)
            $duracion = $servicio->duracion_mayor_25;

        return array_merge($this->espaciosLibres($duracion),$this->espaciosOcupadosConCupoLibre($servicio,$mascota,$longitud,$latitud));
    }

    public function strDiaFecha(){
        $dias = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
        return $dias[date('w',strtotime($this->fecha))];
    }
}