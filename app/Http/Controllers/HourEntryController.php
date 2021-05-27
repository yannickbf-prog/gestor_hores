<?php

namespace App\Http\Controllers;

use App\Models\HourEntry;
use App\Models\UsersProject;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\CreateHourEntryRequest;
use Illuminate\Support\Facades\App;

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
        
        $join = DB::table('hours_entry')->leftJoin('bag_hours', 'hours_entry.bag_hours_id', '=', 'bag_hours.id')->leftJoin('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')->select('type_bag_hours.name')->get();
             

        return view('entry_hours.index', compact(['lang', 'data']))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function getBDInfo() {
        $data = UsersProject::join('users', 'users_projects.user_id', '=', 'users.id')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->join('hours_entry', 'users_projects.id', '=', 'hours_entry.user_project_id')
                ->leftJoin('bag_hours', 'hours_entry.bag_hours_id', '=', 'bag_hours.id')
                ->leftJoin('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
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

        //Create json with the info of DB, need for selects user, project and bag of hours. This work with JavaScript
        $users_info = [];
        $users_data =  DB::table('users')->get();

        foreach ($users_data as $user) {

            $user_id = $user->id;
            $projects_users_data = DB::table('users_projects')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')
                    ->where('users_projects.user_id', $user_id)
                    ->where('projects.active', 1)
                    ->select('projects.id AS project_id', 'projects.name AS project_name', 'customers.name AS customer_name')
                    ->get();
            
            $users_projects = [];
            foreach ($projects_users_data as $project_in_user) {
                
                $bag_hour;
                
                if(DB::table('bag_hours')->where('project_id', $project_in_user->project_id)->exists()){
                    $bag_hour = true;
                }
                else{
                    $bag_hour = false;
                }
                
                $users_projects[] = [
                    'id' => $project_in_user->project_id,
                    'name' => $project_in_user->project_name,
                    'customer' => $project_in_user->customer_name,
                    'bag_hour' => $bag_hour,
                ];
                
                
            }
            
            $users_info[] = [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'phone' =>  $user->phone,
                'role' => $user->role,
                'projects' => $users_projects
            ];
        }

        return view('entry_hours.create', compact(['lang', 'users_data', 'users_info']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHourEntryRequest $request, $lang) {
        
        App::setLocale($lang);
        
        $request->validated();
        
        $user_project_id = DB::table('users_projects')
                ->where('user_id', $request['users'])
                ->where('project_id', $request['projects'])
                ->select('id')
                ->get();
                
        $bag_hour_id;
        if(DB::table('bag_hours')->where('project_id', $request['projects'])->select('id')->exists()){
            $bag_hour_id = DB::table('bag_hours')->where('project_id', $request['projects'])->select('id')->get()[0]->id;
        }
        else{
            $bag_hour_id = NULL;
        }
        
        DB::table('hours_entry')->insert([
            'user_project_id' => $user_project_id[0]->id,
            'bag_hours_id' => $bag_hour_id,
            'hours' => $request['hours'],
            'validate' => $request['validate'],
            'created_at' => now(),
            'updated_at' => now(), 
        ]);
        
        return redirect()->route($lang.'_time_entries.index')
                        ->with('success', __('message.time_entry')." ".__('message.created') );
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
