<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\CompanyOrder;
use App\Package;
use App\Company;
use App\Driver;

class OrdersController extends Controller
{
    public function index()
    {

        return view('orders.index');
    }

    public function orders_list()
    {
        $orders = Order::select('*')
        ->leftjoin('company_order','orders.id','company_order.order_id')
        ->leftjoin('driver_order','orders.id','driver_order.order_id')
        ->leftjoin('packages','orders.id','packages.order_id')
        ->leftjoin('companies','companies.id','company_order.sender_id')
        ->leftjoin('drivers','drivers.id','driver_order.driver_id');

     
        // ->orderBy('orders.created_at', 'desc');
        return datatables()->of($orders)->make(true);
                
    }
}
