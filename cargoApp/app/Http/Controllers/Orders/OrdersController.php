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
        $orders = Order::leftjoin('company_order','orders.id','company_order.order_id')
        ->leftjoin('driver_order','orders.id','driver_order.order_id')
        ->leftjoin('packages','orders.id','packages.order_id')
        ->leftjoin('companies','companies.id','company_order.sender_id')
        ->leftjoin('drivers','drivers.id','driver_order.driver_id')
        ->select ('orders.*','packages.quantity','packages.Weight','packages.value','packages.pickup_location','packages.drop_off_location','packages.time_to_deliver','packages.height','packages.length','packages.width','companies.name as comp_name','drivers.name','drivers.phone')
        ->orderBy('packages.created_at', 'desc');

     
        // ->orderBy('orders.created_at', 'desc');
        return datatables()->of($orders)->make(true);
                
    }
}
