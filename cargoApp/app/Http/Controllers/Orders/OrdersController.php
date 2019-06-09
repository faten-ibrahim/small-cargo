<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use Order;

class OrdersController extends Controller
{
    public function show(Order $Order) {
       
        $orders = Order::find($Order->id);
        return view('orders.show', [
            'order' => $orders,
        ]);
    }

}
