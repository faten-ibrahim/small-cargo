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
use App\DriverToken;
use App\DriverRealTimeLocation;
use App\DriverLocation;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->driver = new Driver();
        config()->set('auth.defaults.guard', 'driver-api');
        \Config::set('jwt.user', 'App\Driver');
        \Config::set('auth.providers.users.model', \App\Driver::class);
        $this->middleware('auth:driver-api', ['except' => ['login', 'register']]);
    }

    // ########## Driver Login ##########
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $phone = $request->input('phone');
        $driver = Driver::where('phone', '=', $phone)->first();
        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::fromUser($driver)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // return response()->json(compact('token'));

        return response()->json([
            'status' => 'You have successfully logged in .',
            'data' => [
                'token' => $token,
                'driver-api' => $driver
            ]
        ], 201);
    }

    // ########## Driver Registration ##########
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|unique:drivers',
            'car_number' => 'required|unique:drivers',
            'car_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $driver = Driver::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'car_number' => $request->car_number,
            'car_type' => $request->car_type,
        ]);

        $token = JWTAuth::fromUser($driver);
        return response()->json([
            'status' => 'You have successfully register.',
            'data' => [
                'token' => $token,
                'driver-api' => $driver,
            ]
        ], 201);
    }

    // ##########  Driver Logout ##########
    public function logout()
    {
        try {

            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ], 201);
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
        ]);
    }
    // ########## Get Current Authenticated Driver ##########
    public function getAuthUser()
    {
        $user = JWTAuth::authenticate(JWTAuth::getToken());
        return response()->json(['user' => $user]);
    }

    // ########## Get FCM Token For Drivers ##########
    public function get_fcm_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
            'token' => 'required|unique:driver_tokens',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $driver_id = $request->driver_id;
        $driver_token = $request->token;
        $driver = DriverToken::where('driver_id', '=', $driver_id);
        if ($driver->exists()) {
            $driver->delete();
        }
        $driver_token  = DriverToken::create([
            'driver_id' => $driver_id,
            'token' => $driver_token,
        ]);

        return response()->json([
            'status' => 'driver token save successfully',
            'data' => [
                'driver_token' => $driver_token
            ]
        ], 201);
    }

    public function post_driver_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
            'driver_latitude' => 'required',
            'driver_longitude' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $driver_id = $request->driver_id;
        $driver = DriverLocation::where('driver_id', '=', $driver_id);
        if ($driver->exists()) {
            $driver->delete();
        }
        $driver_location  = DriverLocation::create([
            'driver_id' => $driver_id,
            'driver_latitude' => $request->driver_latitude,
            'driver_longitude' => $request->driver_longitude,
        ]);

        return response()->json([
            'status' => 'current driver location save successfully',
            'data' => [
                'driver_location' => $driver_location
            ]
        ], 201);
    }


    public function get_driver_location($id)
    {
        $driver_location = DriverLocation::where('driver_id', '=', $id);

        if (!$driver_location->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, driver with id ' . $id . ' cannot be found'
            ], 400);
        } else {
            return response()->json([
                'status' => 'driver location returned successfully',
                'data' => [
                    'driver_location' => $driver_location->get(),
                ]
            ], 200);
        }
    }

    public function edit_profile(Request $request)
    {
        // dd(JWTAuth::user()->id);
        $comp=Driver::find(JWTAuth::user()->id)->update([
            'name' => $request->name,
            'car_type' => $request->car_type,
            'car_number' =>$request->car_number,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);
        // dd($comp);
        return response()->json(['message' => "your updated successfully"],200);
    }

}
