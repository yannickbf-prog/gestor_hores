<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        
        return view('home', compact('lang'));
    }
}
