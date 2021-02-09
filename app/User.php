<?php

namespace DogCat;

use DogCat\Models\Actualizacion;
use DogCat\Models\Afiliacion;
use DogCat\Models\Disponibilidad;
use DogCat\Models\Funcion;
use DogCat\Models\Imagen;
use DogCat\Models\Mascota;
use DogCat\Models\Modulo;
use DogCat\Models\Recordatorio;
use DogCat\Models\Rol;
use DogCat\Models\SolicitudAfiliacion;
use DogCat\Models\Ubicacion;
use DogCat\Models\Veterinaria;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use phpseclib\Crypt\Hash;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_identificacion',
        'identificacion',
        'nombres',
        'apellidos',
        'telefono',
        'celular',
        'fecha_nacimiento',
        'email',
        'genero',
        'estado_civil',
        'certificado',
        'password',
        'imagen_id',
        'ubicacion_id',
        'rol_id',
        'veterinaria_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function permitidos($incluir_inactivos = true){
        if(Auth::user()->esSuperadministrador() || Auth::user()->getTipoUsuario() == 'personal dogcat'){
            //no permite ver usuarios empleados o afiliados
            $users = User::whereNull('users.veterinaria_empleo_id')
                    ->whereNull('users.veterinaria_afiliado_id')
                    ->whereNotNull('password');
        }else{
            $users = User::where('users.veterinaria_empleo_id',Auth::user()->veterinaria_empleo_id)
                    ->whereNotNull('password');
        }

        if(!$incluir_inactivos){
            $users = $users->where('users.estado','activo');
        }

        return $users;
    }

    /**
     * Usuarios afiliados permitidos segun el usuario logueado
     *
     * @return mixed
     */
    public static function afiliados(){
        if(Auth::user()->esSuperadministrador() || Auth::user()->getTipoUsuario() == 'personal dogcat'){
            if(Auth::user()->rol->asesor == 'si') {
                return User::whereNotNull('users.veterinaria_afiliado_id')
                    ->where('users.asesor_asignado_id',Auth::user()->id);
            }else{
                return User::whereNotNull('users.veterinaria_afiliado_id');
            }
        }else if(Auth::user()->getTipoUsuario() == 'empleado'){
            return User::where('users.veterinaria_afiliado_id',Auth::user()->veterinaria_empleo_id);
        }else{
            return User::where('users.id',Auth::user()->id);
        }
    }

    /**
     * Usuarios de tipo afiliados pero que no tienen una afiliacion activa relacionada
     */
    public static function afiliadosSinAfiliacion(){
        return User::afiliados()
            ->whereNotIn('users.id',Afiliacion::select('afiliaciones.user_id')->whereIn('afiliaciones.estado',['Pendiente de pago','Pagada','Activa'])->get());
    }

    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id');
    }

    public function veterinaria(){
        return $this->belongsTo(Veterinaria::class,'veterinaria_empleo_id');
    }

    public function veterinariaAfiliado(){
        return $this->belongsTo(Veterinaria::class,'veterinaria_afiliado_id');
    }

    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class,'ubicacion_id');
    }

    public function imagenPerfil(){
        return $this->belongsTo(Imagen::class,'imagen_id');
    }

    public function solicitudAfiliaciones(){
        return $this->hasMany(SolicitudAfiliacion::class,'user_id');
    }

    public function solicitudAfiliacionActiva(){
        return $this->solicitudAfiliaciones()
            ->where(function ($q){
                $q->whereIn('estado',['registrada','en proceso'])
                    ->orWhere(function ($q1){
                       $q1->where('estado','procesada')
                           ->whereNull('afiliacion_id');
                    });
            })
            ->first();
    }

    public function esSuperadministrador(){
        if($this->rol->superadministrador == "si")return true;
        return false;
    }

    /**
     * Consulta si un usuario tiene un modulo asignado a su rol
     *
     * @param $identificador -> identificador unico del modulo
     * @return bool
     */
    public function tieneModulo($identificador){
        $permisos = $this->rol->privilegios;
        if(is_numeric(strpos($permisos,'('.$identificador.',')))
            return true;

        return false;

    }

    public function tieneFuncion($identificador_modulo,$nombre_funcion,$privilegio_superadministrador){

        $identificador_funcion = config('params')['funciones'][strtolower($nombre_funcion)];
        if($privilegio_superadministrador && $this->esSuperadministrador()){
            return true;
        }

        $permisos = $this->rol->privilegios;
        $modulo = Modulo::where('identificador',$identificador_modulo)->first();
        $funcion = Funcion::where('identificador',$identificador_funcion)->first();

        if($modulo && $funcion && $modulo->tieneFuncion($funcion->id) && $modulo->estado == 'Activo') {
            $result = ''.strpos($permisos,'(' . $identificador_modulo . ',' . $identificador_funcion . ')');
            if ( $result != '')
                return true;
        }

        return false;

    }

    /**
     * Determina si un usuario tiene habilitadas funciones especificas o una de ellas
     *
     * @param $identificador_modulo
     * @param $funciones => Array con los identificadores de las funciones que se necesitan
     * @param $all => Determina si para retornar verdadero se debe tener todas las funciones o por lo menos una
     * @param $privilegio_superadministrador => Determina si se aplica Excepcion cuando el rol del usuario es superadministrador
     */
    public function tieneFunciones($identificador_modulo,$funciones,$all,$privilegio_superadministrador){
        $return = true;

        for ($i = 0; $i < count($funciones);$i++){
            if($this->tieneFuncion($identificador_modulo,$funciones[$i],$privilegio_superadministrador)){
                if(!$all){
                    return true;
                }else{
                    $return = true;
                }
            }else{
                if($all){
                    return false;
                }else{
                    $return = false;
                }
            }
        }
        return $return;
    }

    public function generarPassword($save = false){
        $cadena = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $password = "";
        $lengh = rand(10,20);
        for($i = 0;$i < $lengh;$i++){
            $password .= $cadena[rand(0,strlen($cadena)-1)];
        }
        $this->password = Hash::make($password);
        if($save)$this->save();
        return $password;
    }

    public function fullName(){
        return $this->nombres.' '.$this->apellidos;
    }

    /**
     * Retorna el tipo de usuario del objeto -> afiliado -> Personal dogcat -> empleado -> registro
     */
    public function getTipoUsuario(){
        $rol = $this->rol;
        if($rol->afiliados == 'si'){
            return 'afiliado';
        }

        if($rol->veterinaria_id || $rol->veterinarias == 'si'){
            return 'empleado';
        }

        if($rol->registros == 'si'){
            return 'registro';
        }

        return 'personal dogcat';
    }

    /**
     * Retorna el objeto de la veterinaria con la cual este asociado
     * el usuario ya sea como empleado o afiliado
     */
    public function getVeterinaria(){
        $veterinaria = null;
        switch ($this->getTipoUsuario()){
            case 'afiliado':
                $veterinaria = $this->veterinariaAfiliado;
                break;
            case 'empleado':
                $veterinaria = $this->veterinaria;
                break;
        }
        return $veterinaria;
    }

    /**
     * Define si el usuario relacionado con el objeto
     * tiene activas todas las dependencias necesarias para su funcionamiento
     *
     *
     */
    public function dependenciasActivas(){
        $tipo_usuario = $this->getTipoUsuario();
        $dependeciasActivas = true;
        switch ($tipo_usuario){

            case 'afiliado':
                $veterinaria = $this->veterinariaAfiliado;
                if(!$veterinaria || $veterinaria->estado == 'inactiva')
                    $dependeciasActivas = false;
                break;
            case 'empleado':
                $veterinaria = $this->veterinaria;
                if(!$veterinaria || $veterinaria->estado == 'inactiva')
                    $dependeciasActivas = false;
                break;
            case 'registro':
                $veterinaria = $this->veterinariaAfiliado;
                if(!$veterinaria || $veterinaria->estado == 'inactiva')
                    $dependeciasActivas = false;
                break;
            case 'personal dogcat':
                break;
        }

        if($this->estado == 'inactivo')$dependeciasActivas = false;

        return $dependeciasActivas;
    }

    public function mascotas(){
        return $this->hasMany(Mascota::class,'user_id');
    }

    public function mascotasAflliadas(){
        return $this->mascotas()->select('mascotas.*')
            ->join('mascotas_renovaciones','mascotas.id','=','mascotas_renovaciones.mascota_id')
            ->join('renovaciones','mascotas_renovaciones.renovacion_id','=','renovaciones.id')
            ->join('afiliaciones','renovaciones.afiliacion_id','=','afiliaciones.id')
            ->where('afiliaciones.estado','Activa')
            ->where('mascotas_renovaciones.estado','Activo')->get();
    }

    public function afiliaciones(){
        return $this->hasMany(Afiliacion::class,'user_id');
    }

    /**
     * Busca y return una afiliación que el usuario tenga activa o en proceso
     */
    public function afiliacionActivaOProceso(){
        return $this->afiliaciones()
            ->where(function ($q){
                $q->where('estado','Pendiente de pago')
                    ->orWhere('estado','Pagada')
                    ->orWhere('estado','Activa');
            })->first();
    }

    public function mascotasValidadas(){
        return $this->mascotas()->where('validado','si')->get();
    }

    public function disponibilidades(){
        return $this->hasMany(Disponibilidad::class,'user_id');
    }

    /**
     * Identifica si existe una diponibilidad registrada que cruce sus horarios
     * con los parametros enviados
     *
     * @param $fecha
     * @param $hora_inicio
     * @param $minuto_inicio
     * @param $hora_fin
     * @param $minuto_fin
     *
     */
    public function disponibilidadCruzada($fecha,$hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
        return $this->disponibilidades()->select('disponibilidades.id')
                    ->where('disponibilidades.fecha',$fecha)
                    ->where(function ($q) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                        //disponibilidades que incluyan la hora de inicio seleccionada
                        $q->where(function ($q1) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                                $q1->where('hora_inicio','<',$hora_inicio)
                                    ->where('hora_fin','>',$hora_inicio);
                            })
                            //disponibilidades que incluyan la hora de fin seleccionada
                            ->orWhere(function ($q2) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                                $q2->where('hora_inicio','<',$hora_fin)
                                    ->where('hora_fin','>',$hora_fin);
                            })
                            //disponibilidades cuya hora de inicio este dentro de la disponibilidad seleccionada
                            ->orWhere(function ($q3) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                                $q3->where('hora_inicio','>',$hora_inicio)
                                    ->where('hora_inicio','<',$hora_fin);
                            })
                            //disponibilidades cuya hora de fin este dentro de la disponibilidad seleccionada
                            ->orWhere(function ($q4) use($hora_inicio,$minuto_inicio,$hora_fin,$minuto_fin){
                                $q4->where('hora_fin','>',$hora_inicio)
                                    ->where('hora_fin','<',$hora_fin);
                            })
                            //disponibilidades cuya hora de inicio y fin sean iguales a la hora de inicio y fin seleccionadas
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

    public function strDireccionMaps(){
        $ubicacion = $this->ubicacion;
        if($ubicacion){
            return $ubicacion->stringDireccion(true);
        }
        return 'Popayán - Cauca (Colombia)';
    }

    //indica si se debe cobrar impueto de pago para el asesor
    //el impuesto de pago para el esesor se hace cuando es la primera afliación
    public function impuestoAsesor(){
        $afiliacion = $this->afiliaciones()->first();
        if($afiliacion){
            $renovacion = $afiliacion->ultimaRenovacion();
            if($renovacion){
                return false;
            }
        }
        return true;
    }

    public function terminosCondicionesAprobados(){
        if($this->getTipoUsuario() == 'afiliado'){
            if($this->terminos_condiciones_aceptados == 'no'){
                return false;
            }
        }
        return true;
    }

    public function clearFirebaseToken(){
        $this->firebase_token = null;
        $this->save();
    }

    public function recordatorios(){
        return $this->belongsToMany(Recordatorio::class,'users_recordatorios','user_id', 'recordatorio_id');
    }

    public function actualizaciones(){
        return $this->belongsToMany(Actualizacion::class,'users_actualizaciones','user_id','actualizacion_id');
    }

    public function actualizacionPendiente(){
        $ultima_actualizacion = Actualizacion::orderBy('id','DESC')->first();
        if($ultima_actualizacion){
            $actualizacion_vista = $this->actualizaciones()
                ->where('users_actualizaciones.actualizacion_id',$ultima_actualizacion->id)
                ->first();
            if($actualizacion_vista){
                return false;
            }else{
                return $ultima_actualizacion;
            }
        }else{
            return false;
        }
    }

    public function actualizarSistema(){
        $actualizacion = $this->actualizacionPendiente();
        if($actualizacion){
            $this->actualizaciones()->save($actualizacion);
        }
    }
}
