<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BagHourController;
use App\Http\Controllers\TypeBagHourController;
use App\Http\Controllers\HourEntryController;
use App\Http\Controllers\EntryHoursController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProviderController;
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

/*
  Route::get('/storage/{filename}', function ($filename)
  {
  $path = storage_path('/storage/app/public/' . $filename);

  if (!File::exists($path)) {
  abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
  });
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
    Route::get("control-panel/validate/id/{id}/lang/{lang}", [HomeContoller::class, 'validateEntryHour'])->name('home_entry_hours.validate');
    Route::get("control-panel/validate-all/lang/{lang}", [HomeContoller::class, 'validateAllHours'])->name('home_entry_hours.validate_all');

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

    // Control panel - Users - Operations - Other routes in routes/auth.php
    Route::post("control-panel/users/{user}/lang/{lang}", [UserController::class, 'update'])->name('users.update');
    Route::delete("control-panel/users/{user}/lang/{lang}", [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('control-panel/users/delete_filters/lang/{lang}', [UserController::class, 'deleteFilters'])->name('users.delete_filters');
    Route::get('control-panel/users/change_num_records/lang/{lang}', [UserController::class, 'changeNumRecords'])->name('users.change_num_records');
    Route::get("control-panel/users/orderby/{camp}/lang/{lang}", [UserController::class, 'orderBy'])->name('users.orderby');
    Route::get("control-panel/users/lang/{lang}", [UserController::class, 'cancelEdit'])->name('users.cancel_edit');
    
    // Control panel - Users - en
    Route::get("en/control-panel/users", [UserController::class, 'index'])->name('en_users.index');
    Route::get("en/control-panel/users/{user}/edit", [UserController::class, 'edit'])->name('en_users.edit');
    // Control panel - Users - es
    Route::get("es/panel-de-control/usuarios", [UserController::class, 'index'])->name('es_users.index');
    Route::get("es/panel-de-control/usuarios/{user}/editar", [UserController::class, 'edit'])->name('es_users.edit');
    // Control panel - Users - ca
    Route::get("ca/panell-de-control/usuaris", [UserController::class, 'index'])->name('ca_users.index');
    Route::get("ca/panell-de-control/usuaris/{user}/editar", [UserController::class, 'edit'])->name('ca_users.edit');

    // Control panel - Customers - Operations
    Route::post("control-panel/customers/lang/{lang}", [CustomerController::class, 'store'])->name('customers.store');
    Route::post("control-panel/customers/{customer}/lang/{lang}", [CustomerController::class, 'update'])->name('customers.update');
    Route::delete("control-panel/customers/{customer}/lang/{lang}", [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get("control-panel/customers/orderby/{camp}/lang/{lang}", [CustomerController::class, 'orderBy'])->name('customers.orderby');
    Route::get('control-panel/customers/delete_filters/lang/{lang}', [CustomerController::class, 'deleteFilters'])->name('customers.delete_filters');
    Route::get('control-panel/customers/change_num_records/lang/{lang}', [CustomerController::class, 'changeNumRecords'])->name('customers.change_num_records');
    Route::get("control-panel/customers/lang/{lang}", [CustomerController::class, 'cancelEdit'])->name('customers.cancel_edit');
    
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

    // Control panel - Providers - Operations
    Route::post("control-panel/providers/lang/{lang}", [ProviderController::class, 'store'])->name('providers.store');
    Route::post("control-panel/providers/{provider}/lang/{lang}", [ProviderController::class, 'update'])->name('providers.update');
    Route::delete("control-panel/providers/{provider}/lang/{lang}", [ProviderController::class, 'destroy'])->name('providers.destroy');
    Route::get("control-panel/providers/orderby/{camp}/lang/{lang}", [ProviderController::class, 'orderBy'])->name('providers.orderby');
    Route::get('control-panel/providers/delete_filters/lang/{lang}', [ProviderController::class, 'deleteFilters'])->name('providers.delete_filters');
    Route::get('control-panel/providers/change_num_records/lang/{lang}', [ProviderController::class, 'changeNumRecords'])->name('providers.change_num_records');
    Route::get("control-panel/providers/lang/{lang}", [ProviderController::class, 'cancelEdit'])->name('providers.cancel_edit');
    
    // Control panel - Providers en
    Route::get("en/control-panel/providers", [ProviderController::class, 'index'])->name('en_providers.index');
    Route::get("en/control-panel/providers/create", [ProviderController::class, 'create'])->name('en_providers.create');
    Route::get("en/control-panel/providers/{provider}/edit", [ProviderController::class, 'edit'])->name('en_providers.edit');
    // Control panel - Providers es
    Route::get("es/panel-de-control/proveedores", [ProviderController::class, 'index'])->name('es_providers.index');
    Route::get("es/panel-de-control/proveedores/crear", [ProviderController::class, 'create'])->name('es_providers.create');
    Route::get("es/panel-de-control/proveedores/{provider}/editar", [ProviderController::class, 'edit'])->name('es_providers.edit');
    // Control panel - Providers ca
    Route::get("ca/panell-de-control/proveidors", [ProviderController::class, 'index'])->name('ca_providers.index');
    Route::get("ca/panell-de-control/proveidors/crear", [ProviderController::class, 'create'])->name('ca_providers.create');
    Route::get("ca/panell-de-control/proveidors/{provider}/editar", [ProviderController::class, 'edit'])->name('ca_providers.edit');

    //Control panel - Projects - Operations 
    Route::post("control-panel/projects/lang/{lang}", [ProjectController::class, 'store'])->name('projects.store');
    Route::post("control-panel/projects/{project}/lang/{lang}", [ProjectController::class, 'update'])->name('projects.update');
    Route::delete("control-panel/projects/{project}/lang/{lang}", [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::get('control-panel/projects/filterproject/{project_id}/lang/{lang}', [ProjectController::class, 'filterProject'])->name('projects.filterproject');
    Route::get('control-panel/projects/delete_filters/lang/{lang}', [ProjectController::class, 'deleteFilters'])->name('projects.delete_filters');
    Route::post('control-panel/projects/remove_user/{project_id}/{lang}', [ProjectController::class, 'removeUser'])->name('projects.remove_user');
    Route::post('control-panel/projects/add_user/{project_id}/{lang}', [ProjectController::class, 'addUser'])->name('projects.add_user');
    Route::get("control-panel/projects/lang/{lang}", [ProjectController::class, 'cancelEdit'])->name('projects.cancel_edit');
    Route::get("control-panel/projects/orderby/{camp}/lang/{lang}", [ProjectController::class, 'orderBy'])->name('projects.orderby');
    Route::get('control-panel/projects/change_num_records/lang/{lang}', [ProjectController::class, 'changeNumRecords'])->name('projects.change_num_records');

    //Control panel - Projects - en 
    Route::get("en/control-panel/projects", [ProjectController::class, 'index'])->name('en_projects.index');
    Route::get("en/control-panel/projects/create", [ProjectController::class, 'create'])->name('en_projects.create');
    Route::get("en/control-panel/projects/{project}/edit", [ProjectController::class, 'edit'])->name('en_projects.edit');
    Route::get("en/control-panel/projects/{project}/add-remove-users", [ProjectController::class, 'addRemoveUsers'])->name('en_projects.add_remove_users');

    //Control panel - Projects - es
    Route::get("es/panel-de-control/proyectos", [ProjectController::class, 'index'])->name('es_projects.index');
    Route::get("es/panel-de-control/proyectos/crear", [ProjectController::class, 'create'])->name('es_projects.create');
    Route::get("es/panel-de-control/proyectos/{project}/editar", [ProjectController::class, 'edit'])->name('es_projects.edit');
    Route::get("es/panel-de-control/proyectos/{project}/añadir-eliminar-usuarios", [ProjectController::class, 'addRemoveUsers'])->name('es_projects.add_remove_users');

    //Control panel - Projects - ca
    Route::get("ca/panell-de-control/projectes", [ProjectController::class, 'index'])->name('ca_projects.index');
    Route::get("ca/panell-de-control/projectes/crear", [ProjectController::class, 'create'])->name('ca_projects.create');
    Route::get("ca/panell-de-control/projectes/{project}/editar", [ProjectController::class, 'edit'])->name('ca_projects.edit');
    Route::get("ca/panell-de-control/projectes/{project}/afegir-eliminar-usuaris", [ProjectController::class, 'addRemoveUsers'])->name('ca_projects.add_remove_users');

    //Control panel - Bag hours - Operations 
    Route::post("control-panel/hour-bags/lang/{lang}", [BagHourController::class, 'store'])->name('bag_hours.store');
    Route::get('control-panel/hour-bags/delete_filters/lang/{lang}', [BagHourController::class, 'deleteFilters'])->name('bag_hours.delete_filters');
    Route::delete("control-panel/hour-bags/{bagHour}/lang/{lang}", [BagHourController::class, 'destroy'])->name('bag_hours.destroy');
    Route::post("control-panel/hour-bags/{bagHour}/lang/{lang}", [BagHourController::class, 'update'])->name('bag_hours.update');
    Route::get("control-panel/hour-bags/orderby/{camp}/lang/{lang}", [BagHourController::class, 'orderBy'])->name('bag_hours.orderby');
    Route::get('control-panel/hour-bags/change_num_records/lang/{lang}', [BagHourController::class, 'changeNumRecords'])->name('bag_hours.change_num_records');
    Route::get("control-panel/hour-bags/lang/{lang}", [BagHourController::class, 'cancelEdit'])->name('bag_hours.cancel_edit');
    Route::get('control-panel/hour-bags/export/', [BagHourController::class, 'export'])->name('bag_hours.export');
    
    //Control panel - Bag hours - en
    Route::get("en/control-panel/hour-bags", [BagHourController::class, 'index'])->name('en_bag_hours.index');
    Route::get("en/control-panel/hour-bags/create", [BagHourController::class, 'create'])->name('en_bag_hours.create');

    //Control panel - Bag hours - es
    Route::get("es/panel-de-control/bolsas-de-horas", [BagHourController::class, 'index'])->name('es_bag_hours.index');
    Route::get("es/panel-de-control/bolsas-de-horas/crear", [BagHourController::class, 'create'])->name('es_bag_hours.create');

    //Control panel - Bag hours - ca
    Route::get("ca/panell-de-control/bosses-d'hores", [BagHourController::class, 'index'])->name('ca_bag_hours.index');
    Route::get("ca/panell-de-control/bosses-d'hores/create", [BagHourController::class, 'create'])->name('ca_bag_hours.create');

    //Control panel - Bag hour types - Operations 
    Route::post("control-panel/types-hour-bags/lang/{lang}", [TypeBagHourController::class, 'store'])->name('bag_hours_types.store');
    Route::post("control-panel/types-hour-bags/{typeBagHour}/lang/{lang}", [TypeBagHourController::class, 'update'])->name('bag_hours_types.update');
    Route::delete("control-panel/types-hour-bags/{typeBagHour}/lang/{lang}", [TypeBagHourController::class, 'destroy'])->name('bag_hours_types.destroy');
    Route::get('control-panel/types-hour-bags/delete_filters/lang/{lang}', [TypeBagHourController::class, 'deleteFilters'])->name('type_bag_hours.delete_filters');
    Route::get('control-panel/types-hour-bags/change_num_records/lang/{lang}', [TypeBagHourController::class, 'changeNumRecords'])->name('bag_hours_types.change_num_records');
        
    // Control panel - Bag hour types - en
    Route::get("en/control-panel/types-hour-bags", [TypeBagHourController::class, 'index'])->name('en_bag_hours_types.index');
    Route::get("en/control-panel/types-hour-bags/create", [TypeBagHourController::class, 'create'])->name('en_bag_hours_types.create');
    Route::get("en/control-panel/types-hour-bags/{typeBagHour}/edit", [TypeBagHourController::class, 'edit'])->name('en_bag_hours_types.edit');

    // Control panel - Bag hour types - es
    Route::get("es/panel-de-control/tipos-bolsas-de-horas", [TypeBagHourController::class, 'index'])->name('es_bag_hours_types.index');
    Route::get("es/panel-de-control/tipos-bolsas-horas/crear", [TypeBagHourController::class, 'create'])->name('es_bag_hours_types.create');
    Route::get("es/panel-de-control/tipos-bolsas-de-horas/{typeBagHour}/editar", [TypeBagHourController::class, 'edit'])->name('es_bag_hours_types.edit');

    // Control panel - Bag hour types - ca
    Route::get("ca/panell-de-control/tipus-bosses-hores", [TypeBagHourController::class, 'index'])->name('ca_bag_hours_types.index');
    Route::get("ca/panell-de-control/tipus-bosses-hores/crear", [TypeBagHourController::class, 'create'])->name('ca_bag_hours_types.create');
    Route::get("ca/panell-de-control/tipus-bosses-hores/{typeBagHour}/editar", [TypeBagHourController::class, 'edit'])->name('ca_bag_hours_types.edit');

    // Control panel - Time entries - Operations
    Route::post("control-panel/time-entries/lang/{lang}", [HourEntryController::class, 'store'])->name('time_entries.store');
    //Route::put("control-panel/time-entries/lang/{lang}", [HourEntryController::class, 'validateEntryHour'])->name('entry_hours.validate');
    Route::get("control-panel/time-entries/validate/id/{id}/lang/{lang}", [HourEntryController::class, 'validateEntryHour'])->name('entry_hours.validate');
    //Route::get("control-panel/time-entries/invalidate/id/{id}/lang/{lang}", [HourEntryController::class, 'invalidateEntryHour'])->name('entry_hours.invalidate');
    Route::get("control-panel/time-entries/validate-all/lang/{lang}", [HourEntryController::class, 'validateAllHours'])->name('entry_hours.validate_all');
    Route::get('control-panel/time-entries/filteruser/{user_id}/lang/{lang}', [HourEntryController::class, 'filterUser'])->name('entry_hours.filteruser');
    Route::get('control-panel/time-entries/filterproject/{project_id}/lang/{lang}', [HourEntryController::class, 'filterProject'])->name('entry_hours.filterproject');
    Route::get('control-panel/time-entries/filtercustomer/{customer_id}/lang/{lang}', [HourEntryController::class, 'filterCustomer'])->name('entry_hours.filtercustomer');
    Route::get("control-panel/time-entries/orderby/{camp}/lang/{lang}", [HourEntryController::class, 'orderBy'])->name('entry_hours.orderby');
    Route::get('control-panel/time-entries/delete_filters/lang/{lang}', [HourEntryController::class, 'deleteFilters'])->name('entry_hours.delete_filters');
    Route::get('control-panel/time-entries/change_num_records/lang/{lang}', [HourEntryController::class, 'changeNumRecords'])->name('time_entries.change_num_records');
    Route::delete("control-panel/time-entries/destroy/{hourEntry}/lang/{lang}", [HourEntryController::class, 'destroy'])->name('time_entries.destroy');
    Route::post("control-panel/time-entries/{hourEntry}/lang/{lang}", [HourEntryController::class, 'update'])->name('time_entries.update');
    Route::get("control-panel/time-entries/lang/{lang}", [HourEntryController::class, 'cancelEdit'])->name('time_entries.cancel_edit');
    Route::get('control-panel/time-entries/export/', [HourEntryController::class, 'export'])->name('time_entries.export');

    // Control panel - Time entries - en
    Route::get("en/control-panel/time-entries", [HourEntryController::class, 'index'])->name('en_time_entries.index');
    Route::get("en/control-panel/time-entries/create", [HourEntryController::class, 'create'])->name('en_time_entries.create');

    // Control panel - Time entries - es
    Route::get("es/panel-de-control/entradas-de-horas", [HourEntryController::class, 'index'])->name('es_time_entries.index');
    Route::get("es/panel-de-control/entradas-de-horas/crear", [HourEntryController::class, 'create'])->name('es_time_entries.create');

    //Control panel - Time entries - ca
    Route::get("ca/panell-de-control/entrades-hores", [HourEntryController::class, 'index'])->name('ca_time_entries.index');
    Route::get("ca/panell-de-control/entrades-hores/crear", [HourEntryController::class, 'create'])->name('ca_time_entries.create');
});

//Entry hours - Workers section - Middleware in controller
Route::get('entry-hours-worked/delete_filters/lang/{lang}', [EntryHoursController::class, 'deleteFilters'])->name('hours_entry.delete_filters');
Route::get('entry-hours-worked/change_num_records/lang/{lang}', [EntryHoursController::class, 'changeNumRecords'])->name('hours_entry.change_num_records');
Route::post("entry-hours-worked/{entryHours}/lang/{lang}", [EntryHoursController::class, 'update'])->name('hours_entry.update');
Route::delete("entry-hours-worked/destroy/{entryHours}/lang/{lang}", [EntryHoursController::class, 'destroy'])->name('hours_entry.destroy');
Route::get("entry-hours-worked/lang/{lang}", [HourEntryController::class, 'cancelEdit'])->name('hours_entry.cancel_edit');
    
Route::post("entry-hours-worked/lang/{lang}", [EntryHoursController::class, 'store'])->name('entry_hours.store');

Route::get("en/entry-hours-worked", [EntryHoursController::class, 'index'])->name('en_entry_hours.index');
Route::get("es/entrar-horas-trabajadas", [EntryHoursController::class, 'index'])->name('es_entry_hours.index');
Route::get("ca/entrar-hores-treballades", [EntryHoursController::class, 'index'])->name('ca_entry_hours.index');


Route::get('/', function () {
    $default_lang = DB::table('company')->first()->default_lang;
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route($default_lang . '_home.index', $default_lang);
        } else if (Auth::user()->isUser()) {
            return redirect()->route($default_lang . '_entry_hours.index', $default_lang);
        }
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



