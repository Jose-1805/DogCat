<?php

namespace DogCat\Console\Commands;

use DogCat\Models\CuotaCredito;
use DogCat\Models\Recordatorio;
use DogCat\User;
use Illuminate\Console\Command;

class RecordatorioPagoCuotaCredito extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorio-pago-cuota-credito';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea recordatorios para el pago de creditos de afiliación';

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
        $dias = config('params.dias_recordatorio_pago_cuota_credito');
        $fecha = date('Y-m-d',strtotime('+'.$dias.' days',strtotime(date('Y-m-d'))));
        $cuotas = CuotaCredito::select(
            'cuotas_creditos.*',
                    'afiliaciones.consecutivo',
                    'renovaciones.id as renovacion_id',
                    'afiliaciones.user_id as usuario'
            )
            ->join('renovaciones','cuotas_creditos.renovacion_id','=','renovaciones.id')
            ->join('afiliaciones','renovaciones.afiliacion_id','=','afiliaciones.id')
            ->where('afiliaciones.estado','Activa')
            ->where('cuotas_creditos.estado','Pendiente de pago')
            ->where('cuotas_creditos.fecha_pago',$fecha)
            ->where('cuotas_creditos.recordatorio_enviado','no')
            ->get();

        echo '*****'.count($cuotas).' Pendientes';
        foreach ($cuotas as $c){
            $recordatorio = new Recordatorio();
            $recordatorio->mensaje = 'DogCat le recuerda que debe realizar el pago de la cuota <strong>Nª '.$c->numero.'</strong>'
                    .' de su afiliación con consecutivo <strong>Nª '.$c->consecutivo.'</strong>. Este pago debe realizarse en la fecha '.$c->fecha_pago.'.'
                    .'<br><br>EL valor de su cuota es de <strong> $ '.number_format($c->valor,0,',','.').'</strong>.'
                    .'<br><br>Le recordamos que es importante que esté al día en sus pagos para seguir disfrutando de nuestros servicios.';
            $recordatorio->fecha = date('Y-m-d');
            $recordatorio->hora = date('H:i');
            $recordatorio->url = url('/credito-afiliacion/cuotas/'.$c->renovacion_id);
            $recordatorio->importancia = 'media';
            $recordatorio->enviar_correo = 'si';
            $recordatorio->user_id = $c->usuario;
            $recordatorio->save();

            $user = User::find($c->usuario);
            $recordatorio->users()->save($user);
            $c->recordatorio_enviado = 'si';
            $c->save();
        }
    }
}
