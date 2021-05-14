<?php

namespace App\Http\Controllers;

use App\Models\EntryHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;
use DB;

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
    public function index(Request $request)
    {
        $lang = setGetLang();
        
        $user_id = Auth::user()->getUserId();
        
        $data = DB::table('users_projects')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->where('users_projects.user_id', $user_id)
                ->select('projects.id AS project_id', 'projects.name AS project_name', 'customers.name AS customer_name')
                ->get();
        
        if ($request->has('_token')) {
            echo "<script>";
            echo "alert('hello');";
            echo "</script>";
        }
        
        return view('entry_hours_worker.index', compact(['lang', 'data']));
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
