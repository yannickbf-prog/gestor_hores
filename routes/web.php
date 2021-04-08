<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeBagHourController;
use App\Http\Controllers\CustomerController;

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

Route::post('/type-bag-hours/filter', [TypeBagHourController::class, 'filter'])->name('type-bag-hours.filter');


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