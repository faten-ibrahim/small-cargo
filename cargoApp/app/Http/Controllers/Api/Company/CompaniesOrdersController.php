<?php

namespace App\Http\Controllers\Api\Company;

use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Attendence;
// use App\Customer;
use App\Http\Controllers\Api\Company\AuthController;
use App\Order;
use App\Package;
use App\CompanyOrder;
use Validator;

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
            'shipment_type'=>'required',
            'Weight' => 'required',
            'width' => 'required',
            'height' => 'required',//req
            'length' => 'required',
            'quantity' => 'required',
            'value' => 'required',
            'truck_type' => 'required',
            'car_number' => 'required',
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'contact_name'=>'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $order =Order::create([
            'shipment_type' => $request->shipment_type,
            'car_number' => $request->car_number,
            'truck_type' => $request->truck_type,
        ]);

        $package=Package::create([
            'length'=>$request->length,
            'width'=>$request->width,
            'height'=>$request->height,
            'Weight'=>$request->Weight,
            'pickup_location'=>$request->pickup_location,
            'pickup_latitude'=>$request->pickup_latitude,
            'pickup_longitude'=>$request->pickup_longitude,
            'drop_off_location'=>$request->drop_off_location,
            'drop_off_latitude'=>$request->drop_off_latitude,
            'drop_off_longitude'=>$request->drop_off_longitude,
            'value'=>$request->value,
            'quantity'=>$request->quantity,
            'order_id'=>$order->id,
        ]);

        $company_order=CompanyOrder::create([
            'sender_id'=>$request->sender_id,
            'receiver_id'=>$request->receiver_id,
            'order_id'=>$order->id,
            'contact_name'=>$request->contact_name,
        ]);

        return response()->json([
            'message' => 'Order Saved Successfully',
            'order'=>$order,
            'package'=>$package,
            'company_order'=>$company_order
        ], 201);
    }
}
