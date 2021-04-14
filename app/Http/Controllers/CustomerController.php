<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\EditCustomerRequest;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('_token')){
            
            ($request['name'] == "") ? session(['customer_name' => '%']) : session(['customer_name' => $request['name']]);
            
            ($request['email'] == "") ? session(['customer_email' => '%']) : session(['customer_email' => $request['email']]);
            
            ($request['phone'] == "") ? session(['customer_phone' => '%']) : session(['customer_phone' => $request['phone']]);
            
         
                if (Carbon::createFromFormat('d/m/Y', $request['date_from']) !== false) {
                    session(['customer_date_from' => $request['date_from']]);
                }
                else{
                    session(['customer_date_from' => 'ha entrado']);
                }
            
            
            
            session(['customer_order' => $request['order']]);
                                                                    
        }
        
        $name = session('customer_name', "%");
        $email = session('customer_email', "%");
        $phone = session('customer_phone', "%");
        $date_from = session('customer_date_from', Carbon::now());
        $order = session('customer_order', "desc");
        
        {{ var_dump($date_from); }}
        
        $data = Customer::
                where('name', 'like', "%".$name."%")
                ->where('email', 'like', "%".$email."%")
                ->where('phone', 'like', "%".$phone."%")
                ->orderBy('created_at', $order)
                ->paginate(1);

        return view('customers.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * 1);
    }
    
    public function deleteFilters() {
        
        session(['customer_name' => '%']);
        session(['customer_email' => '%']);
        session(['customer_phone' => '%']);
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
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {

        Customer::create($request->validated());

        return redirect()->route('customers.index')
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
