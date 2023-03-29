<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use Yajra\Datatables\Datatables;
use App\Models\Delivery_book;
use App\Models\Booking\Booking_abcalendar_reservation;
use App\Repositories\DeliveryServiceRepository;
use Carbon\Carbon;

class AdminController extends Controller
{
   
    protected $gestion;
    public function __construct(DeliveryServiceRepository $gestion)
    {
       $this->gestion = $gestion;
    }        

    // ************************************************************* //
    // FUNCION QUE REDIRECCIONA A LOS DEMAS CONTROLADORES
    // ADMINCONTROLLER, COUPONCONTROLLER, PAYMENTCONTROLLER
    // ************************************************************* //
    public function verify($tipo, $token)
    {
        $verificar = $this->verifyToken($token);
        if(!$verificar){
            abort(404);
        }else{
            return redirect($tipo.'/'.$token);
        }
    }

    public function verifyToken($token){
        $arr = $this->gestion->verificarToken($token);  
        if ($arr[0]->uuid != $token ){
            return false;
        }else {
            // EL TOKEN YA FUE CONSUMIDO
            if($arr[0]->consumido == 1){
                return false;                
            }else{   
                //  HAGO EL UPDATE DEL CONSUMIDO A TRUE 
                $this->gestion->updateToken($arr[0]->id);
                return true;
            }         
        }        
    }
    // ************************************************************* //
    // ************************************************************* //

    public function index($token)
    {        
        $validToken = $this->validToken($token);
        if(!$validToken){
            abort(404);
        }else{
            if(request()->ajax()) {
                $correos = $this->gestion->getAllJobs();
                return Datatables::of($correos)
                                    ->addIndexColumn()                     
                                    ->addColumn('action', 'action_button')
                                    ->rawColumns(['action'])                            
                                    ->make(true);             
            }
            return view('admin')->with('token', $token);
        }
    }  
    
    public function validToken($token){    
        $reg = $this->gestion->verificarTokenDelivery($token);  
        if(empty($reg)){
            // EL TOKEN NO EXISTE            
            return false;
        }else{
            $datetime1 = new \DateTime($reg[0]->created_at);
            $datetime2 = new \DateTime(date("Y-m-d H:i:s"));            
            $difference = $datetime1->diff($datetime2);
            $horasDiferencia = $difference->h;           
            if($horasDiferencia >= 6){
                // TOKEN CADUCADO
                return false;
            }else{
                return true;
            }
        }
    }    

    public function edit($id)
    {   
        // SE ACTUALIZA EL RESGITRO A ENVIADO
        $updateDelivery = Delivery_book::find($id);
        $updateDelivery->enviado = 0;
        $updateDelivery->save();   
        return Response::json($updateDelivery);
    } 
    
    public function store(Request $request)
    {  
        
        $reserva =  Booking_abcalendar_reservation::updateOrCreate(['id' => $request->reserva_id ],
        ['c_envOper' => $request->c_envOper ],['c_confOper' => $request->c_confOper ],['c_email' => $request->c_email ]);        
        return Response::json($request->c_email);        
    }

    public function editCorreo($id)
    {   
        $where = array('id' => $id);
        $reserva  = Booking_abcalendar_reservation::where($where)->select('id','c_email')->first();
        return Response::json($reserva);
    }    

    public function donwloadPDF($id, $idioma)
    {
        $infoReservas = $this->gestion->getReserva($id);      
        $infoPago = $this->gestion->getInfoPagoReserva($id);  
        $pdf_path = public_path(DIRECTORY_SEPARATOR .config('constants.pdf_path'));
        if($idioma === 'es'){
            $pathToFile = $pdf_path.'/Reservacion-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-es.pdf';
        }else{
            $pathToFile = $pdf_path.'/Reservation-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-en.pdf';
        }

        $name = 'Reservacion-'.$infoReservas[0]->c_name.'-'.$infoPago[0]->id.'-es.pdf';
        $headers = ['Content-Type: application/pdf'];

        return response()->download($pathToFile, $name, $headers);

    }
}
