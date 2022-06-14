<?php

namespace App\Console;

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
        //
        Commands\EmailBooking::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // CRON JOB PARA ENVIO DE CORREOS BOOKING
        $schedule->command('EmailBooking:sendmail')->timezone('America/Guayaquil')->everyMinute();
        // SE SACAN LOS CORREOS DE LA COLA
        $schedule->command('queue:work --once')->everyMinute();
        // SE AGREGA LO DE ANALITICA CADA 3 HORAS
        //$schedule->command('SuggestionsTours:sendmail')->timezone('America/Guayaquil')->everyMinute();
        //$schedule->command('SuggestionsTours:sendmail')->timezone('America/Guayaquil')->hourly();
        // $schedule->command('SuggestionsTours:sendmail')->timezone('America/Guayaquil')->cron('0 */2 * * *');
        // $schedule->command('queue:work database --queue=emails --tries=3')->everyMinute();

        // CRON JOB PARA ENVIO DE CORREO DE ENGANCHE
        //$schedule->command('RememberReservation:sendmail')->timezone('America/Guayaquil')->everyMinute();

        // CRON JOB PARA ENVIO DE REVIEWS
        // $schedule->command('Reviews:sendmail')->timezone('America/Guayaquil')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
