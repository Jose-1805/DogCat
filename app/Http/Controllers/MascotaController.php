<?php

namespace DogCat\Http\Controllers;

use DogCat\Http\Requests\RequestMascota;
use DogCat\Models\Afiliacion;
use DogCat\Models\Carne;
use DogCat\Models\Imagen;
use DogCat\Models\ItemRevisionPeriodica;
use DogCat\Models\Mascota;
use DogCat\Models\Pdf;
use DogCat\Models\Plan;
use DogCat\Models\Raza;
use DogCat\Models\RevisionPeriodica;
use DogCat\Models\TipoMascota;
use DogCat\Models\Vacuna;
use DogCat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\Facades\Datatables;
use MyPDF;

class MascotaController extends Controller
{
    public $privilegio_superadministrador = true;
    static $privilegio_superadministrador_static = true;
    public $identificador_modulo = 7;
    static $identificador_modulo_static = 7;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permisoModulo:'.$this->identificador_modulo.',' . $this->privilegio_superadministrador);
    }

    /**s
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return redirect('/');

        $mascota = null;
        if($id){
            $mascota = Mascota::permitidos()->find($id);
            if(!$mascota)return redirect('/');
        }

        return view('mascota/index')
            ->with('mascotas',Mascota::permitidos()->get())
            ->with('mascota',$mascota)
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function nueva($usuario = null,$asistido = false){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear', $this->privilegio_superadministrador))
            return redirect('/');

        $usuario_obj = null;
        if($usuario){
            $usuario_obj = User::afiliados()->find($usuario);
        }

        return view('mascota/nueva')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('razas_perros',Raza::json_autocomplete('Perro'))
            ->with('razas_gatos',Raza::json_autocomplete('Gato'))
            ->with('usuario_seleccionado',$usuario_obj)
            ->with('asistido',$asistido == 'true'?true:false);
    }

    public function crear(RequestMascota $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);


        $tipo_mascota = TipoMascota::find($request->input('tipo_mascota'));
        if($tipo_mascota) {
            DB::beginTransaction();
            $mascota = new Mascota();
            $mascota->nombre = $request->input('nombre');
            $mascota->sexo = $request->input('sexo');
            $mascota->fecha_nacimiento = $request->input('fecha_nacimiento');
            $mascota->peso = $request->input('peso');
            $mascota->color = $request->input('color');
            $mascota->raza_id = $request->input('raza');

            $mascota->pelaje = $request->input('pelaje');
            $mascota->cola = $request->input('cola');
            $mascota->patas = $request->input('patas');
            $mascota->orejas = $request->input('orejas');
            $mascota->ojos = $request->input('ojos');
            $mascota->manchas = $request->input('manchas');
            $mascota->esterilizado = $request->input('esterilizado');

            if($request->has('otras_caracteristicas'))
                $mascota->otras_caracteristicas = $request->input('otras_caracteristicas');

            if($request->has('manchas'))
                $mascota->manchas = $request->input('manchas');

            if($request->has('patologias'))
                $mascota->patologias = $request->input('patologias');

            if(Auth::user()->getTipoUsuario() == 'afiliado' || Auth::user()->getTipoUsuario() == 'registro') {
                $mascota->user_id = Auth::user()->id;
            }else {
                $usuario = User::afiliados()->find($request->input('usuario'));
                if(!$usuario)return response(['error'=>['La información enviada es incorrecta.']]);
                $mascota->user_id = $usuario->id;
            }

            if(strtolower($tipo_mascota->nombre) == 'perro'){
                if(!$request->has('clasificacion')){
                    return response(['errors'=>['Seleccione la clasificación de la mascota.']],422);
                }else{
                    if($request->clasificacion != 'Mesocéfalo'
                        && $request->clasificacion != 'Braquicéfalo'
                        && $request->clasificacion != 'Dolicéfalo'
                    ){
                        return response(['errors'=>['La información enviada es incorrecta.']],422);
                    }else{
                        $mascota->clasificacion = $request->clasificacion;
                    }
                }
            }

            if(Auth::user()->getTipoUsuario() == 'personal dogcat'){
                $mascota->validado = 'si';
            }
            $mascota->save();

            if (Auth::user()->tieneFuncion($this->identificador_modulo, 'uploads', $this->privilegio_superadministrador)) {
                if ($request->hasFile('imagen')) {
                    $ruta = config('params.storage_img_perfil_mascota'). $mascota->id;
                    $imagen = $request->file('imagen');
                    $nombre = $imagen->getClientOriginalName();
                    $nombre = str_replace('-', '_', $nombre);
                    $imagen->move(storage_path('app/'.$ruta), $nombre);

                    $imagen_obj = new Imagen();
                    $imagen_obj->nombre = $nombre;
                    $imagen_obj->ubicacion = $ruta;
                    $imagen_obj->save();


                    $mascota->imagen_id = $imagen_obj->id;
                    $mascota->save();
                }
            }

            if ($request->hasFile('vacunas_file')) {
                if(!$request->has('vacunas'))
                    return response(['errors'=>['El campo vacuna es obligatorio cuando se ingresa un carné']],422);

                $ruta = config('params.storage_vacunas') . $mascota->id.'/'.strtotime(date('Y-m-d H:i:s'));
                $archivo = $request->file('vacunas_file');
                $nombre = $archivo->getClientOriginalName();
                $nombre = str_replace('-', '_', $nombre);
                $archivo->move(storage_path('app/'.$ruta), $nombre);

                $archivo_obj = new Imagen();
                $archivo_obj->nombre = $nombre;
                $archivo_obj->ubicacion = $ruta;
                $archivo_obj->save();


                $vacuna = new Vacuna();
                $vacuna->vacunas = $request->input('vacunas');
                $vacuna->mascota_id = $mascota->id;
                $vacuna->archivo_id = $archivo_obj->id;
                $vacuna->save();
            }

            if($request->has('asistido') && $request->asistido == '2')
                session()->put('msj_success','Mascota creada con éxito, a continuación diligencie y guarde la información de la afiliación.');

            DB::commit();
            return ['success'=>true,'usuario'=>$mascota->user_id];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function editar(RequestMascota $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $continuar = false;

        $mascota = Mascota::permitidos()->find($request->input('mascota'));
        if (!$mascota) return response(['error' => ['La información enviada es incorrecta']], 422);

        $tipo_mascota = TipoMascota::find($request->input('tipo_mascota'));

        if($tipo_mascota){
            $continuar = true;
        }else if(!$tipo_mascota && Auth::user()->getTipoUsuario() == 'afiliado') {
            $tipo_mascota = $mascota->raza->tipoMascota;
            $continuar = true;
        }

        if($continuar) {
            DB::beginTransaction();


            //si no es un superadministrador
            //y si la información de la mascota ya ha sido validada
            // o si la mascota a pasado solo la primera validacion y no es un personal dogcat
            if(!$mascota->permitirEditarTodo()){
                $mascota->peso = $request->input('peso');
                $mascota->cola = $request->input('cola');
                $mascota->orejas = $request->input('orejas');
                if ($request->has('patologias')) {
                    if($mascota->patologias)$mascota->patologias .= ' **** ';
                    $mascota->patologias .= $request->input('patologias');
                }

                if ($request->has('otras_caracteristicas')) {
                    if($mascota->otras_caracteristicas)$mascota->otras_caracteristicas .=  ' **** ';
                    $mascota->otras_caracteristicas .= $request->input('otras_caracteristicas');
                }

                if ($mascota->esterilizado == 'no')
                    $mascota->esterilizado = $request->input('esterilizado');

                $mascota->save();

                if (Auth::user()->tieneFuncion($this->identificador_modulo, 'uploads', $this->privilegio_superadministrador)) {
                    if ($request->hasFile('imagen')) {

                        //si la mascota tiene imagen se elimina
                        $imagen_obj = $mascota->imagen;
                        if ($imagen_obj) {
                            $file = storage_path('app/' . $imagen_obj->ubicacion . '/' . $imagen_obj->nombre);
                            @unlink($file);
                        }

                        $ruta = config('params.storage_img_perfil_mascota') . $mascota->id;

                        $imagen = $request->file('imagen');
                        $nombre = $imagen->getClientOriginalName();
                        $nombre = str_replace('-', '_', $nombre);
                        $imagen->move(storage_path('app/' . $ruta), $nombre);

                        if (!$imagen_obj)
                            $imagen_obj = new Imagen();

                        $imagen_obj->nombre = $nombre;
                        $imagen_obj->ubicacion = $ruta;
                        $imagen_obj->save();

                        $mascota->imagen_id = $imagen_obj->id;
                        $mascota->save();
                    }
                }

                if ($request->hasFile('vacunas_file')) {
                    if (!$request->has('vacunas'))
                        return response(['errors' => ['El campo vacuna es obligatorio cuando se ingresa un carné']], 422);

                    $ruta = config('params.storage_vacunas') . $mascota->id . '/' . strtotime(date('Y-m-d H:i:s'));
                    $archivo = $request->file('vacunas_file');
                    $nombre = $archivo->getClientOriginalName();
                    $nombre = str_replace('-', '_', $nombre);
                    $archivo->move(storage_path('app/' . $ruta), $nombre);

                    $archivo_obj = new Imagen();
                    $archivo_obj->nombre = $nombre;
                    $archivo_obj->ubicacion = $ruta;
                    $archivo_obj->save();


                    $vacuna = new Vacuna();
                    $vacuna->vacunas = $request->input('vacunas');
                    $vacuna->mascota_id = $mascota->id;
                    $vacuna->archivo_id = $archivo_obj->id;
                    $vacuna->save();
                }
            }else{
                $mascota->nombre = $request->input('nombre');
                $mascota->sexo = $request->input('sexo');
                $mascota->fecha_nacimiento = $request->input('fecha_nacimiento');
                $mascota->peso = $request->input('peso');
                $mascota->color = $request->input('color');
                $mascota->raza_id = $request->input('raza');

                $mascota->pelaje = $request->input('pelaje');
                $mascota->cola = $request->input('cola');
                $mascota->patas = $request->input('patas');
                $mascota->orejas = $request->input('orejas');
                $mascota->ojos = $request->input('ojos');
                $mascota->manchas = $request->input('manchas');
                $mascota->esterilizado = $request->input('esterilizado');

                if ($request->has('otras_caracteristicas')) {
                    if($mascota->otras_caracteristicas)$mascota->otras_caracteristicas .=  ' **** ';
                    $mascota->otras_caracteristicas .= $request->input('otras_caracteristicas');
                }

                if ($request->has('manchas'))
                    $mascota->manchas = $request->input('manchas');

                if ($request->has('patologias')) {
                    if($mascota->patologias)$mascota->patologias .=  ' **** ';
                    $mascota->patologias .= $request->input('patologias');
                }

                if(strtolower($tipo_mascota->nombre) == 'perro'){
                    if(!$request->has('clasificacion')){
                        return response(['errors'=>['Seleccione la clasificación de la mascota.']],422);
                    }else{
                        if($request->clasificacion != 'Mesocéfalo'
                            && $request->clasificacion != 'Braquicéfalo'
                            && $request->clasificacion != 'Dolicéfalo'
                        ){
                            return response(['errors'=>['La información enviada es incorrecta.']],422);
                        }else{
                            $mascota->clasificacion = $request->clasificacion;
                        }
                    }
                }

                $mascota->save();

                if (Auth::user()->tieneFuncion($this->identificador_modulo, 'uploads', $this->privilegio_superadministrador)) {
                    if ($request->hasFile('imagen')) {

                        //si la mascota tiene imagen se elimina
                        $imagen_obj = $mascota->imagen;
                        if ($imagen_obj) {
                            $file = storage_path('app/' . $imagen_obj->ubicacion . '/' . $imagen_obj->nombre);
                            @unlink($file);
                        }

                        $ruta = config('params.storage_img_perfil_mascota') . $mascota->id;

                        $imagen = $request->file('imagen');
                        $nombre = $imagen->getClientOriginalName();
                        $nombre = str_replace('-', '_', $nombre);
                        $imagen->move(storage_path('app/' . $ruta), $nombre);

                        if (!$imagen_obj)
                            $imagen_obj = new Imagen();

                        $imagen_obj->nombre = $nombre;
                        $imagen_obj->ubicacion = $ruta;
                        $imagen_obj->save();

                        $mascota->imagen_id = $imagen_obj->id;
                        $mascota->save();
                    }
                }

                if ($request->hasFile('vacunas_file')) {
                    if (!$request->has('vacunas'))
                        return response(['errors' => ['El campo vacuna es obligatorio cuando se ingresa un carné']], 422);

                    $ruta = config('params.storage_vacunas') . $mascota->id . '/' . strtotime(date('Y-m-d H:i:s'));
                    $archivo = $request->file('vacunas_file');
                    $nombre = $archivo->getClientOriginalName();
                    $nombre = str_replace('-', '_', $nombre);
                    $archivo->move(storage_path('app/' . $ruta), $nombre);

                    $archivo_obj = new Imagen();
                    $archivo_obj->nombre = $nombre;
                    $archivo_obj->ubicacion = $ruta;
                    $archivo_obj->save();


                    $vacuna = new Vacuna();
                    $vacuna->vacunas = $request->input('vacunas');
                    $vacuna->mascota_id = $mascota->id;
                    $vacuna->archivo_id = $archivo_obj->id;
                    $vacuna->save();
                }
            }
            DB::commit();
            session()->put('msj_success','Mascota actualizada con éxito');
            return ['success'=>true];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function formVacunas(Request $request){
        if($request->has('fecha_nacimiento') && $request->has('tipo_mascota')){
            $fecha_nacimiento = strtotime($request->input('fecha_nacimiento'));
            $hoy = strtotime(date('Y-m-d'));
            $diferencia_mes = ((($hoy - $fecha_nacimiento)/86400)/30.5);
            if($diferencia_mes < 3)return 'No es posible afiliar a esta mascota, todas las mascotas afiliadas a DogCat deben tener como minimo 3 meses de edad.';

            $tipo_mascota = TipoMascota::find($request->input('tipo_mascota'));
            if($tipo_mascota) {
                $vacunas = $tipo_mascota->vacunas()->where(function ($q) use ($diferencia_mes) {
                        $q->where(function ($q_1) use ($diferencia_mes) {
                            $q_1->whereRaw('mes_primera_dosis - ' . $diferencia_mes . ' BETWEEN -0.5 AND 0.5 OR mes_primera_dosis < '.$diferencia_mes);
                            })
                            ->orWhere(function ($q_2) use ($diferencia_mes) {
                                $q_2->whereRaw('mes_segunda_dosis - ' . $diferencia_mes . ' BETWEEN -0.5 AND 0.5 OR mes_segunda_dosis < '.$diferencia_mes);
                            })
                            ->orWhere(function ($q_3) use ($diferencia_mes) {
                                $q_3->whereRaw('mes_tercera_dosis - ' . $diferencia_mes . ' BETWEEN -0.5 AND 0.5OR mes_tercera_dosis < '.$diferencia_mes);
                            });
                    })->get();

                if($request->has('mascota')) {
                    $mascota = Mascota::permitidos()->find($request->input('mascota'));
                    if (!$mascota) return false;
                    else return view('mascota.forms.vacunas')
                        ->with('identificador_modulo',$this->identificador_modulo)
                        ->with('vacunas', $vacunas)->with('mascota', $mascota);
                }
                return view('mascota.forms.vacunas')
                    ->with('identificador_modulo',$this->identificador_modulo)
                    ->with('vacunas', $vacunas);
            }
        }
        return 'La información enviada es incorrecta';
    }

    public function vistaEditar($mascota){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador))
            return redirect('/');

        if(Auth::user()->getTipoUsuario() == 'empleado'){
            $mascota = Mascota::permitidos()->where('mascotas.validado','si')->find($mascota);
        }else {
            $mascota = Mascota::permitidos()->find($mascota);
        }

        if(!$mascota)return redirect('/');

        return view('mascota/editar')
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador)
            ->with('razas_perros',Raza::json_autocomplete('Perro'))->with('razas_gatos',Raza::json_autocomplete('Gato'))->with('mascota',$mascota);
    }

    public function lista(){
        if (Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador)){
            $mascotas = Mascota::permitidos()->select('mascotas.*',DB::raw('CONCAT(users.nombres," ",users.apellidos) as propietario')
                ,DB::raw('CONCAT(users.tipo_identificacion , " " ,users.identificacion) as identificacion_propietario')
                ,'razas.nombre as raza',DB::raw('CONCAT(mascotas.peso," KG") as peso'))
                ->join('users','mascotas.user_id','=','users.id')
                ->join('razas','mascotas.raza_id','=','razas.id');

            if(Auth::user()->getTipoUsuario() == 'empleado')
                $mascotas = $mascotas->where('mascotas.validado','si');

            $mascotas = $mascotas->get();

            $table = Datatables::of($mascotas);

            $table = $table->editColumn('imagen',function ($row){
                if($row->imagen){
                    $ruta = url('/almacen/'.str_replace('/','-',$row->imagen->ubicacion).'-'.$row->imagen->nombre);
                    return '<div class="rounded-circle z-depth-2" style="margin: 0 auto;height: 60px!important;width: 60px!important;background-image: url('.$ruta.');background-repeat: no-repeat;background-position: center;background-size: cover;">';
                }
                return '';
            })->editColumn('edad',function ($row){
                return $row->strDataEdad();
            })->editColumn('opciones',function ($row){
                $opc = '';
                if (Auth::user()->tieneFuncion($this->identificador_modulo, 'editar', $this->privilegio_superadministrador)) {
                    $opc .= "<a data-toggle='tooltip' data-placement='right' title='Editar' href='" . url('mascota/editar/' . $row->id) . "' class='btn btn-xs margin-2 btn-primary'><i class='fa fa-edit'></i></a>";
                }

                if($row->validado == 'no'){
                    if(Auth::user()->tieneFuncion($this->identificador_modulo, 'validar', $this->privilegio_superadministrador)) {
                        $opc .= "<a data-toggle='tooltip' data-placement='right' title='Validar registro' data-mascota='$row->id' href='#!' class='btn btn-xs margin-2 btn-primary btn-validar'><i class='fa fa-check'></i></a>";
                    }
                }else if($row->validado == 'si' && $row->informacion_validada == 'no'){
                    if(Auth::user()->tieneFuncion($this->identificador_modulo, 'validar informacion', $this->privilegio_superadministrador)) {
                        $opc .= "<a data-toggle='tooltip' data-placement='right' title='Validar informacion' data-mascota='$row->id' href='#!' class='btn btn-xs margin-2 btn-success btn-validar-informacion'><i class='fa fa-clipboard-list'></i></a>";
                    }
                }

                if($row->informacion_validada == 'si'){
                    if(Auth::user()->tieneFuncion($this->identificador_modulo, 'ver_revision', $this->privilegio_superadministrador)) {
                        $opc .= "<a data-toggle='tooltip' data-placement='right' title='Revisiones periodicas' href='".url('/mascota/revision/'.$row->id)."' class='btn btn-xs margin-2 btn-info'><i class='fas fa-briefcase-medical'></i></a>";
                    }
                }

                return $opc;
            })->rawColumns(['opciones','imagen']);

            $table = $table->make(true);
            return $table;
        }
    }

    public function vacuna($vacuna){
        $vacuna_obj = Vacuna::permitidos()->find($vacuna);
        if($vacuna_obj) {
            $path = storage_path('app/'.$vacuna_obj->archivo->ubicacion.'/'.$vacuna_obj->archivo->nombre);

            if (!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    }

    public function validar(Request $request){
        $mascota = Mascota::findOrFail($request->mascota);

        $mascota->user_validacion_id = Auth::user()->id;
        $mascota->validado = 'si';
        $mascota->save();
    }

    public function validarInformacion(Request $request){
        $mascota = Mascota::findOrFail($request->mascota);

        if($mascota->validado != 'si')
            return response(['errors'=>['La información enviada es incorrecta']],422);

        $mascota->user_informacion_validada_id = Auth::user()->id;
        $mascota->informacion_validada = 'si';
        $mascota->save();
    }

    public function revision($id){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver_revision', $this->privilegio_superadministrador))
            return redirect('/');

        $mascota = Mascota::permitidos()->find($id);

        if(!$mascota)return redirect('/');

        return view('mascota.revision.index')
            ->with('mascota',$mascota)
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function listaRevisiones(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver_revision', $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        if($request->mascota){
            $mascota = Mascota::permitidos()->find($request->mascota);
            if($mascota){
                $revisiones = $mascota->revisionesPeriodicas()->orderBy('revisiones_periodicas.id','DESC')->get();
                return view('mascota.revision.lista')
                    ->with('mascota',$mascota)
                    ->with('revisiones',$revisiones);
            }
        }

        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function nuevaRevision($id){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear_revision', $this->privilegio_superadministrador))
            return redirect('/');

        $mascota = Mascota::permitidos()->find($id);

        if(!$mascota)return redirect('/');

        $revision = RevisionPeriodica::where('user_id', Auth::user()->id)
            ->where('mascota_id',$mascota->id)
            ->where('estado','iniciada')
            ->first();

        return view('mascota.revision.nueva')
            ->with('mascota',$mascota)
            ->with('revision',$revision)
            ->with('identificador_modulo',$this->identificador_modulo)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function guardarRevision(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'crear_revision', $this->privilegio_superadministrador))
            return redirect('/');

        if(!$request->has('mascota'))
            return response(['error'=>['La información enviada es incorrecta']],422);

        $mascota = Mascota::permitidos()->find($request->mascota);

        if(!$mascota)
            return response(['error'=>['La información enviada es incorrecta']],422);

        DB::beginTransaction();

        if($request->has('revision')){
            if(Auth::user()->esSuperadministrador()){
                $revision = RevisionPeriodica::find($request->revision);
            }else {
                $revision = RevisionPeriodica::where('user_id', Auth::user()->id)->find($request->revision);
            }
        }else{
            $revision = new RevisionPeriodica();
            $revision->estado = 'iniciada';
            $revision->item_actual = config('params.items_revisiones')[0];
            $revision->mascota_id = $request->mascota;
            $revision->user_id = Auth::user()->id;
            $revision->save();
        }

        $item_previo = $revision->item_actual;

        if(!$revision)
            return response(['error'=>['La información enviada es incorrecta']],422);

        $item_revision = new ItemRevisionPeriodica();
        $item_revision->nombre = $revision->item_actual;
        if($request->observaciones){
            $item_revision->observaciones = $request->observaciones;
        }else{
            $item_revision->observaciones = config('params.default_revision_periodica');
        }
        $item_revision->revision_periodica_id = $revision->id;
        $item_revision->save();

        //si existen evidencias
        if($request->hasFile('evidencias')){
            $evidencias_indice = 1;
            $rutas = [];
            foreach ($request->evidencias as $evidencia){

                $tamanio = $evidencia->getSize()/1000;

                if($tamanio > config('params.maximo_peso_archivos')) {
                    foreach ($rutas as $r)
                        @unlink($r);
                    return response(['error' => ['La evidencia #' . $evidencias_indice . ' es demasiado pesada (max.' . config('params.maximo_peso_archivos') . ' Kb)']], 422);
                }

                $extension = $evidencia->getClientOriginalExtension();
                $posibles_extenciones = ['jpg','jpeg','png','pdf'];
                if(!is_numeric(array_search($extension,$posibles_extenciones))) {
                    foreach ($rutas as $r)
                        @unlink($r);
                    return response(['error' => ['Solamente se permiten archivos de tipo (jpg, jpeg, png o pdf)']], 422);
                }

                $nombre = 'evidencia_'.$evidencias_indice++.'.'.$extension;

                $ruta = config('params.storage_evidencias_revisiones_periodicas') . $revision->id.'/'.$item_revision->nombre;
                $evidencia->move(storage_path('app/'.$ruta), $nombre);

                $rutas[] = storage_path('app/'.$ruta.'/'.$nombre);

                $evidencia_obj = new Imagen();
                $evidencia_obj->nombre = $nombre;
                $evidencia_obj->ubicacion = $ruta;
                $evidencia_obj->save();

                $item_revision->evidencias()->save($evidencia_obj);
            }
        }

        //asigna el siguiente item para la revision o la termina si no hay más
        $revision->siguiente();

        if($revision->estado == 'terminada'){
            session(['msj_success'=>'La revisión ha sido registrada y terminada con éxito']);
        }

        DB::commit();
        return [
            'success'=>true,
            'mensaje'=>'Revisión de <strong>'.$item_previo.'</strong> registrada con éxito. A continuación, realice y diligencie la revision de <strong>'.$revision->item_actual.'</strong>.',
            'revision'=>$revision,
            'url_lista_revisiones'=>url('/mascota/revision/'.$mascota->id)
        ];
    }

    public function datosRevision(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver_revision', $this->privilegio_superadministrador))
            return redirect('/');

        if(!$request->has('mascota') || !$request->has('revision'))
            return response(['error'=>['La información enviada es incorrecta']],422);

        $mascota = Mascota::permitidos()->find($request->mascota);

        if(!$mascota)
            return response(['error'=>['La información enviada es incorrecta']],422);

        $revision = $mascota->revisionesPeriodicas()->find($request->revision);

        if(!$revision)
            return response(['error'=>['La información enviada es incorrecta']],422);

        return view('mascota.revision.datos')
            ->with('mascota',$mascota)
            ->with('revision',$revision)->render();
    }

    public function evidenciaRevision($mascota,$evidencia){
        $evidencia = Mascota::permitidos()->select('imagenes.*')
            ->join('revisiones_periodicas','mascotas.id','=','revisiones_periodicas.mascota_id')
            ->join('items_revisiones_periodicas','revisiones_periodicas.id','=','items_revisiones_periodicas.revision_periodica_id')
            ->join('imagenes_items_revisiones_periodicas','items_revisiones_periodicas.id','=','imagenes_items_revisiones_periodicas.item_revision_periodica_id')
            ->join('imagenes','imagenes_items_revisiones_periodicas.imagen_id','=','imagenes.id')
            ->where('mascotas.id',$mascota)
            ->where('imagenes.id',$evidencia)->first();

        if($evidencia){
            $path = storage_path('app/'.$evidencia->ubicacion.'/'.$evidencia->nombre);

            if (!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    }

    public function edad(Request $request){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver', $this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('mascota'))
            return response(['error'=>['La información enviada es incorrecta']],422);

        $mascota = Mascota::permitidos()->find($request->mascota);

        if(!$mascota)
            return response(['error'=>['La información enviada es incorrecta']],422);

        if($request->tipo == 'años'){
            return $mascota->edad($request->tipo);
        }elseif($request->tipo == 'meses'){
            return $mascota->edad($request->tipo);
        }else{
            return $mascota->edad();
        }
    }

    public function revisionPdf($mascota,$revision){
        if (!Auth::user()->tieneFuncion($this->identificador_modulo, 'ver_revision', $this->privilegio_superadministrador))
            return redirect('/');


        $mascota = Mascota::permitidos()->find($mascota);

        if(!$mascota)return redirect('/');

        $revision = $mascota->revisionesPeriodicas()->find($revision);

        if($revision){
            Pdf::revision($revision,$mascota);
        }

        return redirect('/');
    }
}