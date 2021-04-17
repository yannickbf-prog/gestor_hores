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


//Route::get('/', [LocalizationController::class, "index"]);
//Route::get('change/lang', [LocalizationController::class, "lang_change"])->name('LangChange');




Route::view("/", "home")->name('home');
Route::view("/company-info", "company-info")->name('company-info');

Route::resource('customers', CustomerController::class);
Route::resource('type-bag-hours', TypeBagHourController::class);
//Route::get("en/customers", [CustomerController::class, 'index'])->name('en_customers.index');
//Route::get("/portafolio/crear", "ProjectController@create")->name('projects.create');
//Route::post("/portafolio", "ProjectController@store")->name('projects.store');

Route::get("es/clientes", [CustomerController::class, 'index'])->name('es_customers.index');
Route::get("es/clientes/crear", [CustomerController::class, 'create'])->name('es_customers.create');
//Route::post("es/clientes", "ProjectController@store")->name('projects.store');

Route::post('type-bag-hours/delete_filters', [TypeBagHourController::class, 'deleteFilters'])->name('type-bag-hours.delete_filters');
Route::post('customers/delete_filters', [CustomerController::class, 'deleteFilters'])->name('customers.delete_filters');


