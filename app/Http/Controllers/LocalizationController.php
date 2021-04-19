<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    
    public function lang_change(Request $request)
    {
        $currentRoute = $request->currentRoute;
        $langToDisplay = $request->langToDisplay;
        $newRoute = $langToDisplay.substr($currentRoute, 2);
        $id = $request->id;
        
        if ($id == "noid"){   
            return redirect()->route($newRoute);
        }
        else{
            return redirect()->route($newRoute, $id);
        }
       
    }
}