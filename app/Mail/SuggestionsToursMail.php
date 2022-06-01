<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Log;

class SuggestionsToursMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $reserva;
    protected $nombreDestino;
    protected $agrupamientosDestino;
    protected $nombreOrigen;
    protected $agrupamientosOrigen;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserva, $nombreDestino, $agrupamientosDestino, $nombreOrigen, $agrupamientosOrigen)
    {
        $this->reserva = $reserva;
        $this->nombreDestino = $nombreDestino;
        $this->agrupamientosDestino = $agrupamientosDestino;
        $this->nombreOrigen = $nombreOrigen;
        $this->agrupamientosOrigen = $agrupamientosOrigen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->view('emails.suggestions')
                        ->subject(utf8_decode($this->reserva->c_name.' '.$this->reserva->c_lastname.', the best experiences are waiting for you!!!'))        
                        ->with('nombrepara',$this->reserva->c_name." ".$this->reserva->c_lastname)
                        ->with('nombredestino',$this->nombreDestino)
                        ->with('tourdestino',$this->agrupamientosDestino)
                        ->with('nombreorigen',$this->nombreOrigen)
                        ->with('tourorigen',$this->agrupamientosOrigen)                                                       
                        ->with('facebookImg',public_path('/img/facebook.png'))                                
                        ->with('instagramImg',public_path('/img/instagram.png'))                                
                        ->with('logoImg',public_path('img/logo_iwana.png'));    
                                    
        return $message; //Send mail          
    }
}
