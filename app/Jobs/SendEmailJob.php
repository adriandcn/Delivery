<?php

namespace App\Jobs;

// use Log;
use App\Http\Controllers\GeneratePDFController;
use App\Mail\BookingMail;
use App\Mail\SendMailable;
use App\Models\Delivery_book;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Mail;

error_reporting(E_ALL ^ E_DEPRECATED);

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id_reserva;
    protected $id_table_delivery;
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id_reserva, $id_table_delivery)
    {
        date_default_timezone_set('America/Guayaquil');
        $this->id_reserva = $id_reserva;
        $this->id_table_delivery = $id_table_delivery;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {

        //SE GENERAN LOS PDF
        $callPDF = new GeneratePDFController();
        $responsePDF = $callPDF->getInfoBooking($this->id_reserva);

        // PARAMETROS DE LA RESERVA
        $urlConsulta = $responsePDF['urlConsulta'];
        $attachPDFES = $responsePDF['pdf_es'];
        $attachPDFEN = $responsePDF['pdf_en'];
        $agrupamientos = $responsePDF['agrupamientos'];
        $reservas = $responsePDF['reservas'];
        $reserva2 = $responsePDF['reservas2'];
        $pagos = $responsePDF['pagos'];

        Log::info("*********************************************************************************************************************************");
        Log::info("INICIO JOB ENVIO EMAIL RESERVACION: ".$this->id_reserva." DE: ".$reservas[0]->c_name." ".$reservas[0]->c_lastname." FECHA: ".Carbon::now());
        // ENVIO DEL CORREO
        if(isset($reserva2[0]->email_contacto_operador)){

            Mail::to($reservas[0]->c_email, $reservas[0]->c_name." ".$reservas[0]->c_lastname)
            ->cc($reserva2[0]->email_contacto_operador)
            ->cc(config('constants.email_iwannatrip'))
            ->send(new BookingMail($urlConsulta,$attachPDFES,$attachPDFEN,$agrupamientos,$reservas,$reserva2,$pagos));

        }else{

            Mail::to($reservas[0]->c_email, $reservas[0]->c_name." ".$reservas[0]->c_lastname)
            ->cc(config('constants.email_iwannatrip'))
            ->send(new BookingMail($urlConsulta,$attachPDFES,$attachPDFEN,$agrupamientos,$reservas,$reserva2,$pagos));

        }

        // SE ACTUALIZA EL RESGITRO A ENVIADO
        $updateDelivery = Delivery_book::find($this->id_table_delivery);
        $updateDelivery->enviado = 1;
        $updateDelivery->save();

        Log::info("FIN JOB ENVIO EMAIL RESERVACION: ".$this->id_reserva." DE: ".$reservas[0]->c_name." ".$reservas[0]->c_lastname." FECHA: ".Carbon::now());
        Log::info("*********************************************************************************************************************************");
    }

}
