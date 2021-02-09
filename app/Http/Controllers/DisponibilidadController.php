<?php

namespace DogCat\Http\Controllers;

use DogCat\Models\Disponibilidad;
use DogCat\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DisponibilidadController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 16;
    public function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    public function index(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect('/');

        $usuarios = User::permitidos(false)
            ->join('roles','users.rol_id','=','roles.id')
            ->select(DB::raw('CONCAT(users.nombres," ",users.apellidos," (",roles.nombre,")") as nombre'),'users.id')
            ->pluck('nombre','id');
        return view('disponibilidad.index')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('usuarios',$usuarios);
    }

    public function lista(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect('/');

        $rules = [
            'usuario'=>'required|exists:users,id',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date'
        ];


        Validator::make($request->all(),$rules)->validate();

        $fecha_inicio_time = strtotime($request->fecha_inicio);
        $fecha_fin_time = strtotime($request->fecha_fin);

        $fecha_limite_time = strtotime('+15days',$fecha_inicio_time);

        //la fecha de inicio no puede ser menor a la fecha fin
        if($fecha_inicio_time > $fecha_fin_time)
            return response(['error'=>['La fecha de inicio no puede ser mayor a la fecha de fin.']],422);

        //la fecha de inicio no puede ser menor a la fecha fin
        if($fecha_fin_time > $fecha_limite_time)
            return response(['error'=>['La fecha de fin debe ser mayor a la fecha de inicio (15 dias màximo).']],422);

        $usuario = User::permitidos(false)->find($request->usuario);
        if(!$usuario)
            return response(['error'=>['La información enviada es incorrecta.']],422);


        $disponibilidades = [];//$usuario->disponibilidades()->whereBetween('disponibilidades.fecha',[$request->fecha_inicio,$request->fecha_fin])->get();

        $fecha_aux = $fecha_inicio_time;
        $completo = false;
        //se arma un array con cada fecha para mostrar la disponibilidad por dìa
        while (!$completo){
            $disponibilidades_aux = $usuario->disponibilidades()->where('disponibilidades.fecha',date('Y-m-d',$fecha_aux))->orderBy('disponibilidades.hora_inicio')->orderBy('disponibilidades.minuto_inicio')->get();
            $disponibilidades[date('Y-m-d',$fecha_aux)] = $disponibilidades_aux;
            if($fecha_aux == $fecha_fin_time)
                $completo = true;
            else
                $fecha_aux = strtotime('+1days',$fecha_aux);
        }

        return view('disponibilidad.lista')
            ->with('usuario',$usuario)
            ->with('disponibilidades',$disponibilidades)
            ->with('hoy',strtotime(date('Y-m-d')))
            ->render();

    }

    public function guardar(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'asignar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $rules = [
            'usuario'=>'required|exists:users,id',
            'hora_inicio'=>'required|in:06:00,06:30,07:00,07:30,08:00,08:30,09:00,09:30,10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00,17:30,18:00,18:30,19:00,19:30,20:00,20:30,21:00,21:30',
            'hora_fin'=>'required|in:06:30,07:00,07:30,08:00,08:30,09:00,09:30,10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00,17:30,18:00,18:30,19:00,19:30,20:00,20:30,21:00,21:30,22:00'
        ];

        $messages = [
            'usuario.required'=>'La información enviada es incorrecta.',
            'usuario.exists'=>'La información enviada es incorrecta.',
        ];


        Validator::make($request->all(),$rules,$messages)->validate();

        $hora_inicio = explode(':',$request->hora_inicio)[0];
        $minuto_inicio = explode(':',$request->hora_inicio)[1];

        $hora_fin = explode(':',$request->hora_fin)[0];
        $minuto_fin = explode(':',$request->hora_fin)[1];

        if($hora_fin < $hora_inicio){
            return response(['error'=>['La hora de inicio no puede ser mayor a la hora de fin']],422);
        }

        if($hora_inicio == $hora_fin){
            if($minuto_fin < $minuto_inicio){
                return response(['error'=>['La hora de inicio no puede ser mayor a la hora de fin']],422);
            }

            if($minuto_fin == $minuto_inicio){
                return response(['error'=>['La hora de inicio no puede ser igual a la hora de fin']],422);
            }
        }

        $usuario = User::permitidos(false)->find($request->usuario);

        if(!$usuario)return response(['error'=>['La información enviada es incorrecta']],422);

        DB::beginTransaction();
        foreach ($request->fechas as $fecha){
            //validamos si se puede asignar la disponibilidad consultando disponibilidades
            //en cuyos valores se encuentren los seleccionados y/o viceversa
            $disponibilidad_cruzada = $usuario->disponibilidadCruzada($fecha,$hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin);

            if($disponibilidad_cruzada){
                return response(['error'=>['Existe una disponibilidad en la cual las horas se cruzan con las horas seleccionadas. Evento ocurrido en la fecha '.$fecha]],422);
            }else{
                $disponibilidad_obj = new Disponibilidad();
                $disponibilidad_obj->fecha = $fecha;
                $disponibilidad_obj->hora_inicio = $hora_inicio;
                $disponibilidad_obj->minuto_inicio = $minuto_inicio;
                $disponibilidad_obj->hora_fin = $hora_fin;
                $disponibilidad_obj->minuto_fin = $minuto_fin;
                $disponibilidad_obj->user_id = $usuario->id;
                $disponibilidad_obj->user_creador_id = Auth::user()->id;
                $disponibilidad_obj->save();
            }
        }
        DB::commit();
        return ['success'=>true];
    }

    public function eliminar(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'eliminar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $disponibilidad = Disponibilidad::permitidos()->find($request->disponibilidad);
        if($disponibilidad){
            if($disponibilidad->permitirEliminar()) {
                $disponibilidad->delete();
                return ['success' => true];
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }
}
