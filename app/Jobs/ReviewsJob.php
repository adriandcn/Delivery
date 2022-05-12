<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\ReviewsMail;
use Carbon\Carbon;
use Log;
use Mail;

class ReviewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $reserva;
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reserva)
    {
        date_default_timezone_set('America/Guayaquil');   
        $this->reserva = $reserva;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        Log::info("*********************************************************************************************************************************"); 
        Log::info("INICIO JOB ENVIO EMAIL REVIEWS TOURS: ".$this->reserva->id." DE: ".$this->reserva->c_name." ".$this->reserva->c_lastname." FECHA: ".Carbon::now());         

        Mail::to($this->reserva->c_email, $this->reserva->c_name." ".$this->reserva->c_lastname)
        ->cc(config('constants.email_iwannatrip'))
        ->send(new ReviewsMail($this->reserva));  

        Log::info("FIN JOB ENVIO EMAIL REVIEWS TOURS: ".$this->reserva->id." DE: ".$this->reserva->c_name." ".$this->reserva->c_lastname." FECHA: ".Carbon::now());         
        Log::info("*********************************************************************************************************************************");        
    }
}
