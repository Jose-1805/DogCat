<?php

namespace DogCat\Console;

use DogCat\Console\Commands\ActivarAfiliaciones;
use DogCat\Console\Commands\EnviarCorreos;
use DogCat\Console\Commands\Notificaciones;
use DogCat\Console\Commands\RecordatorioMoraCuotaCredito;
use DogCat\Console\Commands\RecordatorioPagoCuotaCredito;
use DogCat\Console\Commands\Recordatorios;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        EnviarCorreos::class,
        ActivarAfiliaciones::class,
        Recordatorios::class,
        Notificaciones::class,
        RecordatorioPagoCuotaCredito::class,
        RecordatorioMoraCuotaCredito::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('enviar-correos')
                ->everyFiveMinutes();
        $schedule->command('activar-afiliaciones')
                ->dailyAt('00:10');
        $schedule->command('recordatorio-pago-cuota-credito')
                ->dailyAt('02:00');
        $schedule->command('recordatorio-mora-cuota-credito')
                ->dailyAt('03:00');
        $schedule->command('recordatorios')
                ->everyMinute();
        $schedule->command('notificaciones')
            ->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
