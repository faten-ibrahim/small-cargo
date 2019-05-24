<?php

namespace App\Http\Controllers\Api\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Company;
use Validator;
use Hash;
use JWTFactory;
// use JWTAuth;
use Tymon\JWTAuth\JWTAuth;
use JWTAuthException;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // config()->set( 'auth.defaults.guard', 'company' );
        // \Config::set('jwt.user', 'App\Campany');
        // \Config::set('auth.providers.users.model', \App\Company::class);
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = $this->guard()->attempt($credentials)) {
                return response()->json(['error' => 'We can`t find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to login, please try again.'], 500);
        }


        return $this->respondWithToken($token);;
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
        //    config()->set( 'auth.defaults.guard', 'company' );
        //    \Config::set('jwt.user', 'App\Campany');
        //    \Config::set('auth.providers.users.model', \App\Company::class);
        $token = $this->guard()->fromUser($company);
        return response()->json([
            'status' => 'You have successfully register.',
            'data' => [
                'token' => $token,
                'company' => $company
            ]
        ], 201);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // return response()->json($this->guard()->user());
        return Auth::guard('company-api')->user();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard('company-api');
    }
}
