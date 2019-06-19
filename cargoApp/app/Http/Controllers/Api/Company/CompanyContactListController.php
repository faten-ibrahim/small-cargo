<?php

namespace App\Http\Controllers\Api\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CompanyContactList;
use Validator;
use App\Company;

class CompanyContactListController extends Controller
{
      public function store_list(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'company_id'=>'required',
            'receiver_name' => 'required',
            'conatct_name' => 'required',
            'contact_phone' => 'required|regex:/(01)[0-9]{9}/',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $company=Company::find($request->company_id);
        if($company){
        $contact_list = new CompanyContactList();
        $contact_list['company_id'] = $request['company_id'];
        $contact_list['receiver_name'] = $request['receiver_name'];
        $contact_list['conatct_name'] = $request['conatct_name'];
        $contact_list['contact_phone'] = $request['contact_phone'];
        $contact_list['address_address'] = $request['address_address'];
        $contact_list['address_latitude'] = $request['address_latitude'];
        $contact_list['address_longitude'] = $request['address_longitude'];
        $contact_list->save();
        return response()->json([
            'message' => "data added successfully",
            'company data'=>$contact_list
        ],200);
        }else{
            return response()->json([
                'message' => "company id not exist",
            ],200);
        }
    }
}
