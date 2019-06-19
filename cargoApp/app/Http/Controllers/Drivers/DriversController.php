<?php

namespace App\Http\Controllers\Drivers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\User;
use App\Driver;
use App\Exports\DriversExport;
use Maatwebsite\Excel\Facades\Excel;
use App\DriverOrder;
use App\Company;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('drivers.index');
    }

    public function get_drivers()
    {
        $user = \Auth::user();
        $role = $user->roles->first()->name;
        if ($role === 'admin') {
            // $drivers = Driver::all();
            $drivers = DB::table('drivers')
                ->leftJoin('users', 'drivers.user_id', '=', 'users.id')
                ->leftJoin('driver_order', 'drivers.id', '=', 'driver_order.driver_id')
                ->select(
                    'drivers.*',
                    DB::raw("count(driver_order.order_id) as count"),
                    'users.name as supervisor_name'
                )
                ->groupBy('drivers.id')
                ->where('drivers.deleted_at',Null)
                ->orderBy('drivers.created_at','desc')
                ->get();

            return datatables()->of($drivers)->toJson();
        } elseif ($role === 'supervisor') {
            $user = \Auth::user();
            $id = $user->id;
            $drivers = DB::table('drivers')
                ->leftJoin('driver_order', 'drivers.id', '=', 'driver_order.driver_id')
                ->select('drivers.*', DB::raw("count(driver_order.order_id) as count"))
                ->groupBy('drivers.id')
                ->where('drivers.user_id', '=', $id)
                ->where('drivers.deleted_at',Null)
                ->orderBy('drivers.created_at','desc')
                ->get();

            return datatables()->of($drivers)->toJson();
        }
    }

    public function export()
    {
        return Excel::download(new DriversExport, 'drivers.xlsx');
    }


    public function create()
    {
        $user = \Auth::user();
        $role = $user->roles->first()->name;
        if ($role === 'admin') {
            $supervisors = DB::table('model_has_roles')
                ->join('users', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select(
                    'users.*'
                )
                ->where('roles.name', '=', 'supervisor')
                ->get();

            return view('drivers.create', compact('supervisors'));
        } elseif ($role === 'supervisor') {
            return view('drivers.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $role = $user->roles->first()->name;
        if ($role === 'supervisor') {
            $request['user_id'] = $user->id;
        }
        $request->validate(
            [
                'name' => 'required',
                'phone' => 'required|regex:/(01)[0-9]{9}/|unique:drivers,phone,NULL,id,deleted_at,NULL',
                'address' => 'required',
                'car_number' => 'required',
                'car_type' => 'required',
                'user_id' => 'required',
            ],
            [
                'name.required' => 'Please enter the driver name',
                'phone.required' => 'Please enter the driver phone',
                'phone.unique' => 'This phone is already exists',
                'phone.regex' => 'Phone must start with (01) then 9 numbers',
                'address.required' => 'Please enter the driver address',
                'car_number.required' => 'Please enter the car number',
                'car_type.required' => 'Please enter the car type',
                'user_id.required' => 'Please enter supervisor',
            ]
        );
        $driver = new Driver();
        $driver['name'] = $request['name'];
        $driver['phone'] = $request['phone'];
        $driver['address'] = $request['address'];
        $driver['car_number'] = $request['car_number'];
        $driver['car_type'] = $request['car_type'];
        $driver['user_id'] = $request['user_id'];
        $driver['address'] = $request['address'];
        $driver['address_latitude'] = $request['address_latitude'];
        $driver['address_longitude'] = $request['address_longitude'];
        $driver->save();
        return redirect()->route('drivers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {

        $user = \Auth::user();
        $role = $user->roles->first()->name;
        if ($role === 'admin') {
            $supervisors = DB::table('model_has_roles')
                ->join('users', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select(
                    'users.*'
                )
                ->where('roles.name', '=', 'supervisor')
                ->get();


        return view('drivers.edit',[
            'driver' => $driver,
            'supervisors'=> $supervisors
        ]);
        } elseif ($role === 'supervisor') {
            return view('drivers.edit',[
                'driver' => $driver,
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        $user = \Auth::user();
        $role = $user->roles->first()->name;
        $request->validate(
            [
                'name' => 'required',
                'phone' => 'required|regex:/(01)[0-9]{9}/|unique:drivers,phone,'.$driver->id.',id,deleted_at,NULL',
                'address' => 'required',
                'car_number' => 'required',
                'car_type' => 'required',
            ],
            [
                'name.required' => 'Please enter the driver name',
                'phone.required' => 'Please enter the driver phone',
                'phone.unique' => 'This phone is already exists',
                'phone.regex' => 'Phone must start with (01) then 9 numbers',
                'address.required' => 'Please enter the driver address',
                'car_number.required' => 'Please enter the car number',
                'car_type.required' => 'Please enter the car type',
            ]
        );

        if ($role === 'admin') {
            $request->validate(
                [
                    'user_id' => 'required',
                ],
                [
                    'user_id.required' => 'Please enter supervisor',
                ]
            );
        }
            $driver['name'] = $request['name'];
            $driver['phone'] = $request['phone'];
            $driver['address'] = $request['address'];
            $driver['car_number'] = $request['car_number'];
            $driver['car_type'] = $request['car_type'];
            if ($role === 'admin') {
            $driver['user_id'] = $request['user_id'];
            }
            $driver['address'] = $request['address'];
            $driver['address_latitude'] = $request['address_latitude'];
            $driver['address_longitude'] = $request['address_longitude'];
            $driver->update();
            return redirect()->route('drivers.index')->with('success', 'driver account has been updated ');
    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index');
    }

    public function ban(Driver $driver)
    {
        $driver->ban();
        $driver->status_driver = 'inactive';
        $driver->save();
        return redirect()->route('drivers.index');
    }
    /* *************************************************** */
    public function unban(Driver $driver)
    {
        $driver->unban();
        $driver->status_driver = 'active';
        $driver->save();
        return redirect()->route('drivers.index');
    }

    /* *************************************************** */
    public function driver_orders(Driver $driver){
       
      $name=Driver::find($driver->id)->first();
      $orders=DriverOrder::where('driver_id',$driver->id)
             ->leftjoin('drivers','driver_order.driver_id','=','drivers.id')
             ->leftjoin('orders','orders.id','driver_order.order_id')
             ->leftjoin('company_order','company_order.order_id','orders.id')
             ->leftjoin('packages','packages.order_id','orders.id')->paginate(4);
    //    dd($name); 
      $sender_ids=array();   
        foreach($orders as $order){
            array_push($sender_ids,$order->sender_id);
            
        }
     $sender=Company::whereIn('id',$sender_ids)->get();

     $reciever_ids=array();   
     foreach($orders as $order){
         array_push($reciever_ids,$order->receiver_id);
     }
    
     $receiver=Company::whereIn('id',$reciever_ids)->get();
      return view('drivers.driver_orders',[
            'name'=>$name,
            'orders' => $orders,
            'sender' => $sender,
            'receiver' =>$receiver
             ]);   
    }
}
