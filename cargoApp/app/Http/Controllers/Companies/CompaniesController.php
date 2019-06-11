<?php
namespace App\Http\Controllers\Companies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Order;
use App\CompanyOrder;
use App\DriverOrder;
use App\Driver;
use App\Package;
use DB;
use Yajra\Datatables\Datatables;
use App\CompanyContactList;
use App\Mail\CompanyMail;
use Mail;
use Hash;


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
                'email' => 'required|unique:companies|email',
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
        $company['address_latitude'] = $request['address_latitude'];
        $company['address_longitude'] = $request['address_longitude'];
        $company['phone'] = $request['phone'];
        $pass=str_random(8);
        $company['password'] =Hash::make($pass);
        $company->save();

          # send email to Company
          if (Company::where('email', '=',  $request['email'])->exists()) {
          $this->SendEmail($request['name'],$request['email'],$pass);
          }
          #####


        return redirect()->route('companies.index');
    }

    /* *************************************************** */
    public function show(Company $company)
    {
        $contacts = Company::find($company->id)->companycontactlists;
        return view('companies.show', [
            'company' => $company,
            'contacts' => $contacts
        ]);
    }

    /* *************************************************** */
    public function edit(Company $company)
    {
        return view('companies.edit', [
            'company' => $company,
        ]);
    }

    /* *************************************************** */
    public function update(Request $request, Company $company)
    {
        if (request('email') != $company->email) {
            $this->validate(request(), [
                'email' => 'email|unique:companies',
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
        $company->phone = request('phone');
        $company->address = request('address');
        $company->address_latitude = request('address_latitude');
        $company->address_longitude = request('address_longitude');
        $company->save();
        return redirect()->route('companies.index')->with('success', 'Company account has been updated ');

    }


    /* *************************************************** */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }

    public function ban(Company $company)
    {
        $company->ban();
        $company->status = 'inactive';
        $company->save();
        return redirect()->route('companies.index');
    }
    /* *************************************************** */
    public function unban(Company $company)
    {
        $company->unban();
        $company->status = 'active';
        $company->save();
        return redirect()->route('companies.index');
    }

    public function create_list(Company $company)
    {
        return view('companies.add', [
            'company' => $company,
        ]);
    }

    public function store_list(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'receiver_name' => 'required',
                'conatct_name' => 'required',
                'contact_phone' => 'required',

            ],
            [
                'receiver_name.required' => 'Please enter the company name',
                'conatct_name.required' => 'Please enter the contact name',
                'contact_phone' => 'Please enter the phone',
            ]
        );

        $contact_list = new CompanyContactList();
        $contact_list['company_id'] = $request['company_id'];
        $contact_list['receiver_name'] = $request['receiver_name'];
        $contact_list['conatct_name'] = $request['conatct_name'];
        $contact_list['contact_phone'] = $request['contact_phone'];
        $contact_list['address_address'] = $request['address_address'];
        $contact_list['address_latitude'] = $request['address_latitude'];
        $contact_list['address_longitude'] = $request['address_longitude'];
        $contact_list->save();
        return redirect()->route('companies.index');
    }

    // public function get_contacts(Company $company)
    // {
    //     $contacts = Company::find($company->id)->companycontactlists;
    //     return view('companies.show_contacts', [
    //         'contacts' => $contacts
    //     ]);
    // }

  /* *************************************************** */
    public function SendEmail($name,$email,$password){
        $data=[
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];
        Mail::to($email)->send(new CompanyMail($data));
    }

   /* *************************************************** */
    public function Send_company_orders(Company $company){
        $company_orders = DB::table('company_order')
                ->select('order_id')
                ->where('sender_id',$company->id);

        $orders=DriverOrder::whereIn('order_id', $company_orders)
                ->leftJoin('orders','orders.id', '=', 'driver_order.order_id')
                ->leftJoin('drivers', function ($join) {
                        $join->on('drivers.id', '=', 'driver_order.driver_id');
                    })
                ->select('orders.*','drivers.name','drivers.phone')
                ->orderBy('orders.created_at', 'desc')->paginate(5);
                // dd($company);

        $packages=Package::whereIn('order_id', $company_orders)->get();

       
        return view('companies.send_orders', [
            'orders' => $orders,
            'company'=>$company,
            'packages'=> $packages,
        ]);

    }

   /* *************************************************** */
   public function Recived_company_orders(Company $company){
    $company_orders = DB::table('company_order')
            ->select('order_id')
            ->where('receiver_id',$company->id);            

    $orders=DriverOrder::whereIn('order_id', $company_orders)
            ->leftJoin('orders','orders.id', '=', 'driver_order.order_id')
            ->leftJoin('drivers', function ($join) {
                    $join->on('drivers.id', '=', 'driver_order.driver_id');
                })        
            ->select('orders.*','drivers.name','drivers.phone')  
            ->orderBy('orders.created_at', 'desc')->paginate(5);
            // dd($company);

    $packages=Package::whereIn('order_id', $company_orders)->get();

   
    return view('companies.recived_orders', [
        'orders' => $orders,
        'company'=>$company,
        'packages'=> $packages,
    ]);

}

}
