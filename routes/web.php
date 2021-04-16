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

/*Route::view("/", "home")->name('home');
Route::view("/company-info", "company-info")->name('company-info');
*/
//Route::resource('users', UserController::class);







Route::view("/", "home")->name('home');
Route::view("/company-info", "company-info")->name('company-info');

Route::get('change/lang', [LocalizationController::class, "lang_change"])->name('LangChange');

//Route::get('customers', [LocalizationController::class, "customers"]);
//Route::get('/', [LocalizationController::class, "index"]);


Route::resource('customers', CustomerController::class);
Route::resource('type-bag-hours', TypeBagHourController::class);


Route::post('type-bag-hours/delete_filters', [TypeBagHourController::class, 'deleteFilters'])->name('type-bag-hours.delete_filters');
Route::post('customers/delete_filters', [CustomerController::class, 'deleteFilters'])->name('customers.delete_filters');


