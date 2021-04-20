<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeContoller extends Controller
{
    public function index()
    {
        $lang = setGetLang();
        
        return view('home', compact('lang'));
    }
}
