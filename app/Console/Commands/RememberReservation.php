<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RememberReservationJob;
use App\Models\Booking\Booking_abcalendar_reservation;
use App\Models\Booking\Booking_abcalendar_coupon;
use App\Repositories\DeliveryServiceRepository;

use Carbon\Carbon;
use Log;
use \DateTime;

class RememberReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RememberReservation:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob para envio de correo de enganche para las reservaciones';

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
        //SE BUSCAN TODOS LOS REGISTROS QUE NO ESTEN ENVIADOS Y QUE NO ESTEN PAGADOS    
        $gestion = new DeliveryServiceRepository();
        $reservations = Booking_abcalendar_reservation::where('status','Pending')->where('enviado_enganche',0)->get();                

        foreach($reservations as $reservation) {

            $datetime1 = new DateTime($reservation->created);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));            
            $difference = $datetime1->diff($datetime2);
            $diasDiferencia = $difference->d;

            if($diasDiferencia < 1){

                $cupon = Booking_abcalendar_coupon::where('id_res_origen',$reservation->id)->where('estado',0)->select('codigo')->get();               

                if(isset($cupon[0]->codigo)){

                    $nombreAgrupamiento = $gestion->getGroupName($reservation->calendar_id);

                    // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
                    $emailJob = (new RememberReservationJob($reservation,$nombreAgrupamiento,$cupon[0]->codigo))->delay(Carbon::now()->addSeconds(5));
                    dispatch($emailJob);     
                    
                    // SE ACTUALIZA LA RESERVA A ENVIADO_ENGANCHE
                    $actualizarReserva = $gestion->updateReservationRemember($reservation->id);                                                 
                }
            }            
        }

    }
}
