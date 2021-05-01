<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\EditCustomerRequest;
use Illuminate\Support\Facades\App;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $lang = setGetLang();
        
        if($request->has('_token')){
            
            ($request['name'] == "") ? session(['customer_name' => '%']) : session(['customer_name' => $request['name']]);
            
            ($request['email'] == "") ? session(['customer_email' => '%']) : session(['customer_email' => $request['email']]);
            
            ($request['phone'] == "") ? session(['customer_phone' => '%']) : session(['customer_phone' => $request['phone']]);

            session(['customer_order' => $request['order']]);
            
            session(['customer_num_records' => $request['num_records']]);
                                                                    
        }
                
        $dates = getIntervalDates($request, 'customer');
        $date_from = $dates[0];
        $date_to = $dates[1];
        
        $name = session('customer_name', "%");
        $email = session('customer_email', "%");
        $phone = session('customer_phone', "%");
        
        $order = session('customer_order', "desc");
        
        $num_records = session('customer_num_records', 10);
        
        if($num_records == 'all'){
            $num_records = Customer::count();
        }
        
        $data = Customer::
                where('name', 'like', "%".$name."%")
                ->where('email', 'like', "%".$email."%")
                ->where('phone', 'like', "%".$phone."%")
                ->whereBetween('created_at', [$date_from, $date_to])
                ->orderBy('created_at', $order)
                ->paginate($num_records);

        return view('customers.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * $num_records)->with('lang', $lang);
    }
    
    public function deleteFilters(Request $request) {
        
        session(['customer_name' => '%']);
        session(['customer_email' => '%']);
        session(['customer_phone' => '%']);
        session(['customer_date_from' => ""]);
        session(['customer_date_to' => ""]);
        session(['customer_order' => 'desc']);
        session(['customer_num_records' => 10]);
        
        $lang = $request->lang;

        return redirect()->route($lang.'_customers.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = setGetLang();
        
        return view('customers.create')->with('lang', $lang);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request, $lang)
    {
        App::setLocale($lang);
              
        Customer::create($request->validated());
        
        return redirect()->route($lang.'_customers.index')
                        ->with('success', __('message.customer')." ".$request->name." ".__('message.created') );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $lang = setGetLang();
        
        return view('customers.edit', compact('customer'), compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(EditCustomerRequest $request, Customer $customer, $lang)
    {
        
        $customer->update($request->validated());
       

        return redirect()->route($lang.'_customers.index')
                        ->with('success', __('message.customer')." ".$request->name." ".__('message.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, $lang)
    {
        App::setLocale($lang);
        
        $customer->delete();

        return redirect()->route($lang.'_customers.index')
                        ->with('success', __('message.customer')." ".__('message.deleted'));
    }
}
