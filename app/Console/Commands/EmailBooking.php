<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendEmailJob;
use App\Mail\SendMailable;
use App\Mail\BookingMail;
use App\Http\Controllers\GeneratePDFController;
use App\Models\Delivery_book;
use Carbon\Carbon;
use Log;

class EmailBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EmailBooking:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob para envio de correos de las reservaciones';

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

        //SE BUSCAN TODOS LOS REGISTROS QUE NO ESTEN ENVIADOS
        $mails = Delivery_book::where('enviado', 0)->get();

        foreach($mails as $mail) {
            // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
            $emailJob = (new SendEmailJob($mail->id_reserva,$mail->id))->delay(Carbon::now()->addSeconds(10));
            try {
                dispatch($emailJob);
            } catch (\Throwable $th) {
                //throw $th;
                print_r($th);
                Log::info("error de envio de correo");
            }
        }
    }
}
