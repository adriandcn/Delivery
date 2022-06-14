<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use Yajra\Datatables\Datatables;
use App\Models\Booking\Booking_abcalendar_coupon;
use App\Repositories\DeliveryServiceRepository;
use Carbon\Carbon;
use App\Http\Controllers\AdminController;

class CouponController extends Controller
{

    protected $gestion;
    public function __construct(DeliveryServiceRepository $gestion)
    {
       $this->gestion = $gestion;
    }     

    public function index($token)
    {
        $validToken = $this->validToken($token);
        if(!$validToken){
            abort(404);
        }else{
            if(request()->ajax()) {
                $cupones = Booking_abcalendar_coupon::orderBy('id', 'desc')->get();
                return datatables()->of($cupones)
                ->addColumn('action', 'action_button_coupon')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('adminCoupon')->with('token', $token);
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
            if($horasDiferencia >= 1){
                // TOKEN CADUCADO
                return false;
            }else{
                return true;
            }
        }
    }     
        
    public function store(Request $request)
    {  
        $cuponId = $request->cupon_id;
        if(isset($request->estado)){
            $estado = 1;
        }else{
            $estado = 0;            
        }
        $cupon =  Booking_abcalendar_coupon::updateOrCreate(['id' => $cuponId],
                    [   'codigo' => $request->codigo, 'cantidad' => $request->cantidad,
                        'fecha_expiracion' => $request->fecha_expiracion, 'estado' => $estado, 
                        'cantidad' => $request->cantidad, 'id_res_origen' => $request->id_res_origen, 
                        'id_res_cons' => $request->id_res_cons, 'min_pass' => $request->min_pass
                    ]);        
        return Response::json($cupon);
        
    }

    public function edit($id)
    {   
        $where = array('id' => $id);
        $cupon  = Booking_abcalendar_coupon::where($where)->first();
        return Response::json($cupon);
    }

    public function destroy($id)
    {
        $cupon = Booking_abcalendar_coupon::where('id',$id)->delete();
        return Response::json($cupon);
    }    
}
