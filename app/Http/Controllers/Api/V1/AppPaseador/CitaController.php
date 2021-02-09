<?php

namespace DogCat\Http\Controllers\Api\V1\AppPaseador;

use DogCat\Http\Controllers\Controller;
use DogCat\Models\Agenda;
use DogCat\Models\Cita;
use DogCat\Models\Ingreso;
use DogCat\Models\TareasSistema;
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

    public function getAgendaFecha(Request $request){
        if(!Auth::user()->tieneFuncion($this->identificador_modulo,'ver',$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $fecha = date('Y-m-d');
        if($request->fecha)$fecha = $request->fecha;

        $agendas = Agenda::porFecha($fecha)
            ->select('agendas.*')
            ->orderBy('agendas.hora_inicio')
            ->orderBy('agendas.minuto_inicio')->get();

        return $agendas;
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