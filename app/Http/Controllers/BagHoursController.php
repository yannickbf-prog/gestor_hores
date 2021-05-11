<?php

namespace App\Http\Controllers;

use App\Models\BagHours;
use Illuminate\Http\Request;

class BagHoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = setGetLang();
        return view('bag_hours.index');
                        //->with('i', (request()->input('page', 1) - 1) * $num_records)->with('lang', $lang);
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
     * @param  \App\Models\BagHours  $bagHours
     * @return \Illuminate\Http\Response
     */
    public function show(BagHours $bagHours)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BagHours  $bagHours
     * @return \Illuminate\Http\Response
     */
    public function edit(BagHours $bagHours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BagHours  $bagHours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BagHours $bagHours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BagHours  $bagHours
     * @return \Illuminate\Http\Response
     */
    public function destroy(BagHours $bagHours)
    {
        //
    }
}
