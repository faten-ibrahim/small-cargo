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

    public function create()
    {
        $companies = Company::all();
        return view('companies.create', [
            'companies' => $companies,
        ]);
    }

  /* *************************************************** */
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
        $contact_list = new CompanyContactList();
        $contact_list['company_id'] = $company->id;
        $contact_list['receiver_name'] = $request['receiver_name'];
        $contact_list['conatct_name'] = $request['conatct_name'];
        $contact_list['contact_phone'] = $request['contact_phone'];
        $contact_list['address_address'] = $request['address_address'];
        $contact_list['address_latitude'] = $request['address_latitude'];
        $contact_list['address_longitude'] = $request['address_longitude'];
        $contact_list->save();
        return redirect()->route('companies.index');
    }

   /* *************************************************** */
    public function show($id)
    {
        $company = Company::find($id);
        return view('companies.show', [
            'companies' => $company
        ]);
    }

  /* *************************************************** */
    public function edit(Company $company)
    {
        $contact_list=CompanyContactList::where('company_id',$company->id)->first();
        return view ('companies.edit',[
            'company'=>$company,
            'contact_list' => $contact_list
          ]);
    }
  /* *************************************************** */
  public function update(Request $request, Company $company)
  {
      if (request('email') != $company->email) {
          $this->validate(request(), [
              'email' => 'email|unique:users',
          ]);
          $company->email = request('email');
      } else {
          $company->email = request('email');
      }

      $request->validate(
          [
              'name' => 'required',
              'email' => 'required|email',
              'address' => 'required',
              'phone' => 'required',
          ],
          [
              'name.required' => 'Please enter the company name',
              'email.required' => 'Please enter the company email',
              'email.email' => 'Please enter an valid email',
              'address.required' => 'Please enter the company address',
              'phone.required' => 'Please enter the company phone',
          ]
      );
      //update company
      $company->name = request('name');
      $company->address = request('address');
      $company->phone = request('phone');
      $company->save();
      //update contact list
      $contact_list=CompanyContactList::where('company_id',$company->id)->first();
      $contact_list->receiver_name = request('receiver_name');
      $contact_list->conatct_name = request('conatct_name');
      $contact_list->contact_phone = request('contact_phone');
      $contact_list->address_address = request('address_address');
      $contact_list->address_latitude= request('address_latitude');
      $contact_list->address_longitude= request('address_longitude');
      $contact_list->save();
      return redirect()->route('companies.index')->with('success', 'Company account has been updated ');
  }


    /* *************************************************** */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }
    /* *************************************************** */
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
  /* *************************************************** */
    public function ban(Company $company)
    {
        $company->ban();
        $company->status='inactive';
        $company->save();
        return redirect()->route('companies.index');
    }
      /* *************************************************** */
    public function unban(Company $company)
    {
        $company->unban();
        $company->status='active';
        $company->save();
        return redirect()->route('companies.index');
    }
}
