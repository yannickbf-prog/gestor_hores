<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Customer;
use App\Models\UsersProject;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\EditProjectRequest;
use Illuminate\Support\Facades\App;
use DB;

class ProjectController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $lang = setGetLang();

        if ($request->has('_token')) {

            ($request['name'] == "") ? session(['project_name' => '%']) : session(['project_name' => $request['name']]);

            ($request['customer_name'] == "") ? session(['project_customer_name' => '%']) : session(['project_customer_name' => $request['customer_name']]);

            session(['project_state' => $request['state']]);

            session(['project_order' => $request['order']]);

            session(['project_num_records' => $request['num_records']]);
        }

        $dates = getIntervalDates($request, 'project');
        $date_from = $dates[0];
        $date_to = $dates[1];

        $name = session('project_name', "%");
        $customer_name = session('project_customer_name', "%");
        $state = session('project_state', '%');

        $order = session('project_order', "desc");

        $num_records = session('project_num_records', 10);

        if ($num_records == 'all') {
            $num_records = Customer::count();
        }

        //config()->set('database.connections.mysql.strict', false);

        $data = DB::table('hours_entry')
                ->join('users_projects', 'users_projects.id', '=', 'hours_entry.user_project_id')
                ->join('projects', 'projects.id', '=', 'users_projects.project_id')
                ->join('customers', 'customers.id', '=', 'projects.customer_id')
                ->leftJoin('bag_hours', 'bag_hours.project_id', '=', 'projects.id')
                ->select('projects.name as project_name', DB::raw('SUM(hours_entry.hours_imputed) as total_hours_project'), 'bag_hours.contracted_hours',
                        'customers.name as customer_name', 'projects.active as project_active', 'projects.description as project_description', 'projects.created_at',
                        'projects.id as id')
                ->groupBy('projects.id')->where('projects.name', 'like', "%" . $name . "%")
                ->where('customers.name', 'like', "%" . $customer_name . "%")
                ->where('projects.active', 'like', $state)
                ->whereBetween('projects.created_at', [$date_from, $date_to])
                ->orderBy('created_at', $order)
                ->paginate($num_records);

        //Filter code

        //Users json

        $users = DB::table('users')
                ->whereExists(function ($query) {

                    $query->select("users_projects.id")
                    ->from('users_projects')
                    ->whereRaw('users_projects.user_id = users.id');
                })
                ->select("users.name", "users.surname", "users.id")
                ->get();
                
        $users_json = [];
        
        foreach ($users as $user) {
            $customers_in_user = DB::table('users_projects')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')->distinct()
                    ->where('users_projects.user_id', $user->id)
                    ->where('projects.active', 1)
                    ->select('customers.id AS customer_id')
                    ->get();
            
            $users_json[] = [
                'id' => $user->id,
                'name' => $user->name,
                'customers_id' => $customers_in_user
            ];
        }
        
        //Customers json

        $customers = DB::table('customers')->select('id', 'name')->get();

        //Projects json
        $projects = DB::table('projects')
                ->select('projects.id', 'projects.name', 'projects.customer_id', 'projects.active')
                ->get();

        $projects_json = [];

        foreach ($projects as $project) {

            $users = DB::table('users_projects')
                    ->select('user_id')
                    ->where('project_id', '=', $project->id)
                    ->get();

            $projects_json[] = [
                'id' => $project->id,
                'name' => $project->name,
                'customer_id' => $project->customer_id,
                'active' => $project->active,
                'users' => $users
            ];
        }

        $filter_jsons = [
            'users_json' => $users_json,
            'customers' => $customers,
            'projects_json' => $projects_json,
        ];

        return view('projects.index', compact('data'))->with($filter_jsons)
                        ->with('i', (request()->input('page', 1) - 1) * $num_records)->with('lang', $lang);
    }

    public function deleteFilters(Request $request) {

        session(['project_name' => '%']);
        session(['project_customer_name' => '%']);
        session(['project_state' => '%']);
        session(['project_date_from' => ""]);
        session(['project_date_to' => ""]);
        session(['project_order' => 'desc']);
        session(['project_num_records' => 10]);

        $lang = $request->lang;

        return redirect()->route($lang . '_projects.index');
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
    public function store(CreateProjectRequest $request, $lang) {

        App::setLocale($lang);

        Project::create($request->validated());

        return redirect()->route($lang . '_projects.index')
                        ->with('success', __('message.project') . " " . $request->name . " " . __('message.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        $lang = setGetLang();

        $customers = Customer::select("id", "name")->get();

        return view('projects.edit', compact('project', 'lang', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(EditProjectRequest $request, Project $project, $lang) {

        $project->update($request->validated());

        return redirect()->route($lang . '_projects.index')
                        ->with('success', __('message.project') . " " . $request->name . " " . __('message.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, $lang) {

        App::setLocale($lang);

        $project->delete();

        return redirect()->route($lang . '_projects.index')
                        ->with('success', __('message.project') . " " . __('message.deleted'));
    }

    public function addRemoveUsers(Project $project) {

        $lang = setGetLang();

        $customer = Customer::select("name")->where('id', $project['customer_id'])->first();

        $users_in_project = DB::table('users_projects')
                ->join('users', 'users_projects.user_id', '=', 'users.id')
                ->where('users_projects.project_id', $project['id'])
                ->select('users.id AS id', 'users.nickname AS nickname', 'users.role AS role', 'users.name AS name', 'users.surname AS surname', 'users.email AS email', 'users.phone AS phone')
                ->get();

        $users_not_id_array = [];

        foreach ($users_in_project as $user) {
            array_push($users_not_id_array, $user->id);
        }

        $users_not_in_project = DB::table('users')
                ->select('id AS id', 'nickname AS nickname', 'role AS role', 'name AS name', 'surname AS surname', 'email AS email', 'phone AS phone')
                ->whereNotIn('id', $users_not_id_array)
                ->get();


        return view('projects.add_remove', compact('project', 'lang', 'customer', 'users_in_project', 'users_not_in_project'));
    }

    public function removeUser(Request $request, $project_id, $lang) {

        DB::table('users_projects')
                ->where('users_projects.user_id', $request->user_id)
                ->where('users_projects.project_id', $project_id)
                ->delete();

        return redirect()->route($lang . '_projects.add_remove_users', $project_id)
                        ->with('success', __('message.user') . " " . $request->user_id . " " . __('message.unseted'));
    }

    public function addUser(Request $request, $project_id, $lang) {

        $request_explode = explode('|', $request->user);

        UsersProject::create([
            'user_id' => $request_explode[0],
            'project_id' => $project_id,
        ]);

        return redirect()->route($lang . '_projects.add_remove_users', $project_id)
                        ->with('success', __('message.user') . " " . $request_explode[1] . " " . __('message.added'));
    }

}
