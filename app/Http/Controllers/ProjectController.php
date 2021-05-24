<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Customer;
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
        
        if($num_records == 'all'){
            $num_records = Customer::count();
        }

        $data = Customer::join('projects', 'projects.customer_id', '=', 'customers.id')
                ->select("customers.name AS customer_name", "projects.*")
                ->where('projects.name', 'like', "%".$name."%")
                ->where('customers.name', 'like', "%".$customer_name."%")
                ->where('projects.active', 'like', $state)
                ->whereBetween('projects.created_at', [$date_from, $date_to])
                ->orderBy('created_at', $order)
                ->paginate($num_records);

        return view('projects.index', compact('data'))
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

        return redirect()->route($lang.'_projects.index');

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
        
        return redirect()->route($lang.'_projects.index')
                        ->with('success', __('message.project')." ".$request->name." ".__('message.created') );
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
        
        return view('projects.edit', compact('project','lang','customers'));
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

        return redirect()->route($lang.'_projects.index')
                        ->with('success', __('message.project')." ".$request->name." ".__('message.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project,$lang) {
        
        App::setLocale($lang);
        
        $project->delete();

        return redirect()->route($lang.'_projects.index')
                        ->with('success', __('message.project')." ".__('message.deleted'));
    }
    
    public function addRemoveUsers(Project $project) {
        
        $lang = setGetLang();
        
        $customer = Customer::select("name")->where('id', $project['customer_id'])->first();
        
        $users_in_project = DB::table('users_projects')
                ->join('users', 'users_projects.user_id', '=', 'users.id')
                ->where('users_projects.project_id', $project['id'])
                ->select('users.id AS id', 'users.nickname AS nickname', 'users.role AS role', 'users.name AS name', 'users.surname AS surname', 'users.email AS email', 'users.phone AS phone')
                ->get();
        
        return view('projects.add_remove', compact('project','lang','customer','users_in_project'));
    }
    
     public function removeUser(Request $request, $project_id, $lang){
        return $request;
    }

}
