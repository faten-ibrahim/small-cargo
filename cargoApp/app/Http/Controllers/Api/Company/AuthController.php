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
use App\CompanyToken;
use App\CompanyContactList;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->company = new Company;
        config()->set('auth.defaults.guard', 'company');
        \Config::set('jwt.user', 'App\Campany');
        \Config::set('auth.providers.users.model', \App\Company::class);
        // $this->middleware('auth:company', ['except' => ['login', 'register']]);
    }
    // ########## Company Login ##########
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comp_name' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
        $credentials = $request->only('comp_name', 'password');
        
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'We can`t find an account with this credentials.'], 401);
            }
            else{
              $status=Company::select('status','password')->where('comp_name',request('comp_name'))->first();
                  if ($status->status ==='inactive'){           
                    return response()->json(['error' => 'This account inactive can not login.'], 500);
                   }
        
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

    // ########## Company Registration ##########

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comp_name' => 'required|unique:companies',
            'email' => 'required|unique:companies',
            'address' => 'required',
            'phone' => 'required|unique:companies',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $company = Company::create([
            'comp_name' => $request->comp_name,
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
                'company' => $company,
            ]
        ], 201);
    }


    // ########## Company Logout ##########
    public function logout()
    {

        try {
                
            JWTAuth::invalidate(JWTAuth::getToken());
            $company = Auth::user();
            $company_token=CompanyToken::where('company_id',$company->id);
            $company_token->delete();
            
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

    // ########## Get Company Current Authenticated company ##########
    public function getAuthUser()
    {
        $user = JWTAuth::authenticate(JWTAuth::getToken());

        return response()->json(['user' => $user]);
    }

    // ########## Get FCM Token Data ##########
    public function get_fcm_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'token' => 'required|unique:company_tokens',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $company_id = $request->company_id;
        $company_token = $request->token;
        $company = CompanyToken::where('company_id', '=', $company_id);
        if ($company->exists()) {
            $company->delete();
        }
        $company_token  = CompanyToken::create([
            'company_id' => $company_id,
            'token' => $company_token,
        ]);

        return response()->json([
            'status' => 'company token save successfully',
            'data' => [
                'company_token' => $company_token
            ]
        ], 201);
    }

    public function edit_profile(Request $request)
    {
        // dd(JWTAuth::user()->id);
        Company::find(JWTAuth::user()->id)->update([
            'comp_name' => $request->comp_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
        ]);
        $company=Company::where('email',$request->email)->get();
        return response()->json([
            'message' => "data updated successfully",
            'company'=>$company
        ],200);
    }


}
