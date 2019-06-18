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
use App\DriverToken;
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
            ->where('deleted_at',Null)
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
                'email' => 'required|unique:companies,email,NULL,id,deleted_at,NULL',
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

        //----------------
        $contact_companies=Company::select('*')
        ->where('status','contact')->get();
        foreach ($contact_companies as $contact_company){
            if( ($contact_company->phone === $request['phone']) || ($contact_company->comp_name === $request['name']) ){
                 $contact_company->delete();
            }
        }     

        //----------------

            $company = new Company();
            $company['comp_name'] = $request['name'];
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
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:companies,email,'.$company->id.',id,deleted_at,NULL',
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
        $company->comp_name = request('name');
        $company->phone = request('phone');
        $company->email = request('email');
        $company->address = request('address');
        $company->address_latitude = request('address_latitude');
        $company->address_longitude = request('address_longitude');
        $company->update();
        return redirect()->route('companies.index')->with('success', 'Company account has been updated ');

    }


    /* *************************************************** */
    public function destroy(Company $company)
    {
        $contacts = Company::find($company->id)->companycontactlists;
        $contacts->each->delete();
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
        $company_orders = CompanyOrder::select('order_id')
                ->where('sender_id',$company->id);
        
        $orders_details = CompanyOrder::where('sender_id', $company->id)
                ->Join('orders', function ($q) {
                    $q->on('orders.id', '=', 'company_order.order_id');
                })
                ->Join('packages', 'packages.order_id', '=', 'orders.id')
                ->leftjoin('driver_order', 'driver_order.order_id', '=', 'orders.id')
                ->leftjoin('drivers','drivers.id','driver_order.driver_id')->paginate(4);        

             // total estimated cost   and orders
             $total=0;
             $sum=0;
             foreach ($orders_details as $order){;
                 $sum=$sum+$order->estimated_cost;
                 $total=$total+1;
             }  
             //---------------------

        return view('companies.send_orders', [
            'orders' => $orders_details,
            'company'=>$company,
            'total'=>$total,
            'sum' => $sum,
        ]);

    }



   /* *************************************************** */
   public function Recived_company_orders(Company $company){
        $company_orders = CompanyOrder::select('order_id')
            ->where('receiver_id',$company->id)->get();

        $orders_details = CompanyOrder::where('receiver_id', $company->id)
        ->Join('orders', function ($q) {
            $q->on('orders.id', '=', 'company_order.order_id');
        })
        ->Join('packages', 'packages.order_id', '=', 'orders.id')
        ->leftjoin('driver_order', 'driver_order.order_id', '=', 'orders.id')
        ->leftjoin('drivers','drivers.id','driver_order.driver_id')->paginate(4);

          // total estimated cost   and orders
          $total=0;
          $sum=0;
          foreach ($orders_details as $order){;
              $sum=$sum+$order->estimated_cost;
              $total=$total+1;
          }  
          //---------------------

        return view('companies.recived_orders', [
        'orders' => $orders_details,
        'company'=>$company,
        'total'=>$total,
        'sum' => $sum,
        ]);

}

}
