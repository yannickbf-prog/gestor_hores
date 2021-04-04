<?php

namespace App\Http\Controllers;

use App\Models\TypeBagHour;
use Illuminate\Http\Request;

class TypeBagHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TypeBagHour::latest()->paginate(5);
    
        return view('type_bag_hours.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function show(TypeBagHour $typeBagHour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeBagHour $typeBagHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeBagHour $typeBagHour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeBagHour $typeBagHour)
    {
        $typeBagHour->delete();
    
        return redirect()->route('type-bag-hours.index')
                        ->with('success','Bag hour type deleted successfully');
    }
}
