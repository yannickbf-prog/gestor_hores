<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TypeBagHourController;
use App\Http\Controllers\EntryHoursController;

use App\Http\Controllers\LocalizationController;
//use App\Http\Controllers\ImageUploadController;
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




//Route::view("/", "home")->name('home');
//Route::view("/company-info", "company-info")->name('company-info');
//Route::resource('customers', CustomerController::class);
//Route::resource('type-bag-hours', TypeBagHourController::class);

    //Route::get('image-upload', [ ImageUploadController::class, 'imageUpload' ])->name('image.upload');
    //Route::post('image-upload', [ ImageUploadController::class, 'imageUploadPost' ])->name('image.upload.post');

//Routes protected for admin user
Route::group(['middleware' => 'admin'], function () {
    // Control panel home
    Route::get("en/control-panel/", [HomeContoller::class, 'index'])->name('en_home.index');
    Route::get("es/panel-de-control/", [HomeContoller::class, 'index'])->name('es_home.index');
    Route::get("ca/panell-de-control/", [HomeContoller::class, 'index'])->name('ca_home.index');

    // Control panel - Company info - Operations
    Route::get("control-panel/company-info/destroyLogo/lang/{lang}", [CompanyController::class, 'destroyLogo'])->name('company-info.destroy_logo');
    Route::put("control-panel/company-info/lang/{lang}", [CompanyController::class, 'update'])->name('company-info.update');
    // Control panel - Company info en
    Route::get("en/control-panel/company-info", [CompanyController::class, 'index'])->name('en_company_info.index');
    Route::get("en/control-panel/company-info/edit", [CompanyController::class, 'edit'])->name('en_company_info.edit');
    // Control panel - Company info es
    Route::get("es/panel-de-control/informacion-empresa", [CompanyController::class, 'index'])->name('es_company_info.index');
    Route::get("es/panel-de-control/informacion-empresa/editar", [CompanyController::class, 'edit'])->name('es_company_info.edit');
    // Control panel - Company info ca
    Route::get("ca/panell-de-control/informacio-empresa", [CompanyController::class, 'index'])->name('ca_company_info.index');
    Route::get("ca/panell-de-control/informacio-empresa/editar", [CompanyController::class, 'edit'])->name('ca_company_info.edit');

    // Control panel - Users - Operations
    Route::put("control-panel/users/{user}/lang/{lang}", [UserController::class, 'update'])->name('users.update');
    Route::delete("control-panel/users/{user}/lang/{lang}", [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('control-panel/users/delete_filters/', [UserController::class, 'deleteFilters'])->name('users.delete_filters');
    // Control panel - Users - en
    Route::get("en/control-panel/users", [UserController::class, 'index'])->name('en_users.index');
        // Control panel - Users - en/control-panel/userses
    Route::get("es/panel-de-control/usuarios", [UserController::class, 'index'])->name('es_users.index');
    // Control panel - Users - ca
    Route::get("ca/panell-de-control/usuaris", [UserController::class, 'index'])->name('ca_users.index');
    
    
    Route::get("en/control-panel/users/{user}/edit", [UserController::class, 'edit'])->name('en_users.edit');
    Route::get("es/panel-de-control/usuarios/{user}/editar", [UserController::class, 'edit'])->name('es_users.edit');
    Route::get("ca/panell-de-control/usuaris/{user}/editar", [UserController::class, 'edit'])->name('ca_users.edit');
    
    // Control panel - Users - en/control-panel/userses
    Route::get("es/panel-de-control/usuarios", [UserController::class, 'index'])->name('es_users.index');
    // Control panel - Users - ca
    Route::get("ca/panell-de-control/usuaris", [UserController::class, 'index'])->name('ca_users.index');
    
    // Control panel - Customers - Operations
    Route::post("control-panel/customers/lang/{lang}", [CustomerController::class, 'store'])->name('customers.store');
    Route::put("control-panel/customers/{customer}/lang/{lang}", [CustomerController::class, 'update'])->name('customers.update');
    Route::delete("control-panel/customers/{customer}/lang/{lang}", [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('control-panel/customers/delete_filters/', [CustomerController::class, 'deleteFilters'])->name('customers.delete_filters');

    // Control panel - Customers en
    Route::get("en/control-panel/customers", [CustomerController::class, 'index'])->name('en_customers.index');
    Route::get("en/control-panel/customers/create", [CustomerController::class, 'create'])->name('en_customers.create');
    Route::get("en/control-panel/customers/{customer}/edit", [CustomerController::class, 'edit'])->name('en_customers.edit');
    // Control panel - Customers es
    Route::get("es/panel-de-control/clientes", [CustomerController::class, 'index'])->name('es_customers.index');
    Route::get("es/panel-de-control/clientes/crear", [CustomerController::class, 'create'])->name('es_customers.create');
    Route::get("es/panel-de-control/clientes/{customer}/editar", [CustomerController::class, 'edit'])->name('es_customers.edit');
    // Control panel - Customers ca
    Route::get("ca/panell-de-control/clients", [CustomerController::class, 'index'])->name('ca_customers.index');
    Route::get("ca/panell-de-control/clients/crear", [CustomerController::class, 'create'])->name('ca_customers.create');
    Route::get("ca/panell-de-control/clients/{customer}/editar", [CustomerController::class, 'edit'])->name('ca_customers.edit');
    
    //Control panel - Bag hour types - Operations 
    Route::post("control-panel/types-hour-bags/lang/{lang}", [TypeBagHourController::class, 'store'])->name('bag_hours_types.store');
    Route::put("control-panel/types-hour-bags/{typeBagHour}/lang/{lang}", [TypeBagHourController::class, 'update'])->name('bag_hours_types.update');
    Route::delete("control-panel/types-hour-bags/{typeBagHour}/lang/{lang}", [TypeBagHourController::class, 'destroy'])->name('bag_hours_types.destroy');
    Route::post('control-panel/types-hour-bags/delete_filters', [TypeBagHourController::class, 'deleteFilters'])->name('type_bag_hours.delete_filters');

    // Control panel - Customers en
    Route::get("en/control-panel/types-hour-bags", [TypeBagHourController::class, 'index'])->name('en_bag_hours_types.index');
    Route::get("en/control-panel/types-hour-bags/create", [TypeBagHourController::class, 'create'])->name('en_bag_hours_types.create');
    Route::get("en/control-panel/types-hour-bags/{typeBagHour}/edit", [TypeBagHourController::class, 'edit'])->name('en_bag_hours_types.edit');

    // Control panel - Customers es
    Route::get("es/panel-de-control/tipos-bolsas-de-horas", [TypeBagHourController::class, 'index'])->name('es_bag_hours_types.index');
    Route::get("es/panel-de-control/tipos-bolsas-horas/crear", [TypeBagHourController::class, 'create'])->name('es_bag_hours_types.create');
    Route::get("es/panel-de-control/tipos-bolsas-de-horas/{typeBagHour}/editar", [TypeBagHourController::class, 'edit'])->name('es_bag_hours_types.edit');

    // Control panel - Customers ca
    Route::get("ca/panell-de-control/tipus-bosses-hores", [TypeBagHourController::class, 'index'])->name('ca_bag_hours_types.index');
    Route::get("ca/panell-de-control/tipus-bosses-hores/crear", [TypeBagHourController::class, 'create'])->name('ca_bag_hours_types.create');
    Route::get("ca/panell-de-control/tipus-bosses-hores/{typeBagHour}/editar", [TypeBagHourController::class, 'edit'])->name('ca_bag_hours_types.edit');
    
    
});

Route::get("en/entry-hours", [EntryHoursController::class, 'index'])->name('en_entry_hours.index');


Route::get('/', function () {
    $default_lang = DB::table('company')->first()->default_lang;
    if (Auth::check()) {
        return redirect()->route($default_lang . '_home.index', $default_lang);
    } else {
        return redirect()->route($default_lang . '_login');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

//Route::post("es/clientes/guardar", [CustomerController::class, 'store'])->name('es_customers.store');
//
//
//
////Route::get("/portafolio/crear", "ProjectController@create")->name('projects.create');
//Route::post("/portafolio", "ProjectController@store")->name('projects.store');
//Route::get("es/clientes", [CustomerController::class, 'index'])->name('es_customers.index');
//Route::get("es/clientes/crear", [CustomerController::class, 'create'])->name('es_customers.create');
//Route::post("es/clientes/guardar", [CustomerController::class, 'store'])->name('es_customers.store');



