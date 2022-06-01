<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\Models\Booking\Booking_abcalendar_coupon;
use Log;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $urlConsulta;
    protected $pdf_es;
    protected $pdf_en;
    protected $infoAgrupamiento;
    protected $infoReservas;
    protected $infoReserva2;
    protected $infoPago;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($urlConsulta, $attachPDFES, $attachPDFEN, $agrupamientos, $reservas, $reservas2, $pagos)
    {
        $this->urlConsulta = $urlConsulta;
        $this->pdf_es = $attachPDFES;
        $this->pdf_en = $attachPDFEN;
        $this->infoAgrupamiento = $agrupamientos;
        $this->infoReservas = $reservas;
        $this->infoReserva2 = $reservas2;
        $this->infoPago = $pagos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //SE ENVIA EL CODIGO DEL CUPON
        $cupon = Booking_abcalendar_coupon::where('id_res_origen',$this->infoReservas[0]->id)->get();
        if(isset($cupon[0]->codigo)){
            $numeroCupon = $cupon[0]->codigo;
            $porcentaje = $cupon[0]->cantidad;
            $fechaExpiracion = date('d M Y', strtotime($cupon[0]->fecha_expiracion));
        }else{
            $numeroCupon = 0;
            $porcentaje = 0;
        }

        //$message = $this->markdown('emails.booking')
        $message = $this->view('emails.booking')
                        ->subject(utf8_decode(config('constants.subject_booking')))
                        ->with('url', $this->urlConsulta)
                        ->with('uuid', $this->infoReservas[0]->uuid)
                        ->with('nombretour',$this->infoAgrupamiento[0]->nombre_eng)
                        ->with('detalletour',$this->infoAgrupamiento[0]->descripcion_eng)
                        ->with('nombreoperador',$this->infoReserva2[0]->nombre_contacto_operador_1)
                        ->with('empresaoperador',$this->infoReserva2[0]->nombre_empresa_operador)
                        ->with('direccionoperador',$this->infoReserva2[0]->direccion_empresa_operador)
                        ->with('telefonooperador',$this->infoReserva2[0]->telf_contacto_operador_1)
                        ->with('correooperador',$this->infoReserva2[0]->email_contacto_operador)
                        ->with('nombrecalendario',$this->infoPago[0]->nombre_calendario)
                        ->with('nombrepara', $this->infoReservas[0]->c_name." ".$this->infoReservas[0]->c_lastname)
                        ->with('correo',$this->infoReservas[0]->c_email)
                        ->with('desde',$this->infoReservas[0]->date_from)
                        ->with('hasta',$this->infoReservas[0]->date_to)
                        ->with('adultos',$this->infoReservas[0]->c_adults)
                        ->with('ninos',$this->infoReservas[0]->c_children)
                        ->with('estadoreserva','Confirmada')
                        ->with('fechapago',$this->infoPago[0]->fecha_pago)
                        ->with('montopago',$this->infoReservas[0]->amount)
                        ->with('cupon',$numeroCupon)
                        ->with('porcentaje',$porcentaje)
                        ->with('fechaExpiracion',$fechaExpiracion)
                        ->with('lat',$this->infoAgrupamiento[0]->lat)
                        ->with('lng',$this->infoAgrupamiento[0]->lng)
                        ->with('instruccion',$this->infoAgrupamiento[0]->instrucciones_eng)
                        ->with('facebookImg',public_path('/img/facebook.png'))
                        ->with('instagramImg',public_path('/img/instagram.png'))
                        ->with('logoImg',public_path('img/logo_iwana.png'))
                        ->with('logoMap',public_path('img/google-maps.jpg'))
                        ->with('title',utf8_decode(config('constants.title_booking')))
                        // TODO: DESCOMENTAR ESTO PARA SACAR DESDE EL DISCO LOCAL
                        // ->attach($this->pdf_es)
                        // ->attach($this->pdf_en);
                        // TODO: DESCOMENTAR ESTO PARA SACAR DESDE S3
                        ->attachFromStorageDisk('s3', $this->pdf_es)
                        ->attachFromStorageDisk('s3', $this->pdf_en);

        return $message; //Send mail
    }
}
