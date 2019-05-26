<?php

namespace App\Http\Controllers\Companies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Order;
use App\CompanyOrder;
use DB;
use Yajra\Datatables\Datatables;
use App\CompanyContactList;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('companies.index');
    }

    public function get_companies()
    {
        $companies = DB::table('companies')
            ->leftJoin('company_order', function ($join) {
                $join->on('companies.id', '=', 'company_order.sender_id')
                    ->orOn('companies.id', '=', 'company_order.receiver_id');
            })
            ->select(
                'companies.*',
                DB::raw("count(company_order.sender_id) as orders_count")
            )
            ->groupBy('companies.id')
            ->orderBy('companies.created_at', 'desc');

        // dd(datatables()->of(Company::all())->toJson());
        return datatables()->of($companies)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('companies.create', [
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'address' => 'required',
                'phone' => 'required',
            ],
            [
                'name.required' => 'Please enter the company name',
                'email.required' => 'Please enter the company email',
                'email.email' => 'Please enter an valid email',
                'email.unique' => 'This email is already exists',
                'address.required' => 'Please enter the company address',
                'phone.required' => 'Please enter the company phone',
            ]
        );
        // dd($request);
        // Company::create($request->all());
        $company = new Company();
        $company['name'] = $request['name'];
        $company['email'] = $request['email'];
        $company['address'] = $request['address'];
        $company['phone'] = $request['phone'];
        $company['password'] = bcrypt("@passwd");
        $company->save();

        // dd($company->id);
        $contact_list=new CompanyContactList();
        $contact_list['company_id']=$company->id;
        $contact_list['receiver_name']=$request['receiver_name'];
        $contact_list['conatct_name']=$request['conatct_name'];
        $contact_list['contact_phone']=$request['contact_phone'];
        $contact_list['address_address']=$request['address_address'];
        $contact_list['address_latitude']=$request['address_latitude'];
        $contact_list['address_longitude']=$request['address_longitude'];
        $contact_list->save();
        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        return view('companies.show', [
            'companies' => $company
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', [
            'companies' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->all());
        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }

    // public function get_table()
    // {
    //     $companies= DB::table('companies')
    //         ->leftJoin('company_order', function ($join) {
    //             $join->on('companies.id', '=', 'company_order.sender_id')
    //                  ->orOn('companies.id', '=', 'company_order.receiver_id');
    //         })
    //         ->select(
    //             'companies.*',
    //             DB::raw("count(company_order.sender_id) as orders_count")
    //         )
    //         ->groupBy('companies.id')
    //         ->orderBy('companies.created_at', 'desc')
    //         ->get();
    //         $res=response()->json($companies);
    //         dd(res);
    //     return response()->json($companies);
    // }



}
