<?php

namespace App\Http\Controllers;

use App\Models\EntryHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EntryHoursController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = setGetLang();
        
        return view('entry_hours_worker.index', compact('lang'));
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
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function show(EntryHours $entryHours)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function edit(EntryHours $entryHours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EntryHours $entryHours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntryHours $entryHours)
    {
        //
    }
}
