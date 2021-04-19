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
        $currentRoute = $request->currentRoute;
        $langToDisplay = $request->langToDisplay;
        $newRoute = $langToDisplay.substr($currentRoute, 2);
        $customer = $request->customer;
        
        if ($request->customer == "nocustomer"){   
            return redirect()->route($newRoute);
        }
        else{
            return redirect()->route($newRoute, $customer);
        }
       
        return $request->langToDisplay." ".$request->currentRoute." ".$request->route()->getName();
    }
}