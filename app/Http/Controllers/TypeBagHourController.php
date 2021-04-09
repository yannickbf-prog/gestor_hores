<?php

namespace App\Http\Controllers;

use App\Models\TypeBagHour;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTypeBagHourRequest;
use App\Http\Requests\EditTypeBagHourRequest;

class TypeBagHourController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        if($request->has('_token')){
            
            ($request['name'] == "") ? session(['type_bag_hour_name' => '%']) : session(['type_bag_hour_name' => $request['name']]);
            
            ($request['hour_price'] == "") ? session(['type_bag_hour_price' => '%']) : session(['type_bag_hour_price' => str_replace(",", ".", $request['hour_price'])]);
                                                                    
        }
        
        
        $name = session('type_bag_hour_name', "%");
        $hour_price = session('type_bag_hour_price', "%");
        
        $data = TypeBagHour::
                where('name', 'ilike', "%".$name."%")
                ->where('hour_price', 'like', $hour_price)
                ->paginate(7);

        return view('type_bag_hours.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * 7);
    }
    
    public function deleteFilters() {
        
        session(['type_bag_hour_name' => '%']);
        session(['type_bag_hour_price' => '%']);

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
    public function store(CreateTypeBagHourRequest $request) {
        $request['hour_price'] = str_replace(",", ".", $request['hour_price']);

        TypeBagHour::create($request->validated());

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
    public function update(EditTypeBagHourRequest $request, TypeBagHour $typeBagHour) {
        
        $request['hour_price'] = str_replace(",", ".", $request['hour_price']);

        $typeBagHour->update($request->validated());

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
