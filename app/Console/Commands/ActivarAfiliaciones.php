<?php

namespace DogCat\Console\Commands;

use DogCat\Models\Afiliacion;
use DogCat\Models\Renovacion;
use DogCat\Models\Rol;
use DogCat\User;
use Illuminate\Console\Command;

class ActivarAfiliaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activar-afiliaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activa afiliaciones que han sido pagadas';

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
        $rol = Rol::where('afiliados','si')->first();
        if(!$rol){
            echo 'No existen roles para asignar a un afiliado';
        }else {
            $afiliaciones = collect(Afiliacion::select('afiliaciones.id', 'afiliaciones.user_id','renovaciones.id as renovacion')
                ->join('renovaciones', 'afiliaciones.id', '=', 'renovaciones.afiliacion_id')
                ->join('pagos_renovaciones','renovaciones.id','=','pagos_renovaciones.renovacion_id')
                ->join('ingresos','pagos_renovaciones.ingreso_id','=','ingresos.id')
                ->where('afiliaciones.estado', 'Pagada')
                ->whereRaw('renovaciones.id IN (select max(r.id) from renovaciones as r where r.afiliacion_id = afiliaciones.id)')
                ->whereRaw('pagos_renovaciones.id IN (select max(p_r.id) from pagos_renovaciones as p_r where p_r.renovacion_id = pagos_renovaciones.renovacion_id)')
                ->where('ingresos.fecha', '<', date('Y-m-d', strtotime('-0 days')))
                ->get()->toArray());

            echo count($afiliaciones).' afiliaciones encontradas';
            $id_afiliaciones = [];
            $id_usuarios = [];
            $id_renovaciones = [];
            foreach ($afiliaciones as $data) {
                $id_afiliaciones[] = $data['id'];
                $id_usuarios[] = $data['user_id'];
                $id_renovaciones[] = $data['renovacion'];
            }
            Afiliacion::whereIn('id', $id_afiliaciones)
                ->update(['estado'=>'Activa']);

            User::whereIn('id',$id_usuarios)
                ->update(['rol_id'=>$rol->id]);

            Renovacion::whereIn('id',$id_renovaciones)
                ->update(['fecha_inicio'=>date('Y-m-d'),'fecha_fin'=>date('Y-m-d',strtotime('+1 years'))]);
        }

    }
}
