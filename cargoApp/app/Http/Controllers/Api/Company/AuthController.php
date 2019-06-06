<?php

namespace App\Http\Controllers\Api\Company;

use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use App\Company;
use Hash;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->company = new Company;
        config()->set( 'auth.defaults.guard', 'company' );
        \Config::set('jwt.user', 'App\Campany');
		\Config::set('auth.providers.users.model', \App\Company::class);
        $this->middleware('auth:company', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('name', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'We can`t find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to login, please try again.'], 500);
        }

        $company = Auth::user();
        // return $this->respondWithToken($token);
        return response()->json([
            'status' => 'You have successfully logged in .',
            'data' => [
                'token' => $token,
                'company' => $company
            ]
        ], 201);
    }

    #------------------------------- regiser function ---------------------------
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:companies',
            'address' => 'required',
            'phone' => 'required|unique:companies',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($company);
        return response()->json([
            'status' => 'You have successfully register.',
            'data' => [
                'token' => $token,
                'company' => $company
            ]
        ], 201);
    }

    #-------------------------------- logout ----------------------------------------
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
            'expires_in' => JWTAuth::factory()->getTTL() * 60

        ]);
    }

    public function getAuthUser()
    {
        $user = JWTAuth::authenticate(JWTAuth::getToken());

        return response()->json(['user' => $user]);
    }
}
