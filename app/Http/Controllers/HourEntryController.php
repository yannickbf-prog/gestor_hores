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

        $data = HourEntryController::getBDInfo()
                ->paginate(10);

        return view('entry_hours.index', compact(['lang', 'data']))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function getBDInfo() {
        $data = DB::table('users_projects')
                ->join('users', 'users_projects.user_id', '=', 'users.id')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->join('hours_entry', 'users_projects.id', '=', 'hours_entry.user_project_id')
                ->join('bag_hours', 'hours_entry.bag_hours_id', '=', 'bag_hours.id')
                ->join('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
                ->select('users.nickname AS user_name', 'projects.name AS project_name', 'customers.name AS customer_name',
                'type_bag_hours.name AS type_bag_hour_name', 'hours_entry.hours AS hour_entry_hours', 'hours_entry.validate AS hour_entry_validate',
                'hours_entry.created_at AS hour_entry_created_at', 'bag_hours.id AS bag_hour_id', 'hours_entry.id AS hours_entry_id');

        return $data;
    }

    public function validateEntryHour($id, $lang) {

        DB::table('hours_entry')
                ->where('hours_entry.id', $id)
                ->update(['validate' => 1]);

        return redirect()->route($lang . '_time_entries.index');
    }

    public function inValidateEntryHour($id, $lang) {

        DB::table('hours_entry')
                ->where('hours_entry.id', $id)
                ->update(['validate' => 0]);

        return redirect()->route($lang . '_time_entries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $lang = setGetLang();

        $users_info = [];
        $users_data =  DB::table('users')->get();

        $projects_users_data = [];
        foreach ($users_data as $user) {
            $user_id = $user->id;
            $projects_users_data = DB::table('users_projects')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')
                    ->where('users_projects.user_id', $user_id+1)
                    ->get();
            
           return $projects_users_data;
        }
        
         
        
        /*
        $projects_users_data_prueva = DB::table('users_projects')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')
                    ->where('users_projects.user_id', 3)
                    ->get();
         * 
         */
        
        return $projects_users_data;

        //return view('projects.create', compact('customers'))->with('lang', $lang);
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
