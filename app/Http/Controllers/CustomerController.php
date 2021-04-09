<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCustomerRequest;


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
                                                                    
        }
        
        $name = session('customer_name', "%");
        $email = session('customer_email', "%");
        $phone = session('customer_phone', "%");
        
        $data = Customer::
                where('name', 'ilike', "%".$name."%")
                ->where('email', 'ilike', "%".$email."%")
                ->where('phone', 'like', "%".$phone."%")
                ->paginate(1);

        return view('customers.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * 1);
    }
    
    public function deleteFilters() {
        
        session(['customer_name' => '%']);
        session(['customer_email' => '%']);
        session(['customer_phone' => '%']);

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
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => ['required', Rule::unique('customers')->ignore($customer)],
            'email' => ['required','email',Rule::unique('customers')->ignore($customer)],
            'phone' => ['required', 'numeric', 'min:100000000', 'max:100000000000000', Rule::unique('customers')->ignore($customer)],
            'description' => 'max:400'
        ]);
        
        $customer->update($request->all());

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
