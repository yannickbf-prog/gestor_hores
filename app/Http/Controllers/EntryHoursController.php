<?php

namespace App\Http\Controllers;

use App\Models\EntryHours;
use App\Models\HourEntry;
use App\Models\UsersProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Requests\CreateHourEntryRequestUser;
use App\Http\Requests\EditUserHourEntryRequest;

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
        
        $values_before_edit_json = null;
        
        $show_create_edit = false;
        $show_filters = false;
        
        if ($request->has('_token') && $request->has('entry_hour_id')) {
            $show_create_edit = true;
            $hour_entry = HourEntry::find($request['entry_hour_id']);

            $day = $hour_entry->day;
            $hours = $hour_entry->hours;
            $hours_imputed = $hour_entry->hours_imputed;
            $description = $hour_entry->description;
            
            $user_project_id = $hour_entry->user_project_id;

            $project_id = UsersProject::find($user_project_id)->project_id;

            $customer_id = Project::find($project_id)->customer_id;
            
            $values_before_edit_json = [
                'hour_entry_id' => $request['entry_hour_id'],
                'day' => \Carbon\Carbon::parse($day)->format('d/m/Y'),
                'hours' => $hours,
                'hours_imputed' => $hours_imputed,
                'description' => $description,
                'user_project_id' => $user_project_id,
                'project_id' => $project_id,
                'customer_id' => $customer_id,
            ];
        }
        
        if ($request->has('_token') && $request->has('select_filter_customer')) {
            $show_filters = true;
            session(['entry_hour_project' => $request['select_filter_projects']]);
        }
        
        $project_id = "%";
        
        if($request->session()->has('entry_hour_project'))
        $project_id = session('entry_hour_project');
        
        $pagination = session('hour_entry_worker_num_records', 10);
        
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

        //Data to create table

        $data = UsersProject::join('users', 'users_projects.user_id', '=', 'users.id')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->join('hours_entry', 'users_projects.id', '=', 'hours_entry.user_project_id')
                ->leftJoin('bag_hours', 'hours_entry.bag_hours_id', '=', 'bag_hours.id')
                ->leftJoin('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
                ->where('users.id', $user_id)
                ->select('projects.name AS project_name', 'customers.name AS customer_name',
                        'type_bag_hours.name AS type_bag_hour_name', 'hours_entry.bag_hours_id AS hours_entry_bag_hours_id', 'hours_entry.hours AS hour_entry_hours', 'hours_entry.hours_imputed AS hour_entry_hours_imputed', 'hours_entry.validate AS hour_entry_validate',
                        'hours_entry.created_at AS hour_entry_created_at', 'bag_hours.id AS bag_hour_id', 'hours_entry.id AS hours_entry_id',
                        'hours_entry.day AS hours_entry_day')
                ->where('projects.id', 'like', $project_id)
                ->orderBy('hours_entry.created_at', 'desc');
                

        if($pagination == 'all'){
            $pagination = $data->count();
        }
        
        $data = $data->paginate($pagination);

        //Create json with the info of DB, need for select projects of customer and user
        $users_projects_with_customer = [];
        $users_data = DB::table('users_projects')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->where('users_projects.user_id', $user_id)
                ->select('projects.id AS project_id', 'projects.name AS project_name', 'customers.id AS customer_id', 'customers.name AS customer_name')
                ->get();

        foreach ($users_data as $project) {
            $users_projects_with_customer[] = [
                'project_id' => $project->project_id,
                'project_name' => $project->project_name,
                'customer_id' => $project->customer_id,
                'customer_name' => $project->customer_name,                
            ];
        }
        
        $user_name = Auth::user()->getUserName();
        $user_surname = Auth::user()->getUserSurname();
        
        return view('entry_hours_worker.index', compact(['lang', 'json_data', 'old_data', 'last_customer_and_project', 'data', 'user_customers_data', 'user_id', 'users_projects_with_customer', 'values_before_edit_json', 'user_name', 'user_surname', 'show_create_edit', 'show_filters']));
    }
    
    public function deleteFilters($lang) {
        
        session(['entry_hour_project' => "%"]);

        return redirect()->route($lang.'_entry_hours.index');

    }
    
    public function changeNumRecords(Request $request, $lang) {
        
        session(['hour_entry_worker_num_records' => $request['num_records']]);
        
        return redirect()->route($lang.'_entry_hours.index');
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
    public function store(CreateHourEntryRequestUser $request, $lang) {

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
                $validate;
                if (DB::table('bag_hours')->where('project_id', $project)->select('id')->exists()) {
                    $bag_hour_id = DB::table('bag_hours')->where('project_id', $project)->select('id')->get()[0]->id;
                    $inputed_hours = $request->inputed_hours[$inputed_hours_index];
                    $inputed_hours_index++;
                    $validate = 0;
                } else {
                    $bag_hour_id = NULL;
                    $inputed_hours = $request->hours[$i];
                    $validate = 1;
                }

                DB::table('hours_entry')->insert([
                    'user_project_id' => $user_project_id[0]->id,
                    'bag_hours_id' => $bag_hour_id,
                    'day' => $day,
                    'hours' => $hours,
                    'hours_imputed' => $inputed_hours,
                    'description' => $description,
                    'validate' => $validate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->route($lang . '_entry_hours.index')
                            ->with('success', __('message.time_entry') . " " . __('message.created'));
        }
    }
    
    function cancelEdit($lang) {
        return redirect()->route($lang . '_time_entries.index');
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
    public function update(EditUserHourEntryRequest $request, EntryHours $entryHours, $lang) {
        
        if ($request->validated()) {
            
            $user_id = Auth::user()->getUserId();

            $user_project_id = DB::table('users_projects')
                    ->where('user_id', $user_id)
                    ->where('project_id', $request->projects[0])
                    ->select('id')
                    ->first();
            
            $inputed_hours = $request->hours[0];
            
            if(isset($request->inputed_hours[0])){
                $inputed_hours = $request->inputed_hours[0];
            }

            DB::table('hours_entry')
                    ->where('id', $entryHours->id)
                    ->update([
                        'user_project_id' => $user_project_id->id,
                        'day' => Carbon::createFromFormat('d/m/Y', $request->days[0])->format('Y-m-d'),
                        'hours' => $request->hours[0],
                        'description' => $request->desc[0],
                        'hours_imputed' => $inputed_hours
                    ]);


            return redirect()->route($lang . '_entry_hours.index')
                            ->with('success', __('message.time_entry') . " " . $request->name . " " . __('message.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntryHours  $entryHours
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntryHours $entryHours, $lang) {
        
        App::setLocale($lang);

        $entryHours->delete();

        return redirect()->route($lang . '_entry_hours.index')
                        ->with('success', __('message.hour_entry') . " " . __('message.deleted'));
    }

}
