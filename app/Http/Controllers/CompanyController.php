<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EditCompanyRequest;
use File;
use App;

class CompanyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $lang = setGetLang();

        $company = DB::table('company')->first();

        $data_counts = [
            'customers_count' => DB::table('customers')->count(),
            'types_hour_bags_count' => DB::table('type_bag_hours')->count()
        ];

        return view('company_info.index', compact(['company', 'lang']))->with($data_counts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit() {

        $lang = setGetLang();

        $company = DB::table('company')->first();

        return view('company_info.edit', compact('company'), compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(EditCompanyRequest $request, $lang) {
        $company = DB::table('company')->where('id', 1);
        
        if ($request->img_logo == "") {
            $company->update($request->validated(), ['except' => ['img_logo'] ]);
        }
        else{
            
            if(File::exists(public_path("/storage/".$company->value('img_logo')))){
                File::delete(public_path("/storage/".$company->value('img_logo')));
            }
            
            $imageName = 'logo.' . $request->img_logo->extension();
            $request->img_logo->storeAs('public', $imageName);
            
          
            DB::transaction(function() use ($request, $company, $imageName) {
                $company->update($request->validated());

                $company->update(['img_logo' => $imageName]);
            });
        }
        

        return redirect()->route($lang . '_company_info.index')
                        ->with('success', __('message.company') . " " . $request->name . " " . __('message.updated_f'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company) {
        //
    }
    
    public function destroyLogo($lang) {
        App::setLocale($lang);
        
        $company = DB::table('company')->where('id', 1);
        
        if(File::exists(public_path("/storage/".$company->value('img_logo')))){
            File::delete(public_path("/storage/".$company->value('img_logo')));
        }
        
        $company->update(['img_logo' => null]);
        
        return redirect()->route($lang.'_company_info.index')
                        ->with('success', __('message.logo') . " " . __('message.deleted'));
    }

}
