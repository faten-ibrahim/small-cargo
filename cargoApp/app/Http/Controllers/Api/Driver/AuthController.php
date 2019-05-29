<?php

namespace App\Http\Controllers\Api\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use Validator;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->driver = new Driver();
        // $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'=>'required',
            // 'password'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        config()->set( 'auth.defaults.guard', 'driver-api' );
        \Config::set('jwt.user', 'App\Driver');
		\Config::set('auth.providers.users.model', \App\Driver::class);
        $credentials = $request->only('phone');
        try {
            if (! $token =JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'We can`t find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to login, please try again.'], 500);
        }


        return $this->respondWithToken($token);
    }

       #------------------------------- regiser function ---------------------------
       public function register(Request $request)
       {
           $validator = Validator::make($request->all(), [
                   'name'=>'required',
                   'phone'=>'required|unique:drivers',
                   'car_number'=>'required|unique:drivers',
                   'car_type'=>'required'

           ]);

           if($validator->fails()){
                   return response()->json($validator->errors(), 400);
           }
           $driver = Driver::create([
                       'name'=> $request->name,
                       'phone'=> $request->phone,
                       'car_number'=> $request->car_number,
                       'car_type'=> $request->car_type,

                   ]);
                   config()->set( 'auth.defaults.guard', 'driver-api' );
                   \Config::set('jwt.user', 'App\Driver');
                   \Config::set('auth.providers.users.model', \App\Driver::class);
           $token =JWTAuth::fromUser($driver);
           return response()->json([
            'status' => 'You have successfully register.',
            'data'=> [
                'token' => $token ,
                'driver-api'=>$driver
            ]
            ],201);

       }

       #-------------------------------- logout ----------------------------------------
       public function logout()
       {
        config()->set('auth.defaults.guard', 'driver-api' );
        \Config::set('jwt.user', 'App\Driver');
        \Config::set('auth.providers.users.model', \App\Driver::class);
        try {

            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
       }


       protected function respondWithToken($token)
       {
           return response()->json([
               'access_token' => $token,
               'token_type' => 'bearer',
               'expires_in' => JWTAuth::factory()->getTTL() * 60

           ]);
       }

       public function getAuthUser()
       {

           config()->set('auth.defaults.guard', 'driver-api' );
           \Config::set('jwt.user', 'App\Driver');
           \Config::set('auth.providers.users.model', \App\Driver::class);
           $user = JWTAuth::authenticate(JWTAuth::getToken());

           return response()->json(['user' => $user]);
       }
}
