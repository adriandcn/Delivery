<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Log;
use App\Repositories\DeliveryServiceRepository;

class ReviewsMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $reserva;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $gestion = new DeliveryServiceRepository();
        
        $agrupamiento = $gestion->getGroupName($this->reserva->calendar_id);
        $calendario = $gestion->getCalendarName($this->reserva->calendar_id);

        $fecha = date('d M Y', strtotime($this->reserva->date_from));

        $message = $this->view('emails.reviews')
                        ->subject(utf8_decode('Rate '.$agrupamiento[0]->nombre))        
                        ->with('nombrepara',$this->reserva->c_name." ".$this->reserva->c_lastname)
                        // ->with('title','iWaNaTrip Review Verification')
                        ->with('agrupamiento',$agrupamiento[0]->nombre)
                        ->with('calendario',$calendario[0]->nombre)
                        ->with('fecha',$fecha)
                        ->with('token_reservations',$this->reserva->token_consulta)
                        ->with('facebookImg',public_path('/img/facebook.png'))                                
                        ->with('instagramImg',public_path('/img/instagram.png'))                                
                        ->with('logoImg',public_path('img/logo_iwana.png'));    
                                                        
        return $message; //Send mail      
    }
}
