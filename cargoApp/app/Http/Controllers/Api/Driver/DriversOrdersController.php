<?php

namespace App\Http\Controllers\Api\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\DriverOrder;
use TheSeer\Tokenizer\Exception;

class DriversOrdersController extends Controller
{
    public function accept_order($id)
    {
        $order = Order::find($id);
        $order->status="accepted";
        $order->save();
        return response()->json([
            'message' => "your updated successfully",
            'order'=>$order
        ], 200);
    }

    public function current_order($id)
    {
        $order=DriverOrder::where('driver_id',$id)
                ->Join('orders', function ($q) {
                    $q->on('orders.id', '=', 'driver_order.order_id')
                    ->whereNotIn('orders.status',['completed'])
                    ->Join('packages','packages.order_id','=','orders.id')
                    ->join('company_order','company_order.order_id','=','orders.id')
                    ->join('companies','companies.id','=','company_order.receiver_id');
                })
                ->select('orders.id','orders.shipment_type','packages.weight','packages.value','packages.quantity','packages.unit','packages.length','packages.width','packages.height','companies.comp_name as reciever_company_name','companies.phone','orders.estimated_cost','orders.car_number','orders.pickup_date','packages.pickup_location','packages.pickup_latitude','packages.pickup_longitude','packages.drop_off_location','packages.drop_off_latitude','packages.drop_off_longitude','packages.distance')->get();
        return response()->json([
            'order'=>$order
        ], 201);
        
    }

    public function last_order($id)
    {
        $order=DriverOrder::where('driver_id',$id)
                ->Join('orders', function ($q) {
                    $q->on('orders.id', '=', 'driver_order.order_id')
                    ->where('orders.status','completed')
                    ->Join('packages','packages.order_id','=','orders.id')
                    ->join('company_order','company_order.order_id','=','orders.id')
                    ->join('companies','companies.id','=','company_order.receiver_id');
                })
                ->select('orders.id','orders.pickup_date','packages.pickup_location','packages.pickup_latitude','packages.pickup_longitude','packages.drop_off_location','packages.drop_off_latitude','packages.drop_off_longitude')->get();
        return response()->json([
            'order'=>$order
        ], 201);
        
    }


}
