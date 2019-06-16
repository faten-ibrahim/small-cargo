<?php

namespace App\Http\Controllers\Api\Company;

use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Company\AuthController;
use App\Order;
use App\Package;
use App\CompanyOrder;
use Validator;
use App\Company;
use App\DriverToken;
use App\DriverOrder;
use App\CompanyContactList;
use Hash;
use App\CompanyToken;

class CompaniesOrdersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:company');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required',
            'pickup_latitude' => 'required',
            'pickup_longitude' => 'required',
            'drop_off_location' => 'required',
            'drop_off_latitude' => 'required',
            'drop_off_longitude' => 'required',
            'shipment_type' => 'required',
            'Weight' => 'required',
            'width' => 'required',
            'height' => 'required', //req
            'length' => 'required',
            'quantity' => 'required',
            'value' => 'required',
            'truck_type' => 'required',
            'car_number' => 'required',
            'sender_id' => 'required',
            'receiver_name' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'address' => 'required',
            'pickup_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $receiver_name = $request->receiver_name;
        $receiver_company = Company::where('name', '=', $receiver_name)->first();
        $id = '';
        if ($receiver_company) {
            $company = CompanyContactList::where('receiver_name', '=', $request->receiver_name)->first();
            $id = $receiver_company->id;
            if (!$company) {
                $CompanyContactList = CompanyContactList::create([
                    'company_id' => $request->sender_id,
                    'receiver_name' => $request->receiver_name,
                    'address_address' => $request->address,
                    'contact_name' => $request->contact_name,
                    'contact_phone' => $request->contact_phone,
                ]);
            }
        } else {
            $company_created = Company::create([
                'name' => $request->receiver_name,
                'address' => $request->address,
                'password' => Hash::make(str_random(8)),
                'email' => str_random(5) . '@gamil.com',
                'phone' => $request->contact_phone,
                'status' => 'contact',
            ]);

            $company_created->status = 'contact';
            $company_created->save();

            $id = $company_created->id;
        }

        // dd("hhhhhhhhhhhhhhhhhhherre");
        $order = Order::create([
            'shipment_type' => $request->shipment_type,
            'car_number' => $request->car_number,
            'truck_type' => $request->truck_type,
            'pickup_date' => $request->pickup_date,
        ]);
        //  dd("hhhhhhhhhhhhhhhhhhhhhh");
        $package = Package::create([
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'Weight' => $request->Weight,
            'pickup_location' => $request->pickup_location,
            'pickup_latitude' => $request->pickup_latitude,
            'pickup_longitude' => $request->pickup_longitude,
            'drop_off_location' => $request->drop_off_location,
            'drop_off_latitude' => $request->drop_off_latitude,
            'drop_off_longitude' => $request->drop_off_longitude,
            'value' => $request->value,
            'quantity' => $request->quantity,
            'order_id' => $order->id,
        ]);

        $company_order = CompanyOrder::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $id,
            'contact_name' => $request->contact_name,
            'order_id' => $order->id,
        ]);

        // Drivers Notifications
        $orderNotify = array();
        $orderNotify = array_merge($order->toArray(), $package->toArray());
        $drivers_tokens = $this->driversNotification();
        // dd('token driver',$drivers_tokens);
        try {
            fcm()
                ->to($drivers_tokens) // $recipients must an array
                ->notification([
                    'title' => 'Test driver FCM',
                    'body' => 'This is a test of driver FCM',
                    'content'=>$orderNotify,
                ])
                ->send();
        } catch (\Exception $e) {
            dd($e);
            report($e);
            return $e->getMessage();
        }

        // Companies Notifications
        $recipients = [];
        $recipients = $this->get_tokens($request->sender_id, $id);


        try {

            fcm()
                ->to($recipients) // $recipients must an array
                ->notification([
                    'title' => 'Test company FCM',
                    'body' => 'This is a test of company FCM',
                    'content'=>$order,
                ])
                ->send();
                // dd('company tokens',$recipients);
        } catch (\Exception $e) {

            return $e->getMessage();
        }


        return response()->json([
            'message' => 'Order Saved Successfully',
            'order' => $order,
            'package' => $package,
            'company_order' => $company_order,

        ], 201);
    }

    public function get_tokens($sender_id, $receiver_id)
    {
        $sender_token = CompanyToken::where('company_id', '=', $sender_id)->first();
        $receiver_token = CompanyToken::where('company_id', '=', $receiver_id)->first();

        $tokens = [];
        if (!$receiver_token) {
            array_push($tokens, $sender_token->token);
        } else {
            array_push($tokens, $sender_token->token, $receiver_token->token);
        }

        return $tokens;
    }

    public function driversNotification()
    {
        $drivers_tokens = array();
        $drivers = DriverToken::select('token')->get()->toArray();
        for ($i = 0; $i < sizeof($drivers); $i++) {
            array_push($drivers_tokens, $drivers[$i]['token']);
        }

        return $drivers_tokens;
    }
 
    public function currentOrders($id){
        $sent_orders = CompanyOrder::where('sender_id',$id)
                ->Join('orders', function($q) {
                                $q->on('orders.id', '=', 'company_order.order_id')
                                  ->whereNotIn('orders.status',['completed']);
                            })
                ->Join('packages','packages.order_id','=','orders.id')
                ->join('companies','companies.id','=','company_order.receiver_id')
                ->select('company_order.sender_id','packages.pickup_location','packages.pickup_latitude','packages.pickup_longitude','packages.drop_off_location','packages.drop_off_latitude','packages.drop_off_longitude','packages.Weight','packages.width','packages.height','packages.length','packages.quantity','packages.value','orders.car_number','orders.shipment_type','orders.truck_type','orders.pickup_date','orders.status','company_order.receiver_id','companies.comp_name as receiver_company_name','companies.phone','companies.address')->get();
              
        $recevied_orders = CompanyOrder::where('receiver_id',$id)
                ->Join('orders', function($q) {
                                $q->on('orders.id', '=', 'company_order.order_id')
                                  ->whereNotIn('orders.status',['completed']);
                            })
                ->Join('packages','packages.order_id','=','orders.id')
                ->join('companies','companies.id','=','company_order.sender_id')
                ->select('company_order.receiver_id','packages.pickup_location','packages.pickup_latitude','packages.pickup_longitude','packages.drop_off_location','packages.drop_off_latitude','packages.drop_off_longitude','packages.Weight','packages.width','packages.height','packages.length','packages.quantity','packages.value','orders.car_number','orders.shipment_type','orders.truck_type','orders.pickup_date','orders.status','company_order.sender_id','companies.comp_name as sender_company_name','companies.phone','companies.address')->get();       
                  
    
         
        return response()->json([
                    'sent_orders' => $sent_orders ,
                    'recevied_orders ' => $recevied_orders,
                ], 201);        
        
    }

    public function get_driver($id){
        $driver=DriverOrder::where('order_id',$id)
                ->join('drivers','drivers.id','=','driver_order.driver_id')->get();

        return response()->json([
                    'driver' => $driver ,
                ], 201);             

    }

    // public function lastOrders($id){


    // }
}
