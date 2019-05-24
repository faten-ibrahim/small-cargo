<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(User $admin)
    {   
        $admin = Auth::user(); 
         return view('admin.edit',compact('admin'));
    }

    public function update(User $admin)
    { 

        $admin->name = request('name');

        if (request('email') != $admin->email){
        $this->validate(request(), [
            'email' => 'email|unique:users',
        ]);
        $admin->email = request('email');
        }
        else{
            $admin->email = request('email');
        }


        if (request('old-password') != '')
        {
                if(Hash::check(request('old-password'), $admin->password)){
                    $this->validate(request(), [
                        'new-password'     => 'required|min:6',
                        'password-confirmation' => 'required|same:new-password',
                    ]);
                    $admin->password = Hash::make(request('new-password'));
                    $admin->save();

                    return back();
                    
                }else{
                    return back()->with('error','The specified password does not match the database password');
                }
        }else{
            $admin->save();
            return back();
        }
        
    }


}
