<?php

namespace App\Http\Controllers;

// use File;
// use Log;
use PDF;
use App\Repositories\DeliveryServiceRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GeneratePDFController extends Controller
{

    public function getInfoBooking($idReserva){

        $gestion = new DeliveryServiceRepository();
        $infoReservas = $gestion->getReserva($idReserva);
        $infoPago = $gestion->getInfoPagoReserva($idReserva);
        $searchUsuServ = $gestion->getUsuarioServicio($infoReservas[0]->calendar_id);
        $idUsuarioServicio = $searchUsuServ[0]->id_usuario_servicio;
        $buscoIdUsuarioServicio = $gestion->getIdUsuarioOperador($idUsuarioServicio);
        $infoReserva2 = $gestion->getInfoUsuarioOperador($buscoIdUsuarioServicio[0]->id_usuario_operador);
        $calendarGroup = $gestion->buscarIdAgrupamiento($infoReservas[0]->calendar_id);
        $infoAgrupamiento = $gestion->getInfoAgrupamiento($calendarGroup[0]->id_agrupamiento);

        $pdf_path = public_path(DIRECTORY_SEPARATOR .config('constants.pdf_path'));
        //SI EL DIRECTORIO  NO EXISTE LO CREA
        if(!File::exists($pdf_path)) {
            Log::info("EL DIRECTORIO NO EXITE Y SE CREA: ".$pdf_path);
            File::makeDirectory($pdf_path, 0777, true, true);
        }

        //SE GENERAN LOS PDF Y SE ENVIA EL CORREO
        // TODO: REVISAR ESTE TEMA, SE TIENE QUE DEVOLVER EL PATH DE S3 O HACER ESO EN EL CORREO
        // $this->generateBookingPDFBucket($infoAgrupamiento, $infoReserva2, $infoPago, $infoReservas, $gestion, $pdf_path);
        // die();

        $this->generateBookingPDFES($infoAgrupamiento, $infoReserva2, $infoPago, $infoReservas, $gestion, $pdf_path);
        $this->generateBookingPDFEN($infoAgrupamiento, $infoReserva2, $infoPago, $infoReservas, $gestion, $pdf_path);

        $urlConsulta = 'https://iwannatrip.com/consultareservacion/'.$infoReservas[0]->token_consulta;

        $pdfPathS3 = config('constants.pdf_path');
        $pdfES = $pdfPathS3.'/Reservacion-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-es.pdf';
        $pdfEN = $pdfPathS3.'/Reservation-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-en.pdf';

        $params = array(
                        'urlConsulta'=>$urlConsulta,
                        'pdf_es'=>$pdfES,
                        'pdf_en'=>$pdfEN,
                        'agrupamientos'=>$infoAgrupamiento,
                        'reservas'=>$infoReservas,
                        'reservas2'=>$infoReserva2,
                        'pagos'=>$infoPago
        );

        return $params;
    }

    /* *************************************************** */
    /*              SE GENERA EL PDF EN ESPANOL            */
    /* *************************************************** */
    public function generateBookingPDFES ($infoAgrupamiento, $infoReserva2, $infoPago, $infoReservas,$gestion,$pdf_path){

        // $consultaLogoOperador = $gestion->consultaLogoOperador($infoReservas[0]->calendar_id);
        // if(empty($consultaLogoOperador)){
        //     $textodocumento = "<center><img src='http://ec2-3-81-214-161.compute-1.amazonaws.com:81/public/images/no-image-available.png'></center>";
        // }else{
        //     $consultaLogoOperador->filename;
        //     $textodocumento = "<center><img src='http://ec2-3-81-214-161.compute-1.amazonaws.com:81/public/imges/icon/". $consultaLogoOperador[0]->filename."'></center>";
        // }

        $textodocumento = "<center><img src='https://iwannatrip.s3.us-east-1.amazonaws.com/images/img/index-logo.png'></center>";
        $textodocumento .= "<center><h1>Confirmaci&oacute;n de la Reservaci&oacute;n Sistema de Booking iWaNaTrip.com</h1></center>";
        $textodocumento .= "<h3>Informaci&oacute;n del Operador del Servicio:</h3>";
        $textodocumento .= "<p><b>Nombre del Tour:</b> ".$infoAgrupamiento[0]->nombre."</p>";

        $textodocumento .= "<div style='width:600px;'><pre><b>Detalle del Tour:</b></br> <code>".$infoAgrupamiento[0]->descripcion."</code></pre></div>";
        $textodocumento .= "<p><b>Nombre del Operador:</b> ".$infoReserva2[0]->nombre_contacto_operador_1."</p>";
        $textodocumento .= "<p><b>Empresa del Operador:</b> ".$infoReserva2[0]->nombre_empresa_operador."</p>";
        $textodocumento .= "<p><b>Direcci&oacute;n del Operador:</b> ".$infoReserva2[0]->direccion_empresa_operador."</p>";
        $textodocumento .= "<p><b>Tel&eacute;fono del Operador:</b> ".$infoReserva2[0]->telf_contacto_operador_1."</p>";
        $textodocumento .= "<p><b>Correo del Operador:</b> ".$infoReserva2[0]->email_contacto_operador."</p>";
        $textodocumento .= "<br>";
        $textodocumento .= "<h3>Informaci&oacute;n de la Reservaci&oacute;n:</h3>";
        $textodocumento .= "<p><b>Nombre del Servicio :</b> ".$infoPago[0]->nombre_calendario."</p>";
        $textodocumento .= "<p><b>Nombre del Cliente:</b> ".$infoReservas[0]->c_name." ".$infoReservas[0]->c_lastname."</p>";
        $textodocumento .= "<p><b>Correo del Cliente:</b> ".$infoReservas[0]->c_email."</p>";
        $textodocumento .= "<p><b>Tel&eacute;fono del Cliente:</b> ".$infoReservas[0]->c_phone."</p>";
        $textodocumento .= "<p><b>Reserva Desde:</b> ".$infoReservas[0]->date_from."</p>";
        $textodocumento .= "<p><b>Reserva Hasta:</b> ".$infoReservas[0]->date_to."</p>";
        $textodocumento .= "<p><b>Adultos:</b> ".$infoReservas[0]->c_adults."</p>";
        $textodocumento .= "<p><b>Ni&ntilde;os:</b> ".$infoReservas[0]->c_children."</p>";
        $textodocumento .= "<p><b>Fecha de Pago:</b> ".$infoPago[0]->fecha_pago."</p>";
        $textodocumento .= "<p><b>Monto Total de la Reservaci&oacute;n:</b> ".$infoReservas[0]->amount."</p>";
        $textodocumento .= "<br><br><br>";
        $textodocumento .= "<h3>Codigo de la Reservaci&oacute;n:</h3>";
        
        $textodocumento .= "<center><img src='https://qrickit.com/api/qr.php?d=https://iwannatrip.com/consultareservacion/".$infoReservas[0]->token_consulta."&txtcolor=442EFF&fgdcolor=76103C&bgdcolor=C0F912&qrsize=150&t=p&e=m'><center>";
       
        
        // PDF::loadHTML($textodocumento)->save($pdf_path.'/Reservacion-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-es.pdf');

        $namePdf = 'Reservacion-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-es.pdf';
        $pdfPathS3 = 'pdf/booking/'.$namePdf;
        $pdf_path = public_path(DIRECTORY_SEPARATOR .config('constants.pdf_path'));
        $pdfLocalPathFile = $pdf_path.'/'.$namePdf;
        PDF::loadHTML($textodocumento)->setPaper('a4')->save($pdfLocalPathFile);

        $this->generatePdfInBucket($pdfPathS3, $pdfLocalPathFile);

    }

    /* *************************************************** */
    /*              SE GENERA EL PDF EN INGLES            */
    /* *************************************************** */
    public function generateBookingPDFEN ($infoAgrupamiento, $infoReserva2, $infoPago, $infoReservas, $gestion, $pdf_path){

        // $consultaLogoOperador = $gestion->consultaLogoOperador($infoReservas[0]->calendar_id);
        // if(empty($consultaLogoOperador)){
        //     $textodocumento = "<center><img src='http://ec2-3-81-214-161.compute-1.amazonaws.com:81/public/images/no-image-available.png'></center>";
        // }else{
        //     $consultaLogoOperador->filename;
        //     $textodocumento = "<center><img src='http://ec2-3-81-214-161.compute-1.amazonaws.com:81/public/imges/icon/". $consultaLogoOperador[0]->filename."'></center>";
        // }

        $textodocumento = "<center><img src='https://iwannatrip.s3.us-east-1.amazonaws.com/images/img/index-logo.png'></center>";
        $textodocumento .= "<center><h1>Confirmation of reservation booking system iWaNaTrip.com</h1></center>";
        $textodocumento .= "<h3>Service Operator Information</h3>";
        $textodocumento .= "<p><b>Name of the Tour:</b> ".$infoAgrupamiento[0]->nombre_eng."</p>";
        $textodocumento .= "<div style='width:600px;text-align: justify;'><pre><b>Tour Detail:</b> ".$infoAgrupamiento[0]->descripcion_eng."</pre></div>";
        $textodocumento .= "<p><b>Operator Name:</b> ".$infoReserva2[0]->nombre_contacto_operador_1."</p>";
        $textodocumento .= "<p><b>Operator Company:</b> ".$infoReserva2[0]->nombre_empresa_operador."</p>";
        $textodocumento .= "<p><b>Operator Direction:</b> ".$infoReserva2[0]->direccion_empresa_operador."</p>";
        $textodocumento .= "<p><b>Operator phone:</b> ".$infoReserva2[0]->telf_contacto_operador_1."</p>";
        $textodocumento .= "<p><b>Operator Mail:</b> ".$infoReserva2[0]->email_contacto_operador."</p>";
        $textodocumento .= "<br>";
        $textodocumento .= "<h3>Reservation Information:</h3>";
        $textodocumento .= "<p><b>Service Name :</b> ".$infoPago[0]->nombre_calendario."</p>";
        $textodocumento .= "<p><b>Customer Name:</b> ".$infoReservas[0]->c_name." ".$infoReservas[0]->c_lastname."</p>";
        $textodocumento .= "<p><b>Customer Mail:</b> ".$infoReservas[0]->c_email."</p>";
        $textodocumento .= "<p><b>Customer Phone:</b> ".$infoReservas[0]->c_phone."</p>";
        $textodocumento .= "<p><b>Book from:</b> ".$infoReservas[0]->date_from."</p>";
        $textodocumento .= "<p><b>Book until:</b> ".$infoReservas[0]->date_to."</p>";
        $textodocumento .= "<p><b>Adult:</b> ".$infoReservas[0]->c_adults."</p>";
        $textodocumento .= "<p><b>Children:</b> ".$infoReservas[0]->c_children."</p>";
        $textodocumento .= "<p><b>Payment Date of the Reservation:</b> ".$infoPago[0]->fecha_pago."</p>";
        $textodocumento .= "<p><b>Total Amount Reservation:</b> ".$infoReservas[0]->amount."</p>";
        $textodocumento .= "<br><br><br>";
        $textodocumento .= "<h3>Booking Code:</h3>";
        $textodocumento .= "<center><img src='https://qrickit.com/api/qr.php?d=https://iwannatrip.com/consultareservacion/".$infoReservas[0]->token_consulta."&txtcolor=442EFF&fgdcolor=76103C&bgdcolor=C0F912&qrsize=150&t=p&e=m'><center>";
        // PDF::loadHTML($textodocumento)->save($pdf_path.'/Reservation-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-en.pdf');

        $namePdf = 'Reservation-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-en.pdf';
        $pdfPathS3 = 'pdf/booking/'.$namePdf;
        $pdf_path = public_path(DIRECTORY_SEPARATOR .config('constants.pdf_path'));
        $pdfLocalPathFile = $pdf_path.'/'.$namePdf;
        PDF::loadHTML($textodocumento)->save($pdfLocalPathFile);

        $this->generatePdfInBucket($pdfPathS3, $pdfLocalPathFile);

    }

    /* *************************************************** */
    /*              SE GENERA EL PDF EN EL BUCKET          */
    /* *************************************************** */
    public function generateBookingPDFBucket ($infoAgrupamiento, $infoReserva2, $infoPago, $infoReservas,$gestion,$pdf_path){
        try {
            $textodocumento = "<center><img src='http://ec2-3-81-214-161.compute-1.amazonaws.com:81/public/img/index-logo.png'></center>";
            $textodocumento .= "<center><h1>Confirmaci&oacute;n de la Reservaci&oacute;n Sistema de Booking iWaNaTrip.com</h1></center>";
            $textodocumento .= "<h3>Informaci&oacute;n del Operador del Servicio:</h3>";
            $textodocumento .= "<p><b>Nombre del Tour:</b> ".$infoAgrupamiento[0]->nombre."</p>";
            $textodocumento .= "<p><b>Detalle del Tour:</b> ".$infoAgrupamiento[0]->descripcion."</p>";
            $textodocumento .= "<p><b>Nombre del Operador:</b> ".$infoReserva2[0]->nombre_contacto_operador_1."</p>";
            $textodocumento .= "<p><b>Empresa del Operador:</b> ".$infoReserva2[0]->nombre_empresa_operador."</p>";
            $textodocumento .= "<p><b>Direcci&oacute;n del Operador:</b> ".$infoReserva2[0]->direccion_empresa_operador."</p>";
            $textodocumento .= "<p><b>Tel&eacute;fono del Operador:</b> ".$infoReserva2[0]->telf_contacto_operador_1."</p>";
            $textodocumento .= "<p><b>Correo del Operador:</b> ".$infoReserva2[0]->email_contacto_operador."</p>";
            $textodocumento .= "<br>";
            $textodocumento .= "<h3>Informaci&oacute;n de la Reservaci&oacute;n:</h3>";
            $textodocumento .= "<p><b>Nombre del Servicio :</b> ".$infoPago[0]->nombre_calendario."</p>";
            $textodocumento .= "<p><b>Nombre del Cliente:</b> ".$infoReservas[0]->c_name." ".$infoReservas[0]->c_lastname."</p>";
            $textodocumento .= "<p><b>Correo del Cliente:</b> ".$infoReservas[0]->c_email."</p>";
            $textodocumento .= "<p><b>Tel&eacute;fono del Cliente:</b> ".$infoReservas[0]->c_phone."</p>";
            $textodocumento .= "<p><b>Reserva Desde:</b> ".$infoReservas[0]->date_from."</p>";
            $textodocumento .= "<p><b>Reserva Hasta:</b> ".$infoReservas[0]->date_to."</p>";
            $textodocumento .= "<p><b>Adultos:</b> ".$infoReservas[0]->c_adults."</p>";
            $textodocumento .= "<p><b>Ni&ntilde;os:</b> ".$infoReservas[0]->c_children."</p>";
            $textodocumento .= "<p><b>Fecha de Pago:</b> ".$infoPago[0]->fecha_pago."</p>";
            $textodocumento .= "<p><b>Monto Total de la Reservaci&oacute;n:</b> ".$infoReservas[0]->amount."</p>";
            $textodocumento .= "<br><br><br>";
            $textodocumento .= "<h3>Codigo de la Reservaci&oacute;n:</h3>";
            $textodocumento .= "<center><img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$infoReservas[0]->uuid."&choe=UTF-8' /><center>";

            $namePdf = 'Reservacion-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-es.pdf';
            echo '<br>Nombre del archivo PDF: ', $namePdf;

            $pdfPathS3 = 'pdf/booking/'.$namePdf;
            // $pdfPathS3 = $namePdf;
            echo '<br>pdfPathS3: ', $pdfPathS3;

            $pdf_path = public_path(DIRECTORY_SEPARATOR .config('constants.pdf_path'));
            echo '<br>pdf_path: ', $pdf_path;

            $pdfLocalPathFile = $pdf_path.'/'.$namePdf;
            echo '<br>pdfLocalPathFile: ', $pdfLocalPathFile;
            // PDF::loadHTML($textodocumento)->save($pdf_path.'/Reservacion-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-es.pdf');
            // Se genera el PDF en el disco local
            PDF::loadHTML($textodocumento)->save($pdfLocalPathFile);

            // Se guarda el archivo generado en S3
            // Storage::disk('s3')->put($pdfPathS3, file_get_contents($pdfLocalPathFile), 'public');
            // Storage::disk('s3')->put($pdfPathS3, file_get_contents($pdfLocalPathFile));

            // TODO: METODOS PARA OBTENER LOS ARCHIVOS DESDE PDF
            // $test = Storage::disk('s3')->get($pdfPathS3);
            // $test = Storage::disk('s3')->files($pdfPathS3);
            // Storage::disk('s3')->delete('pdf/filename');
            // echo $test;

            // $namePdf = Storage::disk('s3')->url($namePdf);

            // Se verifica que el archivo existe en S3, si existe, se borra del disco local
            // $exists = Storage::disk('s3')->has('file.jpg');
            // if (Storage::disk('s3')->exists($pdfPathS3)) {
            //     echo '<br>si se verifica se borra el archivo del disco local<br>';
            //     Storage::delete($pdfLocalPathFile);
            //     unlink($pdfLocalPathFile);
            // }

            // TODO: DESCOMENTAR ESTA LINEA PARA USAR ESTA FUNCION
            $this->generatePdfInBucket($pdfPathS3, $pdfLocalPathFile);

        } catch (\Throwable $th) {
            echo '<br><br>Ocurrio un error al guardar en S3<br><br>';
            print_r($th->getMessage());
        }
    }

    private function generatePdfInBucket($bucketPath, $localPathFile){
        try {
            // Se guarda el archivo generado en S3
            Storage::disk('s3')->put($bucketPath, file_get_contents($localPathFile));
            // Se verifica que el archivo existe en S3, si existe, se borra del disco local
            if (Storage::disk('s3')->exists($bucketPath)) {
                Storage::delete($localPathFile);
                unlink($localPathFile);
            }
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }

}
