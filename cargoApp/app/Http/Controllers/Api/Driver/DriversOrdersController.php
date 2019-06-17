<?php

namespace App\Http\Controllers\Api\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Order;
use TheSeer\Tokenizer\Exception;
use App\DriverOrder;

class DriversOrdersController extends Controller
{
    public function accept_order($id)
    {
        $order = Order::find($id);
        $order->status="accepted";
        $order->save();
        $driver=Driver::find(JWTAuth::user()->id);
        $driver->status_driver="busy";
        $driver->save();
        $driver_order = DriverOrder::create([
            'order_id' => $id,
            'driver_id' => JWTAuth::user()->id,
        ]);
        return response()->json([
            'message' => "order accepted successfully",
            'order'=>$order,
            'driver'=>$driver,
            'driver order'=>$driver_order
        ], 200);
    }


    public function start_trip($id)
    {
        $order = Order::find($id);
        $order->status="ongoing";
        $order->save();

        return response()->json([
            'message' => "order updated successfully",
            'order'=>$order,
        ], 200);
    }
}
