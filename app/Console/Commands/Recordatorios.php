<?php

namespace DogCat\Console\Commands;

use DogCat\Models\Correo;
use DogCat\Models\Notificacion;
use DogCat\Models\Recordatorio;
use DogCat\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Recordatorios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa y envia notificaciones de recordatorios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fecha = date('Y-m-d H:i');
        //calculamos los ultimos cinco minutos para recordatorios
        $horas = [];//[date('H:i',strtotime($fecha))];
        for($i = 0;$i < 5;$i++){
            $horas[] = date('H:i',strtotime('-'.$i.' minutes',strtotime($fecha)));
        }

        $recordatorios = Recordatorio::select(
        'recordatorios.*',
                'users_recordatorios.id as user_recordatorio_id',
                'users_recordatorios.user_id as user_recordatorio_user_id'
            )
            ->join('users_recordatorios','recordatorios.id','=','users_recordatorios.recordatorio_id')
            ->where('recordatorios.fecha','<=',date('Y-m-d'))
            ->whereIn('recordatorios.hora',$horas)
            ->where('users_recordatorios.visto','no')->get();

        foreach ($recordatorios as $r){
            $user = User::find($r->user_recordatorio_user_id);
            $notificacion = new Notificacion();
            $notificacion->titulo = 'Recuerda';
            $notificacion->mensaje = $r->mensaje;
            $notificacion->icon = '/imagenes/sistema/dogcat.png';
            $notificacion->link = $r->url;
            $notificacion->importancia = $r->importancia;
            $notificacion->tipo = 'recordatorio';
            $notificacion->save();
            if($user->permitir_firebase_notificaciones == 'si'){
                $notificacion_firebase_enviada = 'no';
            }else{
                $notificacion_firebase_enviada = 'no aplica';
            }
            $notificacion->users()->save($user,['notificacion_firebase_enviada'=>$notificacion_firebase_enviada]);

            $sql = "UPDATE users_recordatorios SET visto = 'si' WHERE user_id = $user->id AND recordatorio_id = $r->id";

            if($r->enviar_correo == 'si')
                Correo::recordatorio($r,$user);

            DB::statement($sql);

            Notificacion::enviarNotificacionFirebase($notificacion,$user);
        }
    }
}
