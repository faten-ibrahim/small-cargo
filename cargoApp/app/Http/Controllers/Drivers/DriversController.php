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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
