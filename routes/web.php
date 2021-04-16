<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\TypeBagHourController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocalizationController;

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

Route::view("/", "home")->name('home');
Route::view("/company-info", "company-info")->name('company-info');

//Route::resource('users', UserController::class);


Route::resource('customers', CustomerController::class);
Route::resource('type-bag-hours', TypeBagHourController::class);



//Route::view("/clients", "customers")->name('customers');

Route::post('type-bag-hours/delete_filters', [TypeBagHourController::class, 'deleteFilters'])->name('type-bag-hours.delete_filters');
Route::post('customers/delete_filters', [CustomerController::class, 'deleteFilters'])->name('customers.delete_filters');

if ( file_exists( app_path( 'App/Http/Controllers/LocalizationController.php') ) ) 
{
  Route::get('lang/{locale}', [LocalizationController::class, 'LocalizationController.php']);
}

/*
Route::get('clients', [CustomerController::class, 'index']);
Route::view("/clients/crear", "customers.create");
Route::post("/clients", [CustomerController::class, 'store'])->name('clients.index');
*/

//Route::get('clients', function () {
//
//
//    App::setLocale('ca');
//
//    return redirect()->action([CustomerController::class, 'index']);
//});



/*Route::get('type-bag-hours/filter2', function () {
    return 'Hello World';
});
*/
/*
Route::post('type-bag-hours', function (Request $request) {
    echo $request['hour_price'];
})->name('type-bag-hours.filter');
*/


//Route::post('/type-bag-hours', 'TypeBagHourController@filter')->name('type-bag-hours.filter');
//Route::post($uri, $callback);