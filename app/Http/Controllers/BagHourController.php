<?php

namespace App\Http\Controllers;

use App\Models\BagHour;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\CreateBagHourRequest;
use Illuminate\Support\Facades\App;

class BagHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = setGetLang();
        
        $bag_hour_to_edit = null;
        
        $show_create_edit = false;
        
        if ($request->has('_token') && $request->has('contracted_hours')) {
            
            $show_create_edit = true;
            
        }
        
        if ($request->has('_token') && $request->has('type')) {
            ($request['type'] == "") ? session(['bag_hour_type' => '%']) : session(['bag_hour_type' => $request['type']]);
            ($request['project'] == "") ? session(['bag_hour_project' => '%']) : session(['bag_hour_project' => $request['project']]);
            ($request['contracted_hours'] == "") ? session(['bag_hour_contracted_hours' => '%']) : session(['bag_hour_contracted_hours' => $request['contracted_hours']]);
            
            ($request['hour_price'] == "") ? session(['bag_hour_hour_price' => '%']) : session(['bag_hour_hour_price' => str_replace(",", ".", $request['hour_price'])]);        
            ($request['total_price'] == "") ? session(['bag_hour_total_price' => '%']) : session(['bag_hour_total_price' => str_replace(",", ".", $request['total_price'])]);        
        
            session(['bag_hour_order' => $request['order']]);
            session(['bag_hour_num_records' => $request['num_records']]);
        }
        
        $dates = getIntervalDates($request, 'bag_hour');
        
        $type = session('bag_hour_type', "%");
        $project = session('bag_hour_project', "%");
        $contracted_hours = session('bag_hour_contracted_hours', "%");
        
        
        $hour_price = session('bag_hour_hour_price', "%");
        
        if($hour_price != "%"){
            $hour_price = number_format($hour_price, 2, '.', '');
        }
        
        $total_price = session('bag_hour_total_price', "%");
        
        if($total_price != "%"){
            $total_price = number_format($total_price, 2, '.', '');
        }
        
        $order = session('bag_hour_order', "desc");
        $num_records = session('bag_hour_num_records', 10);
        
        if($num_records == 'all'){
            $num_records = BagHour::count();
        }
        
        $data = BagHour::join('projects', 'bag_hours.project_id', '=', 'projects.id')
            ->join('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
            ->join('customers', 'projects.customer_id', '=', 'customers.id')
            ->select('bag_hours.*', 'projects.id AS project_id', 'projects.name AS project_name', 'type_bag_hours.id AS type_id', 'type_bag_hours.name AS type_name', 'type_bag_hours.hour_price AS type_hour_price', 'customers.name as customer_name')
            ->where('type_bag_hours.name', 'like', "%".$type."%")
            ->where('projects.name', 'like', "%".$project."%")
            ->where('contracted_hours', 'like', $contracted_hours)
            ->where('hour_price', 'like', $hour_price)
            ->where('total_price', 'like', $total_price)
            ->whereBetween('bag_hours.created_at', $dates)
            ->orderBy('created_at', $order)
            ->paginate($num_records);
        
        foreach ($data as $bag_hour) {
            
            $users_projects_ids = DB::table('users_projects')
                    ->select('users_projects.id')
                    ->where('users_projects.project_id', '=', $bag_hour->project_id)
                    ->get();
            
            $users_projects_ids_array = [];
            
            foreach ($users_projects_ids as $user_project) {
                array_push($users_projects_ids_array, $user_project->id);
            }

            $hours_imputed_project = DB::table('hours_entry')
                    ->select('hours_imputed')
                    ->whereIn('user_project_id', $users_projects_ids_array)
                    ->sum('hours_imputed');
            
            $bag_hour->total_hours_project = $hours_imputed_project;
        }
        
        //For create / edit
        $bags_hours_types = DB::table('type_bag_hours')->select("id", "name", "hour_price")->get();
        $projects = DB::table('projects')->select("id", "name")->get();
        
        return view('bag_hours.index', compact(['data' ,'bag_hour_to_edit', 'bags_hours_types', 'projects', 'show_create_edit']))
                        ->with('i', (request()->input('page', 1) - 1) * $num_records)->with('lang', $lang);
    }
    
    public function deleteFilters(Request $request) {
        
        session(['bag_hour_type' => '%']);
        session(['bag_hour_type_project' => '%']);
        session(['bag_hour_contracted_hours' => '%']);
        session(['bag_hour_hour_price' => "%"]);
        session(['bag_hour_total_price' => "%"]);
        session(['bag_hour_date_from' => ""]);
        session(['bag_hour_date_to' => ""]);
        session(['bag_hour_order' => 'desc']);
        session(['bag_hour_num_records' => 10]);
        
        $lang = $request->lang;

        return redirect()->route($lang.'_projects.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = setGetLang();
        
        $bags_hours_types = DB::table('type_bag_hours')->select("id", "name", "hour_price")->get();
        $projects = DB::table('projects')->select("id", "name")->get();
        
        return view('bag_hours.create', compact(['lang','bags_hours_types','projects']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBagHourRequest $request, $lang)
    {
        App::setLocale($lang);
        
        $request->validated();

        //BagHour::create($request->validated());
        
        DB::table('bag_hours')->insert([
            'project_id' => $request->get("project_id"),
            'type_id' => $request->get("type_id"),
            'contracted_hours' => $request->get("contracted_hours"),
            'total_price' => $request->get("total_price"),
            'created_at' => now(),
            'updated_at' => now(),
            
        ]);

        return redirect()->route($lang.'_bag_hours.index')
                        ->with('success', __('message.bag_of_hours')." ".__('message.created_f'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function show(BagHour $bagHour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function edit(BagHour $bagHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BagHour $bagHour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BagHour  $bagHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(BagHour $bagHour)
    {
        //
    }
}
