<?php

namespace App\Http\Controllers\Drivers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\User;
use App\Driver;

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
                ->get();
            // dd($drivers);
            return datatables()->of($drivers)->toJson();
        } elseif ($role === 'supervisor') {
            $user = \Auth::user();
            $id = $user->id;
            // $drivers = User::find($user->id)->drivers;
            $drivers = DB::table('drivers')
                ->leftJoin('driver_order', 'drivers.id', '=', 'driver_order.driver_id')
                ->select('drivers.*', DB::raw("count(driver_order.order_id) as count"))
                ->groupBy('drivers.id')
                ->where('drivers.user_id', '=', $id)
                ->get();
            // dd($drivers);
            return datatables()->of($drivers)->toJson();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                'phone' => 'required|unique:drivers',
                'address' => 'required',
                'car_number' => 'required',
                'car_type' => 'required',
                'user_id' => 'required',
            ],
            [
                'name.required' => 'Please enter the driver name',
                'phone.required' => 'Please enter the driver phone',
                'phone.unique' => 'This phone is already exists',
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $driver->status = 'inactive';
        $driver->save();
        return redirect()->route('drivers.index');
    }
    /* *************************************************** */
    public function unban(Driver $driver)
    {
        $driver->unban();
        $driver->status = 'active';
        $driver->save();
        return redirect()->route('drivers.index');
    }
}
