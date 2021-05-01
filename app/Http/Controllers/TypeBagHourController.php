<?php

namespace App\Http\Controllers;

use App\Models\TypeBagHour;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTypeBagHourRequest;
use App\Http\Requests\EditTypeBagHourRequest;
use Illuminate\Support\Facades\App;
use DateTime;
use DateTimeZone;

class TypeBagHourController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        $lang = setGetLang();
        
        if($request->has('_token')){
            
            ($request['name'] == "") ? session(['type_bag_hour_name' => '%']) : session(['type_bag_hour_name' => $request['name']]);
            
            ($request['hour_price'] == "") ? session(['type_bag_hour_price' => '%']) : session(['type_bag_hour_price' => str_replace(",", ".", $request['hour_price'])]);
              
            if (DateTime::createFromFormat('d/m/Y', $request['date_from']) !== false) {
                $date = DateTime::createFromFormat('d/m/Y', $request['date_from'])->format('d/m/Y');
                session(['type_bag_hour_date_from' => $date]);
            }
            else{
                session(['type_bag_hour_date_from' => ""]);
            }
            
            if (DateTime::createFromFormat('d/m/Y', $request['date_to']) !== false) {
                $date = DateTime::createFromFormat('d/m/Y', $request['date_to'])->format('d/m/Y');
                session(['type_bag_hour_date_to' => $date]);
            }
            else{
                session(['type_bag_hour_date_to' => ""]);
            }
            
            session(['type_bag_hour_order' => $request['order']]);
        }
        
        
        $name = session('type_bag_hour_name', "%");
        $hour_price = session('type_bag_hour_price', "%");
        $order = session('type_bag_hour_order', "asc");
        
        $date_from = session('type_bag_hour_date_from', "");
        
        if($date_from == ""){
            $date = new DateTime('2021-04-10');
            $date_from = $date->format('Y-m-d');
        }
        else{
            $date_from = DateTime::createFromFormat('d/m/Y', $date_from)->format('Y-m-d');
        }
        
        //echo $date_from;
        
        $date_to = session('type_bag_hour_date_to', "");
        
        if($date_to == ""){
            $date = new DateTime('NOW +1 day', new DateTimeZone('Europe/Madrid'));
            $date_to = $date->format('Y-m-d');
        }
        else{
            $date_to = DateTime::createFromFormat('d/m/Y', $date_to)->modify('+1 day')->format('Y-m-d');
        }
        
        $data = TypeBagHour::
                where('name', 'like', "%{$name}%")
                ->where('hour_price', 'LIKE', $hour_price)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->orderBy('created_at', $order)
                ->paginate(7);
        
      

        return view('type_bag_hours.index', compact('data'), compact('lang'))
                        ->with('i', (request()->input('page', 1) - 1) * 7);
    }
    
    public function deleteFilters(Request $request) {
        
        session(['type_bag_hour_name' => '%']);
        session(['type_bag_hour_price' => '%']);
        session(['type_bag_hour_order' => 'asc']);

        $lang = $request->lang;
        
        return redirect()->route($lang.'_bag_hours_types.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
        $lang = setGetLang();
        
        return view('type_bag_hours.create')->with('lang', $lang);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTypeBagHourRequest $request, $lang) {
        
        App::setLocale($lang);
        
        $request['hour_price'] = str_replace(",", ".", $request['hour_price']);

        TypeBagHour::create($request->validated());

        return redirect()->route($lang.'_bag_hours_types.index')
                        ->with('success', __('message.bag_hour_type')." ".$request->name." ".__('message.created_f'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function show(TypeBagHour $typeBagHour) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeBagHour $typeBagHour) {
        $lang = setGetLang();
        
        return view('type_bag_hours.edit', compact('typeBagHour'), compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function update(EditTypeBagHourRequest $request, TypeBagHour $typeBagHour, $lang) {
        
        App::setLocale($lang);
        
        $request['hour_price'] = str_replace(",", ".", $request['hour_price']);

        $typeBagHour->update($request->validated());

        return redirect()->route($lang.'_bag_hours_types.index')
                        ->with('success', __('message.bag_hour_type')." ".$request->name." ".__('message.updated_f'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeBagHour  $typeBagHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeBagHour $typeBagHour, $lang) {
        
        App::setLocale($lang);
        
        $typeBagHour->delete();

        return redirect()->route($lang.'_bag_hours_types.index')
                        ->with('success', __('message.bag_hour_type')." ".__('message.deleted_f'));
    }

}
