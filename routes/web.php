<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TypeBagHourController;
use App\Http\Controllers\HomeContoller;

use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




//Route::get('/', [LocalizationController::class, "index"]);
Route::get('change/lang', [LocalizationController::class, "lang_change"])->name('LangChange');




Route::view("/", "home")->name('home');
Route::view("/company-info", "company-info")->name('company-info');

//Route::resource('customers', CustomerController::class);
Route::resource('type-bag-hours', TypeBagHourController::class);

Route::get("en/control-panel/", [HomeContoller::class, 'index'])->name('en_home.index')->middleware('auth');
Route::get("es/panel-de-control/", [HomeContoller::class, 'index'])->name('es_home.index');
Route::get("ca/panell-de-control/", [HomeContoller::class, 'index'])->name('ca_home.index');

Route::post("control-panel/company-info/lang/{lang}", [CustomerController::class, 'update'])->name('company-info.update');

Route::get("en/control-panel/company-info", [CompanyController::class, 'index'])->name('en_company_info.index');
Route::get("en/control-panel/company-info/edit", [CompanyController::class, 'edit'])->name('en_company_info.edit');

Route::get("es/panel-de-control/informacion-empresa", [CompanyController::class, 'index'])->name('es_company_info.index');
Route::get("es/panel-de-control/informacion-empresa/editar", [CompanyController::class, 'edit'])->name('es_company_info.edit');

Route::get("ca/panell-de-control/informacio-empresa", [CompanyController::class, 'index'])->name('ca_company_info.index');
Route::get("ca/panell-de-control/informacio-empresa/editar", [CompanyController::class, 'edit'])->name('ca_company_info.edit');

Route::post("control-panel/customers/{customer}/lang/{lang}", [CustomerController::class, 'update'])->name('customers.update');
Route::post('control-panel/customers/delete_filters/', [CustomerController::class, 'deleteFilters'])->name('customers.delete_filters');
Route::post("control-panel/customers/lang/{lang}", [CustomerController::class, 'store'])->name('customers.store');
Route::delete("control-panel/customers/{customer}/lang/{lang}", [CustomerController::class, 'destroy'])->name('customers.destroy');

Route::get("en/control-panel/customers", [CustomerController::class, 'index'])->name('en_customers.index');
Route::get("en/control-panel/customers/create", [CustomerController::class, 'create'])->name('en_customers.create');
Route::get("en/control-panel/customers/{customer}/edit", [CustomerController::class, 'edit'])->name('en_customers.edit');

Route::get("es/panel-de-control/clientes", [CustomerController::class, 'index'])->name('es_customers.index');
Route::get("es/panel-de-control/clientes/crear", [CustomerController::class, 'create'])->name('es_customers.create');
Route::get("es/panel-de-control/clientes/{customer}/editar", [CustomerController::class, 'edit'])->name('es_customers.edit');

Route::get("ca/panell-de-control/clients", [CustomerController::class, 'index'])->name('ca_customers.index');
Route::get("ca/panell-de-control/clients/crear", [CustomerController::class, 'create'])->name('ca_customers.create');
Route::get("ca/panell-de-control/clients/{customer}/editar", [CustomerController::class, 'edit'])->name('ca_customers.edit');


Route::get('/', function () {
    $default_lang = DB::table('company')->first()->default_lang;
    if(Auth::check()){
        return redirect()->route($default_lang.'_home.index', $default_lang);
    }
    else{
        return redirect()->route($default_lang.'_login');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

//Route::post("es/clientes/guardar", [CustomerController::class, 'store'])->name('es_customers.store');
//
//
//
////Route::get("/portafolio/crear", "ProjectController@create")->name('projects.create');
//Route::post("/portafolio", "ProjectController@store")->name('projects.store');

//Route::get("es/clientes", [CustomerController::class, 'index'])->name('es_customers.index');
//Route::get("es/clientes/crear", [CustomerController::class, 'create'])->name('es_customers.create');
//Route::post("es/clientes/guardar", [CustomerController::class, 'store'])->name('es_customers.store');


Route::post('type-bag-hours/delete_filters', [TypeBagHourController::class, 'deleteFilters'])->name('type-bag-hours.delete_filters');