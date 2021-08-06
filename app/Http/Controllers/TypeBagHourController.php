<?php

namespace App\Http\Controllers;

use App\Models\TypeBagHour;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTypeBagHourRequest;
use App\Http\Requests\EditTypeBagHourRequest;
use Illuminate\Support\Facades\App;
use DB;

class TypeBagHourController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        $lang = setGetLang();
        
        $type_bag_hour_to_edit = null;
        
        $show_filters = false;
        $show_create_edit = false;
        
//        if ($request->has('_token') && $request->has('edit_bag_hour_id')) {
//            $type_bag_hour_to_edit = BagHour::where('id', $request['edit_bag_hour_id'])->first();
//            $show_create_edit = true;
//        }
        
        //edit_bag_hour_type_id
        
        if ($request->has('_token') && $request->has('edit_bag_hour_type_id')) {
            $type_bag_hour_to_edit = TypeBagHour::where('id', $request['edit_bag_hour_type_id'])->first();
            $show_create_edit = true;
        }
        
        if($request->has('_token')  && $request->has('name_id')){
            
            ($request['name'] == "") ? session(['type_bag_hour_name' => '%']) : session(['type_bag_hour_name' => $request['name']]);
            
            ($request['hour_price'] == "") ? session(['type_bag_hour_price' => '%']) : session(['type_bag_hour_price' => str_replace(",", ".", $request['hour_price'])]);
            
            session(['type_bag_hour_order' => $request['order']]);
            
            session(['type_bag_hour_num_records' => $request['num_records']]);
        }
        
        $dates = getIntervalDates($request, 'type_bag_hour');
        $date_from = $dates[0];
        $date_to = $dates[1];
                
        $name = session('type_bag_hour_name', "%");
        $hour_price = session('type_bag_hour_price', "%");
//        
        if($hour_price != "%"){
            $hour_price = number_format($hour_price, 2, '.', '');
        }
        
        $order = session('type_bag_hour_order', "asc");
        
        $num_records = session('type_bag_hour_num_records', 10);
        
        if($num_records == 'all'){
            $num_records = TypeBagHour::count();
        }
        
        $data = TypeBagHour::leftJoin('bag_hours', 'type_bag_hours.id', '=', 'bag_hours.type_id')
                ->select('type_bag_hours.id', 'type_bag_hours.name', 'type_bag_hours.description', 'type_bag_hours.hour_price', 
                        'type_bag_hours.created_at', DB::raw('SUM(bag_hours.contracted_hours) as total_hours_bag_type'), 
                        DB::raw('SUM(bag_hours.total_price) as total_price_bag_type'))
                ->where('type_bag_hours.name', 'like', "%{$name}%")
                ->where('type_bag_hours.hour_price', 'like', $hour_price)
                ->whereBetween('type_bag_hours.created_at', [$date_from, $date_to])
                ->orderBy('type_bag_hours.created_at', $order)
                ->groupBy('type_bag_hours.id')
                ->paginate();
               

        return view('type_bag_hours.index', compact(['data', 'lang', 'show_create_edit', 'show_filters', 'type_bag_hour_to_edit']))
                        ->with('i', (request()->input('page', 1) - 1) * $num_records);
    }
    
    public function deleteFilters(Request $request) {
        
        session(['type_bag_hour_name' => '%']);
        session(['type_bag_hour_price' => '%']);
        session(['type_bag_hour_date_from' => ""]);
        session(['type_bag_hour_date_to' => ""]);
        session(['type_bag_hour_order' => 'asc']);
        session(['type_bag_hour_num_records' => 10]);

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
