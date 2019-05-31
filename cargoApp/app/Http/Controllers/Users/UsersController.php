<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Driver;
use Hash;
use Yajra\Datatables\Datatables;
use App\Http\Requests\User\StoreUserRequest;
use DB;
use Response;
use App\DriverOrder;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /* **************** INDEX ************************** */
    public function index()
    {
        return view('users.index');
    }
    /* ****************************************** */
    public function supervisors_list()
    {
        $supervisors = User::whereHas(
            'roles',
            function ($supervisor) {
                $supervisor->where('name', 'supervisor');
            }
        )
            ->leftJoin('drivers', function ($join) {
                $join->on('users.id', '=', 'drivers.user_id');;
            })
            ->select(
                'users.*',
                DB::raw("count(drivers.user_id) as drivers_count")
            )
            ->groupBy('users.id')
            ->orderBy('users.created_at', 'asc');

        return datatables()->of($supervisors)->toJson();
    }

    /* ********************** CREATE ******************** */
    public function create()
    {
        return view('users.create');
    }

    /* ********************** STORE ******************** */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'address' => 'required',
                'phone' => 'required',
                'status' => 'required',
            ],
            [
                'name.required' => 'Please enter the name',
                'email.required' => 'Please enter the email',
                'email.email' => 'Please enter an valid email',
                'email.unique' => 'This email is already exists',
                'addre-list-altss.required' => 'Please enter the address',
                'phone.required' => 'Please enter the phone',
                'status.required' => 'Please select the status'
            ]
        );
        $supervisor = new User();
        $supervisor['name'] = $request['name'];
        $supervisor['email'] = $request['email'];
        $supervisor['address'] = $request['address'];
        $supervisor['phone'] = $request['phone'];
        $supervisor['status'] = $request['status'];
        $supervisor['password'] = bcrypt("@passwd");
        //dd($supervisor);
        $supervisor->save();
        $supervisor->assignRole('supervisor');
        return redirect()->route('users.index');
    }
    /* *********************** SHOW ******************* */
    public function show($id)
    {
        // $drivers = User::find($id)->drivers;
            $drivers =DB::table('drivers')
            ->leftJoin('driver_order', 'drivers.id', '=', 'driver_order.driver_id')
            ->select('drivers.*', DB::raw("count(driver_order.order_id) as count"))
            ->groupBy('drivers.id')
            ->where('drivers.user_id','=',$id)
            ->get();
        // dd($drivers);
        $supervisor_name = User::find($id)->name;
        // $orders_num = DriverOrder::where('driver_id', '=', $id)->count();
        return view('users.show', compact(['drivers', 'supervisor_name']));
    }
    /* ********************** EDIT ******************** */

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /* ********************* UPDATE ********************* */
    public function update(Request $request, User $user)
    {
        if ($user->hasRole('admin')) {
            $user->name = request('name');

            if (request('email') != $user->email) {
                $this->validate(request(), [
                    'email' => 'email|unique:users',
                ]);
                $user->email = request('email');
            } else {
                $user->email = request('email');
            }


            if (request('old-password') != '') {
                if (Hash::check(request('old-password'), $user->password)) {
                    $this->validate(request(), [
                        'new-password'     => 'required|min:6',
                        'password-confirmation' => 'required|same:new-password',
                    ]);

                    if (request('new-password') != request('old-password')) {
                        $user->password = Hash::make(request('new-password'));
                        $user->save();

                        Auth::logout();
                        return redirect('/login');
                    } else {
                        return back()->with('error', 'New Password must differ from old one');
                    }
                } else {
                    return back()->with('error', 'The specified password does not match the database password');
                }
            } else {
                $user->save();
                return back();
            }

            // -----------------   end if role is admin  ------------------------

        } elseif ($user->hasRole('supervisor')) {

            if (request('email') != $user->email) {
                $this->validate(request(), [
                    'email' => 'email|unique:users',
                ]);
                $user->email = request('email');
            } else {
                $user->email = request('email');
            }

            $request->validate(
                [
                    'name' => 'required',
                    'email' => 'required',
                    'address' => 'required',
                    'phone' => 'required',
                    'status' => 'required',
                ],
                [
                    'name.required' => 'Please enter the name',
                    'email.required' => 'Please enter the email',
                    'email.email' => 'Please enter an valid email',
                    'address' => 'Please enter the address',
                    'phone.required' => 'Please enter the phone',
                    'status.required' => 'Please select the status'
                ]
            );
            $user->name = request('name');
            $user->address = request('address');
            $user->phone = request('phone');
            $user->status = request('status');


            $user->save();
            return redirect()->route('users.index')->with('success', 'Supervisor account has been updated ');
        }
    }

    /* ******************  DELETE ************************ */

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function ban(User $user)
    {
        $user->ban();
        $user->status = 'inactive';
        $user->save();
        return redirect()->route('users.index');
    }
    public function unban(User $user)
    {
        $user->unban();
        $user->status = 'active';
        $user->save();
        return redirect()->route('users.index');
    }

    // public function drivers_list($id)
    // {
    //     $drivers = User::find($id)->drivers;
    //     // dd($drivers);
    //     // return datatables()->of($drivers)->make(true)->render('users.show');
    //     return datatables()->of($drivers)->make(true)->render('users/{user}');
    // }
}
