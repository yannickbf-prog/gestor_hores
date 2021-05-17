<?php

namespace App\Http\Controllers;

use App\Models\HourEntry;
use Illuminate\Http\Request;
use DB;

class HourEntryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $lang = setGetLang();

        $data = DB::table('users_projects')
                ->join('users', 'users_projects.user_id', '=', 'users.id')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->join('hours_entry', 'users_projects.id', '=', 'hours_entry.user_project_id')
                ->join('bag_hours', 'hours_entry.bag_hours_id', '=', 'bag_hours.id')
                ->join('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
                ->select('users.nickname AS user_name', 'projects.name AS project_name', 'customers.name AS customer_name',
                        'type_bag_hours.name AS type_bag_hour_name', 'hours_entry.hours AS hour_entry_hours', 'hours_entry.validate AS hour_entry_validate',
                        'hours_entry.created_at AS hour_entry_created_at', 'bag_hours.id AS bag_hour_id', 'hours_entry.id AS hours_entry_id')
                ->paginate(10);

        return view('entry_hours.index', compact(['lang', 'data']))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function validateEntryHour($id) {
        $id_int = intval($id) - 1;

        $affected = DB::table('hours_entry')
                ->where('hours_entry.id', $id_int)
                ->update(['validate' => 1]);
        
        return redirect()->route('en_time_entries.index');
    }

    public function inValidateEntryHour(Request $request, $lang) {

        if ($request->has('_token')) {
            //Validate entry hour
            $affected = DB::table('hours_entry')
                    ->where('id', $request['hours_entry_id'])
                    ->update(['validate' => 0]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $lang = setGetLang();

        $customers = Customer::select("id", "name")->get();

        return view('projects.create', compact('customers'))->with('lang', $lang);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HourEntry  $hourEntry
     * @return \Illuminate\Http\Response
     */
    public function show(HourEntry $hourEntry) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HourEntry  $hourEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(HourEntry $hourEntry) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HourEntry  $hourEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HourEntry $hourEntry) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HourEntry  $hourEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(HourEntry $hourEntry) {
        //
    }

}
