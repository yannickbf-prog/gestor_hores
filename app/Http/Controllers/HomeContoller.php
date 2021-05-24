<?php

namespace App\Http\Controllers;
use App\Models\UsersProject;


class HomeContoller extends Controller
{
    public function index()
    {
        $lang = setGetLang();
        
        //Si no agafa el idioma amb setGetLang es que estem entrant per la arrel 
        //(/) del lloc, en aquest cas el idioma es el definit com idioma per defecte a la bd
        if(!isset($lang)){
            $lang = $default_lang;
        }
        
        /*$data = HourEntryController::getBDInfo()
                ->paginate(10);*/
        
//        $data = new HourEntryController();
//        $info_for_table = $data->getBDInfo()->validated()->paginate(10);
        
        $info_for_table = UsersProject::validated()
                ->join('users', 'users_projects.user_id', '=', 'users.id')
                ->join('projects', 'users_projects.project_id', '=', 'projects.id')
                ->join('customers', 'projects.customer_id', '=', 'customers.id')
                ->join('hours_entry', 'users_projects.id', '=', 'hours_entry.user_project_id')
                ->join('bag_hours', 'hours_entry.bag_hours_id', '=', 'bag_hours.id')
                ->join('type_bag_hours', 'bag_hours.type_id', '=', 'type_bag_hours.id')
                ->select('users.nickname AS user_name', 'projects.name AS project_name', 'customers.name AS customer_name',
                'type_bag_hours.name AS type_bag_hour_name', 'hours_entry.hours AS hour_entry_hours', 'hours_entry.validate AS hour_entry_validate',
                'hours_entry.created_at AS hour_entry_created_at', 'bag_hours.id AS bag_hour_id', 'hours_entry.id AS hours_entry_id')
                ->paginate(10);

        return view('home', compact('lang','info_for_table'))
                 ->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
