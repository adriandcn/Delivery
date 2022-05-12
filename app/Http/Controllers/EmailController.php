<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SuggestionsToursJob;
use App\Jobs\RememberReservationJob;
use App\Mail\SendMailable;
use App\Mail\BookingMail;
use App\Http\Controllers\GeneratePDFController;
use App\Models\Delivery_book;
use Carbon\Carbon;
use Log;

use App\Mail\SuggestionsToursMail;
use App\Models\Booking\Booking_abcalendar_reservation;
use App\Models\Agrupamiento_origin_destino;
use App\Models\Ubicacion_geografica;
use App\Repositories\DeliveryServiceRepository;

use App\Models\Booking\Booking_abcalendar_coupon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use \DateTime;

class EmailController extends Controller
{

    public function generateRandomString($length = 5) {
        return substr(str_shuffle(str_repeat($x='123456789ABCDEFGHJKLMNPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    public function sendEmail()
    {

        echo '<br><br>';
        echo 'prueba de funcionamiento laravel deliveryIWT';
        echo '<br><br>';
        die();

        date_default_timezone_set('America/Guayaquil');

        $key = hex2bin("0123456789abcdef0123456789abcdef");
        $iv =  hex2bin("abcdef9876543210abcdef9876543210");

        $crypttext = ' NUNe71-eTBzJm-WpohRgvc5AqfQPUZl-U8D03q8UvHpuA0FkVYFR2EGBcNpFvfBA8RDF9MAu+GiFBb+qPpIoZA8OHOItkKV8blhyH2n1O0QdsQSAc3LKmHazbIBTN8FI';
        echo '<br>';
        echo 'Sin el cambio: '. $crypttext;
        echo '<br>';
        echo 'Con el cambio: '. $crypttext = str_replace('-', '/', $crypttext);
        echo '<br>';

        $decrypted = openssl_decrypt($crypttext, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        // finally we trim to get our original string
        echo $decrypted = trim($decrypted);
        echo '<br><br><br>';
        $idUsuario = explode('_', $decrypted);
        echo '<br><br><br>';
        print_r($idUsuario);
        // echo '<br><br><br>';
        // echo 'id del usuario: '. $idUsuario[1];
        // $decode = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $crypttext, MCRYPT_MODE_CBC, $iv);
        // echo base64_encode($crypttext);
        // echo "<br/>";
        // echo $decode;
        // echo "<br/>";

        die();

        //GENERO LA FECHA Y EL IDENTIFICADOR
        echo 'FECHAS: '.$fecha = \Carbon\Carbon::now()->toDateTimeString();
        echo '<br>';
        echo 'UUID: '.$uuid = "13413123_".$fecha;
        echo '<br>';
        //ENCRIPTO EL IDENTIFICADOR
        // echo 'ENCRIPTADO: ' . Hash::make($uuid);
        // echo '<br>';
        // echo 'ENCRIPTADO: ' . $hashed = Hash::make('password', ['rounds' => 12]);


        echo '<br>';
        echo 'ENCRIPTADO: '. $encrypted = \Crypt::encryptString($uuid);
        echo '<br>';
        echo 'dENCRIPTADO: ' . $decrypted = \Crypt::decryptString($encrypted);
        echo '<br><br><br>';
        //echo 'NUEVO dENCRIPTADO: ' . $decrypted = \Crypt::decryptString('09edb9cb7a3245c62150c5f5fe81d6f7d2914d4335451996530f37ba324dff18b0');


        echo '<br>';
        echo '<br>';
        // if (Hash::check('plain-text', $hashed)) {
        //     echo 'EL PASSWORD COINCIDE';
        // }else{
        //     echo 'EL password no coincide';
        // }
        // die();

        echo '<br>';
        echo '<br>';
        echo 'ENCRIPTADO: ' . $encriptado =  \Crypt::encrypt($uuid);

        //echo 'DESENCRIPTADO: ' . $encriptado1=  \Crypt::decrypt($uuid);


        die();
        $gestion = new DeliveryServiceRepository();

        $agrupamiento = $gestion->getGroupName(108);
        $calendario = $gestion->getCalendarName(108);
        $fecha = date('d M Y', strtotime('2019-07-30'));

        $message = view('emails.reviews')
                // ->with('nombrepara',$this->reserva->c_name." ".$this->reserva->c_lastname)
                // ->with('title','iWaNaTrip Review Verification')
                ->with('nombrepara','Fabio Paredes')
                ->with('agrupamiento',$agrupamiento[0]->nombre)
                ->with('calendario',$calendario[0]->nombre)
                ->with('fecha',$fecha)
                ->with('token_reservations','eyJpdiI6IlFlcDZlNDZQZ2ZcLytNZDk0aUFPdWpnPT0iLCJ2YWx1ZSI6Ik04VmMzcncxd2N4dTBoXC9McTBzMmlJN3NleW5vbjNVWXhDd2JTZ3NTSFBJPSIsIm1hYyI6ImQxYjYwMTU3YzE5ZGE2MTkxZTU2NGVjNjg2NDkyZmY5Y2U5NTU0NzVlODgzZThiYjlkODI0MTUzN2FlNzI0MTUifQ==')
                ->with('facebookImg',public_path('/img/facebook.png'))
                ->with('instagramImg',public_path('/img/instagram.png'))
                ->with('logoImg',public_path('img/logo_iwana.png'));

        // $message = view('emails.suggestions')
        // //->subject(utf8_decode($this->reserva->c_name.' '.$this->reserva->c_lastname.', the best experiences are waiting for you!!!'))
        // ->with('nombrepara',$suggestion->c_name." ".$suggestion->c_lastname)
        // ->with('nombredestino',$nombreDestino[0]->nombre)
        // ->with('tourdestino',$destino)
        // ->with('nombreorigen',$nombreOrigen[0]->nombre)
        // ->with('tourorigen',$origen)
        // ->with('facebookImg',public_path('/img/facebook.png'))
        // ->with('instagramImg',public_path('/img/instagram.png'))
        // ->with('logoImg',public_path('img/logo_iwana.png'));

        return $message; //Send mail

        die();
        $gestion = new DeliveryServiceRepository();

        $datetime1 = new DateTime('2019-07-24 00:29:15');
        print_r($datetime1);
        echo '<br><br>';
        $datetime2 = new DateTime(date("Y-m-d H:i:s"));
        print_r($datetime2);
        echo '<br><br>';
        $difference = $datetime1->diff($datetime2);
        echo $diasDiferencia = $difference->h;


        die();

        $reservacionesCronCero = $gestion->getReservacionesCron(2);
        //print_r($reservacionesCronCero);

        foreach ($reservacionesCronCero as $reservaCron){
            $fromDate = date('Y-m-d');
            $curDate = date($reservaCron->date_to);
            $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
            $days = $daysLeft/(60 * 60 * 24);

            echo 'Diferencia en dias: '.$days;
            //SI LA DIFERENCIA EN MAYOR A 1 DIA
            if($days > 0 || $days > '0'){
                //VERIFICO EN LA TABLA DE INTENTOS
                $getAgrupamientoReviewIntentos = $gestion->getAgrupamientoReviewIntentos($reservaCron->calendar_id);
                $verificoIntentosEmail = $gestion->verificoIntentosEmail($reservaCron,$getAgrupamientoReviewIntentos[0]->id_agrupamiento);
                $contador = count($verificoIntentosEmail);
                echo '<br>';
                //SI LOS INTENTOS SON MENOR QUE 3 ENVIAR EL CORREO Y AUMENTAR EN LA TABLA DE INTENTOS
                // if($contador < 3){
                //     //ENVIO DE CORREO AL CORREO DE LA RESERVACION
                //     // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
                //     $emailReviewJob = (new SuggestionsToursJob($reservaCron))->delay(Carbon::now()->addSeconds(5));
                //     dispatch($emailReviewJob);
                //     //GUARDO EN LA TABLA DE INTENTOS
                //     $guardarEnIntentos = $gestion->guardarEnIntentosEmail($getAgrupamientoReviewIntentos[0]->id_agrupamiento,$reservaCron);
                // }
            }
        }
        die();

        $reservations = Booking_abcalendar_reservation::where('status','Pending')->where('enviado_enganche',0)->get();

        //print_r($reservations);
        foreach($reservations as $reservation) {
            // echo '<br><br>';
            // echo 'ID DE LA RESERVACION: '.$reservation->id.'<br>';
            // echo 'FECHA DE L RESERVA: '.$reservation->date_from.'<br>';
            // echo 'FECHA DE CREACION: '.$reservation->created.'<br>';
            // echo 'FECHA ACTUAL: '.date("Y-m-d H:i:s").'<br>';
            // echo '<br>';

            $datetime1 = new DateTime($reservation->created);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $difference = $datetime1->diff($datetime2);
            $diasDiferencia = $difference->d;

            //echo 'Difference in days: ' .$difference->d;

            if($diasDiferencia < 1){

                //echo '<br> se envia el correo y se actualiza la reservacion <br>';

                $cupon = Booking_abcalendar_coupon::where('id_res_origen',$reservation->id)->where('estado',0)->select('codigo')->get();

                if(isset($cupon[0]->codigo)){
                    echo 'Numero del CUpon: '.$cupon[0]->codigo;
                    $nombreAgrupamiento = $gestion->getGroupName($reservation->calendar_id);

                    //echo '<br><h1>Nombre del Agrupamiento: '.$nombreAgrupamiento[0]->nombre.'</h1><br>';

                    // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
                    // $emailJob = (new RememberReservationJob($reservation,$nombreAgrupamiento[0]->nombre,$cupon[0]->codigo))->delay(Carbon::now()->addSeconds(5));
                    // dispatch($emailJob);

                    // SE ACTUALIZA LA RESERVA A ENVIADO_ENGANCHE
                    //$actualizarReserva = $gestion->updateReservationRemember($reservation->id);

                    $fechaExpiracion = date('d M Y', strtotime($cupon[0]->fecha_expiracion));

                    $message = view('emails.remember')
                    //->subject(utf8_decode($this->reserva->c_name.' '.$this->reserva->c_lastname.', the best experiences are waiting for you!!!'))
                    ->with('nombrepara','Fabio Paredes')
                    ->with('nombretour',$nombreAgrupamiento[0]->nombre_eng)
                    ->with('cupon',$cupon[0]->codigo)
                    ->with('porcentaje',$cupon[0]->cantidad)
                    ->with('fechaExpiracion',$fechaExpiracion)
                    ->with('usuarioServicio',$nombreAgrupamiento[0]->id_usuario_servicio)
                    ->with('agrupamientoId',$nombreAgrupamiento[0]->id)
                    ->with('title', 'Get a disscount for your next trip')
                    ->with('facebookImg',public_path('/img/facebook.png'))
                    ->with('instagramImg',public_path('/img/instagram.png'))
                    ->with('logoImg',public_path('img/logo_iwana.png'));

                    return $message;
                }else{
                    echo '<br><h1>no existe cupon para esta reservacion</h1><br>';
                }


            }else{
                echo '<br><h1>NOOOOOO se envia el correo y se actualiza la reservacion</h1><br>';
            }


            echo '<br><br>';
        }

        die();


        //SE BUSCAN TODOS LOS REGISTROS QUE NO ESTEN ENVIADOS
        // $mails = Delivery_book::where('enviado', 0)->get();
        $suggestions = Booking_abcalendar_reservation::where('enviado', 0)->get();
        // print_r($suggestions);
        // die();
        foreach($suggestions as $suggestion) {

            // echo '<br><br>';
            // echo 'ID DE LA RESERVA: '.$suggestion->id;
            // echo '<br>';
            // echo 'ID DEL CALENDARIO: '.$suggestion->calendar_id;
            // echo '<br><br>';

            $agrupamiento = $gestion->getGroupCalendar($suggestion->calendar_id);
            //echo 'ID DEL AGRUPAMIENTO: '.$agrupamiento[0]->id_agrupamiento;

            $group = Agrupamiento_origin_destino::where('id_agrupamiento', $agrupamiento[0]->id_agrupamiento)->select('id_agrupamiento', 'id_canton', 'id_canton_destino')->get();
            if($group[0]->id_canton_destino){

                // echo '<br><br>';
                // echo 'ID CANTON DESTINO: '.$group[0]->id_canton_destino;
                // echo '<br><br>';

                // AGRUPAMIENTOS DE DESTINO
                $nombreDestino = Ubicacion_geografica::where('id', $group[0]->id_canton_destino)->get();
                $destino = $gestion->getSuggestionsTours($agrupamiento[0]->id_agrupamiento,$group[0]->id_canton_destino, 1);

                // echo 'Nombre de Destino: '. $nombreDestino[0]->nombre;
                // echo '<br><br>';
                // print_r($destino);
                // echo '<br><br>';

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

                //echo 'Nombre de Origen: '. $nombreOrigen[0]->nombre;
                // echo '<br><br>';
                // print_r($origen);
                // echo '<br><br>';

                if(count($origen) > 0){
                    foreach($origen as $org){
                        $fotosOrigen = $gestion->getImagesSuggetionsTours($org->id);
                        if(count($fotosOrigen) > 0){
                            $org->filename = $fotosOrigen[0]->filename;
                            $org->original_name = $fotosOrigen[0]->original_name;
                        }
                    }
                }

                // echo '<br><br>';
                // print_r($origen);
                // echo '<br><br>';
                // die();

                // SE PONE LOS CORREOS EN COLA CON DELAY EN EL ENVIO
                //$this->dispatch(new SuggestionsToursJob($suggestion,$nombreDestino[0]->nombre,$destino,$nombreOrigen[0]->nombre,$origen));

                // $emailJob = (new SuggestionsToursJob($suggestion,$nombreDestino[0]->nombre,$destino,$nombreOrigen[0]->nombre,$origen))->delay(Carbon::now()->addSeconds(5));
                // $this->dispatch($emailJob);

                // SE ACTUALIZA LA RESERVA A ENVIADO
                // $actualizarReserva = $gestion->updateReservationSeggestion($suggestion->id);
                // $updateReservation = Booking_abcalendar_reservation::find($suggestion->id);
                // $updateReservation->enviado = 1;
                // $updateReservation->save();
            }


        }

        // Log::info("FINAL Controlador");
        // echo 'email sent';

        // print_r($destino);
        // die();
        $message = view('emails.suggestions')
        //->subject(utf8_decode($this->reserva->c_name.' '.$this->reserva->c_lastname.', the best experiences are waiting for you!!!'))
        ->with('nombrepara',$suggestion->c_name." ".$suggestion->c_lastname)
        ->with('nombredestino',$nombreDestino[0]->nombre)
        ->with('tourdestino',$destino)
        ->with('nombreorigen',$nombreOrigen[0]->nombre)
        ->with('tourorigen',$origen)
        ->with('facebookImg',public_path('/img/facebook.png'))
        ->with('instagramImg',public_path('/img/instagram.png'))
        ->with('logoImg',public_path('img/logo_iwana.png'));

        return $message; //Send mail
    }

    public function generatePDF(){
        $callPDF = new GeneratePDFController();
        $callPDF->getInfoBooking(1186);
    }

}
