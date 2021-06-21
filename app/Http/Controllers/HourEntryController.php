<?php

namespace App\Http\Controllers;

use App\Models\HourEntry;
use App\Models\UsersProject;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\CreateHourEntryRequest;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

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

        //Create json with the info of DB, need for selects user, project and bag of hours. This work with JavaScript
        $users_info = [];
        $users_data = DB::table('users_projects')->distinct()->select('user_id')->get();
        
          /*
          //Create json to storage users with projects, there customers and there projects
          $json = [];
          $users_data = DB::table('users_projects')
          ->join('users', 'users_projects.user_id', '=', 'users.id')->distinct()
          ->select(['users.id', 'users.nickname', 'users.name', 'users.surname', 'users.email', 'users.phone', 'users.role'])->get();

          foreach ($users_data as $user) {

          //Get the customers of the users (users with projects)
          $customers_in_user_data = DB::table('users_projects')
          ->join('projects', 'users_projects.id', '=', 'projects.id')
          ->join('customers', 'projects.customer_id', '=', 'customers.id')->distinct()
          ->where('users_projects.user_id', $user->id)
          ->select('customers.id AS customer_id', 'customers.name AS customer_name')
          ->get();

          $json[] = [
          'user_id' => $user->id,
          'user_nickname' => $user->nickname,
          'user_name' => $user->name,
          'user_surname' => $user->surname,
          'user_email' => $user->email,
          'user_phone' => $user->phone,
          'user_role' => $user->role,
          'customers' => $customers_in_user_data,
          ];
          }

          //        $results=DB::select(DB::raw("
          //            select * from users_projects
          //                INNER JOIN projects
          //            ON `users_projects`.`project_id` = `projects`.`id`
          //                WHERE `users_projects`.`user_id`=3"));

          $customers_in_user_data = DB::table('users')
          ->join('users_projects', 'users.id', '=', 'users_projects.user_id')
          ->join('projects', 'users_projects.project_id', '=', 'projects.id')
          ->join('customers', 'projects.customer_id', '=', 'customers.id')->distinct()
          ->select('customers.name')
          ->where('users.id', '=', 2)
          ->get();

          return $customers_in_user_data; */



        foreach ($users_data as $user) {

            $user_id = $user->user_id;
            $projects_users_data = DB::table('users_projects')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')
                    ->where('users_projects.user_id', $user_id)
                    ->where('projects.active', 1)
                    ->select('projects.id AS project_id', 'projects.name AS project_name', 'customers.id AS customer_id', 'customers.name AS customer_name')
                    ->get();

            $users_projects = [];
            foreach ($projects_users_data as $project_in_user) {

                $bag_hour;

                if (DB::table('bag_hours')->where('project_id', $project_in_user->project_id)->exists()) {
                    $bag_hour = true;
                } else {
                    $bag_hour = false;
                }

                $users_projects[] = [
                    'project_id' => $project_in_user->project_id,
                    'project_name' => $project_in_user->project_name,
                    'customer_id' => $project_in_user->customer_id,
                    'customer_name' => $project_in_user->customer_name,
                    'bag_hour' => $bag_hour,
                ];
            }

            $users_info[] = [
                'user_id' => $user->user_id,
                'user_projects' => $users_projects
            ];
        }


        //Create the JSON of the relation of users and customers
        $users_customers = [];
        $users_with_projects = DB::table('users')
                        ->join('users_projects', 'users.id', '=', 'users_projects.user_id')
                        ->distinct()->get(['users.id', 'users.nickname', 'users.name', 'users.surname', 'users.email', 'users.phone', 'users.role']);

        foreach ($users_with_projects as $user) {

//            $users_customers_data = DB::table('users_projects')
//                    ->join('projects', 'users_projects.id', '=', 'projects.id')
//                    ->join('customers', 'projects.customer_id', '=', 'customers.id')->distinct()
//                    ->where('users_projects.user_id', $user->id)
//                    ->select('customers.id AS customer_id', 'customers.name AS customer_name')
//                    ->get();
            
            $users_customers_data = DB::table('users')
                    ->join('users_projects', 'users.id', '=', 'users_projects.user_id')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')->distinct()
                    ->select('customers.id AS customer_id', 'customers.name AS customer_name')
                    ->where('users.id', '=', $user->id)
                    ->get();

            $users_customers[] = [
                'user_id' => $user->id,
                'user_nickname' => $user->nickname,
                'user_name' => $user->name,
                'user_surname' => $user->surname,
                'user_email' => $user->email,
                'user_phone' => $user->phone,
                'user_role' => $user->role,
                'customers' => $users_customers_data,
            ];
        }

        return view('entry_hours.index', compact(['lang', 'data', 'users_data', 'users_info', 'users_customers']))
                        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function getBDInfo() {
        $data = UsersProject::join('users', 'users_projects.user_id', '=', 'users.id')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->join('hours_entry', 'users_projects.id', '=', 'hours_entry.user_project_id')
                ->leftJoin('bag_hours', 'hours_entry.bag_hours_id', '=', 'bag_hours.id')
                ->leftJoin('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
                ->select('users.nickname AS user_nickname', 'users.name AS user_name', 'users.surname AS user_surname', 'projects.name AS project_name', 'customers.name AS customer_name',
                'type_bag_hours.name AS type_bag_hour_name', 'hours_entry.bag_hours_id AS hours_entry_bag_hours_id', 'hours_entry.hours AS hour_entry_hours', 'hours_entry.hours AS hour_entry_hours_imputed', 'hours_entry.validate AS hour_entry_validate',
                'hours_entry.created_at AS hour_entry_created_at', 'bag_hours.id AS bag_hour_id', 'hours_entry.id AS hours_entry_id', 
                'hours_entry.day AS hours_entry_day');

        return $data;
    }

    public function validateEntryHour($hours_entry_id, $lang) {
        
        DB::statement("UPDATE hours_entry SET validate = 1 where id = ".$hours_entry_id);
        
//        DB::table('hours_entry')
//                ->where('hours_entry.id', $hour_entry_id)
//                ->update(['validate' => 1]);

        return redirect()->route($lang . '_time_entries.index')
                ->with('success', __('message.time_entry') . " " . __('message.validated'));
    }

    public function inValidateEntryHour($hours_entry_id, $lang) {
        
        DB::statement("UPDATE hours_entry SET validate = 0 where id = ".$hours_entry_id);

//        DB::table('hours_entry')
//                ->where('hours_entry.id', $id)
//                ->update(['validate' => 0]);

        return redirect()->route($lang . '_time_entries.index')
                ->with('success', __('message.time_entry') . " " . __('message.invalidated'));
    }
    
    public function validateAllHours($lang){
        
        $entries_to_validate = HourEntryController::getBDInfo()->validated()->update(['validate' => 1]);
        
        return redirect()->route($lang . '_time_entries.index')
                ->with('success', __('message.time_entries') . " " . __('message.validated'));
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
        $users_data = DB::table('users_projects')->distinct()->select('user_id')->get();

        foreach ($users_data as $user) {

            $user_id = $user->user_id;
            $projects_users_data = DB::table('users_projects')
                    ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')
                    ->where('users_projects.user_id', $user_id)
                    ->where('projects.active', 1)
                    ->select('projects.id AS project_id', 'projects.name AS project_name', 'customers.id AS customer_id', 'customers.name AS customer_name')
                    ->get();

            $users_projects = [];
            foreach ($projects_users_data as $project_in_user) {

                $bag_hour;

                if (DB::table('bag_hours')->where('project_id', $project_in_user->project_id)->exists()) {
                    $bag_hour = true;
                } else {
                    $bag_hour = false;
                }

                $users_projects[] = [
                    'project_id' => $project_in_user->project_id,
                    'project_name' => $project_in_user->project_name,
                    'customer_id' => $project_in_user->customer_id,
                    'customer_name' => $project_in_user->customer_name,
                    'bag_hour' => $bag_hour,
                ];
            }

            $users_info[] = [
                'user_id' => $user->user_id,
                'user_projects' => $users_projects
            ];
        }


        //Create the JSON of the relation of users and customers
        $users_customers = [];
        $users_with_projects = DB::table('users')
                        ->join('users_projects', 'users.id', '=', 'users_projects.user_id')
                        ->distinct()->get(['users.id', 'users.nickname', 'users.name', 'users.surname', 'users.email', 'users.phone', 'users.role']);

        foreach ($users_with_projects as $user) {

            $users_customers_data = DB::table('users_projects')
                    ->join('projects', 'users_projects.id', '=', 'projects.id')
                    ->join('customers', 'projects.customer_id', '=', 'customers.id')->distinct()
                    ->where('users_projects.user_id', $user->id)
                    ->select('customers.id AS customer_id', 'customers.name AS customer_name')
                    ->get();

            $users_customers[] = [
                'user_id' => $user->id,
                'user_nickname' => $user->nickname,
                'user_name' => $user->name,
                'user_surname' => $user->surname,
                'user_email' => $user->email,
                'user_phone' => $user->phone,
                'user_role' => $user->role,
                'customers' => $users_customers_data,
            ];
        }

        return view('entry_hours.create', compact(['lang', 'users_data', 'users_info', 'users_customers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHourEntryRequest $request, $lang) {
        
        $count_hours_entries = count($request->days);
        
        session(['count_hours_entries' => $count_hours_entries]);

        App::setLocale($lang);

        $request->validated();

        $inputed_hours_index = 0;

        for ($i = 0; $i < $count_hours_entries; $i++) {
            $day = Carbon::createFromFormat('d/m/Y', $request->days[$i])->format('Y-m-d');
            $hours = $request->hours[$i];
            $user = $request->users[$i];
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
                'validate' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
       
        return redirect()->route($lang . '_time_entries.index')
                        ->with('success', __('message.time_entry') . " " . __('message.created'));

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
