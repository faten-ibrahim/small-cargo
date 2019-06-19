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
use DB;
use App\DriverLocation;
use App\Driver;
use App\CompanyNotification;
use phpDocumentor\Reflection\Types\Null_;

class CompaniesOrdersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:company', ['except' => ['login', 'register','calc_distance']]);
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
            'pickup_date' => 'required',
            // 'photo'=>'required',
            'value'=>'required',
            'estimated_cost'=>'required',
            'distance'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $sender_company=Company::where('id', '=', $request->sender_id)->first();
        $receiver_name = $request->receiver_name;
        $receiver_company = Company::where('comp_name', '=', $receiver_name)->first();
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
                'comp_name' => $request->receiver_name,
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
            'status' => "pending",
            'estimated_cost'=>$request->estimated_cost,
        ]);
        // $order->status = 'pending';
        $order->status = "pending";
        $order->save();
        //  dd("hhhhhhhhhhhhhhhhhhhhhh");

        $photo=$request['photo'];
        if(!$photo){
            $photo= NULL;
        }
        // dd($order);
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
            'photo'=>$photo,
            'value'=>$request->value,
            'distance'=>$request->distance,
        ]);

        $company_order = CompanyOrder::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $id,
            'contact_name' => $request->contact_name,
            'order_id' => $order->id,
        ]);

        // Drivers Notifications
        $lat = $request->pickup_latitude;
        $lng = $request->pickup_longitude;
        $nearest_drivers = $this->get_nearest_drivers($lat, $lng);
        // dd('nearest drivers',$nearest_drivers);
        $orderContent = [];
        $receiver_data = array('receiver_name'=> $receiver_name);
        $orderContent = array_merge($receiver_data,$sender_company->toArray(),$order->toArray(), $package->toArray(),$company_order->toArray());
        // array_push($orderContent,$receiver_name);
        $drivers_tokens = $this->driversTokens($nearest_drivers);
        // dd('token driver',$drivers_tokens);

        $orderDetails = json_encode($orderContent);
        // dd($orderDetails);
        try {
            fcm()
                ->to($drivers_tokens) // $recipients must an array
                ->data([
                    'title' => 'Cargo Order',
                    'body' => 'There is an order for you'.'$'.$orderDetails,

                ])
                ->send();
        } catch (\Exception $e) {
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
                    'title' => 'Cargo order',
                    'body' => 'Your order is pending , now',
                    'content' => $orderContent,
                ])
                ->send();
    //----------  save notification in database ----------
    // dd($orderDetails);
                CompanyNotification::create([
                    'sender_id'=>$request->sender_id,
                    'receiver_id'=>$id,
                    'shipment_type' =>$request->shipment_type,
                    'car_number' =>$request->car_number,
                    'truck_type' =>$request->truck_type,
                    'pickup_date' =>$request->pickup_date,
                    'order_status' =>'pending',
                    'length' =>$request->length,
                    'width' =>$request->width,
                    'height' =>$request->height,
                    'Weight' =>$request->Weight,
                    'pickup_location' =>$request->pickup_location,
                    'pickup_latitude' =>$request->pickup_latitude,
                    'pickup_longitude' =>$request->pickup_longitude,
                    'drop_off_location' =>$request->drop_off_location,
                    'drop_off_latitude' =>$request->drop_off_latitude,
                    'drop_off_longitude' =>$request->drop_off_longitude,
                    'value' =>$request->value,
                    'quantity' =>$request->quantity,
                    'order_id' =>$order->id,

                ]);

    //----------------------------------------------------

        } catch (\Exception $e) {

            return $e->getMessage();
        }


        return response()->json([
            'message' => 'Order Saved Successfully',
            'order' => $order,
            'package' => $package,
            'company_order' => $company_order,
            'recipients'=>$recipients,

        ], 201);
    }

    public function get_tokens($sender_id, $receiver_id)
    {
        $sender_token = CompanyToken::where('company_id', '=', $sender_id)->first();
        $receiver_token = CompanyToken::where('company_id', '=', $receiver_id)->first();

        $tokens = [];
        if (!$receiver_token&&$sender_token) {
            array_push($tokens, $sender_token->token);
        } else {
            array_push($tokens, $sender_token->token, $receiver_token->token);
        }

        return $tokens;
    }

    public function driversTokens($nearest_drivers)
    {
        // dd('near drivers', $nearest_drivers);
        $drivers = DriverToken::whereIn('driver_id', $nearest_drivers)->select('token')->get()->toArray();
        // dd('drivers',$drivers);
        $drivers_tokens = [];
        foreach ($drivers as $driver) {
            array_push($drivers_tokens, $driver['token']);
        }
        // dd($drivers_tokens);
        return $drivers_tokens;
    }

    public function get_nearest_drivers($lat, $lng)
    {

        // $lat = 31.1926859;
        // $lng = 29.906324700000027;
        $circle_radius = 3959;
        $max_distance = 10;
        $locations = DB::select(
            'SELECT * FROM
                    (SELECT driver_id,driver_latitude, driver_longitude, (' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(driver_latitude)) *
                    cos(radians(driver_longitude) - radians(' . $lng . ')) +
                    sin(radians(' . $lat . ')) * sin(radians(driver_latitude))))
                    AS distance
                    FROM driver_locations) AS distances
                WHERE distance < ' . $max_distance . '
                ORDER BY distance
                 '
        );

        $result = [];
        foreach ($locations as $loc) {
            array_push($result, $loc->driver_id);
        }
        return $result;
    }

    public function currentOrders($id)
    {
        $sent_orders = CompanyOrder::where('sender_id', $id)
            ->Join('orders', function ($q) {
                $q->on('orders.id', '=', 'company_order.order_id')
                    ->whereNotIn('orders.status', ['completed']);
            })
            ->Join('packages', 'packages.order_id', '=', 'orders.id')
            ->join('companies', 'companies.id', '=', 'company_order.receiver_id')
            ->select('company_order.sender_id', 'packages.pickup_location', 'packages.pickup_latitude', 'packages.pickup_longitude', 'packages.drop_off_location', 'packages.drop_off_latitude', 'packages.drop_off_longitude', 'packages.Weight', 'packages.width', 'packages.height', 'packages.length', 'packages.quantity', 'packages.value', 'orders.car_number', 'orders.shipment_type', 'orders.truck_type', 'orders.pickup_date', 'orders.status', 'company_order.receiver_id', 'companies.comp_name as receiver_company_name', 'companies.phone', 'companies.address')->get();

        $recevied_orders = CompanyOrder::where('receiver_id', $id)
            ->Join('orders', function ($q) {
                $q->on('orders.id', '=', 'company_order.order_id')
                    ->whereNotIn('orders.status', ['completed']);
            })
            ->Join('packages', 'packages.order_id', '=', 'orders.id')
            ->join('companies', 'companies.id', '=', 'company_order.sender_id')
            ->select('company_order.receiver_id', 'packages.pickup_location', 'packages.pickup_latitude', 'packages.pickup_longitude', 'packages.drop_off_location', 'packages.drop_off_latitude', 'packages.drop_off_longitude', 'packages.Weight', 'packages.width', 'packages.height', 'packages.length', 'packages.quantity', 'packages.value', 'orders.car_number', 'orders.shipment_type', 'orders.truck_type', 'orders.pickup_date', 'orders.status', 'company_order.sender_id', 'companies.comp_name as sender_company_name', 'companies.phone', 'companies.address')->get();


        return response()->json([
            'sent_orders' => $sent_orders,
            'recevied_orders ' => $recevied_orders,
        ], 201);
    }


    public function get_driver($id)
    {
        $driver = DriverOrder::where('order_id', $id)
            ->join('drivers', 'drivers.id', '=', 'driver_order.driver_id')
            ->join('driver_locations','driver_locations.driver_id','=','driver_order.driver_id')
            ->select('name','phone','car_type','car_number','car_no_of_trips','rating','status_driver','availability','address','driver_latitude','driver_longitude')->get();

        return response()->json([
            'driver' => $driver,
        ], 201);
    }

    public function lastOrders($id)
    {
        $last_orders = CompanyOrder::where('sender_id', $id)
            ->orWhere('receiver_id', $id)
            ->Join('orders', function ($q) {
                $q->on('orders.id', '=', 'company_order.order_id')
                    ->where('orders.status', 'completed');
            })
            ->Join('packages', 'packages.order_id', '=', 'orders.id')->get();

        return response()->json([
            'last_orders' => $last_orders,
        ], 201);
    }


    public function calc_total_estimated_cost(Request $request)
    {
        $lat1 = $request->pickup_latitude;
        $lon1 = $request->pickup_longitude;
        $lat2 = $request->drop_off_latitude;
        $lon2 = $request->drop_off_longitude;
        $Weight = $request->Weight;
        $type = $request->shipment_type;
        $unit = "K";
        $final_distance;
        try {
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                // return 0;
                return response()->json([
                    'total_cost' => '0',
                    'final_estimated_cost' => '0',
                ], 200);
            } else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $unit = strtoupper($unit);

                if ($unit == "K") {
                    // dd('dist in kkkk', $miles * 1.609344);
                    $final_distance = $miles * 1.609344;
                } else if ($unit == "M") {
                    // dd('dist in miles ', $miles);
                    $final_distance = $miles;
                }
            }

            $final_distance_cost = $final_distance * 2;
            // dd($final_distance_cost);

            $Weight_cost = $Weight ;
            // dd($Weight_cost);

            $total_cost = $final_distance_cost + $Weight_cost;
            // dd($total_estimated_cost);
            if ($type == "glass") {
                $_final_estimated_cost = $total_cost;
            } else if ($type == "poisonous" || $type == "flammable") {
                $_final_estimated_cost = $total_cost * 1.5;
            }
            return response()->json([
                'distance' => $final_distance,
                'final_estimated_cost' => $_final_estimated_cost,
            ], 200);
        } catch (\Exception $e) {

            return  response()->json([
                'Please enter all required parameters' => $e->getMessage(),
            ], 400);
        }
    }

    public function confirm_order($order_id, $company_id,$rate)
    {
        $has_order = CompanyOrder::where('order_id', $order_id)->where('sender_id', $company_id)->get();

        if ($has_order->count()) {
            $order = Order::find($order_id);
            $order->status = "completed";
            $order->save();

            $order_driver =DriverOrder::select('driver_id')->where('order_id',$order_id)->get()->toArray();

            $driver=Driver::find($order_driver)->first();
            $driver->status_driver="available";
            $driver->rating=$rate;
            $driver->save();
            // dd($driver);
            return response()->json([
                'message' => "Order successfully completed",
                'order' => $order,
                'driver'=>$driver

            ], 200);
        } else {
            return response()->json([
                'message' => "Invalid parameters",
            ], 400);
        }
    }

    public function get_contact_list($id){
      $contact=CompanyContactList::where('company_id',$id)->get();
      return response()->json([
        'contact' => $contact,
    ], 201);
    }


   public function notifications($id){
    $notifications = CompanyNotification::where('sender_id', $id)
    ->orWhere('receiver_id', $id)
    ->orderBy('company_notifications.created_at', 'desc')
    ->select('company_notifications.sender_id','company_notifications.receiver_id','company_notifications.title','company_notifications.body','company_notifications.shipment_type','company_notifications.pickup_date','company_notifications.car_number','company_notifications.truck_type','company_notifications.length','company_notifications.width','company_notifications.height','company_notifications.pickup_location','company_notifications.pickup_latitude','company_notifications.pickup_longitude','company_notifications.drop_off_location','company_notifications.drop_off_latitude','company_notifications.drop_off_longitude','company_notifications.value','company_notifications.Weight','company_notifications.quantity','company_notifications.order_id','company_notifications.status')->get();



    return response()->json([
          'notifications' => $notifications,
    ], 201);

   }

}
