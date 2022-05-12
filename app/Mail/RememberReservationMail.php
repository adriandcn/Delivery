<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\Models\Booking\Booking_abcalendar_coupon;
use Log;

class RememberReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $reserva;
    protected $nombreDestino;
    protected $codigoCupon;    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserva, $nombreDestino,$codigoCupon)
    {
        date_default_timezone_set('America/Guayaquil');   
        $this->reserva = $reserva;
        $this->nombreDestino = $nombreDestino;
        $this->codigoCupon = $codigoCupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //SE ENVIA EL CODIGO DEL CUPON
        $cupon = Booking_abcalendar_coupon::where('id_res_origen',$this->reserva->id)->get();
        if(isset($cupon[0]->codigo)){
            $numeroCupon = $cupon[0]->codigo;
            $porcentaje = $cupon[0]->cantidad;
            $fechaExpiracion = date('d M Y', strtotime($cupon[0]->fecha_expiracion));
        }else{
            $numeroCupon = 0;
            $porcentaje = 0;
        }

        $message = $this->view('emails.remember')
                        ->subject(utf8_decode($this->reserva->c_name.' '.$this->reserva->c_lastname.', get a disscount for your next trip.'))        
                        ->with('nombrepara',$this->reserva->c_name." ".$this->reserva->c_lastname)
                        ->with('nombretour',$this->nombreDestino[0]->nombre_eng)
                        ->with('cupon',$numeroCupon)
                        ->with('porcentaje',$porcentaje)     
                        ->with('fechaExpiracion',$fechaExpiracion)  
                        ->with('usuarioServicio',$this->nombreDestino[0]->id_usuario_servicio)
                        ->with('agrupamientoId',$this->nombreDestino[0]->id)        
                        ->with('title', 'Get a disscount for your next trip')                                                                    
                        ->with('facebookImg',public_path('/img/facebook.png'))                                
                        ->with('instagramImg',public_path('/img/instagram.png'))                                
                        ->with('logoImg',public_path('img/logo_iwana.png'));    
                                    
        return $message; //Send mail
    }
}
