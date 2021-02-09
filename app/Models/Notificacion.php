<?php

namespace DogCat\Models;

use DogCat\User;
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Notificacion extends Model
{
    protected $table = "notificaciones";

    protected $fillable = [
        'mensaje',
        'titulo',
        'icon',
        'link'
    ];

    public static function permitidos(){
        return Notificacion::select('notificaciones.*')
            ->join('users_notificaciones','notificaciones.id','=','users_notificaciones.notificacion_id')
            ->where('users_notificaciones.user_id',Auth::user()->id);
    }

    public function users(){
        return $this->belongsToMany(User::class,'users_notificaciones','notificacion_id','user_id');
    }

    /**
     *  Envia notificaciones push por firebase
     *  a los usuarios relacionados con la notificacion.
     *
     *  Se consultan los usuarios que no han visto la notificación,
     *  a los que no se han enviado antes la notificacion por firebase
     *  que tienen habilitado el permiso para enviar notificaciones push con firebase
     *  y que tienen la sesion activa (pueden recibir la notificacion)
     */
    public function enviarFirebaseUsers(){
        $users = $this->users()
            ->select('users.*')
            ->where('users.permitir_firebase_notificaciones','si')
            ->whereNotNull('users.firebase_token')
            ->where('users_notificaciones.visto','no')
            ->where('users_notificaciones.notificacion_firebase_enviada','no')
            ->get();

        foreach ($users as $user){
            Notificacion::enviarNotificacionFirebase($this,$user);
        }
    }

    /**
     * Envia la notificacion recibida en el primer parametro
     * al usuario recibido en el segundo parametro
     *
     * @param Notificacion $notificacion
     * @param $user
     */
    public static function enviarNotificacionFirebase(Notificacion $notificacion,$user){
        $user_notificacion = UserNotificacion::where('user_id',$user->id)
            ->where('notificacion_id',$notificacion->id)
            ->where('visto','no')
            ->where('notificacion_firebase_enviada','no')
            ->first();

        if($user_notificacion){
            //si no tiene permitido el envio de notificaciones
            //cambiamos el campo notificacion_firebase_enviada para no volver a intentar enviar
            //la notificacion
            if($user->permitir_firebase_notificaciones == 'no'){
                $user_notificacion->notificacion_firebase_enviada = 'no aplica';
                $user_notificacion->save();
            }else {
                //si se tiene un token para el usuario (generalmente es cuando tiene una sesion activa)
                if($user->firebase_token) {

                    $file_name = storage_path('app/restringido/') . 'dogcat-1526672577530-firebase-adminsdk-pumwk-ccf50812ef.json';

                    $client_google = new ServiceAccountCredentials([
                        'https://www.googleapis.com/auth/firebase.messaging',
                    ], $file_name);
                    $token = $client_google->fetchAuthToken()['access_token'];

                    //si se logra obtener el token de acceso
                    if($token) {

                        $cliente = new Client();

                        $url = "https://fcm.googleapis.com/v1/projects/dogcat-1526672577530/messages:send";

                        $notification = [
                            "title"=>$notificacion->titulo,
                            "body"=>$notificacion->mensaje,
                            "tipo"=>$notificacion->tipo,
                            "importancia"=>'importancia_'.$notificacion->importancia,
                            "icon"=>"/imagenes/sistema/dogcat.png",
                            "html"=>view('notificacion.lista_items')
                                ->with('notificaciones',collect([$notificacion]))->render(),
                            "identificador_notificacion"=>"$notificacion->id",
                        ];

                        if($notificacion->icon){
                            $notification["icon"] = $notificacion->icon;
                        }

                        if($notificacion->link){
                            $notification["click_action"] = $notificacion->link;
                        }

                        $body = [
                            "message"=>[
                                "data"=>$notification,
                                "token"=>$user->firebase_token,
                            ],
                        ];

                        $body = json_encode($body);
                        //dd($token);

                        $res = $cliente->request('POST', $url, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $token,
                                'Content-Type' => 'application/json',
                            ],
                            'body' => $body,
                        ]);


                        if($res->getStatusCode() == '200'){
                            $sql = "UPDATE users_notificaciones SET notificacion_firebase_enviada = 'si' WHERE user_id = $user->id AND notificacion_id = $notificacion->id";
                            DB::statement($sql);
                        }else{
                            $body = $res->getBody();
                            $data = \GuzzleHttp\json_decode($body->read($body->getSize()));
                            //dd($data);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param Registro $registro
     *
     * Registra e intenta enviar la notificación de nuevo registro en el sistema
     */
    public static function nuevoRegistro(Registro $registro){
        //usuarios superadministradores
        $users = User::select('users.*')
            ->join('roles','users.rol_id','=','roles.id')
            ->where('roles.superadministrador','si')->get();

        $notificacion = new Notificacion();
        $notificacion->titulo = 'Nuevo registro';
        $notificacion->mensaje = $registro->nombre.' se registró en el sistema';
        $notificacion->icon = '/imagenes/sistema/dogcat.png';
        $notificacion->link = url('/registro/historial/'.$registro->id);
        $notificacion->importancia = 'media';
        $notificacion->tipo = 'notificacion';
        $notificacion->save();
        foreach ($users as $u)
            $notificacion->users()->save($u,['notificacion_firebase_enviada'=>$u->permitir_firebase_notificaciones == 'si'?'no':'no aplica']);

        $notificacion->enviarFirebaseUsers();
    }

    /**
     * @param Registro $registro
     *
     * Registra e intenta enviar la notificación cuando se asigna un registro a alguien
     */
    public static function registroAsignado(Registro $registro,$user){

        $notificacion = new Notificacion();
        $notificacion->titulo = 'Registro asignado';
        $notificacion->mensaje = 'Le ha sido asignado el registro de '.$registro->nombre.'.';
        $notificacion->icon = '/imagenes/sistema/dogcat.png';
        $notificacion->link = url('/registro/historial/'.$registro->id);
        $notificacion->importancia = 'media';
        $notificacion->tipo = 'notificacion';
        $notificacion->save();
        $notificacion->users()->save($user,['notificacion_firebase_enviada'=>$user->permitir_firebase_notificaciones == 'si'?'no':'no aplica']);

        $notificacion->enviarFirebaseUsers();
    }

    /**
     * @param SolicitudAfiliacion $solicitud
     *
     * Registra e intenta enviar notificación cuando se registra una solicitud de afiliación
     */
    public static function solicitudAfiliacion(SolicitudAfiliacion $solicitud){
        $user = $solicitud->usuario;
        //usuarios superadministradores
        $users = User::select('users.*')
            ->join('roles','users.rol_id','=','roles.id')
            ->where('roles.superadministrador','si')->get();

        $notificacion = new Notificacion();
        $notificacion->titulo = 'Solicitud de afiliación';
        $notificacion->mensaje = 'Nueva solicitud de afiliación de '.$user->fullName();
        $notificacion->icon = '/imagenes/sistema/dogcat.png';
        $notificacion->link = url('/solicitud-afiliacion/historial/'.$solicitud->id);
        $notificacion->importancia = 'media';
        $notificacion->tipo = 'notificacion';
        $notificacion->save();
        foreach ($users as $u)
            $notificacion->users()->save($u,['notificacion_firebase_enviada'=>$u->permitir_firebase_notificaciones == 'si'?'no':'no aplica']);

        $notificacion->enviarFirebaseUsers();
    }

    /**
     * @param SolicitudAfiliacion $solicitud
     *
     * Registra e intenta enviar notificación cuando se registra una solicitud de afiliación
     */
    public static function nuevaCita(Servicio $servicio,$fecha,$usuario_encargado){
        $notificacion = new Notificacion();
        $notificacion->titulo = 'Nueva cita';
        $notificacion->mensaje = 'Nueva cita para '.$servicio->nombre.'. Fecha: '.$fecha;
        $notificacion->icon = '/imagenes/sistema/dogcat.png';
        $notificacion->importancia = 'media';
        $notificacion->tipo = 'notificacion';
        $notificacion->save();
        $notificacion->users()->save($usuario_encargado,['notificacion_firebase_enviada'=>$usuario_encargado->permitir_firebase_notificaciones == 'si'?'no':'no aplica']);
        $notificacion->enviarFirebaseUsers();
    }

    /**
     * @param Afiliacion $afiliacion
     *
     * Registra e intenta enviar notificación cuando se registra una nueva afiliación
     */
    public static function nuevaAfiliacion(Afiliacion $afiliacion, $user_registro){
        $user = $afiliacion->userAfiliado;
        //usuarios superadministradores
        $users = User::select('users.*')
            ->join('roles','users.rol_id','=','roles.id')
            ->where('roles.superadministrador','si')->get();

        $notificacion = new Notificacion();
        $notificacion->titulo = 'Nueva afiliación';
        $notificacion->mensaje = $user_registro->fullName().' registró una afiliación para '.$user->fullName();
        $notificacion->icon = '/imagenes/sistema/dogcat.png';
        $notificacion->link = url('/afiliacion/ver/'.$afiliacion->id);
        $notificacion->importancia = 'media';
        $notificacion->tipo = 'notificacion';
        $notificacion->save();
        foreach ($users as $u)
            $notificacion->users()->save($u,['notificacion_firebase_enviada'=>$u->permitir_firebase_notificaciones == 'si'?'no':'no aplica']);

        $notificacion->enviarFirebaseUsers();
    }

    /**
     * @param Afiliacion $afiliacion
     *
     * Registra e intenta enviar notificación cuando se realiza un pago de una afiliación pendiente de pago
     */
    public static function pagoAfiliacion(Afiliacion $afiliacion, $user_registro){
        $user = $afiliacion->userAfiliado;
        //usuarios superadministradores
        $users = User::select('users.*')
            ->join('roles','users.rol_id','=','roles.id')
            ->where('roles.superadministrador','si')->get();

        $notificacion = new Notificacion();
        $notificacion->titulo = 'Pago de afiliación';
        $notificacion->mensaje = $user_registro->fullName().' registró el pago de afiliación para '.$user->fullName();
        $notificacion->icon = '/imagenes/sistema/dogcat.png';
        $notificacion->link = url('/afiliacion/ver/'.$afiliacion->id);
        $notificacion->importancia = 'media';
        $notificacion->tipo = 'notificacion';
        $notificacion->save();
        foreach ($users as $u)
            $notificacion->users()->save($u,['notificacion_firebase_enviada'=>$u->permitir_firebase_notificaciones == 'si'?'no':'no aplica']);

        $notificacion->enviarFirebaseUsers();
    }
}