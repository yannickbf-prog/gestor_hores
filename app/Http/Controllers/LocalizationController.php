<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    public function index()
    {
        return view('language');
    }
    
    public function lang_change(Request $request)
    {
       
        return $request->lang." ".$request->urltoredirect." ".$request->route()->getName();
    }
}