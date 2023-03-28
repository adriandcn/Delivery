<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use Yajra\Datatables\Datatables;
use App\Models\Booking\Booking_abcalendar_reservation;
use App\Models\Booking\Booking_abcalendar_payment_bank;
use App\Models\Booking\Booking_abcalendar_payment_operator;
use App\Repositories\DeliveryServiceRepository;
use Carbon\Carbon;
use Log;

class PaymentController extends Controller
{
    protected $gestion;
    public function __construct(DeliveryServiceRepository $gestion)
    {
       $this->gestion = $gestion;
    }

    //
    public function index($token)
    {
        $validToken = $this->validToken($token);
        if(!$validToken){
            abort(404);
        }else{
            if(request()->ajax()) {
                $pagos = $this->gestion->getAllReservationsPayments(0);
                dd($pagos);
                return Datatables::of($pagos)
                                    ->addIndexColumn()
                                    ->addColumn('action', 'action_button_payment')
                                    ->rawColumns(['action'])
                                    ->make(true);
            }
            return view('adminPayment')->with('token', $token);
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

    public function store(Request $request)
    {
        $banco =  Booking_abcalendar_payment_bank::updateOrCreate(['reserva_id' => $request->reserva_id],
                    [ 'cantidad' => $request->pgobanco, 'fecha' => $request->fechapagobanco]);

        $operador = Booking_abcalendar_payment_operator::updateOrCreate(['reserva_id' => $request->reserva_id],
                    [ 'cantidad' => $request->pagooperador, 'fecha_pago' => $request->fechapagooperador, 'observaciones' => $request->observaciones]);

        return Response::json($banco);
    }

    public function edit($id)
    {
        $pagos = $this->gestion->getAllReservationsPayments($id);
        return Response::json($pagos);
    }

}
