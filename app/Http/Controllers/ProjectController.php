<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;

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
        }
        
        /*$dates = getIntervalDates($request, 'project');
        $date_from = $dates[0];
        $date_to = $dates[1];*/
        
        $name = session('project_name', "%");
        $customer_name = session('project_customer_name', "%");
        $state = session('project_state', '%');

        $data = Customer::join('projects', 'projects.customer_id', '=', 'customers.id')
                ->select("customers.name AS customer_name", "projects.*")
                ->where('projects.name', 'like', "%".$name."%")
                ->where('customers.name', 'like', "%".$customer_name."%")
                ->where('projects.active', 'like', $state)
                //->whereBetween('created_at', [$date_from, $date_to])
                ->paginate(2);

        return view('projects.index', compact('data'))
                        ->with('i', (request()->input('page', 1) - 1) * 2)->with('lang', $lang);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        //
    }

}
