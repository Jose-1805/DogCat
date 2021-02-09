<?php

namespace DogCat\Http\Controllers;

use Collective\Html\FormFacade;
use DogCat\Models\Agenda;
use DogCat\Models\Cita;
use DogCat\Models\Disponibilidad;
use DogCat\Models\Ingreso;
use DogCat\Models\Mascota;
use DogCat\Models\MascotaRenovacion;
use DogCat\Models\Notificacion;
use DogCat\Models\Servicio;
use DogCat\Models\TareasSistema;
use DogCat\Models\Veterinaria;
use DogCat\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class CitaController extends Controller
{
    public $privilegio_superadministrador = true;
    public $identificador_modulo = 15;
    public function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    public function index(){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return redirect('/');

        $veterinarias = Veterinaria::permitidos()->where('veterinaria','si')->pluck('nombre','id');

        return view('cita.index')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('veterinarias',$veterinarias);
    }

    public function gestionCita(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return response(['errors'=>['Unauthorized.']],401);

        if(!$request->has('mascota'))
            return response(['errors'=>['EL campo mascota es obligadorio']],422);

        if(!$request->has('usuario'))
            return response(['errors'=>['EL campo usuario es obligadorio']],422);

        $usuario = User::afiliados()->where('estado','activo')->find($request->usuario);

        $mascota = Mascota::permitidosCita($usuario)->select('mascotas.*')->find($request->mascota);

        if(!$mascota)
            return response(['errors'=>['La información enviada es incorrecta.']],422);

        $servicios = Servicio::permitidosCitasMascota($mascota)->select('servicios.id','servicios.nombre','servicios.paseador')->get();

        return ['html'=>view('cita.gestion_cita')
            ->with('mascota',$mascota)
            ->with('usuario',$usuario)
            ->with('servicios',$servicios)
            ->render(),'ubicacion'=>$usuario->ubicacion];

    }

    public function selectAfiliados(Request $request){
        $usuarios = [''=>'Seleccione un usuario'];
        if($request->has('veterinaria') && $request->veterinaria) {
            $veterinaria = Veterinaria::permitidos()->find($request->veterinaria);
            if (!$veterinaria) return response(['error' => ['La información enviada es incorrecta']], 422);

            $usuarios = User::afiliados()->where('users.estado', 'activo')
                ->select('users.id', \Illuminate\Support\Facades\DB::raw('CONCAT(nombres," ",apellidos," - ",tipo_identificacion," ",identificacion) as afiliado'))
                ->join('afiliaciones','users.id','=','afiliaciones.user_id')
                ->where('afiliaciones.estado','Activa')
                ->where('users.veterinaria_afiliado_id', $veterinaria->id)
                ->pluck('afiliado', 'id')->toArray();
        }
            $name = 'usuario';

        if ($request->has('name')) $name = $request->input('name');

        return view('layouts.componentes.select')
            ->with('elementos',$usuarios)
            ->with('name',$name)->render();
    }

    public function selectMascotas(Request $request){
        $mascotas = [''=>'Seleccione una mascota'];
        if($request->has('usuario') && $request->usuario) {
            $usuario = User::afiliados()->find($request->usuario);
            if (!$usuario) return response(['error' => ['La información enviada es incorrecta']], 422);

            $mascotas = Mascota::permitidosCita($usuario)->select(DB::raw('CONCAT(mascotas.nombre," (",tipos_mascotas.nombre,")") as mascota'), 'mascotas.id')
                ->join('razas', 'mascotas.raza_id', '=', 'razas.id')
                ->join('tipos_mascotas', 'razas.tipo_mascota_id', '=', 'tipos_mascotas.id')->pluck('mascota', 'id');
        }

        $name = 'mascota';

        if($request->has('name'))$name = $request->input('name');

        return view('layouts.componentes.select')
            ->with('elementos',$mascotas)
            ->with('name',$name)->render();
    }

    public function selectEncargados(Request $request){
        $usuarios = [''=>'Seleccione un encargado'];
        if($request->has('servicio') && $request->servicio && $request->servicio != 'Seleccione un servicio') {
            $usuario = User::afiliados()->find($request->usuario_);
            if (!$usuario) return response(['error' => ['La información enviada es incorrecta']], 422);

            $mascota = Mascota::permitidosCita($usuario)->find($request->mascota);
            if (!$mascota) return response(['error' => ['La información enviada es incorrecta']], 422);

            $servicio = Servicio::permitidosCitasMascota($mascota)->find($request->servicio);
            if (!$servicio) return response(['error' => ['La información enviada es incorrecta']], 422);

            $usuarios = ['' => 'Seleccione un encargado'] + $servicio->usuarios()
                    ->select(DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'), 'users.id')
                    ->where('users.estado', 'activo')
                    ->pluck('nombre', 'id')->toArray();
        }

        $name = 'encargado';

        if($request->has('name'))$name = $request->input('name');

        return view('layouts.componentes.select')
            ->with('elementos',$usuarios)
            ->with('name',$name)->render();
    }

    //retorna los dìas que tiene disponibles el personal
    public function getDisponibilidades(Request $request){
        if($request->has('encargado') && $request->encargado) {
            $usuario = User::afiliados()->find($request->usuario_);
            if (!$usuario) return response(['error' => ['La información enviada es incorrecta']], 422);

            $mascota = Mascota::permitidosCita($usuario)->find($request->mascota);
            if (!$mascota) return response(['error' => ['La información enviada es incorrecta']], 422);

            $servicio = Servicio::permitidosCitasMascota($mascota)->find($request->servicio);
            if (!$servicio) return response(['error' => ['La información enviada es incorrecta']], 422);

            $encargado = $servicio->usuarios()
                ->where('users.estado', 'activo')->find($request->encargado);
            if (!$encargado) return response(['error' => ['La información enviada es incorrecta']], 422);

            $afiliacion = $usuario->afiliaciones()
                ->where('estado', 'Activa')->first();

            if (!$afiliacion) return response(['error' => ['La información enviada es incorrecta']], 422);

            $renovacion = $afiliacion->ultimaRenovacion();

            //fecha limite para pedir citas
            //inicialmente el final de la afiliación
            $fecha_limite_time = strtotime($renovacion->fecha_fin);

            $hoy_time = strtotime('+1days',strtotime(date('Y-m-d')));

            //si en 15 dias aun no se termina la afiliación
            //puede sacar citas hasta dentro de 15 dìas
            if (strtotime('+15days', $hoy_time) < $fecha_limite_time)
                $fecha_limite_time = strtotime('+15days', $hoy_time);

            $disponibilidades = Disponibilidad::porServicioMascota($mascota, $servicio, $encargado, $hoy_time, $fecha_limite_time);

            return view('cita.disponibilidades')
                ->with('disponibilidades',$disponibilidades)->render();
        }
    }

    public function getAgenda(Request $request){
        if($request->has('encargado') && $request->encargado
            && $request->has('fecha') && $request->fecha) {

            $usuario = User::afiliados()->find($request->usuario_);
            if (!$usuario) return response(['error' => ['La información enviada es incorrecta']], 422);

            $mascota = Mascota::permitidosCita($usuario)->find($request->mascota);
            if (!$mascota) return response(['error' => ['La información enviada es incorrecta']], 422);

            $servicio = Servicio::permitidosCitasMascota($mascota)->find($request->servicio);
            if (!$servicio) return response(['error' => ['La información enviada es incorrecta']], 422);

            //si es paseo solicitamos longitud y latitud
            if($servicio->paseador == 'si'){
                if(!$request->has('longitud') || !$request->has('latitud')){
                    return response(['error' => ['La información enviada es incorrecta']], 422);
                }
            }

            $encargado = $servicio->usuarios()
                ->where('users.estado', 'activo')->find($request->encargado);
            if (!$encargado) return response(['error' => ['La información enviada es incorrecta']], 422);

            $afiliacion = $usuario->afiliaciones()
                ->where('estado', 'Activa')->first();

            if (!$afiliacion) return response(['error' => ['La información enviada es incorrecta']], 422);

            $renovacion = $afiliacion->ultimaRenovacion();

            //fecha limite para pedir citas
            //inicialmente el final de la afiliación
            $fecha_limite_time = strtotime($renovacion->fecha_fin);
            $hoy_time = strtotime(date('Y-m-d'));

            //si en 15 dias aun no se termina la afiliación
            //puede sacar citas hasta dentro de 15 dìas
            if (strtotime('+15days', $hoy_time) < $fecha_limite_time)
                $fecha_limite_time = strtotime('+15days', $hoy_time);

            $maniana = strtotime('+2days',$hoy_time);

            $fecha_seleccionada_time = strtotime($request->fecha);

            if($fecha_limite_time < $fecha_seleccionada_time  || $fecha_seleccionada_time < $maniana)
                return response(['error' => ['La fecha seleccionada es incorrecta']], 422);

            $disponibilidades = Disponibilidad::porServicioMascotaFecha($mascota, $servicio, $encargado, $request->fecha);

            $agendas = [];
            foreach ($disponibilidades as $disponibilidad){
                $data = $disponibilidad->posiblesAgendas($servicio,$mascota,$request->longitud,$request->latitud,$request->longitud,$request->latitud);
                foreach ($data as $agenda){
                    if($mascota->citaPosible($request->fecha,$agenda)) {
                        $agendas[] = $agenda;
                    }
                }
            }

            $agendas = TareasSistema::ordenarArrayAgenda($agendas);

            $precios = $servicio->dataPreciosMascota($mascota);
            $dias = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
            $data_cita = [
                'dia'=>$dias[date('w',strtotime($request->fecha))],
                'fecha'=>$request->fecha,
                'mascota'=>$mascota->nombre.' ('.$mascota->raza->tipoMascota->nombre.')',
                'servicio'=>$servicio->nombre,
                'encargado'=>$encargado->fullName(),
            ];

            return [
                'html'=>view('cita.agendas')->with('agendas',$agendas)->render(),
                'precios'=>$precios,
                'datos_cita'=>$data_cita
            ];
        }
    }

    public function guardar(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'crear',$this->privilegio_superadministrador))
            return response(['error'=>['unauthorized.']],422);

        $rules = [
          'usuario_'=>'required|exists:users,id',
          'mascota'=>'required|exists:mascotas,id',
          'servicio'=>'required|exists:servicios,id',
          'encargado'=>'required|exists:users,id',
          'fecha'=>'required',
          'hora_inicio'=>'required',
          'minuto_inicio'=>'required',
        ];

        $messages = [
            'usuario_.required'=>'La información enviada es incorrecta',
            'usuario_.exists'=>'La información enviada es incorrecta',
            'mascota.required'=>'La información enviada es incorrecta',
            'mascota.exists'=>'La información enviada es incorrecta',
            'servicio.required'=>'La información enviada es incorrecta',
            'servicio.exists'=>'La información enviada es incorrecta',
            'encargado.required'=>'La información enviada es incorrecta',
            'encargado.exists'=>'La información enviada es incorrecta',
            'fecha.required'=>'La información enviada es incorrecta',
            'hora_inicio.required'=>'La información enviada es incorrecta',
            'minuto_inicio.required'=>'La información enviada es incorrecta',
        ];

        Validator::make($request->all(),$rules,$messages)->validate();

        $usuario = User::afiliados()->find($request->usuario_);
        if (!$usuario) return response(['error' => ['La información enviada es incorrecta']], 422);

        $mascota = Mascota::permitidosCita($usuario)->select('mascotas.*')->find($request->mascota);
        if (!$mascota) return response(['error' => ['La información enviada es incorrecta']], 422);

        $servicio = Servicio::permitidosCitasMascota($mascota)->find($request->servicio);
        if (!$servicio) return response(['error' => ['La información enviada es incorrecta']], 422);

        //si es paseo solicitamos longitud y latitud
        if($servicio->paseador == 'si'){
            if(!$request->has('longitud') || !$request->has('latitud')){
                return response(['error' => ['La información enviada es incorrecta']], 422);
            }
        }

        $encargado = $servicio->usuarios()
            ->where('users.estado', 'activo')->find($request->encargado);
        if (!$encargado) return response(['error' => ['La información enviada es incorrecta']], 422);

        $afiliacion = $usuario->afiliaciones()
            ->where('estado', 'Activa')->first();

        if (!$afiliacion) return response(['error' => ['La información enviada es incorrecta']], 422);

        $renovacion = $afiliacion->ultimaRenovacion();

        //fecha limite para pedir citas
        //inicialmente el final de la afiliación
        $fecha_limite_time = strtotime($renovacion->fecha_fin);
        $hoy_time = strtotime(date('Y-m-d'));

        //si en 15 dias aun no se termina la afiliación
        //puede sacar citas hasta dentro de 15 dìas
        if(strtotime('+15days', $hoy_time) < $fecha_limite_time)
            $fecha_limite_time = strtotime('+15days', $hoy_time);

        $maniana = strtotime('+1days',$hoy_time);

        $fecha_seleccionada_time = strtotime($request->fecha);

        if($fecha_limite_time < $fecha_seleccionada_time  || $fecha_seleccionada_time < $maniana)
            return response(['error' => ['La fecha seleccionada es incorrecta']], 422);

        $disponibilidades = Disponibilidad::porServicioMascotaFecha($mascota, $servicio, $encargado, $request->fecha);

        $agenda_seleccionada = null;
        $disponibilidad_obj = null;
        foreach ($disponibilidades as $disponibilidad){
            $data = $disponibilidad->posiblesAgendas($servicio,$mascota,$request->longitud,$request->latitud);
            foreach ($data as $agenda){
                if($mascota->citaPosible($request->fecha,$agenda)) {
                    if (intval($agenda['hora_inicio']) == intval($request->hora_inicio) && intval($agenda['minuto_inicio']) == intval($request->minuto_inicio)) {
                        $agenda_seleccionada = $agenda;
                        $disponibilidad_obj = $disponibilidad;
                    }
                }
            }
        }

        if(!$agenda_seleccionada)
            return response(['error' => ['Ocurrio un error al registrar la cita, posiblemente la hora seleccionada ha sido ocupada recientemente por alguien más. Recargue la página e intente nuevamente']], 422);

        $precios = $servicio->dataPreciosMascota($mascota);
        $mascota_renovacion = MascotaRenovacion::where('mascota_id',$mascota->id)
            ->where('renovacion_id',$renovacion->id)->first();

        DB::beginTransaction();
        $cita = new Cita();
        $cita->estado = 'Agendada';
        $cita->fecha = $disponibilidad_obj->fecha;
        $cita->valor = $precios['valor'];
        $cita->descuento = $precios['descuento'];
        $cita->entidad = 'Dogcat';
        if($servicio->veterinaria_id){
            $veterinaria = $usuario->veterinariaAfiliado;
            if($veterinaria->veterinaria == 'si'){
                $cita->entidad = 'Veterinaria';
                $cita->veterinaria_id = $veterinaria->id;
            }
        }
        $cita->servicio_id = $servicio->id;
        $cita->mascota_renovacion_id = $mascota_renovacion->id;
        if($servicio->paseador == 'si'){
            $cita->direccion = $request->direccion;
            $cita->latitud = $request->latitud;
            $cita->longitud = $request->longitud;
        }
        $cita->save();

        $agenda = new Agenda($agenda_seleccionada);
        $agenda->user_id = Auth::user()->id;
        $agenda->cita_id = $cita->id;
        $agenda->disponibilidad_id = $disponibilidad_obj->id;
        $agenda->save();
        Notificacion::nuevaCita($servicio,$disponibilidad_obj->fecha.' a las '.$agenda->hora_inicio.':'.$agenda->minuto_inicio,$encargado);
        DB::commit();
        return [
            'success'=>true,
            'mensaje'=>'La cita para la fecha '.$disponibilidad_obj->fecha.' a las '.$agenda->hora_inicio.':'.$agenda->minuto_inicio.' ha sido registrada con éxito en el sistema.'
        ];
    }

    public function getAgendaFecha(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $fecha = date('Y-m-d');
        if($request->fecha)$fecha = $request->fecha;

        $agendas = Agenda::porFecha($fecha)
            ->select('agendas.*')
            ->orderBy('agendas.hora_inicio')
            ->orderBy('agendas.minuto_inicio')->get();
        return view('cita.agenda_fecha')
            ->with('agendas',$agendas)
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->render();
    }

    public function lista(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
            $citas = Cita::permitidos()
            ->select(
                'citas.*',
                'servicios.nombre as servicio',
                'agendas.hora_inicio','agendas.minuto_inicio','agendas.hora_fin','agendas.minuto_fin',
                DB::raw('CONCAT(mascotas.nombre," (",mascotas.peso," KG)") as mascota'),
                DB::raw('CONCAT(propietario.nombres," ",propietario.apellidos) as propietario'),
                DB::raw('CONCAT(encargado.nombres," ",encargado.apellidos) as encargado')
            )->orderBy('citas.estado')->orderBy('citas.fecha')->get();

        $citas = Datatables::of($citas);

        $citas = $citas->editColumn('fecha',function ($row){
            return date('Y-m-d',strtotime($row->fecha));
        })->editColumn('hora',function ($row){
            /*return 'De '.TareasSistema::addCero($row->hora_inicio).':'.TareasSistema::addCero($row->minuto_inicio)
                .' a '.TareasSistema::addCero($row->hora_fin).':'.TareasSistema::addCero($row->minuto_fin);*/
            return TareasSistema::addCero($row->hora_inicio).':'.TareasSistema::addCero($row->minuto_inicio);
        })->editColumn('opciones',function ($row){
            $opc = '<a  href="#!" data-cita="'.$row->id.'" class="btn btn-xs margin-2 btn-primary btn-ver-cita" data-toggle="tooltip" data-placement="bottom" title="Ver completo"><i class="fas fa-eye margin-5"></i></a>';
            if(Auth::user()->tieneFuncion($this->identificador_modulo, 'cancelar', $this->privilegio_superadministrador) && $row->estado == 'Agendada') {
                $opc .= '<a href="#!" data-cita="'.$row->id.'" class="btn btn-xs margin-2 btn-danger btn-cancelar-cita" data-toggle="tooltip" data-placement="bottom" title="Cancelar cita"><i class="fas fa-minus-square margin-5"></i></a>';
            }

            if(Auth::user()->tieneFuncion($this->identificador_modulo, 'pagos', $this->privilegio_superadministrador) && $row->estado == 'Agendada') {
                $opc .= '<a href="#!" data-cita="'.$row->id.'" class="btn btn-xs margin-2 btn-success btn-pagar-cita" data-toggle="tooltip" data-placement="bottom" title="Facturar cita"><i class="fas fa-hand-holding-usd margin-5"></i></a>';
            }

            if(Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador) && $row->estado == 'Facturada') {
                $opc .= '<a href="#!" data-cita="'.$row->id.'" class="btn btn-xs margin-2 btn-success btn-finalizar-cita" data-toggle="tooltip" data-placement="bottom" title="Atender cita (finalizar)"><i class="fas fa-handshake margin-5"></i></a>';
            }
            return $opc;
        })
        ->rawColumns(['fecha','hora','opciones']);

        return $citas->make(true);
    }

    public function getDatos(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $cita = Cita::permitidos()
            ->select(
                'citas.*',
                'agendas.hora_inicio','agendas.minuto_inicio','agendas.hora_fin','agendas.minuto_fin',
                'servicios.nombre as servicio','servicios.id as servicio_id',
                'mascotas.nombre as mascota',
                'mascotas.peso as mascota_peso_mascotas',
                DB::raw('CONCAT(propietario.nombres," ",propietario.apellidos) as propietario'),
                DB::raw('CONCAT(encargado.nombres," ",encargado.apellidos) as encargado')
            )->find($request->cita);

        if(!$cita)
            return response(['error'=>['La información enviada es incorrecta']],422);

        return view('cita.datos')
            ->with('cita',$cita);
    }

    public function cancelar(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'cancelar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('motivo_cancelacion'))
            return response(['error'=>['Registre el motivo de la cancelación de la cita.']],422);

        $cita = Cita::permitidos()
            ->select(
                'citas.*',
                'agendas.hora_inicio','agendas.minuto_inicio','agendas.hora_fin','agendas.minuto_fin',
                DB::raw('CONCAT(mascotas.nombre," (",mascotas.peso," KG)") as mascota'),
                DB::raw('CONCAT(propietario.nombres," ",propietario.apellidos) as propietario'),
                DB::raw('CONCAT(encargado.nombres," ",encargado.apellidos) as encargado')
            )->find($request->cita);

        if(!$cita)
            return response(['error'=>['La información enviada es incorrecta']],422);

        if($cita->estado == 'Agendada'){
            //la fecha es mayor a la fecha limite y hay que verificar confirmación
            $permitir = true;

            if(!$cita->permitirCancelarCita()){
                $permitir = false;
                if($request->confirmar_cancelar == 'si'){
                    $permitir = true;
                }
            }

            if($permitir){
                $cita->estado = 'Cancelada';
                $cita->motivo_cancelacion = $request->motivo_cancelacion;
                $cita->save();
                return ['success'=>true];
            }else{
                return ['success'=>false];
            }
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function pagar(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'pagos',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $rules = [
            'cita'=>'required|exists:citas,id',
            'valor_servicio'=>'nullable|integer',
            'valor_adicional'=>'required_with:valor_adicional_check',
            'descripcion_valor_adicional'=>'required_with:valor_adicional_check|max:250',
            'medio_pago'=>'required|in:Efectivo,Consignación,Transferencia',
            'codigo_verificacion'=>'required_if:medio_pago,Consignación,Transferencia'
        ];

        $messages = [
            'cita.required'=>'La información enviada es incorrecta',
            'cita.exists'=>'La información enviada es incorrecta',
            'valor_adicional.required_with'=>'El campo valor adicional es obligatorio',
            'valor_adicional.numeric'=>'El campo valor adicional debe ser de tipo numérico',
            'descripcion_valor_adicional.required_with'=>'EL campo descripción de valor adicional es obligatorio',
            'descripcion_valor_adicional.max:250'=>'EL campo descripción de valor adicional puede contener máximo 250 caracteres',
            'medio_pago.required'=>'El campo medio de pago es requerido.',
            'medio_pago.in'=>'EL campo medio de pago debe contener uno de estos valores (Efectivo,Consignación,Transferencia).',
            'codigo_verificacion.required_if'=>'El campo còdigo de verificación es requerido.'
        ];

        Validator::make($request->all(),$rules,$messages)->validate();

        $cita = Cita::permitidos()->find($request->cita);
        if($cita){
            if($cita->estado == 'Agendada'){
                $mascota = $cita->getMascota();
                $servicio = $cita->servicio;

                $datos = $servicio->dataPreciosMascota($mascota);

                $cita->estado = 'Facturada';
                if(is_numeric($datos['valor'])){
                    $cita->valor = $datos['valor'];
                }else{
                    if(!$request->has('valor_servicio'))
                        return response(['errors'=>['El campo valor del servicio es obligatorio']],422);

                    if(!is_numeric($request->valor_servicio))
                        return response(['errors'=>['El campo valor del servicio debe ser numerico']],422);

                    $cita->valor = $request->valor_servicio;
                }

                $cita->descuento = $datos['descuento'];
                $cita->peso_mascota = $mascota->peso;
                if($request->valor_adicional_check){
                    if(!is_numeric($request->valor_adicional))
                        return response(['error'=>['La información enviada es incorrecta.']],422);

                    $cita->valor_adicional = $request->valor_adicional;
                    $cita->descripcion_valor_adicional = $request->descripcion_valor_adicional;
                }

                DB::beginTransaction();

                //guardamos el ingreso si es por dogcat
                if($cita->entidad == 'Dogcat') {
                    $valor = $cita->valor - (($cita->valor * $cita->descuento) / 100);
                    if (is_numeric($cita->valor_adicional)) $valor += $cita->valor_adicional;

                    $ingreso = new Ingreso();
                    $ingreso->valor = $valor;
                    $ingreso->fecha = date('Y-m-d');
                    $ingreso->fuente = 'Servicio';
                    $ingreso->servicio_id = $servicio->id;
                    $ingreso->medio_pago = $request->input('medio_pago');
                    $ingreso->user_id = Auth::user()->id;

                    if ($request->has('codigo_verificacion'))
                        $ingreso->codigo_verificacion = $request->input('codigo_verificacion');

                    $ingreso->save();

                    $cita->ingreso_id = $ingreso->id;
                }
                $cita->save();
                DB::commit();
                return ['success'=>true];
            }
        }
        return response(['error'=>['La información enviada es incorrecta.']],422);
    }

    public function finalizar(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'editar',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);


        $cita = Cita::permitidos()
            ->select('citas.*')->find($request->cita);

        if(!$cita)
            return response(['error'=>['La información enviada es incorrecta']],422);

        if($cita->estado == 'Facturada'){
            $cita->estado = 'Finalizada';
            $cita->observaciones = $request->observaciones;
            $cita->save();
            return ['success'=>true];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function getInfoValorPago(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'pagos',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $cita = Cita::permitidos()->find($request->cita);

        if(!$cita)return response(['error'=>['La información enviada es incorrecta.']],422);

        $mascota = $cita->getMascota();
        $servicio = $cita->servicio;

        $datos = $servicio->dataPreciosMascota($mascota);

        $html = '<p class="margin-bottom-20"><span class="font-weight-500">Servicio: </span>'.$servicio->nombre.'</p>';
        //si el servicio tiene un precio fijo
        if(is_numeric($datos['valor'])){
            $total = $datos['valor'];
            $html .= '<p class="alert alert-success text-center" data-descuento="'.$datos['descuento'].'" data-total="'.$total.'" id="valor_servicio">VALOR<br><span class="font-xx-large font-weight-500" id="">$'. number_format($total,0,',','.').'</span></p>';
        }else{
            //el veterinario debe ingresar el valor a pagar (sin descuento)
            $html .= '<div class="md-form">';
            $html .= '<label for="valor_servicio">Ingrese el valor del servicio</label>';
            $html .= '<input type="number" data-descuento="'.$datos['descuento'].'" class="form-control item-precio" name="valor_servicio" id="valor_servicio"/>';
            $html .= '</div>';
        }
        $html .= '<p class="font-weight-500">Descuento '.$datos['descuento'].'%</p>';

        /*$total_largo = $datos['largo']-(($datos['largo']*$datos['descuento'])/100);
        $total_corto = $datos['corto']-(($datos['corto']*$datos['descuento'])/100);
        $data_Select = [
            'largo'=>'Pelo largo: $ '.number_format($total_largo,0,',','.'),
            'corto'=>'Pelo corto: $ '.number_format($total_corto,0,',','.')
        ];

        $select = '<select name="precio" id="precio" class="form-control item-precio">';
        $select .= '<option value="largo" data-precio="'.$total_largo.'" selected>'.$data_Select['largo'].'</option>';
        $select .= '<option value="corto" data-precio="'.$total_corto.'">'.$data_Select['corto'].'</option>';
        $select .= '</select>';*/
        return $html;//$select;
    }
}
