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
use App\CompanyOrder;
use App\CompanyToken;
use App\Package;
use DB;

class DriversOrdersController extends Controller
{
    public function accept_order($id)
    {

        $companies = CompanyOrder::select('sender_id', 'receiver_id')->where('order_id', $id)->get();
        $companies_id = [];
        foreach ($companies as $company) {
                array_push($companies_id, $company->sender_id, $company->receiver_id);
            }
        $comp_tokens = CompanyToken::whereIn('company_id', $companies_id)->select('token')->get()->toArray();

        // dd($comp_tokens);
        $recipients = [];
        foreach ($comp_tokens as $company) {
            array_push($recipients, $company['token']);
        }
        // dd($recipients);
        // $details_obj = $this->get_order_details($id);
        // dd($details_obj);


        $order = Order::find($id);
        $order->status = "accepted";
        $order->save();
        $driver = Driver::find(JWTAuth::user()->id);
        $driver->availability = "busy";
        $driver->save();
        $driver_order = DriverOrder::create([
            'order_id' => $id,
            'driver_id' => JWTAuth::user()->id,
        ]);
        $package=Package::where('order_id',$id)->first()->toArray();
        $total=[];
        $total=array_merge($order->toArray(),$driver->toArray(),$driver_order->toArray(),$package);
        $obj=json_encode($total);
        // dd($obj);
        try {

            fcm()
                ->to($recipients) // $recipients must an array
                ->notification([
                    'title' => 'Cargo order',
                    'body' => 'Your order is accepted from a driver , now',
                    'content' => $obj,
                ])
                ->send();
            // dd('company tokens',$recipients);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return response()->json([
            'message' => "order accepted successfully",
            'order' => $order,
            'driver' => $driver,
            'driver order' => $driver_order
        ], 200);
    }


    public function start_trip($id)
    {
        $order = Order::find($id);
        $order->status = "ongoing";
        $order->save();

        return response()->json([
            'message' => "order updated successfully",
            'order' => $order,
        ], 200);
    }


    public function delivere_order($id)
    {
        $companies = CompanyOrder::select('sender_id', 'receiver_id')->where('order_id', $id)->get();
        $companies_id = [];
        foreach ($companies as $company) {
                array_push($companies_id, $company->sender_id, $company->receiver_id);
            }
        $comp_tokens = CompanyToken::whereIn('company_id', $companies_id)->select('token')->get()->toArray();

        // dd($comp_tokens);
        $recipients = [];
        foreach ($comp_tokens as $company) {
            array_push($recipients, $company['token']);
        }
        // dd($recipients);
        // $details_obj = $this->get_order_details($id);

        $driver = Driver::find(JWTAuth::user()->id);
        $order = Order::find($id);
        $order->status = "delivered";
        $order->save();
        $package=Package::where('order_id',$id)->first()->toArray();
        $total=[];
        $total=array_merge($order->toArray(),$driver->toArray(),$package);
        $obj=json_encode($total);

        // dd($obj);

        try {

            fcm()
                ->to($recipients) // $recipients must an array
                ->notification([
                    'title' => 'Cargo order',
                    'body' => 'Your order is delivered , now',
                    'content' => $obj,
                ])
                ->send();
            // dd('company tokens',$recipients);
        } catch (\Exception $e) {

            return $e->getMessage();
        }

        return response()->json([
            'message' => "order updated successfully",
            'order' => $order,
        ], 200);
    }

    public function current_order($id)
    {
        $order = DriverOrder::where('driver_id', $id)
            ->Join('orders', function ($q) {
                $q->on('orders.id', '=', 'driver_order.order_id')
                    ->whereNotIn('orders.status', ['completed'])
                    ->Join('packages', 'packages.order_id', '=', 'orders.id')
                    ->join('company_order', 'company_order.order_id', '=', 'orders.id')
                    ->join('companies', 'companies.id', '=', 'company_order.receiver_id');
            })
            ->select('orders.id', 'orders.shipment_type', 'packages.weight', 'packages.value', 'packages.quantity', 'packages.unit', 'packages.length', 'packages.width', 'packages.height', 'companies.comp_name as reciever_company_name', 'companies.phone', 'orders.estimated_cost', 'orders.car_number', 'orders.pickup_date', 'packages.pickup_location', 'packages.pickup_latitude', 'packages.pickup_longitude', 'packages.drop_off_location', 'packages.drop_off_latitude', 'packages.drop_off_longitude', 'packages.distance')->get();
        return response()->json([
            'order' => $order
        ], 201);
    }

    public function last_order($id)
    {
        $order = DriverOrder::where('driver_id', $id)
            ->Join('orders', function ($q) {
                $q->on('orders.id', '=', 'driver_order.order_id')
                    ->where('orders.status', 'completed')
                    ->Join('packages', 'packages.order_id', '=', 'orders.id')
                    ->join('company_order', 'company_order.order_id', '=', 'orders.id')
                    ->join('companies', 'companies.id', '=', 'company_order.receiver_id');
            })
            ->select('orders.id', 'orders.pickup_date', 'packages.pickup_location', 'packages.pickup_latitude', 'packages.pickup_longitude', 'packages.drop_off_location', 'packages.drop_off_latitude', 'packages.drop_off_longitude')->get();
        return response()->json([
            'order' => $order
        ], 201);
    }


    public function get_order_details($id)
    {
        $details = DB::table('orders')
            ->leftjoin('packages', 'packages.order_id', '=', 'orders.id')
            ->leftjoin('company_order', 'company_order.order_id', '=', 'orders.id')
            ->leftjoin('driver_order', 'driver_order.order_id', '=', 'orders.id')
            ->select('orders.*', 'packages.*', 'driver_order.*')
            ->where('orders.id', '=', $id)
            ->get()->toArray();
   

        // $details =Order::where ('id',)
        $orderDetails2 = json_encode($details);

        return $orderDetails2;
    }



}
