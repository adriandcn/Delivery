<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ReviewsJob;
use App\Repositories\DeliveryServiceRepository;

use Carbon\Carbon;
use Log;

class Reviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reviews:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob para envio de reviews de las reservaciones';

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

        $gestion = new DeliveryServiceRepository();

        //ESTADO DEL REVIEW EN LA RESERVA ES IGUAL A 0        
        $reservacionesCronCero = $gestion->getReservacionesCron(2);
        if(!empty($reservacionesCronCero)){
            foreach ($reservacionesCronCero as $reservaCron){
                $fromDate = date('Y-m-d');
                $curDate = date($reservaCron->date_to);
                $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
                $days = $daysLeft/(60 * 60 * 24);
                //SI LA DIFERENCIA EN MAYOR A 1 DIA
                if($days > 0 || $days > '0'){             
                    //VERIFICO EN LA TABLA DE INTENTOS
                    $getAgrupamientoReviewIntentos = $gestion->getAgrupamientoReviewIntentos($reservaCron->calendar_id);
                    $verificoIntentosEmail = $gestion->verificoIntentosEmail($reservaCron,$getAgrupamientoReviewIntentos[0]->id_agrupamiento);
                    $contador = count($verificoIntentosEmail);
                    //SI LOS INTENTOS SON MENOR QUE 3 ENVIAR EL CORREO Y AUMENTAR EN LA TABLA DE INTENTOS
                    if($contador < 3){
                        //ENVIO DE CORREO AL CORREO DE LA RESERVACION
                        // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
                        $emailReviewJob = (new ReviewsJob($reservaCron))->delay(Carbon::now()->addSeconds(5));
                        dispatch($emailReviewJob);                          
                        //GUARDO EN LA TABLA DE INTENTOS
                        $guardarEnIntentos = $gestion->guardarEnIntentosEmail($getAgrupamientoReviewIntentos[0]->id_agrupamiento,$reservaCron);
                    }                     
                } 
            }           
        }

        //ESTADO DEL REVIEW EN LA RESERVA ES IGUAL A NULL
        $reservacionesCronNull = $gestion->getReservacionesCron(1);
        if(!empty($reservacionesCronNull)){
            foreach ($reservacionesCronNull as $reservaCron){
                $fromDate = date('Y-m-d');
                $curDate = date($reservaCron->date_to);
                $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
                $days = $daysLeft/(60 * 60 * 24);
                if($days > 0 || $days > '0'){
                    //ACTUALIZO EL ESTADO DEL REVIEW DE LA RESERVACION A 0
                    $estadoReviewReserva = $gestion->updateEstadoReviewReservacion($reservaCron->id);
                    //VERIFICO EN LA TABLA DE INTENTOS
                    $getAgrupamientoReviewIntentos = $gestion->getAgrupamientoReviewIntentos($reservaCron->calendar_id);
                    $verificoIntentosEmail = $gestion->verificoIntentosEmail($reservaCron,$getAgrupamientoReviewIntentos[0]->id_agrupamiento);
                    $contador = count($verificoIntentosEmail);
                    //SI LOS INTENTOS SON MENOR QUE 3 ENVIAR EL CORREO Y AUMENTAR EN LA TABLA DE INTENTOS
                    if($contador < 3){
                        //ENVIO DE CORREO AL CORREO DE LA RESERVACION
                        // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
                        $emailReviewJob = (new ReviewsJob($reservaCron))->delay(Carbon::now()->addSeconds(5));
                        dispatch($emailReviewJob);                                 
                        //GUARDO EN LA TABLA DE INTENTOS
                        $guardarEnIntentos = $gestion->guardarEnIntentosEmail($getAgrupamientoReviewIntentos[0]->id_agrupamiento,$reservaCron);
                    }                    
                } 
            }
        }        
       
    }
}
