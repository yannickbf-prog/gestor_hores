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
    public function index() {
        $data = TypeBagHour::paginate(2);

        return view('type_bag_hours.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * 2);
    }

    public function filter(Request $request) {
        
        $name = "%";
        if(($request['name'] != "")) $name = $request['name'];
        
        $hour_price = "%";
        if(($request['hour_price'] != "")) $hour_price = floatval(str_replace(",", ".", $request['hour_price']));
        

        $data = TypeBagHour::
                where('hour_price', '=', $hour_price)
                ->where('name', 'ilike', "%".$name."%")
                ->get();

        return view('type_bag_hours.filter.index', compact('data'));
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
