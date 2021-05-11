<?php

namespace App\Http\Controllers;

use App\Models\BagHour;
use Illuminate\Http\Request;


class BagHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = setGetLang();
        
        $data = BagHour::join('projects', 'bag_hours.project_id', '=', 'projects.id')
            ->join('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
            ->select('projects.*', 'projects.id AS project_id', 'projects.name AS project_name', 'type_bag_hours.id AS type_id', 'type_bag_hours.name AS type_name', 'type_bag_hours.hour_price AS type_hour_price')
            ->paginate(2);
                
        
        return view('bag_hours.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * 2)->with('lang', $lang);
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
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function show(BagHour $bagHour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function edit(BagHour $bagHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BagHour $bagHour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(BagHour $bagHour)
    {
        //
    }
}
