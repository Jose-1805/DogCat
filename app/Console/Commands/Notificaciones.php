<?php

namespace DogCat\Console\Commands;

use DogCat\Models\Notificacion;
use Illuminate\Console\Command;

class Notificaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia notificaciones pendientes de envio';

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
        $notificaciones = Notificacion::select('notificaciones.*')
            ->join('users_notificaciones','notificaciones.id','=','users_notificaciones.notificacion_id')
            ->where('users_notificaciones.visto','no')
            ->where('users_notificaciones.notificacion_firebase_enviada','no')->get();

        echo count($notificaciones).' notificaciones para enviar';
        foreach ($notificaciones as $notificacion){
            $notificacion->enviarFirebaseUsers();
        }
    }
}