<?php

namespace App\Http\Controllers;

use App\Models\TypeBagHour;
use Illuminate\Http\Request;


class TypeBagHourController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        if($request->has('_token')){
            session(['type_bag_hour_name' => '%']);
            if(($request['name'] != "")) session(['type_bag_hour_name' => $request['name']]);
            
            session(['type_bag_hour_price' => '%']);
            if(($request['hour_price'] != "")) session(['type_bag_hour_price' => $request['hour_price']]);
        }
        
        
        $name = session('type_bag_hour_name', "%");
        $hour_price = session('type_bag_hour_price', "%");
        
        $data = TypeBagHour::
                where('hour_price', 'like', $hour_price)
                ->where('name', 'ilike', "%".$name."%")
                ->paginate(1);

        return view('type_bag_hours.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * 1);
    }
    
    public function deleteFilters() {
        
        session(['type_bag_hour_name' => '%']);
        session(['hour_price' => '%']);
        

        return redirect()->route('type-bag-hours.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('type_bag_hours.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request['hour_price'] = str_replace(",", ".", $request['hour_price']);

        $request->validate([
            'name' => 'required',
            'hour_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                ], [
            'hour_price.regex' => __('The price must have the next format: 20, 2000, 20.25 or 20,25 (example values).'),
        ]);

        TypeBagHour::create($request->all());

        return redirect()->route('type-bag-hours.index')
                        ->with('success', 'Bag hour type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function show(TypeBagHour $typeBagHour) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeBagHour $typeBagHour) {
        return view('type_bag_hours.edit', compact('typeBagHour'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeBagHour $typeBagHour) {
        $request['hour_price'] = str_replace(",", ".", $request['hour_price']);

        $request->validate([
            'name' => 'required',
            'hour_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                ], [
            'hour_price.regex' => __('The price must have the next format: 20, 2000, 20.25 or 20,25 (example values).'),
        ]);

        $typeBagHour->update($request->all());

        return redirect()->route('type-bag-hours.index')
                        ->with('success', 'Bag hour type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeBagHour $typeBagHour) {
        $typeBagHour->delete();

        return redirect()->route('type-bag-hours.index')
                        ->with('success', 'Bag hour type deleted successfully');
    }

}
