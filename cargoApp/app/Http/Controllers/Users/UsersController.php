<?php


namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;
use Yajra\Datatables\Datatables;
use App\Http\Requests\User\StoreUserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /* ****************************************** */
    public function index()
    {
        return view('users.index');
    }

    public function supervisors_list()
    {
        return datatables()->of(User::all())->toJson();
    }

    /* ****************************************** */
    public function create()
    {
        return view('users.create');
    }


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
                'address.required' => 'Please enter the address',
                'phone.required' => 'Please enter the phone',
                'status.required' => 'Please select the status'
            ]
        );
        $supervisor = new User();
        $supervisor['name'] = $request['name'];
        $supervisor['email'] = $request['email'];
        $supervisor['address'] = $request['address'];
        $supervisor['status'] = $request['status'];
        $supervisor['password'] = bcrypt("@passwd");
        //dd($supervisor);
        $supervisor->save();
        $supervisor->assignRole('supervisor');
        return redirect()->route('users.index');
    }
    /* ****************************************** */
    public function show($id)
    { }
    /* ****************************************** */
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }
    /* ****************************************** */
    public function update(User $user)
    {

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
                $user->password = Hash::make(request('new-password'));
                $user->save();

                Auth::logout();
                return redirect('/login');
            } else {
                return back()->with('error', 'The specified password does not match the database password');
            }
        } else {
            $user->save();
            return back();
        }
    }
}
