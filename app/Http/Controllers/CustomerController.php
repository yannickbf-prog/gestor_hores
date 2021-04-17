<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\EditCustomerRequest;
use DateTime;
use DateTimeZone;
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
        
        $lang = setLang();
        
        if($request->has('_token')){
            
            ($request['name'] == "") ? session(['customer_name' => '%']) : session(['customer_name' => $request['name']]);
            
            ($request['email'] == "") ? session(['customer_email' => '%']) : session(['customer_email' => $request['email']]);
            
            ($request['phone'] == "") ? session(['customer_phone' => '%']) : session(['customer_phone' => $request['phone']]);
            
            if (DateTime::createFromFormat('d/m/Y', $request['date_from']) !== false) {
                $date = DateTime::createFromFormat('d/m/Y', $request['date_from'])->format('d/m/Y');
                session(['customer_date_from' => $date]);
            }
            else{
                session(['customer_date_from' => ""]);
            }
            
            if (DateTime::createFromFormat('d/m/Y', $request['date_to']) !== false) {
                $date = DateTime::createFromFormat('d/m/Y', $request['date_to'])->format('d/m/Y');
                session(['customer_date_to' => $date]);
            }
            else{
                session(['customer_date_to' => ""]);
            }

            session(['customer_order' => $request['order']]);
            
            session(['customer_num_records' => $request['num_records']]);
                                                                    
        }
        
        $name = session('customer_name', "%");
        $email = session('customer_email', "%");
        $phone = session('customer_phone', "%");
        
        $date_from = session('customer_date_from', "");
        
        if($date_from == ""){
            $date = new DateTime('2021-04-10');
            $date_from = $date->format('Y-m-d');
        }
        else{
            $date_from = DateTime::createFromFormat('d/m/Y', $date_from)->format('Y-m-d');
        }
        
        //echo $date_from;
        
        $date_to = session('customer_date_to', "");
        
        if($date_to == ""){
            $date = new DateTime('NOW', new DateTimeZone('Europe/Madrid'));
            $date_to = $date->format('Y-m-d');
        }
        else{
            $date_to = DateTime::createFromFormat('d/m/Y', $date_to)->format('Y-m-d');
        }
        
        //echo " ".$date_to;
        
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
    
    public function deleteFilters() {
        
        session(['customer_name' => '%']);
        session(['customer_email' => '%']);
        session(['customer_phone' => '%']);
        session(['customer_date_from' => ""]);
        session(['customer_date_to' => ""]);
        session(['customer_order' => 'desc']);

        return redirect()->route('customers.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = setLang();
        
        return view('customers.create')->with('lang', $lang);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {

        $lang = setLang();
        
        if (\Request::is('es/*')) {
            $lang = "es";
        }
        
        Customer::create($request->validated());

        return redirect()->route('es_customers.index')
                        ->with('success', 'Customer created successfully.');
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
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(EditCustomerRequest $request, Customer $customer)
    {
        
        
        $customer->update($request->validated());
       

        return redirect()->route('customers.index')
                        ->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
                        ->with('success', 'Customer deleted successfully');
    }
}
