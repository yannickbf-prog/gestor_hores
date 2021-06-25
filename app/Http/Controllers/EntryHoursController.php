<?php

namespace App\Http\Controllers;

use App\Models\EntryHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Requests\CreateHourEntryRequestUser;

class EntryHoursController extends Controller {

    public function __construct() {
        $this->middleware('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $old_data = [];

        $old_days = old('days');

        if ($old_days != null) {
            $old_data = [
                'old_days' => $old_days,
                'old_hours' => old('hours'),
                'old_customers' => old('customers'),
                'old_projects' => old('projects'),
                'old_inputed_hours' => old('inputed_hours'),
                'old_desc' => old('desc'),
            ];
        }

        $lang = setGetLang();

        $user_id = Auth::user()->getUserId();

        $json_data = [];

        $user_customers_data = DB::table('users_projects')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')->distinct()
                ->where('users_projects.user_id', $user_id)
                ->select('customers.id AS customer_id', 'customers.name AS customer_name')
                ->get();

        foreach ($user_customers_data as $customer) {
            $user_customer_projects = DB::table('users_projects')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')
                    ->where('users_projects.user_id', $user_id)
                    ->where('customers.id', $customer->customer_id)
                    ->where('projects.active', 1)
                    ->select('projects.id AS project_id', 'projects.name AS project_name')
                    ->get();

            foreach ($user_customer_projects as $project) {
                if (DB::table('bag_hours')->where('project_id', $project->project_id)->exists()) {
                    $project->projects_active = true;
                } else {
                    $project->projects_active = false;
                }
            }

            $json_data[] = [
                'customer_id' => $customer->customer_id,
                'customer_name' => $customer->customer_name,
                'customer_projects' => $user_customer_projects,
            ];
        }


        $last_project_entry = DB::table('hours_entry')
                ->join('users_projects', 'hours_entry.user_project_id', '=', 'users_projects.id')
                ->select('users_projects.project_id')
                ->where('users_projects.user_id', $user_id)
                ->get();

        $last_customer_and_project = null;

        if (!$last_project_entry->isEmpty()) {
            $last_project_entry = DB::table('hours_entry')
                    ->join('users_projects', 'hours_entry.user_project_id', '=', 'users_projects.id')
                    ->select('users_projects.project_id')
                    ->where('users_projects.user_id', $user_id)
                    ->latest('hours_entry.created_at')
                    ->first();

            $last_customer_entry = DB::table('projects')
                    ->select('customer_id')
                    ->where('projects.id', $last_project_entry->project_id)
                    ->first();

            $last_customer_and_project = [
                'customer_id' => $last_customer_entry->customer_id,
                'project_id' => $last_project_entry->project_id,
            ];
        }

        return view('entry_hours_worker.index', compact(['lang', 'json_data', 'old_data', 'last_customer_and_project']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHourEntryRequestUser $request) {

        $count_hours_entries = count($request->days);

        session(['count_hours_entries_user' => $count_hours_entries]);

        if (!$request->validated()) {

            return back()->withInput();
        } else {

            $inputed_hours_index = 0;
            for ($i = 0; $i < count($request->days); $i++) {
                $day = Carbon::createFromFormat('d/m/Y', $request->days[$i])->format('Y-m-d');
                $hours = $request->hours[$i];
                $user = Auth::user()->getUserId();
                $customer = $request->customers[$i];
                $project = $request->projects[$i];
                $description = $request->desc[$i];

                $user_project_id = DB::table('users_projects')
                        ->where('user_id', $user)
                        ->where('project_id', $project)
                        ->select('id')
                        ->get();

                $bag_hour_id;
                $inputed_hours;
                if (DB::table('bag_hours')->where('project_id', $project)->select('id')->exists()) {
                    $bag_hour_id = DB::table('bag_hours')->where('project_id', $project)->select('id')->get()[0]->id;
                    $inputed_hours = $request->inputed_hours[$inputed_hours_index];
                    $inputed_hours_index++;
                } else {
                    $bag_hour_id = NULL;
                    $inputed_hours = $request->hours[$i];
                }

                DB::table('hours_entry')->insert([
                    'user_project_id' => $user_project_id[0]->id,
                    'bag_hours_id' => $bag_hour_id,
                    'day' => $day,
                    'hours' => $hours,
                    'hours_imputed' => $inputed_hours,
                    'description' => $description,
                    'validate' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $lang = setGetLang();

            return view('entry_hours_worker.success', compact('lang'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function show(EntryHours $entryHours) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function edit(EntryHours $entryHours) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EntryHours $entryHours) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntryHours $entryHours) {
        //
    }

}
