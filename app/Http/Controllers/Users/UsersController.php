<?php


namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {

    }
    

    public function edit(User $user)
    {   
        $user = Auth::user(); 
         return view('users.edit',compact('user'));
    }

    public function update(User $user)
    { 

        $user->name = request('name');

        if (request('email') != $user->email){
        $this->validate(request(), [
            'email' => 'email|unique:users',
        ]);
        $user->email = request('email');
        }
        else{
            $user->email = request('email');
        }


        if (request('old-password') != '')
        {
                if(Hash::check(request('old-password'), $user->password)){
                    $this->validate(request(), [
                        'new-password'     => 'required|min:6',
                        'password-confirmation' => 'required|same:new-password',
                    ]);
                    $user->password = Hash::make(request('new-password'));
                    $user->save();

                    Auth::logout();
                    return redirect('/login');
                    
                }else{
                    return back()->with('error','The specified password does not match the database password');
                }
        }else{
            $user->save();
            return back();
        }
        
    }

}
