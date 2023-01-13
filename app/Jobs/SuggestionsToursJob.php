<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\SuggestionsToursMail;
use Carbon\Carbon;
use Log;
use Mail;

class SuggestionsToursJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reserva;
    protected $nombreDestino;
    protected $agrupamientosDestino;
    protected $nombreOrigen;
    protected $agrupamientosOrigen;
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reserva, $nombreDestino, $agrupamientosDestino, $nombreOrigen, $agrupamientosOrigen)
    {
        date_default_timezone_set('America/Guayaquil');   
        $this->reserva = $reserva;
        $this->nombreDestino = $nombreDestino;
        $this->agrupamientosDestino = $agrupamientosDestino;
        $this->nombreOrigen = $nombreOrigen;
        $this->agrupamientosOrigen = $agrupamientosOrigen;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        //
        Log::info("*********************************************************************************************************************************"); 
        Log::info("INICIO JOB ENVIO EMAIL SUGERENCIA TOURS: ".$this->reserva->id." DE: ".$this->reserva->c_name." ".$this->reserva->c_lastname." FECHA: ".Carbon::now());         

        Mail::to($this->reserva->c_email, $this->reserva->c_name." ".$this->reserva->c_lastname)
        ->cc(config('constants.email_iwannatrip'))
        ->send(new SuggestionsToursMail($this->reserva,$this->nombreDestino,$this->agrupamientosDestino,$this->nombreOrigen,$this->agrupamientosOrigen));  

        Log::info("FIN JOB ENVIO EMAIL SUGERENCIA TOURS: ".$this->reserva->id." DE: ".$this->reserva->c_name." ".$this->reserva->c_lastname." FECHA: ".Carbon::now());         
        Log::info("*********************************************************************************************************************************");        
    }
}
