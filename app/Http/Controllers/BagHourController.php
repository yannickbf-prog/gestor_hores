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
    public function index(Request $request)
    {
        $lang = setGetLang();
        
        if ($request->has('_token')) {
            ($request['type'] == "") ? session(['bag_hour_type' => '%']) : session(['bag_hour_type' => $request['type']]);
            ($request['project'] == "") ? session(['bag_hour_project' => '%']) : session(['bag_hour_project' => $request['project']]);
            ($request['contracted_hours'] == "") ? session(['bag_hour_contracted_hours' => '%']) : session(['bag_hour_contracted_hours' => $request['contracted_hours']]);
            ($request['hours_available'] == "") ? session(['bag_hour_hours_available' => '%']) : session(['bag_hour_hours_available' => $request['hours_available']]);
            ($request['hour_price'] == "") ? session(['bag_hour_hour_price' => '%']) : session(['bag_hour_hour_price' => str_replace(",", ".", $request['hour_price'])]);        
        }
        
        $type = session('bag_hour_type', "%");
        $project = session('bag_hour_project', "%");
        $contracted_hours = session('bag_hour_contracted_hours', "%");
        $hours_available = session('bag_hour_hours_available', "%");
        
        $hour_price = session('bag_hour_hour_price', "%");
        if(strlen(substr(strrchr($hour_price, "."), 1)) == 1){
            $hour_price = number_format($hour_price, 2, '.', '');
        }
        
        $data = BagHour::join('projects', 'bag_hours.project_id', '=', 'projects.id')
            ->join('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
            ->select('bag_hours.*', 'projects.id AS project_id', 'projects.name AS project_name', 'type_bag_hours.id AS type_id', 'type_bag_hours.name AS type_name', 'type_bag_hours.hour_price AS type_hour_price')
            ->where('type_bag_hours.name', 'like', "%".$type."%")
            ->where('projects.name', 'like', "%".$project."%")
            ->where('contracted_hours', 'like', $contracted_hours)
            ->where('hours_available', 'like', $hours_available)
            ->where('hour_price', 'like', $hour_price)
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
