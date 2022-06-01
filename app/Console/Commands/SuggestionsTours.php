<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SuggestionsToursJob;
use App\Models\Booking\Booking_abcalendar_reservation;
use App\Models\Agrupamiento_origin_destino;
use App\Models\Ubicacion_geografica;
use App\Repositories\DeliveryServiceRepository;

use Carbon\Carbon;
use Log;

class SuggestionsTours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SuggestionsTours:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob para envio de sugerencias de las reservaciones';

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
        //SE BUSCAN TODOS LOS REGISTROS QUE NO ESTEN ENVIADOS    
        $suggestions = Booking_abcalendar_reservation::where('enviado', 0)->get();

        foreach($suggestions as $suggestion) {
            
            $agrupamiento = $gestion->getGroupCalendar($suggestion->calendar_id);

            $group = Agrupamiento_origin_destino::where('id_agrupamiento', $agrupamiento[0]->id_agrupamiento)->select('id_agrupamiento', 'id_canton', 'id_canton_destino')->get();                
            if($group[0]->id_canton_destino){

                // AGRUPAMIENTOS DE DESTINO
                $nombreDestino = Ubicacion_geografica::where('id', $group[0]->id_canton_destino)->get();
                $destino = $gestion->getSuggestionsTours($agrupamiento[0]->id_agrupamiento,$group[0]->id_canton_destino, 1);

                if(count($destino) > 0){
                    foreach($destino as $dest){
                        $fotosDestino = $gestion->getImagesSuggetionsTours($dest->id);
                        if(count($fotosDestino) > 0){
                            $dest->filename = $fotosDestino[0]->filename;
                            $dest->original_name = $fotosDestino[0]->original_name;
                        }
                    }
                }

                // AGRUPAMIENTOS DE ORIGEN
                $nombreOrigen = Ubicacion_geografica::where('id', $group[0]->id_canton)->get();
                $origen = $gestion->getSuggestionsTours($agrupamiento[0]->id_agrupamiento,$group[0]->id_canton,2);

                if(count($origen) > 0){
                    foreach($origen as $org){
                        $fotosOrigen = $gestion->getImagesSuggetionsTours($org->id);
                        if(count($fotosOrigen) > 0){
                            $org->filename = $fotosOrigen[0]->filename;
                            $org->original_name = $fotosOrigen[0]->original_name;
                        }
                    }
                }  
                
                // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
                $emailJob = (new SuggestionsToursJob($suggestion,$nombreDestino[0]->nombre,$destino,$nombreOrigen[0]->nombre,$origen))->delay(Carbon::now()->addSeconds(5));
                dispatch($emailJob);     
                
                // SE ACTUALIZA LA RESERVA A ENVIADO
                $actualizarReserva = $gestion->updateReservationSeggestion($suggestion->id);                
            }
   

        }
    }
}
