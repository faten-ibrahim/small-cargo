<?php

namespace App\Http\Controllers\Api\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Order;
use TheSeer\Tokenizer\Exception;

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
        return response()->json([
            'message' => "order accepted successfully",
            'order'=>$order,
            'driver'=>$driver,
        ], 200);
    }
}
